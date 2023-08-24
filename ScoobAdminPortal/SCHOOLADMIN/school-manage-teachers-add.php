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
    <a class="navbar-brand" href="school-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp School Admin - Add Teacher</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!--Navigation Shortcuts-->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto"><li class="nav-item"><a style="color:white;" id="current-time"></a></li></ul>
    </div>
	</nav>

  <!-- Main Container -->
  <div class="bodyContainer">
    <div class="leftPanel">
      <button class="customButton" type="button" onclick="window.location.href='school-manage-classes.php'"> <span>Manage Classes</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-manage-teachers.php'"> <span>Manage Teachers</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-manage-students.php'"> <span>Manage Students</span></button><br><br>      
      <button class="customButton" type="button" onclick="window.location.href='school-view-bus.php'"> <span>Bus Assignments</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='school-import.php'">          <span>Import Data</span></button><br><br>
      <form method="post">
	      <button class="logoutButton" tpe="button" name="logout">Logout</button>
	    </form>
    </div>

    <div class="rightPanel">
      <div class="header">
        <h1 style="display: inline;">Add A Teacher</h1> <br><br>
      </div>

      <div class="add-teacher-form">
        <form method="post">
          <label>Teacher's First Name: </label><br>
          <input type="text" name="teacherFirstName" placeholder="Enter First Name" required><br><br>
          <label>Teacher's Last Name: </label><br>
          <input type="text" name="teacherLastName" placeholder="Enter Last Name" required><br><br>
          <label>Teacher ID: </label><br>
          <input type="text" name="teacherID" placeholder="Enter Teacher's ID" required><br><br>
          <label>E-Mail: </label><br>
          <input type="text" name="email" placeholder="Enter E-Mail" required><br><br>
          <label>Password: </label><br>
          <input type="text" name="password" placeholder="Enter Password" required><br><br>
          <label>Class: </label><br>
          <?php
          $acc = GetActiveClass::getActiveClass();
          $result = $_SESSION['viewActiveClassSQLTable'];

          if ($result === NULL) {
            echo "No classes available, create a new class first.";
          } else {
            echo "<select name='class' required>";
            echo "<option disabled hidden selected>Assign Class</option>";
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<option value='" . $row['class'] . "'>" . $row['class'] . "</option>";
            }
            echo "<option value='NO'>No Class</option>";
            echo "</select><br><br>";
          }
          ?>
          <input type="submit" name="submit" value="Add Teacher">
        </form>
        <?php
          if (isset($_POST["submit"]))
          {      
            $fname = $_POST["teacherFirstName"];
            $lname = $_POST["teacherLastName"];       
            $teacherid = $_POST["teacherID"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $class = $_POST["class"];

            $addTeacher = new AddTeacher();
            $addTeacher->addTeacher($fname, $lname, $teacherid, $email, $password, $class);

            if ($addTeacher == true) {
              echo "<script>alert('Teacher successfully added'); window.location.href = 'school-manage-teachers.php';</script>";
            } else {
              echo "<script>alert('Teacher already exists'); window.location.href = 'school-manage-teachers-add.php';</script>";
            }
          }
        ?>
      </div> <!-- End of add-class-form -->
    </div> <!-- End of RightPanel -->
  </div> <!-- End of Main Container -->
</body>
</html>

<style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
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
        }

        form {
    margin-bottom: 0;
  }
    </style>