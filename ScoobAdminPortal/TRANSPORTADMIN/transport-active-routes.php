<?php
include 'TransportAdminController.php';
include '../LogoutController.php';
session_start();

//VERIFY IF SYSTEMADMIN SESSION TYPE
if ($_SESSION['type'] != "Transport Admin") {
  header("Location: ../login.php");
}

//CHECK FOR SCHOOL PAIR
//IF PAIR EXISTS, REDIRECT TO TRANSPORT HOME 
//IF PAIR DO NOT EXISTS, REDIRECT TO FIRST TIME PAIRING
$transport = new CheckPair();
$pair = $transport->checkPair($_SESSION['uen']);

if ($pair === false) {
  header("Location: first-time-pairing.php");
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
    <a class="navbar-brand" href="transport-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Transport Admin - Homepage</a>
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
      <?php
      $aaa = GetTrips::getTrips();
      $result = NULL; //PLACEHOLDER

      if (isset($_SESSION['viewGetTripsSQLTable'])) {
        $result = $_SESSION['viewGetTripsSQLTable'];
      }

      if ($result == NULL) {
        echo 'No trips at the moment.';
      } else {
        $rowNumber = 1;
        echo '<h1>Active Bus Service Overview</h1>';

        while ($row = mysqli_fetch_assoc($result)) {
          echo '<table class="table table-bordered" style="text-align: center">';
          echo '<thead class="thead-dark">';
          echo '<tr>';
          echo '<th scope="col">Bus Reg. No</th>';
          echo '<th scope="col">Assigned Driver</th>';
          echo '<th scope="col">Trip Status</th>';
          echo '<th scope="col">Service Area</th>';
          echo '</tr>';
          echo '</thead>';

          echo '<tbody>';
          echo '<tr>';
          echo '<td>' . $row['busid'] . "</td>";
          echo '<td>' . $row['driver'] . "</td>";
          echo '<td>' . $row['tripstatus'] . "</td>";
          echo '<td>' . $row['area'] . "XXX</td>";
          echo '</tr>';
          echo '</tbody>';

          // Retrieve and display associated students
          $studentList = GetStudents::getStudents($row['busid']);

          if ($studentList->num_rows > 0) {
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">S/N</th>';
            echo '<th scope="col">Student Name</th>';
            echo '<th scope="col">Student ID</th>';
            echo '<th scope="col">Postal Code</th>';
            echo '</tr>';
            echo '</thead>';

            $rowNumber2 = 1;

            while ($row2 = mysqli_fetch_assoc($studentList)) {
              echo '<tbody>';
              echo '<tr>';
              echo '<td>' . $rowNumber2 . "</td>";
              echo '<td>' . $row2['studentname'] . "</td>";
              echo '<td>' . $row2['studentid'] . "</td>";
              echo '<td>' . $row2['pcode'] . "</td>";
              echo '</tr>';
              echo '</tbody>';
              $rowNumber2++;
            }
          } else {
            echo '<tr>';
            echo '<td colspan="4">No students associated with this trip.</td>';
            echo '</tr>';
          }

          echo '</table><br><br>';
          $rowNumber++;
        }
      }
      ?>
    </div> <!-- End of RightPanel -->

  </div> <!-- End of Container -->
</body>

</html>