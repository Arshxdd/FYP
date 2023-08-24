import { useBottomTabBarHeight } from "@react-navigation/bottom-tabs";
import { BlurView } from "expo-blur";
import React from "react";
import {
	FlatList,
	Image,
	SafeAreaView,
	ScrollView,
	StyleSheet,
	Text,
	TouchableOpacity,
	View,
} from "react-native";
import Icon from "react-native-vector-icons/Ionicons";
import TestAnimation from "../../components/TestAnimation";
import TestButton from "../../components/TestButton";

import { Button } from "@react-native-material/core";
import { HStack, Stack, VStack } from "react-native-flex-layout";

import { Input } from "@rneui/base";
import Icon2 from "react-native-vector-icons/MaterialCommunityIcons";

const ChatPage = () => {
	const tabBarHeight = useBottomTabBarHeight();

	return (
		<SafeAreaView style={[styles.container]}>
			<ScrollView style={{ flex: 1, width: "100%" }}>
				<View style={{ marginBottom: tabBarHeight }}>
					<Text style={styles.text}>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
						eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
						ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
						aliquip ex ea commodo consequat. Duis aute irure dolor in
						reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
						pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
						culpa qui officia deserunt mollit anim id est laborum.
					</Text>
					{/* <Image
					style={{ resizeMode: "contain" }}
					source={require("../../assets/images/ScooB.png")}
				/>
					{/* <TestAnimation /> */}
					{/* <TestButton style={styles.button} />
					<HStack m={4} spacing={6} justify="center">
						<Button title="Contained" />
						<Button variant="outlined" title="Outlined" />
						<Button variant="text" title="Text" />
					</HStack>
					<VStack m={4} spacing={6} justify="center">
						<Input
							containerStyle={{}}
							disabledInputStyle={{ background: "#ddd" }}
							inputContainerStyle={{}}
							errorStyle={{}}
							errorProps={{}}
							inputStyle={{}}
							label="Login"
							labelStyle={{}}
							labelProps={{}}
							leftIcon={<Icon name="person" size={20} />}
							leftIconContainerStyle={{}}
							rightIconContainerStyle={{}}
							placeholder="Enter Username"
						/>
						<Input
							containerStyle={{}}
							disabledInputStyle={{ background: "#ddd" }}
							inputContainerStyle={{}}
							errorStyle={{}}
							errorProps={{}}
							inputStyle={{}}
							labelStyle={{}}
							labelProps={{}}
							leftIcon={<Icon name="lock-closed" size={20} />}
							leftIconContainerStyle={{}}
							rightIconContainerStyle={{}}
							placeholder="Enter Password"
						/>
					</VStack> */}
				</View>
			</ScrollView>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		alignItems: "center",
		justifyContent: "center",
	},
	text: {
		fontWeight: "400",
		fontSize: 43,
	},
	button: {
		flex: 1,
		width: "40",
	},
});

export default ChatPage;
