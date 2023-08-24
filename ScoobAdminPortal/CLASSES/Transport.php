<?php

class Transport
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

  //FUNCITON TO VIEW ALL BUSES
  public function viewAllBuses()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bus.busid, CONCAT(driver.fname, ' ', driver.lname) AS drivername
            from bus left join bus_driver on bus.busid = bus_driver.busid left join driver on bus_driver.driverid = driver.driverid
            WHERE bus.uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllBusesSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW A BUS
  public function viewBus($busid)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bus.busid, CONCAT(driver.fname, ' ', driver.lname) AS drivername, driver.driverid
            from bus left join bus_driver on bus.busid = bus_driver.busid left join driver on bus_driver.driverid = driver.driverid
            WHERE bus.busid = '$busid' AND bus.uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewBusSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO ADD A BUS
  public function addBus($busID)
  {
    $uen = $_SESSION['uen'];

    $sql = "INSERT INTO bus (busid, uen)
            VALUES ('$busID', '$uen');
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO DELETE A BUS
  //DELETE FROM BUS TABLE AND BUS_DRIVER TABLE
  public function deleteBus($busID)
  {
    $uen = $_SESSION['uen'];

    $sql1 = "DELETE FROM bus WHERE busid = '$busID' AND uen = '$uen';
    ";

    $result1 = $this->conn->query($sql1);

    $sql2 = "DELETE FROM bus_driver WHERE busid = '$busID' AND uen = '$uen';
    ";

    $result2 = $this->conn->query($sql2);

    if ($result1 && $result2) {
      return true;
    } else {
      return false;
    }
  }


  //FUNCTION TO SEARCH A BUS
  public function searchBus($searchQuery)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bus.busid, CONCAT(driver.fname, ' ', driver.lname) AS drivername
            from bus left join bus_driver on bus.busid = bus_driver.busid left join driver on bus_driver.driverid = driver.driverid
            WHERE bus.uen = '$uen' AND bus.busid LIKE '%$searchQuery%'
                               
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchBusSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW ALL DRIVERS
  public function viewAllDrivers()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT driver.driverid, CONCAT(driver.fname, ' ', driver.lname) AS drivername, bus.busid
            from driver left join bus_driver on driver.driverid = bus_driver.driverid left join bus on bus_driver.busid = bus.busid
            WHERE driver.uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllDriversSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW A DRIVER
  public function viewDriver($driverID)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT driver.driverid, CONCAT(driver.fname, ' ', driver.lname) AS drivername, driver.phone, driver.email, bus.busid
            from driver left join bus_driver on driver.driverid = bus_driver.driverid left join bus on bus_driver.busid = bus.busid
            WHERE driver.driverid = '$driverID' AND driver.uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewDriverSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO ADD A DRIVER
  public function addDriver($driverID, $fname, $lname, $phone, $email, $password)
  {
    $uen = $_SESSION['uen'];

    $sql = "INSERT INTO driver (driverid, fname, lname, phone, email, password, uen)
            VALUES ('$driverID', '$fname', '$lname', '$phone', '$email', '$password', '$uen');
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO ASSIGN DRIVER TO A BUS
  public function assignDriver($driverID, $busID)
  {
    $uen = $_SESSION['uen'];

    $sql = "INSERT INTO bus_driver (uen, driverid, busid)
            VALUES ('$uen' ,'$driverID', '$busID');
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO UNASSIGN DRIVER FROM A BUS
  public function unassignDriver($driverID, $busID)
  {
    $uen = $_SESSION['uen'];

    $sql = "DELETE FROM bus_driver WHERE uen = '$uen' AND driverid = '$driverID' AND busid = '$busID';
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO DELETE A DRIVER
  //DELETE DRIVER FROM DRIVER TABLE AND ASSIGNED BUS TABLE
  public function deleteDriver($driverID)
  {
    $uen = $_SESSION['uen'];

    $sql2 = "DELETE FROM bus_driver WHERE driverid = '$driverID' AND uen = '$uen';
    ";

    $result2 = $this->conn->query($sql2);

    $sql1 = "DELETE FROM driver WHERE driverid = '$driverID' AND uen = '$uen';
    ";

    $result1 = $this->conn->query($sql1);

    if ($result1 && $result2) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO SEARCH A DRIVER

  public function searchDriver($searchQuery)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT driver.driverid, CONCAT(driver.fname, ' ', driver.lname) AS drivername, bus.busid
    from driver left join bus_driver on driver.driverid = bus_driver.driverid left join bus on bus_driver.busid = bus.busid
    WHERE driver.uen = '$uen' AND CONCAT(driver.fname, ' ', driver.lname) LIKE '%$searchQuery%'
    OR driver.uen = '$uen' AND fname LIKE '%$searchQuery%'
    OR driver.uen = '$uen' AND lname LIKE '%$searchQuery%';
                               
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchDriverSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO IMPORT THE 3 DATA FILES
  public function importTransport($csv_file_1, $csv_file_2, $csv_file_3)
  {
    ob_start();

    //SETTING TO ENSURE NO MEMORY LIMITS AND EXECUTION TIME LIMITS
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 0);

    //DATABASE CONNECTION SETTINGS
    $servername = "scoob-database.c8k5fhmymkis.ap-southeast-1.rds.amazonaws.com";
    $username = "admin";
    $password = "admin123";
    $dbname = "scoob";

    //INITIALISE DATABASE CONNECTION
    $conn = new mysqli($servername, $username, $password, $dbname);

    //FUNCTION TO INSERT CSV DATA EACH LINE INTO THE DATABASE
    function insertCSVData($conn, $table, $columns, $data)
    {
      $values = array();
      foreach ($data as $row) {
        $values[] = "('" . implode("','", $row) . "')";
      }

      //ROW TO STRING CONVERSION
      $values_str = implode(",", $values);

      //INSERT INTO DATABASE AND SKIP DUPLICATES
      $query = "INSERT IGNORE INTO $table ($columns) VALUES $values_str";
      return $conn->query($query);
    }

    // Process and insert CSV file 1 (BUSES)
    $csv_file_1 = $_FILES['csv_file_1']['tmp_name'];
    $data_1 = array_map('str_getcsv', file($csv_file_1));
    $header_1 = array_shift($data_1);
    $query1_success = insertCSVData($conn, 'bus', implode(', ', $header_1), $data_1);

    // Process and insert CSV file 2 (DRIVERS)
    $csv_file_2 = $_FILES['csv_file_2']['tmp_name'];
    $data_2 = array_map('str_getcsv', file($csv_file_2));
    $header_2 = array_shift($data_2);
    $query2_success = insertCSVData($conn, 'driver', implode(', ', $header_2), $data_2);

    // Process and insert CSV file 3 (ASSIGNMENTS)
    $csv_file_3 = $_FILES['csv_file_3']['tmp_name'];
    $data_3 = array_map('str_getcsv', file($csv_file_3));
    $header_3 = array_shift($data_3);
    $query3_success = insertCSVData($conn, 'bus_driver', implode(', ', $header_3), $data_3);

    // Close the database connection
    $conn->close();

    if ($query1_success == true && $query2_success == true && $query3_success == true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO CHECK IF SCHOOL_TRANSPORT PAIR AVAILABLE
  public function checkPair($uen)
  {
    $sql = "SELECT * FROM school_transport WHERE transportuen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO CHECK SCHOOL PAIR TO LET TRANSPORT ADMIN PICK
  //MATCH BASED ON SIZE S, M, L AND REGION
  public function availablePair($uen)
  {
    //RETRIEVE TRANSPORT COMPANY DETAILS BASED ON UEN
    $sql1 = "SELECT * FROM transports WHERE uen = '$uen';
    ";

    $result1 = $this->conn->query($sql1);

    $row = mysqli_fetch_assoc($result1);

    $region = $row['region'];
    $size = $row['size'];

    //ASSESS SIZE AND SET RULES
    //IF SIZE L, CAN CHOOSE L OR M OR S
    if ($size == "L") {
      //SHOW MATCHING REGION AND SIZE FIRST, THEN SHOW MATCHING REGION AND SIZE M, THEN SHOW MATCHING REGION AND SIZE S
      //IF NO MATCHING REGION AND SIZE, SHOW MATCHING SIZE L, M AND S
      $sql = "SELECT * FROM schools WHERE region = '$region' AND size = 'L' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE region = '$region' AND size = 'M' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE region = '$region' AND size = 'S' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'L' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'M' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'S' AND status ='Approved';
      ";

      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewSchoolPairSQLTable'] = $result;
        return true;
      } else {
        return false;
      }
    }

    //IF SIZE M, CAN CHOOSE M OR S
    else if ($size == "M") {
      $sql = "SELECT * FROM schools WHERE region = '$region' AND size = 'M' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE region = '$region' AND size = 'S' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'M' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'S' AND status ='Approved';
      ";

      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewSchoolPairSQLTable'] = $result;
        return true;
      } else {
        return false;
      }
    }

    //IF SIZE S, CAN CHOOSE S
    else if ($size == "S") {
      $sql = "SELECT * FROM schools WHERE region = '$region' AND size = 'S' AND status ='Approved'
      UNION
      SELECT * FROM schools WHERE size = 'S' AND status ='Approved';
      ";

      $result = $this->conn->query($sql);

      if ($result->num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewSchoolPairSQLTable'] = $result;
        return true;
      } else {
        return false;
      }
    }
  }

  //FUNCTION TO ADD SCHOOL/TRANSPORT PAIR
  public function setPair($uen, $busuen)
  {
    $sql = "INSERT INTO school_transport (schooluen, transportuen)
            VALUES ('$uen', '$busuen');
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET CURRENT TRANSPORT DETAILS
  public function getTransportDetails()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT * FROM transports WHERE uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewTransportDetailsSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET LIST OF BUSES WITH NO ASSIGNED DRIVERS
  public function getNoAssignBus()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bus.busid
          from bus left join bus_driver on bus.busid = bus_driver.busid left join driver on bus_driver.driverid = driver.driverid
          WHERE bus.uen = '$uen' AND driver.driverid IS NULL;
  ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewNoAssignBusSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO ASSIGN DRIVER TO BUS
  public function assignBus($busid, $driverid)
  {
    $uen = $_SESSION['uen'];

    $check = "SELECT busid FROM bus_driver WHERE uen = '$uen' AND driverid = '$driverid'; ";

    $check2 = $this->conn->query($check);

    if ($check2->num_rows > 0) {
      $sql = "UPDATE bus_driver SET busid = '$busid' WHERE uen = '$uen' AND driverid = '$driverid'; ";
      $result = $this->conn->query($sql);

      if ($result) {
        return true;
      } else {
        return false;
      }
    } else {
      $sql = "INSERT INTO bus_driver (uen, driverid, busid)
          VALUES ('$uen' ,'$driverid', '$busid');
  ";

      $result = $this->conn->query($sql);

      if ($result) {
        return true;
      } else {
        return false;
      }
    }
  }

  //FUNCTION TO VIEW ALL ROUTES
  public function viewAllRoutes()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bus.busid, CONCAT(driver.fname, ' ', driver.lname) AS drivername, bus_driver.area
          from bus left join bus_driver on bus.busid = bus_driver.busid left join driver on bus_driver.driverid = driver.driverid
          WHERE bus_driver.uen = '$uen';
  ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllRoutesSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCITON TO GET POSTAL GROUP SCHOOLS
  public function getPostalGroup()
  {
    $uen = $_SESSION['uen'];

    $sql = "with schoolquery as (
      select left(pcode, 3) as pcode from school_transport st left join student s on st.schooluen = s.uen where st.transportuen = '$uen' group by left (pcode, 3)
      ), 
      busquery as (
      select area from bus_driver where uen = '$uen')
      
      SELECT * from schoolquery sq left join busquery bq on sq.pcode = bq.area
      where bq.area IS NULL
      ;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewPostalGroupSQLTable'] = $result;
      return true;
    } else {
      unset ($_SESSION['viewPostalGroupSQLTable']);
      return false;
    }
  }

  //FUNCTION TO ADD ROUTE TO BUS
  public function addRoute($pcode, $busid)
  {
    $uen = $_SESSION['uen'];

    $sql = "UPDATE bus_driver SET area = '$pcode' WHERE uen = '$uen' AND busid = '$busid';
  ";

    $result = $this->conn->query($sql);

    $sql2 = "UPDATE student s join school_transport st on s.uen = st.schooluen join bus_driver bd on st.transportuen = bd.uen
    set s.busid = '$busid' 
    WHERE bd.uen = '$uen'
    AND left(s.pcode, 3) = bd.area
    AND s.subscription= 'Yes';
  ";

    $result2 = $this->conn->query($sql2); 

    if ($result == true && $result2 == true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO UNASSIGN ROUTE FROM BUS
  public function unassignArea($busid, $pcode)
  {
    $uen = $_SESSION['uen'];

    $sql = "UPDATE bus_driver SET area = NULL WHERE uen = '$uen' AND busid = '$busid' AND area = '$pcode';
  ";

    $result = $this->conn->query($sql);

    $sql2 = "UPDATE student s join school_transport st on s.uen = st.schooluen join bus_driver bd on st.transportuen = bd.uen
    set s.busid = NULL 
    WHERE bd.uen = '$uen'
    AND left(s.pcode, 3) = '$pcode'
    AND s.subscription= 'Yes';
  ";

    $result2 = $this->conn->query($sql2);

    if ($result == true && $result2 == true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET ALL TRIPS FOR ADMIN OVERVIEW
  public function getTrips()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bd.busid, bd.driverid, bd.tripstatus, bd.area, s.pcode, s.fname, s.lname, s.busid as 'busid2', concat(d.fname, ' ',d.lname, ' - ', d.driverid) as 'driver' 
    FROM bus_driver bd
    LEFT JOIN student s ON bd.busid = s.busid
    LEFT JOIN driver d ON bd.driverid = d.driverid
    WHERE bd.uen = '$uen'
    -- AND bd.tripstatus IS NOT NULL
    AND bd.area IS NOT NULL
    GROUP BY bd.busid
    ;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewGetTripsSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET ALL STUDENTS BASED ON GETTRIP BUSID
  public function getStudents($busid)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT concat(fname, ' ', lname) AS studentname, studentid, pcode from 
    school_transport st 
    join student s on st.schooluen = s.uen
    join bus_driver bd on st.transportuen = bd.uen
    where bd.uen = '$uen'
    AND s.busid = '$busid'
    AND LEFT(s.pcode,3) = bd.area
    ;";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewGetStudentsSQLTable'] = $result;
      return $result;
    } else {
      return $result;
    }
  }

  //FUNCTION TO GET DATA FOR HOMEPAGE DISPLAY COMPANY
  public function getCompanyData()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT t.name as cname, t.uen as cuen, s.name as sname FROM transports t left join school_transport st on t.uen = st.transportuen left join schools s on st.schooluen = s.uen WHERE t.uen = '$uen';

    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewCompanyDataSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }
}
