<?php

class User
{

  //VARIBLES
  private $conn = NULL;

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

  //FUNCTION TO LOGIN
  public function login($type, $email, $password)
  {
    if ($type == "System Admin") {
      $_SESSION['type'] = $type;
      $query = "SELECT * FROM systemadmins WHERE email = '$email' AND password = '$password'";
      $result = $this->conn->query($query);
      $num_rows = mysqli_num_rows($result);
      if ($num_rows == 1) {
        return true;
      } else {
        return false;
      }
    }

    if ($type == "School Admin") {
      $_SESSION['type'] = $type;
      $query = "SELECT * FROM schooladmins left join schools on schooladmins.uen = schools.uen WHERE email = '$email' AND password = '$password' AND status = 'Approved'";
      $result = $this->conn->query($query);
      $num_rows = mysqli_num_rows($result);
      if ($num_rows == 1) {
        //SET SESSION UEN
        $row = mysqli_fetch_assoc($result);
        $_SESSION['uen'] = $row['uen'];
        return true;
      } else {
        return false;
      }
    }

    if ($type == "Transport Admin") {
      $_SESSION['type'] = $type;
      $query = "SELECT * FROM transportadmins left join transports on transportadmins.uen = transports.uen WHERE email = '$email' AND password = '$password' AND status = 'Approved'";
      $result = $this->conn->query($query);
      $num_rows = mysqli_num_rows($result);
      if ($num_rows == 1) {
        //SET SESSION UEN
        $row = mysqli_fetch_assoc($result);
        $_SESSION['uen'] = $row['uen'];
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

}
