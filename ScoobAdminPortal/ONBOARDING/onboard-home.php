<?php
//Placeholder error message
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Check if the user has selected an option
  if (isset($_POST["type"]) === 'hidden' || empty($_POST["type"])) {
    $errorMessage = "Please select an option.";
  } else {
    $selectedOption = $_POST['type'];

    // Perform the redirection based on the selected option
    if ($selectedOption === 'school') {
      header('Location: onboard-school.php');
      exit();
    } elseif ($selectedOption === 'transport') {
      header('Location: onboard-transport.php');
      exit();
    } elseif ($selectedOption === 'parentguardian') {
      header('Location: onboard-parentguardian.php');
      exit();
    }
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


    <!-- First row, 1 column span across 3 -->
    <div class="row">
      <div class="image-column">
        <h3>REGISTER WITH SCOOB AS</h3>
      </div>
    </div>


    <!-- Second row, 3 columns -->
    <div class="row">
      <div class="form-column">
        <!-- Your content for the first column in the second row -->
        <div class="image-column">
          <h3>Parent or Guardian</h3>
          <img src="../img/parentx.png" height="150px" alt="Parent">
        </div>
        Register with Scoob to manage your child's school bus transport.
        Once registered, you'll gain immediate access to our Scoob Mobile App.
        You'll be able to track, update, manage your child pickup process and progress with just a few taps away!
      </div>


      <div class="form-column">
        <!-- Your content for the second column in the second row -->
        <div class="image-column">
          <h3>School Organisation</h3>
          <img src="../img/schoolx.png" height="150px" alt="School">
        </div>
        Register your school with Scoob to manage your school bus fleet and student transport.
        For School Admins to register and get on board Scoob's platform.
        Application requires account approval and may take up to 5 working days.
      </div>

      <div class="form-column">
        <!-- Your content for the third column in the second row -->
        <div class="image-column">
          <h3>Transport Company</h3>
          <img src="../img/bus.png" height="150px" alt="Transport">
        </div>
        Register your school with Scoob to manage your school bus fleet and student transport.
      </div>
    </div>


    <!-- Last row, 1 column span across 3 -->
    <div class="row">
    <div class="form-column">
      <form method="post">
        <br>
        <select id="type" name="type" required>
          <option disabled hidden selected>I want to sign up as a</option>
          <option value="parentguardian">Parent or Guardian</option>
          <option value="school">School Organisation</option>
          <option value="transport">Transport Company</option>
        </select>
        <input type="submit" id="submit" name="Next" value="Next">
      </form>
    </div>
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
    max-width: 1200px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding-top: 15px;
    padding-bottom: 15px;
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
    padding: 20px;
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
    width: 250px;
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