import axios from "axios";
import React, { useContext, useEffect, useState } from "react";
import {
	Alert,
	FlatList,
	SafeAreaView,
	ScrollView,
	StyleSheet,
	TouchableHighlight,
	View,
} from "react-native";
import CustomButton from "../../components/CustomButton";
import UserContext from "../../context/UserContext";

import { Text } from "@react-native-material/core";
import { Avatar, ListItem } from "@rneui/base";
import { Icon } from "react-native-elements";
import COLORS from "../../constants/colors";

const BusServicePage = ({ navigation }) => {
	const { userDetails } = useContext(UserContext);
	const [childData, setChildData] = useState("");

	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	useEffect(() => {
		// Sends a GET request to the API endpoint using Axios, retrieves the data from the response, and sets it in the
		// childData state
		axios
			.get(`${lambdaEndpoint}/student/${userDetails.userId}`)
			.then((response) => {
				// Handle the response and set the profile data in the state
				console.log("Response data 1:", response.data); // Log the fetched data
				setChildData(response.data);
			})
			.catch((error) => {
				console.error("Error fetching profile data:", error);
			});
	}, [userDetails]);

	const handleChildPress = (child) => {
		// Sending in the 'item' object
		console.log("Child info 2:", child); // Log the selected child info

		if (child.subscription === "Yes") {
			// If the child is subscribed, navigate to SubscribedPage
			console.log("Child is subscribed. Navigating to SubscribedPage.");
			navigation.navigate("ParentsSubscribedPage", { childInfo: child });
		} else {
			// If the child is not subscribed, display a prompt
			console.log("Child is not subscribed. Displaying prompt.");
			Alert.alert(
				"Child Not Subscribed",
				"Your child is not subscribed. Do you want to be redirected to the child's profile page for subscription?",
				[
					{
						text: "No",
						style: "cancel",
					},
					{
						text: "Yes",
						onPress: () => {
							// Redirect to the ChildInfoPage for subscription
							console.log("User chose 'Yes'. Navigating to ChildInfoStack.");
							navigation.navigate("ChildInfoStack", { childInfo: child });
						},
					},
				],
				{ cancelable: false }
			);
		}
	};

	return (
		<SafeAreaView style={styles.container}>
			<Text variant="h4" style={styles.title}>
				Child(s)
			</Text>
			<View style={styles.scrollContainer}>
				<FlatList
					showsVerticalScrollIndicator={false}
					contentContainerStyle={styles.scrollViewItem}
					data={childData}
					renderItem={({ item }) => (
						<ListItem
							bottomDivider
							Component={TouchableHighlight}
							containerStyle={{
								height: 150,
							}}
							disabledStyle={{ opacity: 0.5 }}
							onLongPress={() => console.log("onLongPress()")}
							onPress={() => handleChildPress(item)} // Use the handleChildPress function here
							pad={20}
						>
							<Avatar
								rounded
								title={`${item.fname[0]}`}
								containerStyle={{ backgroundColor: "grey" }}
							/>
							<ListItem.Content>
								<ListItem.Title>
									<Text
										variant="h5"
										style={styles.text}
									>{`${item.fname} ${item.lname}`}</Text>
								</ListItem.Title>
								<ListItem.Subtitle>
									<Text>{`${item.studentid}, ${item.class}`}</Text>
								</ListItem.Subtitle>
								{/* Display the subscription status indicator here */}
								{item.subscription === "Yes" ? (
									// You can use any icon or text component to show the subscription status
									<Icon
										name="check"
										type="font-awesome" // Use the appropriate icon library/type
										color="green"
									/>
								) : (
									<Icon
										name="times"
										type="font-awesome" // Use the appropriate icon library/type
										color="red"
									/>
								)}
							</ListItem.Content>
						</ListItem>
					)}
				/>
			</View>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		paddingHorizontal: 10,
	},
	scrollContainer: {
		padding: 8,
		borderRadius: 8,
		backgroundColor: "lightgray",
		margin: 10,
	},
	scrollViewItem: {
		justifyContent: "center",
		alignSelf: "stretch",
	},
	image: {
		resizeMode: "contain",
		height: 20,
		width: 10,
	},
	title: {
		padding: 15,
		fontWeight: "bold",
	},
	text: {
		fontWeight: "bold",
	},
});

export default BusServicePage;
