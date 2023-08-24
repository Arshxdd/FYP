import { createStackNavigator } from "@react-navigation/stack";
import React from "react";

import DriversHomePage from "../screens/Drivers/HomePage";
import DriversScannerPage from "../screens/Drivers/ScannerPage";

import COLORS from "../constants/colors";

const Stack = createStackNavigator();

const DriverHomeStack = () => {
	return (
		<Stack.Navigator
			screenOptions={{
				headerShown: false,
				headerTitle: " ",
				headerStyle: {
					backgroundColor: COLORS.background,
				},
			}}
			initialRouteName="DriversHomePage"
		>
			<Stack.Screen
				name="DriversHomePage"
				component={DriversHomePage}
				options={{
					headerLeft: false,
				}}
			/>
			<Stack.Screen
				name="DriversScannerPage"
				component={DriversScannerPage}
				options={{
					headerShown: true,
				}}
			/>
		</Stack.Navigator>
	);
};

export default DriverHomeStack;
