import { Button } from "@rneui/themed";
import React from "react";
import { SafeAreaView, StyleSheet, Text, View } from "react-native";
import COLORS from "../../constants/colors";

import CustomButton from "../../components/CustomButton";

const PUZInfoPage = ({ navigation, route }) => {
	const { fname, lname, parentFname, parentLname } = route.params;

	// console.log(route.params);

	return (
		<SafeAreaView style={styles.container}>
			<View style={styles.text}>
				<Text style={styles.details}>
					Parent: {parentFname} {parentLname}
				</Text>
				<Text style={styles.details}>
					Child: {fname} {lname}
				</Text>
			</View>
			<View style={styles.button}>
				<Button
					buttonStyle={{
						width: 150,
						backgroundColor: COLORS.primary,
						borderRadius: 8,
						height: 50,
					}}
					containerStyle={{ margin: 5 }}
					linearGradientProps={null}
					iconContainerStyle={{ background: "#000" }}
					loadingProps={{ animating: true }}
					loadingStyle={{}}
					onPress={() =>
						navigation.navigate("ScanID", {
							parentid: route.params.parentid,
							studentid: route.params.studentid,
						})
					}
					title="Scan ID"
					titleProps={{}}
					titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
				/>
			</View>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
	},
	button: {
		alignItems: "center",
		justifyContent: "center",
		flex: 1,
		paddingTop: 50,
	},
	text: {
		alignItems: "center",
		fontSize: 18,
		flex: 1,
		justifyContent: "flex-end",
	},
	details: {
		fontSize: 20,
		fontWeight: "bold",
		margin: 10,
	},
});

export default PUZInfoPage;
