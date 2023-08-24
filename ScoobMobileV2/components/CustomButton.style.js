import { StyleSheet } from "react-native";
import { COLORS } from "../constants";

const styles = StyleSheet.create({
	// -------------------------------
	// Default style
	container: {
		// backgroundColor: COLORS.accent,
		width: "100%",
		padding: 15,
		alignItems: "center",
		borderRadius: 18,
	},
	text: {
		fontSize: 18,
		color: COLORS.text,
	},
	// -------------------------------

	container_SECONDARY: {
		marginBottom: 10,
		marginTop: 10,
		borderRadius: 18,
	},
	text_SECONDARY: {
		color: COLORS.text,
		fontSize: 18,
		padding: 35,
	},

	container_TERTIARY: {
		width: "75%",
		margin: 10,
	},
	text_TERTIARY: {
		fontSize: 18,
		color: COLORS.text,
	},

	container_QUARTERNARY: {
		width: "40%",
		padding: 0,
		marginVertical: 10,
		borderRadius: 18,
	},
	text_QUARTERNARY: {
		color: COLORS.text,
		fontSize: 18,
		padding: 15,
	},
});

export default styles;
