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
      <div class="data">
        <form method="post" enctype="multipart/form-data">
          <h1>Bulk Import Data Files</h1>
          <br>
          <b>Buses Data File</b><br>
          <label for="csv_file_1">CSV File 1:</label>
          <input type="file" name="csv_file_1" accept=".csv" required><br><br>

          <b>Drivers Data File</b><br>
          <label for="csv_file_2">CSV File 2:</label>
          <input type="file" name="csv_file_2" accept=".csv" required><br><br>

          <b>Bus Assignments Data File</b><br>
          <label for="csv_file_3">CSV File 3:</label>
          <input type="file" name="csv_file_3" accept=".csv" required><br><br>
          <br><br><br>
          <input type="submit" value="Upload Data Files" name="submit">
        </form>

        <!-- ON FORM SUBMIT, PROCESSES THE FILES, PASS TO CONTROLLER -->
        <?php
        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
          // Get the uploaded files
          $csv_file_1 = $_FILES['csv_file_1']['tmp_name'];
          $csv_file_2 = $_FILES['csv_file_2']['tmp_name'];
          $csv_file_3 = $_FILES['csv_file_3']['tmp_name'];

          // Call the importSchool function with the uploaded files
          $execute = ImportTransport::importTransport($csv_file_1, $csv_file_2, $csv_file_3);

          if ($execute == true) {
            echo '<script>alert("Data files successfully uploaded!");</script>';
          } else {
            echo '<script>alert("Error uploading data files!");</script>';
          }
        }
        ?>
      </div>
    </div> <!-- End of RightPanel -->

  </div> <!-- End of Container -->
</body>

</html>

