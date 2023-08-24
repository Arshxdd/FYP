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
      <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 style="margin: 0;">Matching Search Results</h1>
        <div style="display: flex; align-items: center;">
          <a href="school-manage-teachers-add.php" style="margin-right: 10px;"><button>Add Teacher</button></a>
          <form method="post" action="school-manage-teachers-search.php">
            <input type="text" name="searchQuery" placeholder="Search Teacher" style="margin-right: 5px;" required>
            <input type="submit" value="Search">
          </form>
        </div>
      </div>

      <div class="data">
        <?php
        if (isset($_POST["searchQuery"])) {
          // Get the search query from the form
          $searchQuery = $_POST["searchQuery"];

          $execute = SearchTeacher::searchTeacher($searchQuery);

          if ($execute === false) {
            echo 'No Teachers found.';
          } else {
            $result = $_SESSION['viewSearchTeacherSQLTable'];
            //PRINT TABLE HEADERS
            echo '<table class="table table-bordered table-sm" style="text-align: center">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">S/N</th>';
            echo '<th scope="col">Teacher ID</th>';
            echo '<th scope="col">Teacher Name</th>';
            echo '<th scope="col">Class</th>';
            echo '<th scope="col">Action</th>';
            echo '</tr>';
            echo '</thead>';

            $rowNumber = 1;

            while ($row = mysqli_fetch_assoc($result)) {
              echo '<tbody>';
              echo '<tr>';
              echo '<td>' . $rowNumber . "</td>";
              echo '<td>' . $row['teacherid'] . "</td>";
              echo '<td>' . $row['teachername'] . "</td>";
              echo '<td>' . $row['class'] . "</td>";

              //BUTTON FORM TO SEND POST UEN TO NEXT PAGE
              echo '<td><form action="school-manage-teachers-view.php" method="post">';
              echo '<input type="hidden" name="teacher" value="' . $row['teacherid'] . '">';
              echo '<button class="view-button" type="submit">View</button>';
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

  form {
    margin-bottom: 0;
  }
</style>