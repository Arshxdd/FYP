import React from "react";
import { Pressable, SafeAreaView, StyleSheet, Text, View } from "react-native";
import { COLORS } from "../constants";

export default function TestButton({ onPress }) {
	return (
		<SafeAreaView style={styles.container}>
			<Pressable
				onPress={onPress}
				style={({ pressed }) => [
					{
						backgroundColor: pressed ? COLORS.pressed : COLORS.accent,
					},
					styles.button,
				]}
			>
				<Text style={styles.text}>Im a button</Text>
			</Pressable>
		</SafeAreaView>
	);
}

const styles = StyleSheet.create({
	container: {
		flex: 1,
	},
	button: {
		alignItems: "center",
		justifyContent: "center",
		borderRadius: 18,
		padding: 10,
		height: 50,
		minHeight: 50,
	},
	text: {
		fontSize: 20,
		fontFamily: "NunitoSans-Regular",
	},
});
