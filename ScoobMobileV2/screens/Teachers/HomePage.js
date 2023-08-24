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
import UserContext from "../../context/UserContext";

import { HStack, Text } from "@react-native-material/core";
import { Avatar, Button, Icon, ListItem } from "@rneui/base";
// import { Icon } from "react-native-elements";
import COLORS from "../../constants/colors";

const HomePage = ({ navigation }) => {
	const { userDetails } = useContext(UserContext);
	const [childData, setChildData] = useState("");
	const [studentData, setStudentData] = useState("");
	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	const fetchPUZStudentData = async () => {
		try {
			const response = await axios.get(
				`${lambdaEndpoint}/teacher/${userDetails.userClass}/pickupstatus/arrived`
			);
			const data = response.data;
			setChildData(data);
			//Test
			console.log(childData);
			console.log("fetchPUZStudentData() Successful");
		} catch (error) {
			console.error("fetchPUZStudentData() Unsuccessful: ", error);
			// setChildData(null);
		}
	};

	const fetchStudentData = async () => {
		try {
			const response = await axios.get(
				`${lambdaEndpoint}/teacher/${userDetails.userClass}`
			);
			const data = response.data;
			setStudentData(data);
			console.log("fetchStudentData() Successful");
		} catch (error) {
			console.error("fetchStudentData() Unsuccessful: ", error);
			// setStudentData(null);
		}
	};

	const scannerHandler = async () => {
		navigation.navigate("ScanID", { studentData });
	};

	const focusHandler = () => {
		navigation.addListener("focus", () => {
			fetchPUZStudentData();
			fetchStudentData();
			console.log("Refreshed!");
		});
	};

	useEffect(() => {
		focusHandler();
	}, [navigation]);

	return (
		<SafeAreaView style={styles.container}>
			<HStack justify={"space-evenly"} align={"center"} m={10}>
				<Text variant="h4" style={styles.welcome}>
					Welcome, {userDetails.fname}
				</Text>
				<Icon
					raised
					underlayColor={COLORS.white}
					name="barcode-scan"
					type="material-community"
					color={COLORS.primary}
					onPress={scannerHandler}
				/>
			</HStack>
			<Text variant="h5" style={styles.title}>
				Parent(s) in Pick Up Zone
			</Text>
			<View style={styles.scrollContainer}>
				{/* // ! Display something is no data */}
				{childData === null ? (
					<Text>No</Text>
				) : (
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
									navigation.navigate("TeacherPickUpStack", { childInfo: item })
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
									<ListItem.Subtitle></ListItem.Subtitle>
								</ListItem.Content>
								<ListItem.Chevron />
							</ListItem>
						)}
					/>
				)}
			</View>
			<Text variant="h5" style={styles.title}>
				Class List
			</Text>
			<View style={styles.scrollContainer}>
				<FlatList
					showsVerticalScrollIndicator={false}
					contentContainerStyle={styles.scrollViewItem}
					// keyExtractor={(item) => item.id} //if you want to extract key value
					data={studentData}
					renderItem={({ item }) => (
						<ListItem
							bottomDivider
							Component={TouchableHighlight}
							containerStyle={{
								// borderRadius: 8,
								height: 150,
							}}
							disabledStyle={{ opacity: 0.5 }}
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
									>{`${item.fname} ${item.lname}  `}</Text>
									{item.pickupstatus === "In School" ? (
										<Icon
											name="checkbox-marked-circle-outline"
											type="material-community" // Use the appropriate icon library/type
											color="green"
										/>
									) : (
										<Icon
											name="checkbox-blank-circle-outline"
											type="material-community" // Use the appropriate icon library/type
											color="red"
										/>
									)}
								</ListItem.Title>
								<ListItem.Subtitle>
									<Text>{`${item.studentid}, ${item.class}`}</Text>
								</ListItem.Subtitle>
								<ListItem.Subtitle>
									{item.pickupstatus === "Arriving" ? (
										<Text>Status: In School</Text>
									) : item.pickupstatus === "Arrived" ? (
										<Text>Status: In School</Text>
									) : (
										<Text>{`Status: ${item.pickupstatus}`}</Text>
									)}
									{/* <Text>{`Status: ${item.pickupstatus}`}</Text> */}
								</ListItem.Subtitle>
								<ListItem.Subtitle>
									{item.pickupmode === 1 ? (
										<Icon
											name="bus"
											type="ionicon" // Use the appropriate icon library/type
											color={COLORS.accent}
										/>
									) : (
										<Icon
											name="car-sport"
											type="ionicon" // Use the appropriate icon library/type
											color={COLORS.secondary}
										/>
									)}
								</ListItem.Subtitle>
							</ListItem.Content>
							{/* <ListItem.Chevron /> */}
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
		maxHeight: 225,
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
	welcome: {
		paddingTop: 16,
		// paddingLeft: 10,
		// padding: 10,
		fontWeight: "bold",
		// fontFamily: "NunitoSans-Bold",
		color: COLORS.primary,
	},
	text: {
		fontWeight: "bold",
	},
});

export default HomePage;
