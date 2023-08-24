<?php
include 'SchoolAdminController.php';
include '../LogoutController.php';
session_start();

//VERIFY IF SYSTEMADMIN SESSION TYPE
if ($_SESSION['type'] != "School Admin") {
  header("Location: ../login.php");
}

if (isset($_POST["logout"])) {
  $logout = new LogoutController();
  $logout->logout();
}
?>

<html>

<head>
  <title>School Admin</title>
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
    <a class="navbar-brand" href="school-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp School Admin - Manage Students</a>
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
      <button class="customButton" type="button" onclick="window.location.href='school-manage-classes.php'"> <span>Manage Classes</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-manage-teachers.php'"> <span>Manage Teachers</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-manage-students.php'"> <span>Manage Students</span></button><br><br>      
      <button class="customButton" type="button" onclick="window.location.href='school-view-bus.php'"> <span>Bus Assignments</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-import.php'"> <span>Import Data</span></button><br><br>
      <form method="post">
        <button class="logoutButton" tpe="button" name="logout">Logout</button>
      </form>
    </div>


    <div class="rightPanel">
      <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 style="margin: 0;">Viewing Student Details</h1>
        <div style="display: flex; align-items: center;">
          <a href="school-manage-students-add.php" style="margin-right: 10px;"><button>Add Student</button></a>
          <form method="post" action="school-manage-students-search.php">
            <input type="text" name="searchQuery" placeholder="Search Student" style="margin-right: 5px;" required>
            <input type="submit" value="Search">
          </form>
        </div>
      </div>

      <div class="data">
        <div class="header">
          <h1 style="display: inline;">Edit Class for Student</h1> <br><br>
        </div>

        <form method="post">
          <b>Selected Teacher & Current Class of Student:</b><br>
          <?php echo $_SESSION['studentname'] . ' / ' . $_SESSION['studentclass'] ?><br><br>
          <?php
          $aaa = GetActiveClass::getActiveClass();
          $result = $_SESSION['viewActiveClassSQLTable'];

          if ($result == NULL) {
            echo "<b>No classes available to assign.</b>";
          } else {
            echo "<b>Available Classes:</b><br>";
            echo "<select name='class'>";
            echo "<option default selected hidden>Select a class</option>";
            echo "<option value=''>Unassign Class</option>";
            while ($row = mysqli_fetch_array($result)) {
              echo "<option value='" . $row['class'] . "'>" . $row['class'] . "</option>";
            }
            echo "</select><br><br><br>";
          }
          ?>
          <input type="submit" name="submit" value="Edit Class">

          <?php
          if (isset($_POST["submit"])) {
            $classid = $_POST["class"];
            $studentid = $_SESSION['studentid'];

            $assignBus = new AssignStudentClass();
            $assignBus->assignStudentClass($studentid, $classid);

            if ($assignBus == true) {
              echo "<script>alert('Student successfully assigned class'); window.location.href = 'school-manage-students.php';</script>";
            } else {
              echo "<script>alert('Class is already assigned'); window.location.href = 'school-manage-students-edit.php';</script>";
            }
          }
          ?>
        </form>
      </div>

    </div>
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