import React from "react";
import { Pressable, StyleSheet, Text, View } from "react-native";
import { TapGestureHandler } from "react-native-gesture-handler";
import Animated, {
	useAnimatedGestureHandler,
	useAnimatedStyle,
	useSharedValue,
	withSpring,
} from "react-native-reanimated";

export default function TestAnimation() {
	const pressed = useSharedValue(false);

	const eventHandler = useAnimatedGestureHandler({
		onStart: (event, ctx) => {
			pressed.value = true;
		},
		onEnd: (event, ctx) => {
			pressed.value = false;
		},
	});

	const uas = useAnimatedStyle(() => {
		return {
			backgroundColor: pressed.value ? "#feef86" : "#001972",
			transform: [{ scale: withSpring(pressed.value ? 1 : 0.5) }],
		};
	});

	return (
		<TapGestureHandler onGestureEvent={eventHandler}>
			<Animated.View style={[styles.ball, uas]}></Animated.View>
			{/* <Pressable
				onPress={() => {
					// alert("Pressed");
				}}
				style={({ pressed }) => [
					{
						backgroundColor: pressed ? "pink" : "grey",
					},
					styles.button,
				]}
			>
				<Text style={styles.text}>Im a button</Text>
			</Pressable> */}
		</TapGestureHandler>
	);
}

const styles = StyleSheet.create({
	container: {
		flex: 1,
	},
	button: {
		alignItems: "center",
		borderRadius: 18,
		padding: 6,
		height: 50,
	},
	text: {
		fontSize: 20,
	},
	ball: {
		flex: 1,
		width: 100,
		height: 100,
		borderRadius: 100 / 2,
	},
});
