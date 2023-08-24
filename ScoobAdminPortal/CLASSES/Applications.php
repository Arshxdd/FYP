<?php

class Applications
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

  //FUNCTION TO VIEW ALL PENDING SCHOOL AND TRANSPORT APPLICATIONS
  public function viewPendingApplications()
  {
    $query = "SELECT 'School' AS type , timestamp, name, uen FROM schools WHERE status = 'Pending'
              UNION ALL
              SELECT 'Transport' AS type , timestamp, name, uen FROM transports WHERE status = 'Pending'
              ORDER BY timestamp asc;
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewPendinglApplicationsSQLTable'] = $result;
      return true;
    } else {
      unset($_SESSION['viewPendinglApplicationsSQLTable']);
      return false;
    }
  }

  //FUNCTION TO A VIEW SCHOOL APPLICATION
  public function viewSchoolApplication($uen)
  {
    $query = "SELECT 'School' AS type, name, uen, dismissal, region, size, timestamp FROM schools where UEN='$uen'";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSchoolApplicationSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO APPROVE SCHOOL APPLICATION
  public function approveSchool($uen)
  {
    $query = "UPDATE schools SET status = 'Approved', actiontimestamp = NOW() WHERE UEN = '$uen'";

    $result = $this->conn->query($query);

    $row_affected = mysqli_affected_rows($this->conn);

    if ($result && $row_affected > 0) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO REJECT SCHOOL APPLICATION
  public function rejectSchool($uen)
  {
    $query = "UPDATE schools SET status = 'Rejected', actiontimestamp = NOW() WHERE UEN = '$uen'";

    $result = $this->conn->query($query);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO A VIEW TRANSPORT APPLICATION
  public function viewTransportApplication($uen)
  {
    $query = "SELECT 'Transport' AS type, name, uen, region, size , timestamp FROM transports where UEN='$uen'";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewTransportApplicationSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO APPROVE TRANSPORT APPLICATION
  public function approveTransport($uen)
  {
    $query = "UPDATE transports SET status = 'Approved', actiontimestamp = NOW() WHERE UEN = '$uen'";

    // Debugging: Output the query to see if it's correct
    // echo $query;

    $result = $this->conn->query($query);

    // Debugging: Output any error messages from the query execution
    // if (!$result) {
    //     echo "Query Error: " . $this->conn->error;
    // }

    $row_affected = mysqli_affected_rows($this->conn);

    if ($result && $row_affected > 0) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO REJECT TRANSPORT APPLICATION
  public function rejectTransport($uen)
  {
    $query = "UPDATE transports SET status = 'Rejected', actiontimestamp = NOW() WHERE UEN = '$uen'";

    $result = $this->conn->query($query);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO SEARCH APPLICATIONS
  public function searchApplications($searchQuery)
  {
    $query = "SELECT 'School' AS type , name, uen , timestamp FROM schools WHERE status = 'Pending' AND name LIKE '%$searchQuery%' OR status = 'Pending' AND  uen LIKE '%$searchQuery%'
              UNION ALL
              SELECT 'Transport' AS type , name, uen, timestamp FROM transports WHERE status = 'Pending' AND name LIKE '%$searchQuery%' OR status = 'Pending' AND uen LIKE '%$searchQuery%'
              ORDER BY timestamp asc;
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchApplicationSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW ALL PAST SCHOOL AND TRANSPORT APPLICATIONS
  public function viewPastApplications()
  {
    $query = "SELECT 'School' AS type , timestamp, name, uen, status,  actiontimestamp FROM schools WHERE status != 'Pending'
              UNION ALL
              SELECT 'Transport' AS type , timestamp, name, uen, status, actiontimestamp FROM transports WHERE status != 'Pending'
              ORDER BY actiontimestamp desc;
    ";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewPastApplicationsSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

    //FUNCTION TO A VIEW PAST SCHOOL APPLICATION
    public function viewPastSchoolApplication($uen)
    {
      $query = "SELECT 'School' AS type, name, uen, dismissal, region, size, timestamp, status, actiontimestamp FROM schools where UEN='$uen'";
  
      $result = $this->conn->query($query);
  
      $num_rows = mysqli_num_rows($result);
  
      if ($result && $num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewPastSchoolApplicationSQLTable'] = $result;
        return true;
      } else {
        return false;
      }
    }
    
      //FUNCTION TO A VIEW PAST TRANSPORT APPLICATION
  public function viewPastTransportApplication($uen)
  {
    $query = "SELECT 'Transport' AS type, name, uen, region, size , timestamp, status, actiontimestamp FROM transports where UEN='$uen'";

    $result = $this->conn->query($query);

    $num_rows = mysqli_num_rows($result);

    if ($result && $num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewPastTransportApplicationSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

    //FUNCTION TO SEARCH PAST APPLICATIONS
    public function searchPastApplications($searchQuery)
    {
      $query = "SELECT 'School' AS type , name, uen , timestamp, status, actiontimestamp FROM schools WHERE status != 'Pending' AND name LIKE '%$searchQuery%' OR status != 'Pending' AND  uen LIKE '%$searchQuery%'
                UNION ALL
                SELECT 'Transport' AS type , name, uen, timestamp, status, actiontimestamp FROM transports WHERE status != 'Pending' AND name LIKE '%$searchQuery%' OR status != 'Pending' AND uen LIKE '%$searchQuery%'
                ORDER BY timestamp desc;
      ";
  
      $result = $this->conn->query($query);
  
      $num_rows = mysqli_num_rows($result);
  
      if ($result && $num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewSearchPastApplicationSQLTable'] = $result;
        return true;
      } else {
        return false;
      }
    }

}