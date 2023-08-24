import axios from "axios";
import React, { useContext, useEffect, useState } from "react";
import {
	Alert,
	FlatList,
	SafeAreaView,
	StyleSheet,
	TouchableHighlight,
	View,
} from "react-native";
import UserContext from "../../context/UserContext";

import { HStack, Text } from "@react-native-material/core";
import { Avatar, ListItem } from "@rneui/base";
import { Button, Icon } from "@rneui/themed";
import COLORS from "../../constants/colors";

import * as Location from "expo-location";
import MapView, { Marker } from "react-native-maps";

const HomePage = ({ route, navigation }) => {
	const { userDetails } = useContext(UserContext);
	const [tripData, setTripData] = useState("");
	const [childData, setChildData] = useState("");
	const [trip, setTrip] = useState();
	var ts = " ";
	var did = " ";
	var bid = " ";
	const lambdaEndpoint =
		"https://2teci17879.execute-api.ap-southeast-1.amazonaws.com/dev";

	// ! for testing location
	const [location, setLocation] = useState({});
	const [errorMsg, setErrorMsg] = useState(null);

	const fetchTripData = async () => {
		// Fetch trip data
		try {
			const response = await axios.get(
				`${lambdaEndpoint}/bus_driver/${userDetails.userId}`
			);
			const data = response.data;
			setTripData(data);
			ts = data[0].tripstatus;
			did = data[0].driverid;
			bid = data[0].busid;
			setTrip(ts === "Started" ? true : false);

			console.log("fetchTripData() Successful");
		} catch (error) {
			console.error("fetchTripData() Unsuccessful: ", error);
			setTripData(null);
		}

		// Fetch student data
		try {
			// ! TO LOOK AT THIS FUNCTION IN APP.JS (ERROR HANDLING PART) AGAIN
			const response = await axios.get(
				`${lambdaEndpoint}/student/${bid}/takingbus`
			);
			const data = response.data;
			setChildData(data);
			console.log("fetchStudentData() Successful");
		} catch (error) {
			console.error("fetchStudentData() Unsuccessful: ", error);
			setChildData(null);
		}
	};

	// ! Test live location
	const getLiveLocation = async () => {
		let { status } = await Location.requestForegroundPermissionsAsync();
		if (status !== "granted") {
			setErrorMsg("Permission to access location was denied");
			return;
		}
		let location = await Location.getCurrentPositionAsync({
			enableHighAccuracy: true,
		});
		setLocation({
			latitude: location.coords.latitude,
			longitude: location.coords.longitude,
			latitudeDelta: 0.0922,
			longitudeDelta: 0.0421,
		});
	};

	const focusHandler = async () => {
		navigation.addListener("focus", () => {
			fetchTripData();
			console.log("Refreshed!");
		});
	};

	useEffect(() => {
		// ! test live location
		getLiveLocation();

		focusHandler();
	}, [navigation]);

	// ! testing location
	let text = "Waiting..";
	if (errorMsg) {
		text = errorMsg;
	} else if (location) {
		text = JSON.stringify(location);
	}
	console.log(location);

	const startHandler = () => {
		console.log(userDetails.userId);
		axios
			.put(`${lambdaEndpoint}/bus_driver/${userDetails.userId}/start`)
			.then((response) => {
				setTrip(true);
				console.log(trip);
				Alert.alert("Success", "Trip has started!");
			})
			.catch((error) => {
				console.error("Error updating trip status:", error);
				// Show an error message to the user
				Alert.alert("Error", "No students on the bus!");
			});
	};

	const endHandler = () => {
		axios
			.put(`${lambdaEndpoint}/bus_driver/${userDetails.userId}/end`)
			.then((response) => {
				setTrip(false);
				console.log(trip);
				Alert.alert("Success", "Trip has ended!");
			})
			.catch((error) => {
				console.error("Error updating pickup status:", error);
				// Show an error message to the user
				Alert.alert(
					"Error",
					"Failed to update pickup status. Please try again."
				);
			});
	};

	const scannerHandler = () => {
		navigation.navigate("DriversScannerPage", { childData });
	};

	return (
		<SafeAreaView style={styles.container}>
			<HStack justify={"space-between"} align={"center"} m={10}>
				<Text variant="h5" style={styles.title}>
					Trip
				</Text>
				<Icon
					raised
					underlayColor={COLORS.white}
					name="barcode-scan"
					type="material-community"
					color={COLORS.secondary}
					onPress={scannerHandler}
				/>
			</HStack>
			<View style={styles.scrollContainer}>
				<FlatList
					showsVerticalScrollIndicator={false}
					contentContainerStyle={styles.scrollViewItem}
					// keyExtractor={(item) => item.id} //if you want to extract key value
					data={childData}
					renderItem={({ item }) => (
						<ListItem
							bottomDivider
							Component={TouchableHighlight}
							containerStyle={{
								// borderRadius: 8,
								height: 150,
							}}
							disabledStyle={{ opacity: 0.5 }}
							pad={20}
						>
							<Avatar
								rounded
								title={`${item.fname[0]}`}
								containerStyle={{ backgroundColor: "grey" }}
							/>
							<ListItem.Content>
								<ListItem.Title>
									<Text
										variant="h4"
									// style={styles.text}
									>{`${item.fname} ${item.lname}`}</Text>
								</ListItem.Title>
								<ListItem.Subtitle>
									<Text>{`${item.studentid}, ${item.class}`}</Text>
								</ListItem.Subtitle>
								<ListItem.Subtitle>
									<Text>S'{`${item.pcode}`}</Text>
								</ListItem.Subtitle>
							</ListItem.Content>
							{/* <ListItem.Chevron /> */}
						</ListItem>
					)}
				/>
			</View>
			<View style={styles.buttonStack}>
				<HStack>
					<Button
						buttonStyle={{
							width: 150,
							backgroundColor: COLORS.primary,
							borderRadius: 8,
							height: 50,
						}}
						containerStyle={{ margin: 5 }}
						disabled={trip === true ? true : false}
						disabledStyle={{}}
						disabledTitleStyle={{}}
						linearGradientProps={null}
						iconContainerStyle={{ background: "#000" }}
						loadingProps={{ animating: true }}
						loadingStyle={{}}
						onPress={startHandler}
						title="Start Trip"
						titleProps={{}}
						titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
					/>
					<Button
						buttonStyle={{
							width: 150,
							backgroundColor: COLORS.primary,
							borderRadius: 8,
							height: 50,
						}}
						containerStyle={{ margin: 5 }}
						disabled={trip === false ? true : false}
						disabledStyle={{}}
						disabledTitleStyle={{}}
						linearGradientProps={null}
						iconContainerStyle={{ background: "#000" }}
						loadingProps={{ animating: true }}
						loadingStyle={{}}
						onPress={endHandler}
						title="End trip"
						titleProps={{}}
						titleStyle={{ marginHorizontal: 5, color: COLORS.black }}
					/>
				</HStack>
				<MapView style={styles.map}>
					<Marker coordinate={location} title="Marker" />
				</MapView>
			</View>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		paddingHorizontal: 10,
	},
	scrollContainer: {
		// paddingHorizontal: 15,
		padding: 8,
		borderRadius: 8,
		backgroundColor: "lightgray",
		margin: 10,
		minHeight: 150,
		maxHeight: 225,
	},
	scrollViewItem: {
		justifyContent: "center",
		alignSelf: "stretch",
	},
	image: {
		resizeMode: "contain",
		height: 20,
		width: 10,
	},
	title: {
		// paddingTop: 10,
		// paddingLeft: 10,
		padding: 15,
		fontWeight: "bold",
		// fontFamily: "NunitoSans-Bold",
	},
	text: {
		fontWeight: "bold",
	},
	buttonStack: {
		alignItems: "center",
		// paddingTop: 250,
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
	map: {
		width: "80%",
		height: "70%",
	},
});

export default HomePage;
