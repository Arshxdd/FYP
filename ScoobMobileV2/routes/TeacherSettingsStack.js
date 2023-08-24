import React from "react";
import { createStackNavigator } from "@react-navigation/stack";

import TeachersSettingsPage from "../screens/Teachers/Settings";

import { Text } from "react-native";

const Stack = createStackNavigator();

function TeachersettingsStack() {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: false,
			}}
			initialRouteName="TeachersSettingsPage"
		>
			<Stack.Screen
				name="TeachersSettingsPage"
				component={TeachersSettingsPage}
			/>
		</Stack.Navigator>
	);
}

export default TeachersettingsStack;
