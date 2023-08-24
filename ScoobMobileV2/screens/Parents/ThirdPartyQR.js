import React, { useContext, useState } from "react";
import {
	SafeAreaView,
	StyleSheet,
	Text,
	TextInput,
	TouchableOpacity,
	View,
} from "react-native";
import QRCode from "react-native-qrcode-svg";
import CustomButton from "../../components/CustomButton";
import { COLORS } from "../../constants";
import UserContext from "../../context/UserContext";

const ThirdPartyQR = ({ route }) => {
	const { userDetails } = useContext(UserContext);

	return (
		<SafeAreaView style={{ flex: 1 }}>
			<View style={styles.container}>
				<Text style={styles.title}>Third Party QR</Text>
				<View style={styles.QRStyle}>
					<QRCode
						//QR code value
						value={`${userDetails.userId}`}
						//size of QR Code
						size={250}
						//Color of the QR Code (Optional)
						color={COLORS.black}
						//Background Color of the QR Code (Optional)
						backgroundColor={COLORS.white}
						//Logo of in the center of QR Code (Optional)
						logo={require("../../assets/images/icon.png")}
						//Center Logo size  (Optional)
						logoSize={50}
						logoMargin={-1}
						//Center Logo radius (Optional)
						logoBorderRadius={15}
						//Center Logo background (Optional)
						logoBackgroundColor={COLORS.white}
					/>
				</View>
			</View>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		alignItems: "center",
		justifyContent: "flex-start",
	},
	title: {
		fontSize: 35,
		padding: 50,
		fontFamily: "NunitoSans-Bold",
	},
	QRStyle: {
		padding: 50,
	},
	buttonStyle: {
		backgroundColor: COLORS.primary,
		borderWidth: 0,
		color: COLORS.white,
		borderColor: COLORS.primary,
		alignItems: "center",
		borderRadius: 5,
		marginTop: 30,
		padding: 10,
	},
	buttonTextStyle: {
		color: COLORS.black,
		paddingVertical: 10,
		fontSize: 16,
	},
});

export default ThirdPartyQR;
