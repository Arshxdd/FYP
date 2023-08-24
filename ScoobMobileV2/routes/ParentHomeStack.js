import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import { COLORS } from "../constants";
import ParentsHomePage from "../screens/Parents/HomePage";
import ChildInfoStack from "./ChildInfoStack";

const Stack = createStackNavigator();

const ParentHomeStack = () => {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: true,
				headerTitle: " ",
				headerStyle: {
					backgroundColor: COLORS.background,
				},
			}}
			initialRouteName="ParentsHomePage"
		>
			<Stack.Screen
				name="ParentsHomePage"
				component={ParentsHomePage}
				options={{
					headerShown: false,
					headerLeft: false,
				}}
			/>
			<Stack.Screen
				name="ChildInfoStack"
				component={ChildInfoStack}
				options={{
					headerShown: false,
					headerTitle: "Child Info",
				}}
			/>
		</Stack.Navigator>
	);
};

export default ParentHomeStack;
