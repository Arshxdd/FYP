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
        <h1 style="display: inline;">Assign Driver to Bus</h1> <br><br>
      </div>

      <form method="post">
        <b>Selected Driver Name & ID:</b><br>
        <?php echo $_SESSION['assignname'] . ' / ' . $_SESSION['assigndriver'] ?><br><br>
        <?php
        $aaa = GetNoAssignBus::getNoAssignBus();
        $result = $_SESSION['viewNoAssignBusSQLTable'];

        if ($result == NULL) {
          echo "<b>No buses available to assign.</b>";
        } else {
          echo "<b>Available Buses:</b><br>";
          echo "<select name='busid'>";
          while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['busid'] . "'>" . $row['busid'] . "</option>";
          }
          echo "</select><br><br><br>";
        }
        ?>
        <input type="submit" name="submit" value="Assign Bus">

        <?php
        if (isset($_POST["submit"])) {
          $busid = $_POST["busid"];
          $driverid = $_SESSION['assigndriver'];

          $assignBus = new AssignBus();
          $assignBus->assignBus($busid, $driverid);

          if ($assignBus == true) {
            echo "<script>alert('Bus successfully assigned'); window.location.href = 'transport-manage-drivers.php';</script>";
          } else {
            echo "<script>alert('Bus already assigned'); window.location.href = 'transport-manage-drivers-assign.php';</script>";
          }
        }
        ?>

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