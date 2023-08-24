<?php
include 'TransportAdminController.php';
include '../LogoutController.php';
session_start();

//VERIFY IF SYSTEMADMIN SESSION TYPE
if ($_SESSION['type'] != "Transport Admin") {
  header("Location: ../login.php");
}

if (isset($_POST["logout"])) {
  $logout = new LogoutController();
  $logout->logout();
}
?>

<html>

<head>
  <title>Transport Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/custom.css">
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/live-clock.js"></script>
</head>

<body>
  <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="transport-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Transport Admin - Managing Buses</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!--Navigation Shortcuts-->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a style="color:white;" id="current-time"></a></li>
      </ul>
    </div>
  </nav>

  <!-- Main Container -->
  <div class="bodyContainer">
    <div class="leftPanel">
      <button class="customButton" type="button" onclick="window.location.href='transport-manage-buses.php'"> <span>Manage Buses</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-manage-drivers.php'"> <span>Manage Drivers</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-manage-routes.php'"> <span>Manage Routes</span></button><br><br>
<button class="customButton" type="button" onclick="window.location.href='transport-active-routes.php'"> <span>View Active Routes</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-import.php'"> <span>Import Data</span></button><br><br>
      <form method="post">
        <button class="logoutButton" tpe="button" name="logout">Logout</button>
      </form>
    </div>

    <div class="rightPanel">
      <div class="header">
        <h1 style="display: inline;">Add A Driver</h1> <br><br>
      </div>

      <form method="post">
        <label>Driver ID: </label><br>
        <input type="text" name="driverid" placeholder="Driver ID" required><br><br>
        <label>Driver First Name: </label><br>
        <input type="text" name="fname" placeholder="First Name" required><br><br>
        <label>Driver Last Name: </label><br>
        <input type="text" name="lname" placeholder="Last Name" required><br><br>
        <label>Driver Phone: </label><br>
        <input type="text" name="phone" placeholder="Phone" required><br><br>
        <label>Driver Email: </label><br>
        <input type="text" name="email" placeholder="Email" required><br><br>
        <label>Driver Account Password: </label><br>
        <input type="text" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="submit" value="Add Driver">
      </form>

      <?php
      if (isset($_POST["submit"])) {

        $driverid = $_POST["driverid"];
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        $addDriver = new AddDriver();
        $addDriver->addDriver($driverid, $fname, $lname, $phone, $email, $password);

        if ($addDriver == true) {
          echo "<script>alert('Driver successfully added'); window.location.href = 'transport-manage-buses.php';</script>";
        } else {
          echo "<script>alert('Driver already exists'); window.location.href = 'transport-manage-buses-add.php';</script>";
        }
      }
      ?>

    </div> <!-- End of RightPanel -->

  </div> <!-- End of Container -->
</body>

</html>


<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th,
  td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
  }

  .view-button {
    background-color: #4CAF50;
    color: white;
    padding: 6px 10px;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    cursor: pointer;
    margin-bottom: 0px;
  }

  .edit-button {
    background-color: #4CAF50;
    color: white;
    padding: 6px 10px;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    cursor: pointer;
    margin-bottom: 0px;
  }

  .delete-button {
    background-color: #f44336;
    color: white;
    padding: 6px 10px;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    cursor: pointer;
    margin-bottom: 0px;
  }

  form {
    margin-bottom: 0;
  }
</style>