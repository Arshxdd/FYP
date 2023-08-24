import axios from "axios";
import React, { useEffect, useState } from "react";
import {
	Alert,
	FlatList,
	SafeAreaView,
	StyleSheet,
	TouchableOpacity,
	View,
} from "react-native";

import CustomButton from "../../components/CustomButton";
import { COLORS } from "../../constants";

import { HStack, Stack, VStack } from "react-native-flex-layout";

import { Text, useBoolean } from "@react-native-material/core";
import { Button, Switch } from "@rneui/themed";

const ChildInfoPage = ({ route, navigation }) => {
	const {
		fname,
		lname,
		studentid,
		class: studentClass,
		pickupmode,
		pcode,
		pickupstatus,
	} = route.params;
	const [subscriptionStatus, setSubscriptionStatus] = useState(
		route.params.subscription
	);

	var transportCompany = " ";
	const [arriving, setArriving] = useState();
	const [pickUpMode, setPickUpMode] = useState(pickupmode === 1 ? true : false);
	const [pickupStatus, setPickupStatus] = useState(pickupstatus);
	// const [transportCompany, setTransportCompany] = useState('');

	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	const generateQR = () => {
		navigation.navigate("ThirdPartyQR", route.params);
	};

	const selfPickUpStatus = () => {
		// Disable the "Self" button to prevent multiple clicks while the request is being processed
		// setPickupStatus("Yes");

		// Make a PUT request to update the pickupstatus of the student to "Arriving"
		axios
			.put(`${lambdaEndpoint}/student/${studentid}/arriving`)
			.then((response) => {
				// Update the setPickupStatus and setArriving state after the successful request
				setPickupStatus("Arriving");

				// On the way to school
				Alert.alert("Success", "Pickup status updated successfully!");
			})
			.catch((error) => {
				console.error("Error updating pickup status:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update pickup status. Please try again."
				);
			});
	};

	// Change Pickup mode to Self
	const selfPickUpHandler = () => {
		axios
			.put(`${lambdaEndpoint}/student/${studentid}/bus`)
			.then((response) => {
				// Update the subscription status in the state
				setPickUpMode(false);
				// Show a success message to the user
				Alert.alert("Success", "Pick up mode updated to self!");
			})
			.catch((error) => {
				console.error("Error updating pick up mode:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update pick up mode. Please try again."
				);
			});
	};

	// Change Pickup mode to Bus
	const busPickUpHandler = () => {
		axios
			.put(`${lambdaEndpoint}/student/${studentid}/self`)
			.then((response) => {
				// Update the subscription status in the state
				setPickUpMode(true);
				// Show a success message to the user
				Alert.alert("Success", "Pick up mode updated to bus!");
			})
			.catch((error) => {
				console.error("Error updating pick up mode:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update pick up mode. Please try again."
				);
			});
	};

	const arrivedHandler = () => {
		axios
			.put(`${lambdaEndpoint}/student/${studentid}/arrived`)
			.then((response) => {
				// Update the setPickupStatus and setArriving state after the successful request
				setPickupStatus("Arrived");

				// On the way to school
				Alert.alert("Success", "Pickup status updated successfully!");
			})
			.catch((error) => {
				console.error("Error updating pickup status:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update pickup status. Please try again."
				);
			});
	};

	const handleSubscriptionToggle = () => {
		// Show a confirmation prompt to the user
		const promptMessage =
			subscriptionStatus === "Yes"
				? "Are you sure you want to unsubscribe from the bus service?"
				: "Are you sure you want to subscribe to the bus service?";

		Alert.alert(
			"Confirmation",
			promptMessage,
			[
				{
					text: "Cancel",
					style: "cancel",
				},
				{
					text: "Confirm",
					onPress: () => {
						// Call the API to update the subscription status in the database
						updateSubscriptionStatus();
					},
				},
			],
			{ cancelable: true }
		);
	};

	const matchedBus = (busID) => {
		// Update the student's 'busid' with the matching bus driver's 'busid'
		axios
			.put(`${lambdaEndpoint}/student/${studentid}/updatebus`, {
				busid: busID,
			})
			.then((response) => {
				Alert.alert("Success", "Subscribed successfully!");
			})
			.catch((error) => {
				console.error("Error updating student's busid:", error);
				Alert.alert(
					"Error",
					"Failed to update student's busid. Please try again."
				);
			});
	};
	// working
	const updateSubscriptionStatus = async () => {
		const newSubscriptionStatus = subscriptionStatus === "Yes" ? "No" : "Yes";

		// Make a PUT request to update the subscription status in the database
		axios
			.put(`${lambdaEndpoint}/student/${studentid}`, {
				subscription: newSubscriptionStatus,
			})
			.then((response) => {
				// Update the subscription status in the state
				setSubscriptionStatus(newSubscriptionStatus);
				console.log(newSubscriptionStatus);
				if (newSubscriptionStatus === "Yes") {
					axios
						.get(`${lambdaEndpoint}/schooltransport/${route.params.uen}`)
						.then((response2) => {
							//   setTransportCompany(response2.data.transportuen);
							transportCompany = response2.data.transportuen;
						})
						.catch((error) => {
							console.error("Error fetching transport uen:", error);
							Alert.alert(
								"Error",
								"Failed to fetch transport uen. Please try again."
							);
						});
					console.log(
						"substring: ",
						route.params.pcode.toString().substring(0, 3)
					);
					axios
						.get(
							`${lambdaEndpoint}/busdriver/${route.params.pcode
								.toString()
								.substring(0, 3)}`
						)
						.then((response3) => {
							const matchingBusDriver = response3.data;
							console.log("transportCompany: ", transportCompany);
							console.log("matchingBusDriver: ", matchingBusDriver);
							{
								matchingBusDriver.map((matched) =>
									matched.uen === transportCompany
										? matchedBus(matched.busid)
										: console.log("no")
								);
							}
						})
						.catch((error) => {
							console.error("Error fetching bus driver:", error);
							Alert.alert(
								"Error",
								"Failed to fetch bus driver. Please try again."
							);
						});
				} else {
					Alert.alert("Success", "Unsubscribed Successfully")
				}
			})
			.catch((error) => {
				console.error("Error updating subscription status:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update subscription status. Please try again."
				);
			});
	};

	return (
		<SafeAreaView style={styles.container}>
			<View style={styles.studentDetails}>
				<VStack m={10} spacing={5}>
					<Text variant="h2" style={styles.studentName}>
						{fname} {lname}
					</Text>
					<Text variant="h6" style={styles.details}>
						{studentid}
					</Text>
					<Text variant="h6" style={styles.details}>
						{studentClass}
					</Text>
					<Text style={styles.details}>
						Subscription Status:{" "}
						{subscriptionStatus === "Yes" ? "Subscribed" : "Not Subscribed"}
					</Text>
				</VStack>
			</View>

			<View style={styles.buttonStack}>
				<VStack>
					{subscriptionStatus === "Yes" ? (
						<HStack justify={"center"} align={"center"}>
							<Text>{pickUpMode === true ? "Bus Pickup" : "Self Pickup"}</Text>
							<Switch
								color={COLORS.primary}
								value={pickUpMode}
								onValueChange={() =>
									pickUpMode === true ? selfPickUpHandler() : busPickUpHandler()
								}
							/>
						</HStack>
					) : (
						<></>
					)}

					<HStack>
						<Button
							buttonStyle={{
								width: 150,
								backgroundColor: COLORS.primary,
								borderRadius: 8,
								height: 50,
							}}
							containerStyle={{ margin: 5 }}
							disabled={pickUpMode === true ? true : false}
							disabledStyle={{}}
							disabledTitleStyle={{}}
							linearGradientProps={null}
							iconContainerStyle={{ background: "#000" }}
							loadingProps={{ animating: true }}
							loadingStyle={{}}
							onPress={selfPickUpStatus}
							title="Arriving"
							titleProps={{}}
							titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
						/>
						<Button
							buttonStyle={{
								width: 150,
								backgroundColor: COLORS.primary,
								borderRadius: 8,
								height: 50,
							}}
							containerStyle={{ margin: 5 }}
							// disabled={pickUpMode === true ? true : false}
							disabledStyle={{}}
							disabledTitleStyle={{}}
							linearGradientProps={null}
							iconContainerStyle={{ background: "#000" }}
							loadingProps={{ animating: true }}
							loadingStyle={{}}
							onPress={generateQR}
							title="Third Party"
							titleProps={{}}
							titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
						/>
					</HStack>
					<Button
						buttonStyle={{
							width: "100%",
							backgroundColor: COLORS.primary,
							borderRadius: 8,
							height: 50,
						}}
						containerStyle={{ margin: 5 }}
						disabled={pickupStatus === "Arriving" ? false : true}
						disabledStyle={{}}
						disabledTitleStyle={{}}
						linearGradientProps={null}
						iconContainerStyle={{ background: "#000" }}
						loadingProps={{ animating: true }}
						loadingStyle={{}}
						onPress={arrivedHandler}
						title="Arrived"
						titleProps={{}}
						titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
					/>

					<Button
						buttonStyle={{
							width: "100%",
							backgroundColor:
								subscriptionStatus === "Yes" ? "red" : COLORS.secondary, // Choose a color for the subscribe/unsubscribe button
							borderColor: "transparent",
							borderWidth: 0,
							borderRadius: 8,
							height: 50,
						}}
						containerStyle={{ margin: 5 }}
						disabledStyle={{
							borderWidth: 2,
							borderColor: "#00F",
						}}
						disabledTitleStyle={{ color: "#00F" }}
						linearGradientProps={null}
						iconContainerStyle={{ background: "#000" }}
						loadingProps={{ animating: true }}
						loadingStyle={{}}
						onPress={handleSubscriptionToggle}
						title={subscriptionStatus === "Yes" ? "Unsubscribe" : "Subscribe"}
						titleProps={{}}
						titleStyle={{ marginHorizontal: 5, color: COLORS.white }}
					/>
				</VStack>
			</View>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		// alignItems: "center",
		justifyContent: "flex-start",
	},
	studentDetails: {
		alignItems: "flex-start",
		// backgroundColor: "pink",
		height: "30%",
	},
	buttonStack: {
		alignItems: "center",
		// paddingTop: 250,
	},
	text: {
		fontSize: 18,
	},
	studentName: {
		fontWeight: "bold",
	},
	details: {},
	row: {
		flexDirection: "row",
		justifyContent: "space-around",
		width: "100%",
	},
	scrollViewItem: {
		// backgroundColor: COLORS.primary,
		flex: 1,
	},
	buttonStyle: {
		backgroundColor: COLORS.primary,
		borderWidth: 0,
		color: COLORS.white,
		borderColor: COLORS.primary,
		alignItems: "center",
		borderRadius: 5,
		marginTop: 30,
		padding: 10,
	},
	buttonTextStyle: {
		color: COLORS.black,
		paddingVertical: 10,
		fontSize: 16,
	},
});

export default ChildInfoPage;
