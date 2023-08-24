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
    <a class="navbar-brand" href="transport-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Transport Admin - First Time Pairing</a>
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
      <!-- <button class="customButton" type="button" onclick="window.location.href='transport-manage-buses.php'"> <span>Manage Buses</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-manage-drivers.php'"> <span>Manage Drivers</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-manage-routes.php'"> <span>Manage Routes</span></button><br><br>
<button class="customButton" type="button" onclick="window.location.href='transport-active-routes.php'"> <span>View Active Routes</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='transport-import.php'"> <span>Import Data</span></button><br><br> -->
      <form method="post">
        <button class="logoutButton" tpe="button" name="logout">Logout</button>
      </form>
    </div>

    <div class="rightPanel">
      <?php
      //SHOW CURRENT CURRENT TRANSPORT COMPANY APPLICATION DETAILS ESP REGION AND SIZE
      $xxx = GetTransportDetails::getTransportDetails();
      $resultx = NULL; //PLACEHOLDER

      if (isset($_SESSION['viewTransportDetailsSQLTable'])) {
        $resultx = $_SESSION['viewTransportDetailsSQLTable'];
      }

      if ($resultx == NULL) {
        echo "Error retrieving transport company details";
      } else {

        //PRINT TABLE HEADERS
        echo '<h1>Transport Company Details</h1>';
        echo '<table class="table table-bordered table-sm" style="text-align: center">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th scope="col">Company Name</th>';
        echo '<th scope="col">UEN</th>';
        echo '<th scope="col">Region</th>';
        echo '<th scope="col">Size</th>';
        echo '</tr>';
        echo '</thead>';

        $rowNumber = 1;

        while ($row = mysqli_fetch_assoc($resultx)) {
          echo '<tbody>';
          echo '<tr>';
          echo '<td>' . $row['name'] . "</td>";
          echo '<td>' . $row['uen'] . "</td>";
          echo '<td>' . $row['region'] . "</td>";
          echo '<td>' . $row['size'] . "</td>";
          echo "</tr>";
          echo '</tr>';
          echo '</tbody>';
          $rowNumber++;
        }
        echo '</table><br><br>';
      }


      //GET UEN FROM SESSION
      $uen = $_SESSION['uen'];

      $aaa = AvailablePair::availablePair($uen);
      $result = NULL; //PLACEHOLDER

      if (isset($_SESSION['viewSchoolPairSQLTable'])) {
        $result = $_SESSION['viewSchoolPairSQLTable'];
      }

      if ($result == NULL) {
        echo "No schools available for selection at the moment.";
      } else {

        //PRINT TABLE HEADERS
        echo '<h1>Matching School Pairs Based on Region and Size</h1>';
        echo '<table class="table table-bordered table-sm" style="text-align: center">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th scope="col">S/N</th>';
        echo '<th scope="col">School Name</th>';
        echo '<th scope="col">UEN</th>';
        echo '<th scope="col">Region</th>';
        echo '<th scope="col">Size</th>';
        echo '<th scope="col">Dismissal Time</th>';
        echo '<th scope="col">Action</th>';
        echo '</tr>';
        echo '</thead>';

        $rowNumber = 1;

        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tbody>';
          echo '<tr>';
          echo '<td>' . $rowNumber . "</td>";
          echo '<td>' . $row['name'] . "</td>";
          echo '<td>' . $row['uen'] . "</td>";
          echo '<td>' . $row['region'] . "</td>";
          echo '<td>' . $row['size'] . "</td>";
          echo '<td>' . $row['dismissal'] . "</td>";

          //ACCEPT BUTTON TO WORK WITH SCHOOL
          echo '<td><form method="post">';
          echo '<input type="hidden" name="uen" value="' . $row['uen'] . '">';
          echo '<button class="view-button" type="submit">Pair</button>';
          echo '</form></td>';
          echo "</tr>";
          echo '</tr>';
          echo '</tbody>';
          $rowNumber++;
        }
        echo '</table><br>';
        echo '<b>Matching Priority:</b><br>1) By Region & Descending Size<br>2) By Region & Next Smaller Size<br>3) By Size';
      }

      //ON SUBMIT OF ACCEPT BUTTON
      //ADD SCHOOL AND TRANSPORT UEN TO PAIR TABLE
      if (isset($_POST['uen'])) {
        $uen = $_POST['uen'];
        $busuen = $_SESSION['uen'];
        $addPair = new SetPair();
        $addPair->setPair($uen, $busuen);
        //ADD SUCCESS MESSAGE AND REDIRECT TO HOMEPAGE
        echo'<script>alert("School paired successfully!")</script> ';
        echo "<script>location.href='transport-home.php'</script>";
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

  .approve-button {
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
    width: 100px;
  }

  .reject-button {
    background-color: #FF0000;
    color: white;
    padding: 6px 10px;
    border: none;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    cursor: pointer;
    margin-bottom: 0px;
    width: 100px;
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

  .button-container {
    display: inline-block;
  }

  form {
    margin-bottom: 0;
  }
</style>