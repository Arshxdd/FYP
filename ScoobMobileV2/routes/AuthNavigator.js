import { createStackNavigator } from "@react-navigation/stack";
import { Auth } from "aws-amplify";
import React from "react";

import COLORS from "../constants/colors";
import LoginPage from "../screens/LoginPage";
import DriverBottomTab from "./DriverBottomTab";
import ParentBottomTab from "./ParentBottomTab";
import TeacherBottomTab from "./TeacherBottomTab";

const Stack = createStackNavigator();

function AuthNavigator() {
	return (
		<Stack.Navigator
			screenOptions={{
				headerStyle: {
					backgroundColor: COLORS.background,
					shadowColor: "transparent",
					elevation: 0,
				},
				headerTitleAlign: "center",
				headerTintColor: COLORS.background,
			}}
			initialRouteName="LoginPage"
		>
			<Stack.Screen
				name="LoginPage"
				component={LoginPage}
				options={{
					headerTitle: " ",
					headerShown: false,
				}}
			/>
			{/* <Stack.Screen 
			name="ParentsHomePage" 
			component={ParentsHomePage} 
			options={{
				headerLeft: () => null, // Remove back button
				headerTitle: "Home"
			}}
		/> */}
			<Stack.Screen
				name="ParentBottomTab"
				component={ParentBottomTab}
				options={{
					headerShown: false,
					gestureEnabled: false,
				}}
			/>
			<Stack.Screen
				name="DriverBottomTab"
				component={DriverBottomTab}
				options={{ headerShown: false, gestureEnabled: false }}
			/>
			<Stack.Screen
				name="TeacherBottomTab"
				component={TeacherBottomTab}
				options={{ headerShown: false, gestureEnabled: false }}
			/>
		</Stack.Navigator>
	);
}

export default AuthNavigator;
