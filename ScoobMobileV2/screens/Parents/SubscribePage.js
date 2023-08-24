import axios from "axios";
import React, { useContext, useEffect, useState } from "react";
import { Alert, SafeAreaView, StyleSheet, Text, View } from "react-native";
import SelectDropdown from "react-native-select-dropdown";
import Icon from "react-native-vector-icons/Ionicons";
import CustomButton from "../../components/CustomButton";
import { COLORS } from "../../constants";
import UserContext from "../../context/UserContext";

const SubscribePage = () => {
	var subscribed = false;
	const [updatedAt, setUpdatedAt] = useState("");

	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	const subscriptionHandler = () => {
		Alert.alert("Subscription", "Do you want to subscribe to bus service?", [
			{
				text: "Cancel",
				onPress: () => console.log("Cancel Pressed"),
				style: "cancel",
			},
			{ text: "OK", onPress: () => okHandler() },
		]);
	};

	const okHandler = () => {
		// Fetch data from the Lambda function when the component mounts
		axios
			.put(`${lambdaEndpoint}/student/12345/notSubscribed`)
			.then((response) => {
				// Handle the response and set the profile data in the state
				(response) => setUpdatedAt(response.data.updatedAt);
			})
			.catch((error) => {
				console.error("Error updating profile data:", error);
			});
		subscribed = true;
		Alert.alert("Subscribed");
		navigation.navigate("ParentsSubscribedPage", subscribed);
	};
	return (
		<CustomButton
			onPress={subscriptionHandler}
			text="Subscribe"
			type="TERTIARY"
		/>
	);
};

export default SubscribePage;
