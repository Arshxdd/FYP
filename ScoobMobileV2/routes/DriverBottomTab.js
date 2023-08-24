import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import React from "react";
import Icon from "react-native-vector-icons/Ionicons";
import { COLORS } from "../constants";

// Need to redo import style
import DriversSettingsPage from "../screens/Drivers/Settings";
import DriverHomeStack from "./DriverHomeStack";

const Tab = createBottomTabNavigator();

function DriverBottomTab() {
	return (
		<Tab.Navigator
			screenOptions={({ route }) => ({
				headerShown: false,
				headerTitle: "",
				tabBarShowLabel: false,
				gestureEnabled: false,
				tabBarActiveBackgroundColor: COLORS.background,
				tabBarInactiveBackgroundColor: COLORS.background,
				tabBarActiveTintColor: COLORS.primary,
				tabBarInactiveTintColor: COLORS.secondary,
				tabBarStyle: {
					paddingBottom: 0,
				},
				tabBarIconStyle: {
					paddingBottom: Platform.OS === "ios" ? 25 : 0,
				},
				headerStyle: {
					backgroundColor: COLORS.background,
				},
				// To dynamically set bottom tab bar icons to icon pack, name must be the same, KIV
				tabBarIcon: ({ color, size, focused }) => {
					let iconName;

					if (route.name === "DriversHome") {
						iconName = focused ? "ios-home-sharp" : "ios-home-outline";
					} else if (route.name === "DriverSettings") {
						iconName = focused ? "settings" : "settings-outline";
					}

					return <Icon name={iconName} size={25} color={color} />;
				},
			})}
		>
			<Tab.Screen
				name="DriversHome"
				component={DriverHomeStack}
				options={{
					tabBarLabel: "Home",
					gestureEnabled: false,
					headerStyle: { backgroundColor: COLORS.background },
				}}
			/>
			<Tab.Screen
				name="DriverSettings"
				component={DriversSettingsPage}
				options={{ tabBarLabel: "Settings" }}
			/>
		</Tab.Navigator>
	);
}

export default DriverBottomTab;
