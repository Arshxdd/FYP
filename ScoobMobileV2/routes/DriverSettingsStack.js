import React from "react";
import { createStackNavigator } from "@react-navigation/stack";

import DriversSettingsPage from "../screens/Drivers/Settings";

import { Text } from "react-native";

const Stack = createStackNavigator();

function DriversSettingsStack() {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: false,
			}}
			initialRouteName="DriversSettingsPage"
		>
			<Stack.Screen
				name="DriversSettingsPage"
				component={DriversSettingsPage}
			/>
		</Stack.Navigator>
	);
}

export default DriversSettingsStack;
