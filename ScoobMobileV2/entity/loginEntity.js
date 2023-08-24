import { useNavigation } from "@react-navigation/native";
import axios from "axios";
import UserContext from "../context/UserContext";

export default async function loginEntity(credentials) {
	const navigation = useNavigation();
	const { setUserEmail, setUserDetails } = useContext(UserContext); // Get setUserEmail and setUserDetails from the context
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
		Alert.alert("Failed to perform login");
	}
}
