import { NavigationContainer } from "@react-navigation/native";
import { useFonts } from "expo-font";
import * as SplashScreen from "expo-splash-screen";
import { StatusBar } from "expo-status-bar";
import React, { useEffect, useState } from "react";
import "react-native-gesture-handler";
import { GestureHandlerRootView } from "react-native-gesture-handler";
import { setCustomText, setCustomTextInput } from "react-native-global-props";
import AuthNavigator from "./routes/AuthNavigator";

import COLORS from "./constants/colors";

import { UserProvider } from "./context/UserContext";
// --------------AWS AMPLIFY ----------
import { Amplify } from "aws-amplify";
import aws_exports from "./src/aws-exports";
Amplify.configure(aws_exports);
//-------------------------------------

export default function App() {
	const [fontsLoaded] = useFonts({
		Urbanist: require("./assets/fonts/Urbanist.ttf"),
		"NunitoSans-Regular": require("./assets/fonts/NunitoSans-Regular.ttf"),
		"NunitoSans-Bold": require("./assets/fonts/NunitoSans-Bold.ttf"),
		"DMSerifDisplay-Regular": require("./assets/fonts/DMSerifDisplay-Regular.ttf"),
	});

	useEffect(() => {
		async function prepare() {
			await SplashScreen.preventAutoHideAsync();
		}
		prepare();
	}, []);

	if (!fontsLoaded) {
		return undefined;
	} else {
		SplashScreen.hideAsync();
	}
	// ----------------------------------------------

	// ---------------- Setting Global Styles ----------------
	const customTextProps = {
		style: {
			fontFamily: "DMSerifDisplay-Regular",
			color: COLORS.text,
		},
	};
	setCustomText(customTextProps);

	const customTextInputProps = {
		style: {
			fontFamily: "NunitoSans-Regular",
			color: COLORS.text,
		},
	};
	setCustomTextInput(customTextInputProps);
	// --------------------------------------------------------

	return (
		<UserProvider>
			<GestureHandlerRootView style={{ flex: 1 }}>
				<NavigationContainer>
					<AuthNavigator />
				</NavigationContainer>
			</GestureHandlerRootView>
		</UserProvider>
	);
}
