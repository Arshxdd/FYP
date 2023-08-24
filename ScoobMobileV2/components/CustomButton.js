import React from "react";
import { Icon, Pressable, StyleSheet, Text, View } from "react-native";

import { COLORS } from "../constants";
import styles from "./CustomButton.style";

const CustomButton = ({ onPress, text, type }) => {
	return (
		<Pressable
			onPress={onPress}
			style={({ pressed }) => [
				{
					backgroundColor: pressed ? COLORS.pressed : COLORS.accent,
				},
				[styles.container, styles[`container_${type}`]],
			]}
		>
			<Text style={[styles.text, styles[`text_${type}`]]}>{text}</Text>
		</Pressable>
	);
};

export default CustomButton;
