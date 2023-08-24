import React, { useEffect, useState } from "react";
import { SafeAreaView, StyleSheet, Text, View } from "react-native";

const ChatPage = () => {
	const [data, setData] = useState([]);

	useEffect(() => {
		fetch("http://localhost:3306/parentguardians")
			.then((response) => response.json())
			.then((data) => console.log(data))
			.catch((error) => console.error(error));
	});

	return (
		<SafeAreaView style={styles.container}>
			<Text>{data}</Text>
		</SafeAreaView>
	);
};

const styles = StyleSheet.create({
	container: {
		flex: 1,
		alignItems: "center",
		justifyContent: "center",
	},
});

export default ChatPage;
