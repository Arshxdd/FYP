import axios from "axios";
import React, { useState } from "react";
import {
	Alert,
	Button,
	SafeAreaView,
	StyleSheet,
	Text,
	TouchableOpacity,
	View,
} from "react-native";
import CustomButton from "../../components/CustomButton";
import { COLORS } from "../../constants";

const SubscribedPage = () => {
	const [updatedAt, setUpdatedAt] = useState("");
	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	function unsubscribe() {
		axios
			.put(`${lambdaEndpoint}/student/12345/subscribed`)
			.then((response) => {
				// Handle the response and set the profile data in the state
				(response) => setUpdatedAt(response.data.updatedAt);
			})
			.catch((error) => {
				console.error("Error updating profile data:", error);
			});
		subscribed = true;
		Alert.alert("Unsubscribed");
	}

	return (
		<SafeAreaView style={styles.container}>
			<View>
				<TouchableOpacity style={styles.buttonStyle} onPress={unsubscribe}>
					<Text style={styles.buttonTextStyle}>Unsubscribe</Text>
				</TouchableOpacity>
			</View>
		</SafeAreaView>
	);
};
const styles = StyleSheet.create({
	container: {
		flex: 1,
	},
	parent: {
		flexDirection: "row",
		justifyContent: "space-evenly",
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

export default SubscribedPage;
