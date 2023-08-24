<?php

class Onboarding
{

  //VARIABLES
  private $conn = null;



  //INITIALISE DATABASE CONNECTION
  function __construct()
  {
    $servername = "scoob-database.c8k5fhmymkis.ap-southeast-1.rds.amazonaws.com";
    $username = "admin";
    $password = "admin123";
    $dbname = "scoob";

    // Create connection
    $mysqli = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
      die("Connection failed: " . mysqli_connect_error());
    }
    $this->conn = $mysqli;
  }



  //FUNCTION TO CREATE NEW SCHOOL APPLICATION AND SCHOOL ADMIN ACCOUNT
  public function createSchoolApplication($name, $uen, $dismissal, $region, $size, $email, $password)
  {
    $query = "
      INSERT INTO schools (name, uen, dismissal, region, size, timestamp)
      VALUES ('$name', '$uen', '$dismissal', '$region', '$size', NOW());
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_affected_rows($this->conn);

    if ($result && $num_rows > 0) {
      $query = "
        INSERT INTO schooladmins (uen, email, password)
        VALUES ('$uen', '$email', '$password');
      ";

      $result = $this->conn->query($query);

      $num_rows = mysqli_affected_rows($this->conn);

      if ($result && $num_rows > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }



  //FUNCTION TO CREATE NEW TRANSPORT APPLICATION AND TRANSPORT ADMIN ACCOUNT
  public function createTransportApplication($name, $uen, $region, $size, $email, $password)
  {
    $query = "
      INSERT INTO transports (name, uen, region, size, timestamp)
      VALUES ('$name', '$uen', '$region', '$size', NOW());
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_affected_rows($this->conn);

    if ($result && $num_rows > 0) {
      $query = "
        INSERT INTO transportadmins (uen, email, password)
        VALUES ('$uen', '$email', '$password');
      ";

      $result = $this->conn->query($query);

      $num_rows = mysqli_affected_rows($this->conn);

      if ($result && $num_rows > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }



  //FUNCTION TO CREATE NEW PARENT/GUARDIAN ACCOUNT
  public function createParentGuardianAccount($fname, $lname, $parentid, $email, $password)
  {
    $query = "
      INSERT INTO parentguardians (fname, lname, parentid, email, password)
      VALUES ('$fname', '$lname', '$parentid', '$email', '$password');
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_affected_rows($this->conn);

    if ($result && $num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }
}
