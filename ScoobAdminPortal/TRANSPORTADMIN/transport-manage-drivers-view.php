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

if (isset($_POST['assignBus'])) {

  //SAVE DRIVERID TO SESSION
  $_SESSION['assigndriver'] = $_POST['driverid'];
  $_SESSION['assignname'] = $_POST['drivername'];

  //REDIRECT TO ASSIGN BUS PAGE
  echo '<script>window.location.href="transport-manage-drivers-assign.php";</script>';
}

if (isset($_POST['deleteDriver'])) {
  $driverid = $_POST['driverid'];
  $execute = DeleteDriver::deleteDriver($driverid);

  if ($execute) {
    echo '<script>alert("Driver deleted successfully.");</script>';
    echo '<script>window.location.href="transport-manage-drivers.php";</script>';
  } else {
    echo '<script>alert("Error deleting driver.");</script>';
    echo '<script>window.location.href="transport-manage-drivers.php";</script>';
  }
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
    <a class="navbar-brand" href="transport-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Transport Admin - Managing Drivers</a>
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
      <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 style="margin: 0;">Viewing Driver Details</h1>
        <div style="display: flex; align-items: center;">
          <a href="transport-manage-drivers-add.php" style="margin-right: 10px;"><button>Add Driver</button></a>
          <form method="post" action="transport-manage-drivers-search.php">
            <input type="text" name="searchQuery" placeholder="Search Driver" style="margin-right: 5px;" required>
            <input type="submit" value="Search">
          </form>
        </div>
      </div>

      <div class="data">
        <?php
        if (isset($_POST['driverid'])) {
          $driverid = $_POST['driverid'];

          $aaa = ViewDriver::viewDriver($driverid);
          $result = NULL; //PLACEHOLDER

          if (isset($_SESSION['viewDriverSQLTable'])) {
            $result = $_SESSION['viewDriverSQLTable'];
          }

          if ($result == NULL) {
            echo 'No drivers found.';
          } else {
            //PRINT TABLE HEADERS
            echo '<table class="table table-bordered table-sm" style="text-align: center">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">S/N</th>';
            echo '<th scope="col">Driver ID</th>';
            echo '<th scope="col">Driver Name</th>';
            echo '<th scope="col">Assigned Bus</th>';
            echo '<th scope="col">Email</th>';
            echo '<th scope="col">Phone Number</th>';
            echo '<th scope="col">Action</th>';
            echo '</tr>';
            echo '</thead>';

            $rowNumber = 1;

            while ($row = mysqli_fetch_assoc($result)) {
              echo '<tbody>';
              echo '<tr>';
              echo '<td>' . $rowNumber . "</td>";
              echo '<td>' . $row['driverid'] . "</td>";
              echo '<td>' . $row['drivername'] . "</td>";
              echo '<td>' . $row['busid'] . "</td>";
              echo '<td>' . $row['email'] . "</td>";
              echo '<td>' . $row['phone'] . "</td>";

              //BUTTON FORM TO SEND POST UEN TO NEXT PAGE
              echo '<td><form method="post">';
              echo '<input type="hidden" name="driverid" value="' . $row['driverid'] . '">';
              echo '<input type="hidden" name="drivername" value="' . $row['drivername'] . '">';
              echo '<button class="view-button" name="assignBus" type="submit">Assign Bus</button>&nbsp';
              echo '<button class="delete-button" name="deleteDriver" type="submit">Delete Driver</button>';
              echo '</form></td>';
              echo "</tr>";
              echo '</tr>';
              echo '</tbody>';
              $rowNumber++;
            }
            echo '</table>';
          }
        }
        ?>

      </div>
    </div>
  </div>
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