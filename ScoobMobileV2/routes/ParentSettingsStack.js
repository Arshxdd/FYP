import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import ParentsProfilePage from "../screens/Parents/ProfilePage";
import ParentsSettingsPage from "../screens/Parents/Settings";

import { Text } from "react-native";
import { COLORS } from "../constants";

const Stack = createStackNavigator();

function ParentSettingsStack() {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: true,
				headerTitle: "",
				headerStyle: {
					backgroundColor: COLORS.background,
				},
			}}
			initialRouteName="ParentsSettingsPage"
		>
			<Stack.Screen
				name="ParentsSettingsPage"
				component={ParentsSettingsPage}
				options={{ headerLeft: false }}
			/>
			<Stack.Screen name="ParentsProfile" component={ParentsProfilePage} />
		</Stack.Navigator>
	);
}

export default ParentSettingsStack;
