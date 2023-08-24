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
<script>
  (function(d, s, id) {
    if (d.getElementById(id)) {
      if (window.__TOMORROW__) {
        window.__TOMORROW__.renderWidget();
      }
      return;
    }
    const fjs = d.getElementsByTagName(s)[0];
    const js = d.createElement(s);
    js.id = id;
    js.src = "https://www.tomorrow.io/v1/widget/sdk/sdk.bundle.min.js";

    fjs.parentNode.insertBefore(js, fjs);
  })(document, 'script', 'tomorrow-sdk');
</script>

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
      $aaa = GetCompanyData::getCompanyData();
      $result = NULL; //PLACEHOLDER

      if (isset($_SESSION['viewCompanyDataSQLTable'])) {
        $result = $_SESSION['viewCompanyDataSQLTable'];
      }

      if ($result == NULL) {
        echo 'Unable to retrieve company data.';
      } else {
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<h1>Welcome</h1>';
          echo 'Hi ' . $row['cname'] . ' admin!<br>';
          echo 'What would you like to do today?<br><br>';
          echo '<br>';
          echo '<b>Company Name: </b><br>' . $row['cname'] . '<br><br>';
          echo '<B>Company UEN: </b><br>' . $row['cuen'] . '<br><br>';
          echo '<B>Paired School: </b><br>' . $row['sname'] . '<br><br><br>';
          echo "<b>Today's Weather</b>";
          echo '<div class="tomorrow" data-location-id="2004709" data-language="EN" data-unit-system="METRIC" data-skin="light" data-widget-type="summary" style="width: 750px; padding-bottom: 22px; position: relative;">
          <a href="https://www.tomorrow.io/weather-api/" rel="nofollow noopener noreferrer" target="_blank" style="position: absolute; bottom: 0; transform: translateX(-50%); left: 50%;">
            <img alt="Powered by the Tomorrow.io Weather API" src="https://weather-website-client.tomorrow.io/img/powered-by.svg" width="250" height="18" />
          </a>
        </div>';
        }
      }

      ?>

    </div>
  </div> <!-- End of RightPanel -->

  </div> <!-- End of Container -->
</body>

</html>