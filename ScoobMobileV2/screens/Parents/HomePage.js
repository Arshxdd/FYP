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

const HomePage = ({ navigation }) => {
	const { userDetails } = useContext(UserContext);
	const [childData, setChildData] = useState("");
	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	const fetchStudentData = async () => {
		try {
			const response = await axios.get(
				`${lambdaEndpoint}/student/${userDetails.userId}`
			);
			const data = response.data;
			setChildData(data);
			console.log("Fetching...");
		} catch (error) {
			console.error(error);
		}
	};

	const focusHandler = () => {
		navigation.addListener("focus", () => {
			fetchStudentData();
			console.log("Refreshed!");
		});
	};

	useEffect(() => {
		focusHandler();
	}, [navigation]);

	return (
		<SafeAreaView style={styles.container}>
			<Text variant="h4" style={styles.title}>
				Child(s)
			</Text>
			<View style={styles.scrollContainer}>
				<FlatList
					showsVerticalScrollIndicator={false}
					contentContainerStyle={styles.scrollViewItem}
					// keyExtractor={(item) => item.id} //if you want to extract key value
					data={childData}
					renderItem={({ item }) => (
						<ListItem
							bottomDivider
							Component={TouchableHighlight}
							containerStyle={{
								// borderRadius: 8,
								height: 150,
							}}
							disabledStyle={{ opacity: 0.5 }}
							onLongPress={() => console.log("onLongPress()")}
							onPress={() =>
								navigation.navigate("ChildInfoStack", { childInfo: item })
							}
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
										variant="h4"
										style={styles.text}
									>{`${item.fname} ${item.lname}`}</Text>
								</ListItem.Title>
								<ListItem.Subtitle>
									<Text>{`${item.studentid}, ${item.class}`}</Text>
								</ListItem.Subtitle>
								<ListItem.Subtitle>
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
								</ListItem.Subtitle>
								<ListItem.Subtitle>
									{item.pickupstatus === "Arriving" ? (
										<Text>Status: In School</Text>
									) : item.pickupstatus === "Arrived" ? (
										<Text>Status: In School</Text>
									) : (
										<Text>{`Status: ${item.pickupstatus}`}</Text>
									)}
								</ListItem.Subtitle>
								<ListItem.Subtitle>
									{item.busid != null ? (
										<Text>Bus: {item.busid}</Text>
									) : (
										<Text></Text>
									)}
								</ListItem.Subtitle>
							</ListItem.Content>
							<ListItem.Chevron />
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
		// paddingHorizontal: 15,
		padding: 8,
		borderRadius: 8,
		backgroundColor: "lightgray",
		margin: 10,
		minHeight: 150,
		maxHeight: 350,
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
		// paddingTop: 10,
		// paddingLeft: 10,
		padding: 15,
		fontWeight: "bold",
		// fontFamily: "NunitoSans-Bold",
	},
	text: {
		fontWeight: "bold",
	},
});

export default HomePage;
