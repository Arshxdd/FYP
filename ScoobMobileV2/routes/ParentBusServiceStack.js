import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import ParentsBusServicePage from "../screens/Parents/BusServicePage";
import ParentsSubscribedPage from "../screens/Parents/SubscribedPage";
import ParentsSubscribePage from "../screens/Parents/SubscribePage";

import { Text } from "react-native";

const Stack = createStackNavigator();

function ParentBusServiceStack() {
	return (
		<Stack.Navigator
			screenOptions={{ headerShown: false }}
			initialRouteName="ParentsBusServicePage"
		>
			<Stack.Screen
				name="ParentsBusServicePage"
				component={ParentsBusServicePage}
			/>
			<Stack.Screen
				name="ParentsSubscribedPage"
				component={ParentsSubscribedPage}
			/>
			<Stack.Screen
				name="ParentsSubscribePage"
				component={ParentsSubscribePage}
			/>
		</Stack.Navigator>
	);
}

export default ParentBusServiceStack;
