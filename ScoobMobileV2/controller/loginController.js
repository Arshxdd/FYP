// import React from "react";
// import { Text, View } from "react-native";
// import loginEntity from "../entity/loginEntity";

// const loginController = async (credentials) => {

//     // Call entity function
// 	loginEntity(credentials);
// };

// export default loginController;

import React from "react";
import { Text, View } from "react-native";
import loginEntity from "../entity/loginEntity";

export default function loginController(credentials) {
	return loginEntity(credentials);
}
/* LoginController.validateLogin(user, password, profile)

public boolean validateLogin(String username, String password, String userProfile) {
        return user.verifyLogin(username, password, userProfile);
    }

    public boolean verifyLogin(String username, String password, String userProfile) {
        boolean userExists = false;
        Connection c = null; // setup db Connection
        try {
            c = DriverManager.getConnection("jdbc:sqlite:updated_db.db");
            System.out.println("Opened DB Successfully");

            Statement stmt = c.createStatement();
            ResultSet rs = stmt.executeQuery("SELECT * FROM USERS WHERE username =" + "'" + username + "'"
                    + "AND password =" + "'" + password + "'" + "AND user_profile = " + "'" + userProfile + "'");
            if (!rs.next()) {
                // This means no account found
                System.out.println("No account found.");
            } else {
                // This means account found
                System.out.println("Account is valid.");
                userExists = true;
            }
        } catch (Exception e) {
            System.err.println(e);

        } finally {
            try {
                c.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
        return userExists;
    }
*/
