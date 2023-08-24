const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const mysql = require("mysql2");

const app = express();
const port = 3306;

app.use(bodyParser.json());
app.use(cors());

const connection = mysql.createConnection({
	host: "scoob-database.c8k5fhmymkis.ap-southeast-1.rds.amazonaws.com",
	// host: "localhost",
	user: "admin",
	password: "admin123",
	database: "scoob",
});

connection.connect((err) => {
	if (err) {
		console.error("Error connecting to the database: ", err);
		return;
	}
	console.log("Connected to the database!");
});

app.get("/parentguardians", (req, res) => {
	connection.query(
		"SELECT * FROM parentguardians",
		(error, results, fields) => {
			if (error) {
				console.error("Error retrieving users: ", error);
				res.status(500).send({ message: "Error retrieving users" });
				return;
			}
			res.send(results);
		}
	);
});

app.listen(port, () => {
	console.log(`Server running on port ${port}`);
});

fetch("http://localhost:3306/parentguardians")
	.then((response) => response.json())
	.then((data) => console.log(data))
	.catch((error) => console.error(error));
