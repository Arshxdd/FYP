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
    <a class="navbar-brand" href="school-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp School Admin - Manage Teachers</a>
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

      <div class="data">
        <div class="header">
          <h1 style="display: inline;">Edit Class for Teacher</h1> <br><br>
        </div>

        <form method="post">
          <b>Selected Teacher & Current Class of Teacher:</b><br>
          <?php echo $_SESSION['teachername'] . ' / ' . $_SESSION['teacherclass'] ?><br><br>
          <?php
          $aaa = GetActiveClass::getActiveClass();
          $result = $_SESSION['viewActiveClassSQLTable'];

          if ($result == NULL) {
            echo "<b>No classes available to assign.</b>";
            exit;
          } else {
            echo "<b>Available Classes:</b><br>";
            echo "<select name='class'>";
            echo "<option value='' disabled hidden selected>Select an option</option>";
            echo "<option value=''>Unassign Class</option>";
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_array($result)) {
                if ($row != NULL) {
                  echo "<option value='" . $row['class'] . "'>" . $row['class'] . "</option>";
                }
              }
            } else {
              echo "<option value='' disabled selected>No classes available</option>";
            }
            echo "</select><br><br><br>";
          }
          echo "<input type='submit' name='submit' value='Edit Class'>";
          ?>




          <?php
          if (isset($_POST["submit"])) {
            $classid = $_POST["class"];
            $teacherid = $_SESSION['teacherid'];

            $assignBus = new AssignTeacherClass();
            $assignBus->assignTeacherClass($teacherid, $classid);

            if ($assignBus == true) {
              echo "<script>alert('Teacher successfully assigned class'); window.location.href = 'school-manage-teachers.php';</script>";
            } else {
              echo "<script>alert('Class is already assigned'); window.location.href = 'school-manage-teachers-edit.php';</script>";
            }
          }
          ?>
        </form>
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