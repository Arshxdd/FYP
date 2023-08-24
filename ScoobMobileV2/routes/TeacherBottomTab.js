import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import React from "react";
import Icon from "react-native-vector-icons/Ionicons";
import { COLORS } from "../constants";

// Need to redo import style
import TeachersChatPage from "../screens/Teachers/ChatPage";
import TeachersHomeStack from "./TeacherHomeStack";
import TeachersSettingsStack from "./TeacherSettingsStack";

const Tab = createBottomTabNavigator();
const TeacherBottomTab = () => {
	return (
		<Tab.Navigator
			screenOptions={({ route }) => ({
				headerShown: false,
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
				// To dynamically set bottom tab bar icons to icon pack, name must be the same, KIV
				tabBarIcon: ({ color, size, focused }) => {
					let iconName;

					if (route.name === "TeachersHome") {
						iconName = focused ? "ios-home-sharp" : "ios-home-outline";
					} else if (route.name === "TeachersSettings") {
						iconName = focused ? "settings" : "settings-outline";
					} else if (route.name === "TeachersChat") {
						iconName = focused ? "chatbubbles" : "chatbubbles-outline";
					}

					return <Icon name={iconName} size={25} color={color} />;
				},
			})}
		>
			<Tab.Screen
				name="TeachersHome"
				component={TeachersHomeStack}
				options={{ tabBarLabel: "Home" }}
			/>
			{/* <Tab.Screen name="TeachersHome" component={TeachersHomePage} options={{tabBarLabel: "Home", gestureEnabled: false,}}/> */}
			{/* <Tab.Screen
				name="TeachersChat"
				component={TeachersChatPage}
				options={{
					tabBarLabel: "Chat",
					headerShown: true,
					headerTitle: "",
					headerStyle: { backgroundColor: COLORS.background },
				}}
			/> */}
			<Tab.Screen
				name="TeachersSettings"
				component={TeachersSettingsStack}
				options={{ tabBarLabel: "Settings" }}
			/>
		</Tab.Navigator>
	);
};

export default TeacherBottomTab;
