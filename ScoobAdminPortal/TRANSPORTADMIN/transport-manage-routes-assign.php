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

if (isset($_POST["assign"]))
{      
  $pcode = $_POST['pcode'];

  $addRoute = new AddRoute();
  $addRoute->addRoute($pcode, $_SESSION['busid']);

  if ($addRoute == true) {
    echo "<script>alert('Route successfully added'); window.location.href = 'transport-manage-routes.php';</script>";
  } else {
    echo "<script>alert('Route error'); window.location.href = 'transport-manage-routes-assign.php';</script>";
  }
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
    <a class="navbar-brand" href="transport-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Transport Admin - Manage Routes</a>
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
    if (isset($_POST['bus'])) {
      $_SESSION['busid'] = $_POST['bus'];
      $busid = $_POST['bus'];
      $driver = $_POST['name'];
      echo '<h1>Assigning Route</h1><br>';
      echo '<b>Selected Bus & Driver</b><br>';
      echo $busid .'<br>';
      echo $driver.'<br><br>';

      $acc = GetPostalGroup::getPostalGroup();

      if (isset($_SESSION['viewPostalGroupSQLTable'])) {
        echo "<form method='post'>";
        echo "<select name='pcode' required>";
        echo "<option disabled hidden selected>Assign Postal Area</option>";
        while ($row = mysqli_fetch_assoc($_SESSION['viewPostalGroupSQLTable'])) {
          echo "<option value='" . $row['pcode'] . "'>" . $row['pcode'] . "XXX</option>";
        }
        echo "</select><br><br>";
        echo "<input type='submit' name='assign' value='Assign Route'>";
        echo "</form>";
        
      } else {
        echo "No new routes required by school. All routes has been assigned.";
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