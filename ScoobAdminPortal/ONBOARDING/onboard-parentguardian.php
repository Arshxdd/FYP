<?php
include("OnboardingController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // ON SUBMIT CALL ONBOARDING CONTROLLER
    $result = new CreateParentGuardianAccount();
    $success = $result->createParentGuardianAccount($_POST['fname'], $_POST['lname'], $_POST['parentid'], $_POST['email'], $_POST['password']);

    // CHECK IF SUCCESSFULLY CREATED
    if ($success === true) {
      echo "<script type='text/javascript'>alert('Parent/Guardian Account Created Successfully!'); window.location.href = 'onboard-home.php';</script>";
    } else {
      echo "<script type='text/javascript'>alert('$onboardingController->getErrorMessage()');</script>";
      echo "<script type='text/javascript'>alert('Account Creation Unsuccessful!'); window.location.href = 'onboard-home.php';</script>";
    }
  } catch (mysqli_sql_exception $e) {
    echo "<script type='text/javascript'>alert('NRIC has already been registered. Please check and try again.'); window.location.href = 'onboard-parentguardian.php';</script>";
  }
}
?>

<html>

<head>
  <title>Scoob Onboarding Signup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</head>

<body>
  <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="onboard-home.php">
      <img src="../img/scoob-orange.svg" height="30px" alt="Toggle Navigation">&nbsp&nbsp Scoob Onboarding Signup
    </a>
    <a href="../login.php">Web Portal Login</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <div class="container">

    <div class="form-column">
      <!-- Your content for the third column in the second row -->
      <div class="image-column">
        <h3>Signing up as a Parent or Guardian</h3>
        <img src="../img/parentx.png" height="150px" alt="Transport">
      </div>

      <form method="post">
        <h5>Personal Details</h5>
        <input id="fname" name="fname" type="text" maxlength="30" placeholder="First Name" required>
        <input id="lname" name="lname" type="text" maxlength="30" placeholder="Last Name" required>
        <input id="parentid" name="parentid" type="text" maxlength="30" placeholder="NRIC" required>
        <h5>Account Creation</h5>
        <input id="email" name="email" type="text" maxlength="30" placeholder="Email" required>
        <input id="password" name="password" type="password" placeholder="Password" required>
        <input type="submit" id="submit" name="submit" value="Sign Up">
      </form>

    </div>
</body>

</html>





<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #F07c34;
  }

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 700px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-top: 15px;
    padding-bottom: 15px;
    margin-top: 59px;
  }

  .row {
    display: flex;
    width: 100%;
    /* align-items: center;
    text-align: center; */
  }

  .image-column {
    flex: 3;
    padding: 20px;
    text-align: center;
  }

  .image-column img {
    max-width: 100%;
    justify-content: center;
    align-items: center;
    display: block;
    margin: 0 auto;
  }

  .form-column {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .form-column label,
  .form-column input,
  .form-column select {
    display: block;
    width: 100%;
    margin-bottom: 15px;
  }

  .form-column select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    /* Adjust the width for wider input fields */
    width: 200px;
  }

  .form-column input[type="text"],
  .form-column input[type="password"],
  .form-column select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    /* Adjust the width for wider input fields */
    width: 400px;
  }

  .form-column input[type="submit"] {
    padding: 10px 20px;
    background-color: #093d65;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 0;
  }

  .form-column input[type="submit"]:hover {
    background-color: #0056b3;
  }
</style>