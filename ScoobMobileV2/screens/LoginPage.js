import { useNavigation } from "@react-navigation/native";
import axios from "axios";
import React, { useContext, useState } from "react";
import {
	Alert,
	Image,
	Keyboard,
	KeyboardAvoidingView,
	LogBox,
	SafeAreaView,
	StatusBar,
	StyleSheet,
	Text,
	TextInput,
	TouchableWithoutFeedback,
	View,
} from "react-native";
import SelectDropdown from "react-native-select-dropdown";
import Icon from "react-native-vector-icons/Ionicons";
import CustomButton from "../components/CustomButton";
import { COLORS } from "../constants";
import UserContext from "../context/UserContext";

import { Input } from "@rneui/base";
import { Button } from "@rneui/themed";
import { HStack, Stack, VStack } from "react-native-flex-layout";

function LoginPage() {
	LogBox.ignoreAllLogs();
	const navigation = useNavigation();
	const { setUserEmail, setUserDetails } = useContext(UserContext); // Get setUserEmail and setUserDetails from the context

	const users = ["Parent", "Teacher", "Driver"];

	const [credentials, setCredentials] = useState({
		username: "",
		password: "",
	});

	const onLoginPressed = async () => {
		try {
			const response = await axios.post(
				"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev/login",
				{
					email: credentials.username,
					password: credentials.password,
					userType: selectedUser.toLowerCase(),
				}
			);
			if (response.data.message === "Login successful") {
				const userType = response.data.userType;
				setUserEmail(credentials.username); // Set the user's email using the setUserEmail function from the UserContext
				// Set the user's details (including the ID) using the setUserDetails function from the UserContext
				setUserDetails(response.data); // Save all user details from the response
				// Display the values using Alert
				// Alert.alert("User Type", userType);

				switch (userType) {
					case "teacher":
						navigation.navigate("TeacherBottomTab");
						break;
					case "driver":
						navigation.navigate("DriverBottomTab");
						break;
					case "parent":
						navigation.navigate("ParentBottomTab");
						break;
					default:
						break;
				}
			} else {
				// Incorrect details, display an error message
				Alert.alert("Incorrect details");
			}
		} catch (err) {
			// Handle any errors that occur during the login process
			console.error("Error logging in:", err);
			if (err.response.status == "401") {
				Alert.alert("Incorrect username or password or type");
			}
		}
	};

	return (
		<KeyboardAvoidingView
			behavior={Platform.OS === "ios" ? "padding" : "height"}
			style={styles.container}
		>
			{/* RN statusbar */}
			<StatusBar
				barStyle={"dark-content"}
				backgroundColor={COLORS.background}
			/>
			{/* Expo statusbar
			<StatusBar style="auto"/> */}

			<TouchableWithoutFeedback
				onPress={() => {
					Keyboard.dismiss();
				}}
			>
				<SafeAreaView style={styles.inner}>
					<Image
						style={styles.logo}
						source={require("../assets/images/ScooB.png")}
					/>
					<View style={styles.interactive}>
						<Input
							containerStyle={{ width: "90%" }}
							disabledInputStyle={{ background: "#ddd" }}
							inputContainerStyle={{}}
							errorStyle={{}}
							errorProps={{}}
							inputStyle={{}}
							label="LOGIN"
							labelStyle={{}}
							labelProps={{}}
							leftIcon={<Icon name="person" size={20} />}
							leftIconContainerStyle={{}}
							rightIconContainerStyle={{}}
							placeholder="Email"
							onChangeText={(val) =>
								setCredentials({ ...credentials, username: val })
							}
						/>
						<Input
							containerStyle={{ width: "90%" }}
							disabledInputStyle={{ background: "#ddd" }}
							inputContainerStyle={{}}
							errorStyle={{}}
							errorProps={{}}
							inputStyle={{}}
							labelStyle={{}}
							labelProps={{}}
							leftIcon={<Icon name="lock-closed" size={20} />}
							leftIconContainerStyle={{}}
							rightIconContainerStyle={{}}
							placeholder="Password"
							secureTextEntry={true}
							onChangeText={(val) =>
								setCredentials({ ...credentials, password: val })
							}
						/>
						{/* </VStack> */}
						<SelectDropdown
							statlog
							data={users}
							defaultButtonText="Select user"
							onSelect={(selectedItem, index) => {
								console.log(selectedItem, index);
							}}
							buttonStyle={styles.dropdown2BtnStyle}
							buttonTextStyle={styles.dropdown2BtnTxtStyle}
							dropdownStyle={styles.dropdown2DropdownStyle}
							rowStyle={styles.dropdown2RowStyle}
							rowTextStyle={styles.dropdown2RowTxtStyle}
							selectedRowStyle={styles.dropdown2SelectedRowStyle}
							renderDropdownIcon={(isOpened) => {
								return (
									<Icon
										name={isOpened ? "caret-up" : "caret-down"}
										color={"#444"}
										size={20}
									/>
								);
							}}
							buttonTextAfterSelection={(selectedItem, index) => {
								// text represented after item is selected
								// if data array is an array of objects then return selectedItem.property to render after item is selected
								selectedUser = selectedItem;
								return selectedItem;
							}}
							rowTextForSelection={(item, index) => {
								// text represented for each item in dropdown
								// if data array is an array of objects then return item.property to represent item in dropdown
								return item;
							}}
						/>

						<View style={styles.buttonContainer}>
							<Button
								buttonStyle={{
									width: "100%",
									backgroundColor: COLORS.primary,
									borderRadius: 8,
									height: 50,
								}}
								containerStyle={{ margin: 5 }}
								linearGradientProps={null}
								iconContainerStyle={{ background: "#000" }}
								loadingProps={{ animating: true }}
								loadingStyle={{}}
								onPress={onLoginPressed}
								title="Login"
								uppercase={true}
								titleProps={{}}
								titleStyle={{
									marginHorizontal: 5,
									color: COLORS.black,
								}}
							/>
						</View>
					</View>
				</SafeAreaView>
			</TouchableWithoutFeedback>
		</KeyboardAvoidingView>
	);
}

const styles = StyleSheet.create({
	container: {
		flex: 1,
		backgroundColor: COLORS.background,
	},
	inner: {
		flex: 1,
		alignItems: "center",
		justifyContent: "center",
	},
	logo: {
		resizeMode: "contain",
		height: 200,
		width: 300,
		marginTop: 20,
		marginBottom: 40,
	},
	interactive: {
		alignItems: "center",
		width: "100%",
	},
	input: {
		backgroundColor: COLORS.white,
		borderWidth: 2,
		borderColor: COLORS.secondary,
		borderRadius: 18,
		padding: 8,
		margin: 5,
		width: "80%",
		height: 50,
	},
	buttonContainer: {
		marginTop: 20,
		width: "90%",
	},
	dropdown2BtnStyle: {
		width: "90%",
		height: 50,
		backgroundColor: COLORS.white,
		// borderWidth: 2,
		// borderColor: COLORS.secondary,
		// borderRadius: 18,
		marginTop: 5,
	},
	dropdown2BtnTxtStyle: {
		color: COLORS.black,
		textAlign: "center",
		fontSize: 14,
	},
	dropdown2DropdownStyle: {
		backgroundColor: COLORS.white,
		borderRadius: 8,
	},
	dropdown2RowStyle: {
		backgroundColor: COLORS.white,
	},
	dropdown2RowTxtStyle: {
		color: COLORS.black,
		textAlign: "center",
		fontSize: 14,
	},
	dropdown2SelectedRowStyle: {
		backgroundColor: "rgba(255,255,255,0.2)",
	},
});

export default LoginPage;
