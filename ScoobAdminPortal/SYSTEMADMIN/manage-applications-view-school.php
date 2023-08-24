<?php
include 'SystemAdminController.php';
include '../LogoutController.php';
session_start();

//VERIFY IF SYSTEMADMIN SESSION TYPE
if ($_SESSION['type'] != "System Admin") {
  header("Location: ../login.php");
}

if (isset($_POST["logout"])) {
  $logout = new LogoutController();
  $logout->logout();
}

// Handle Approve or Reject actions
if (isset($_POST["submit-approve"])) {
  if (isset($_POST["uen2"])) {
    $uen = $_POST["uen2"];
    $aaa = ApproveSchool::approveSchool($uen);

    if ($aaa === true) {
      echo "<script>alert('UEN Approved.'); window.location.href = 'manage-applications-home.php';</script>";
      exit; // Important to prevent further execution of the page
    } else {
      echo "<script>alert('Error Approving UEN.');</script>";
    }
  }
}


if (isset($_POST["submit-reject"])) {
  if (isset($_POST["uen2"])) {
    $uen = $_POST["uen2"];
    $aaa = RejectSchool::rejectSchool($uen);

    if ($aaa === true) {
      echo "<script>alert('UEN Rejected.'); window.location.href = 'manage-applications-home.php';</script>";
      exit; // Important to prevent further execution of the page
    } else {
      echo "<script>alert('Error Rejecting UEN.');</script>";
    }
  }
}
?>

<html>

<head>
  <title>System Admin</title>
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
    <a class="navbar-brand" href="manage-applications-home.php"><img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Scoob System Admin</a>
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
      <button class="customButton" type="button" onclick="window.location.href='manage-applications-home.php'"> <span>Manage Applications</span></button><br><br>
      <button class="customButton" type="button" onclick="window.location.href='manage-applications-past.php'"> <span>Application History</span></button><br><br>
      <form method="post">
        <button class="logoutButton" tpe="button" name="logout">Logout</button>
      </form>
    </div>
    <div class="rightPanel">
      <div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
        <h1 style="margin: 0;">Viewing School Application</h1>
        <div style="display: flex; align-items: center;">
          <form action="manage-applications-view-search.php" method="post">
            <input type="text" name="searchQuery" placeholder="Search Applications" style="margin-right: 5px;" required>
            <input type="submit" value="Search">
          </form>
        </div>
      </div>
      <div class="data">
        <?php
        if (isset($_POST['uen'])) {
          $uen = $_POST['uen'];
          $execute = ViewSchoolApplication::viewSchoolApplication($uen);

          if ($execute === true) {
            //GET RESULTS FROM SESSION VARIABLE
            $result = $_SESSION['viewSchoolApplicationSQLTable'];

            //PRINT TABLE HEADERS
            echo '<table class="table table-bordered table-sm" style="text-align: center">';
            echo '<thead class="thead-dark">';
            echo '<tr>';
            echo '<th scope="col">Type</th>';
            echo '<th scope="col">School Name</th>';
            echo '<th scope="col">UEN</th>';
            echo '<th scope="col">Dismissal Timing</th>';
            echo '<th scope="col">School Region</th>';
            echo '<th scope="col">Size</th>';
            echo '<th scope="col">Applied On</th>';
            echo '<th scope="col">Actions</th>';
            echo '</tr>';
            echo '</thead>';

            //PRINT DATA
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tbody>";
              echo "<tr>";
              echo "<td>" . $row['type'] . "</td>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['uen'] . "</td>";
              echo "<td>" . $row['dismissal'] . "</td>";
              echo "<td>" . $row['region'] . "</td>";
              echo "<td>" . $row['size'] . "</td>";
              echo '<td>' . $row['timestamp'] . "</td>";
              echo '<td>';
              echo '<div="button-container">';

              // BUTTON FORM TO SEND POST UEN TO NEXT PAGE
              echo '<form action="" method="post">';
              echo '<input type="hidden" name="uen2" value="' . $row['uen'] . '">';

              // Separate submit buttons for Approve and Reject actions
              echo '<button class="approve-button" type="submit" name="submit-approve">Approve</button>';
              echo '&nbsp';
              echo '<button class="reject-button" type="submit" name="submit-reject">Reject</button>';

              echo '</form>';

              echo '</div>';
              echo '</td>';
              echo "</tbody>";
            }

            echo '</table>';
            echo '<br>';
            echo '<br>';
            echo '<h6><u>Size Refers to Estimated Number of Students Requiring Transport Services</u></h6>';
            echo 'S : Up to 100 Students<br>';
            echo 'M : Up to 200 Students<br>';
            echo 'L : Up to 300 Students and more<br>';
          } else {
            echo "<script>alert('Error Retrieving Data. Invalid UEN.');</script>";
          }
        }
        ?>
      </div> <!-- End of Data -->
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

  .button-container {
    display: inline-block;
  }


  form {
    margin-bottom: 0;
  }
</style>