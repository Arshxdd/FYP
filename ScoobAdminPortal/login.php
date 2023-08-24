<?php
include('LoginController.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  //CHECK IF LOGIN BUTTON IS CLICKED
  if (isset($_POST['Login'])) {

    if (isset($_POST['type'])) {

      $type = $_POST['type'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      $userlogin = new Login();
      $success = $userlogin->login($type, $email, $password);

      if ($type === "System Admin" && $success === true) {
        echo "<script>alert('Login Successful. Welcome " . $type . ".'); window.location.href = 'systemadmin/manage-applications-home.php';</script>";
        exit();
      } else if ($type === "School Admin" && $success === true) {
        echo "<script>alert('Login Successful. Welcome " . $type . ".'); window.location.href = 'schooladmin/school-home.php';</script>";
        exit();
      } else if ($type === "Transport Admin" && $success === true) {
        echo "<script>alert('Login Successful. Welcome " . $type . ".'); window.location.href = 'transportadmin/transport-home.php';</script>";
        exit();
      } else {
        echo "<script>alert('Invalid login Credentials or Account Status Pending.');</script>";
      }
    } else {
      echo "<script>alert('Please select an a user type.'); window.location.href = 'login.php';</script>";
      exit();
    }
  }
}
?>

<html>

<head>
  <title>Scoob Web Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
  <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="login.php">
      <img src="img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Scoob Admin Portal
    </a>
    <a href="onboarding/onboard-home.php">Signup</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <!--Login Form-->
  <div class="container">
    <div class="image-column">
      <img src="img/scoobcirclesquare.png" alt="Image"><br>
      <a href="onboarding/onboard-home.php">Don't have an account? Signup now</a>
    </div>
    <div class="form-column">
      <h3>SCOOB ADMIN PORTAL</h3><br>
      <form method="post">
        <select id="type" name="type" required>
          <option disabled hidden selected>Select Admin Type</option>
          <option value="System Admin">System Admin</option>
          <option value="School Admin">School Admin</option>
          <option value="Transport Admin">Transport Admin</option>
        </select>
        <br>
        <input id="email" name="email" type="text" maxlength="30" placeholder="Email / Username" required>
        <br>
        <input id="password" name="password" type="password" placeholder="Password" required>
        <br>
        <input type="submit" id="submit" name="Login" value="Login">
      </form>
    </div>
  </div>
</body>

</html>





<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    /* background-color: #F07c34; */
    /* background-color: #ffa404; */
    background-color: #FFFFFF;
  }

  .container {
    display: flex;
    align-items: center;
    max-width: 800px;
    background-color: #F07c34;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .image-column {
    flex: 1;
    padding: 20px;
    border-radius: 10px;
    background-color: #F07c34;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .image-column a {
    color: #ffffff;
  }

  .image-column img {
    max-width: 100%;
    display: block;
  }

  .form-column {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .form-column h3 {
    margin-top: 10px;
    color: #ffffff;
    /* Change the color of the h2 to #093d65 */
  }

  .form-column label,
  .form-column input,
  .form-column select {
    display: block;
    width: 100%;
    margin-bottom: 15px;
  }

  .form-column input[type="text"],
  .form-column input[type="password"],
  .form-column select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    /* Adjust the width for wider input fields */
    width: 300px;
  }

  .form-column input[type="submit"] {
    padding: 10px 20px;
    background-color: #093d65;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .form-column input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>