import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import { COLORS } from "../constants";

import ChildInfoPage from "../screens/Parents/ChildInfoPage";
import ThirdPartyQR from "../screens/Parents/ThirdPartyQR";

const Stack = createStackNavigator();

const ChildInfoStack = ({ route }) => {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: true,
				headerTitle: " ",
				headerStyle: {
					backgroundColor: COLORS.background,
				},
			}}
			initialRouteName="ChildInfoPage"
		>
			<Stack.Screen
				name="ChildInfoPage"
				component={ChildInfoPage}
				initialParams={route.params.childInfo}
				options={{
					headerShown: true,
					headerTitle: " ",
				}}
			/>
			<Stack.Screen name="ThirdPartyQR" component={ThirdPartyQR} options={{}} />
		</Stack.Navigator>
	);
};

export default ChildInfoStack;
