<?php

class School
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

  //FUNCTION TO VIEW ALL CLASSES
  public function viewAllClasses()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT class.class, CONCAT(teacher.fname, ' ', teacher.lname) AS teacher, COUNT(student.uen) AS 'number of students'
            FROM class
            LEFT JOIN teacher ON class.class = teacher.class
            LEFT JOIN student ON class.class = student.class
            WHERE class.uen = '$uen'
            GROUP BY class.class;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllClassesSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }


  //FUNCTION TO VIEW SPECIFIC CLASS DETAILS
  public function viewClass($class)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT class.class, CONCAT(teacher.fname, ' ', teacher.lname) AS teacher, COUNT(student.uen) AS 'number of students'
            FROM class
            LEFT JOIN teacher ON class.class = teacher.class
            LEFT JOIN student ON class.class = student.class
            WHERE class.uen ='$uen' AND class.class = '$class' AND student.uen = '$uen'
            GROUP BY class.class;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewClassSQLTable'] = $result;

      //RUN QUERY 2
      $sql2 = "SELECT student.studentid, CONCAT(student.fname, ' ', student.lname) AS name
              FROM student
              WHERE student.class = '$class' AND student.uen = '$uen';
      ";

      $result2 = $this->conn->query($sql2);

      if ($result2->num_rows > 0) {
        //SAVE THE TABLE TO SESSION
        $_SESSION['viewClassListSQLTable'] = $result2;
        return true;
      } elseif ($result2->num_rows == 0) {
        $_SESSION['viewClassListSQLTable'] = NULL;
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  //FUNCTION TO ADD A CLASS
  public function addClass($class)
  {
    $uen = $_SESSION['uen'];

    $sql = "INSERT INTO class (uen, class) VALUES ('$uen', '$class');
    ";

    $result = $this->conn->query($sql);

    if ($result === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO SEARCH A CLASS
  public function searchClass($searchQuery)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT class.class, CONCAT(teacher.fname, ' ', teacher.lname) AS teacher, COUNT(student.uen) AS 'number of students'
            FROM class
            LEFT JOIN teacher ON class.class = teacher.class
            LEFT JOIN student ON class.class = student.class
            WHERE class.uen ='$uen' AND class.class LIKE '%$searchQuery%' OR class.uen ='$uen' AND teacher.fname LIKE '%$searchQuery%' OR class.uen ='$uen' AND teacher.lname LIKE '%$searchQuery%'
            GROUP BY class.class;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchClassesSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO DELETE A CLASS
  public function deleteClass($class)
  {
    $uen = $_SESSION['uen'];

    //DELETE CLASS FROM TEACHER RECORD
    $sql1 = "UPDATE teacher SET class = NULL WHERE class = '$class' AND uen = '$uen';";

    //DELETE CLASS FROM STUDENT RECORD
    $sql2 = "UPDATE student SET class = NULL WHERE class = '$class' AND uen = '$uen';";

    //DELETE ACTUAL CLASS
    $sql3 = "DELETE FROM class WHERE class = '$class' AND uen = '$uen';
    ";

    $result1 = $this->conn->query($sql1);
    $result2 = $this->conn->query($sql2);
    $result3 = $this->conn->query($sql3);

    if ($result1 === true && $result2 === true && $result3 === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO ADD A STUDENT
  public function addStudent($studentid, $fname, $lname, $class, $pcode, $parentid)
  {
    $uen = $_SESSION['uen'];

    $sql = "INSERT INTO student (fname, lname, studentid, parentid, class, pcode, uen) VALUES ('$fname', '$lname', '$studentid', '$parentid', '$class', '$pcode', '$uen');
      ";

    $result = $this->conn->query($sql);

    if ($result === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW ALL STUDENTS
  public function viewAllStudents()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT student.class, CONCAT(student.fname, ' ', student.lname) AS studentname, student.studentid
            FROM student
            LEFT JOIN class on student.class = class.class
            WHERE student.uen = '$uen'
            ORDER BY student.class;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllStudentsSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW SPECIFIC STUDENT DETAILS
  public function viewStudent($studentid)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT studentid, parentid, CONCAT(fname, ' ', lname) AS name, student.class, pcode, subscription from student WHERE uen = '$uen' AND studentid = '$studentid';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewStudentSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO SEARCH A STUDENT
  public function searchStudent($searchQuery)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT student.class, CONCAT(student.fname, ' ', student.lname) AS studentname, student.studentid
            FROM student
            JOIN class on student.class = class.class
            WHERE student.uen = '$uen' AND studentid LIKE '%$searchQuery%' 
            OR student.uen = '$uen' AND CONCAT(student.fname , ' ', student.lname) LIKE '%$searchQuery%'
            OR student.uen = '$uen' AND fname LIKE '%$searchQuery%'
            OR student.uen = '$uen' AND lname LIKE '%$searchQuery%'
            OR student.uen = '$uen' AND student.class LIKE '%$searchQuery%';
               
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchStudentSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO DELETE A STUDENT
  public function deleteStudent($studentid)
  {
    $uen = $_SESSION['uen'];

    $sql = "DELETE FROM student WHERE studentid = '$studentid' AND uen = '$uen'";
    $result = $this->conn->query($sql);

    if ($result === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO VIEW ALL TEACHERS
  public function viewAllTeachers()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT teacher.class, CONCAT(teacher.fname, ' ', teacher.lname) AS teachername, teacher.teacherid
              FROM teacher
              LEFT JOIN class on teacher.class = class.class
              WHERE teacher.uen = '$uen'
              ORDER BY teacher.class;
      ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewAllTeachersSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }



  //FUNCTION TO VIEW SPECIFIC TEACHER DETAILS
  public function viewTeacher($teacherid)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT teacherid, CONCAT(fname, ' ', lname) AS name, teacher.class, email, password from teacher WHERE uen = '$uen' AND teacherid = '$teacherid';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewTeacherSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }



  //FUNCTION TO ADD A TEACHER
  public function addTeacher($fname, $lname, $teacherid, $email, $password, $class)
  {
    $uen = $_SESSION['uen'];

    if ($class === 'NO') {
      //INSERT NEW RECORD WITHOUT CLASS
      $sql1 = "INSERT INTO teacher (fname, lname, teacherid, email, password, uen) VALUES ('$fname', '$lname', '$teacherid', '$email', '$password', '$uen');
    ";
      $result1 = $this->conn->query($sql1);

      if ($result1 === true) {
        return true;
      } else {
        return false;
      }
    } else {
      //EXISTING TEACHER UNSET CLASS FIRST
      $sql2 = "UPDATE teacher SET class = NULL WHERE class='$class' AND uen = '$uen';
    ";

      //INSERT NEW RECORD AND NEW CLASS
      $sql1 = "INSERT INTO teacher (fname, lname, teacherid, email, password, class, uen) VALUES ('$fname', '$lname', '$teacherid', '$email', '$password', '$class', '$uen');
    ";

      $result2 = $this->conn->query($sql2);
      $result1 = $this->conn->query($sql1);

      if ($result1 === true && $result2 === true) {
        return true;
      } else {
        return false;
      }
    }
  }



  //FUNCTION TO SEARCH A TEACHER
  public function searchTeacher($searchQuery)
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT teacher.class, CONCAT(teacher.fname, ' ', teacher.lname) AS teachername, teacher.teacherid
                FROM teacher
                JOIN class on teacher.class = class.class
                WHERE teacher.uen = '$uen' AND teacherid LIKE '%$searchQuery%' 
                OR teacher.uen = '$uen' AND CONCAT(teacher.fname , ' ', teacher.lname) LIKE '%$searchQuery%'
                OR teacher.uen = '$uen' AND fname LIKE '%$searchQuery%'
                OR teacher.uen = '$uen' AND lname LIKE '%$searchQuery%';
                  
        ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSearchTeacherSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO DELETE A TEACHER
  public function deleteTeacher($teacherid)
  {
    $uen = $_SESSION['uen'];

    $sql = "DELETE FROM teacher WHERE teacherid = '$teacherid' AND uen = '$uen'";
    $result = $this->conn->query($sql);

    if ($result === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO IMPORT THE 3 DATA FILES
  public function importSchool($csv_file_1, $csv_file_2, $csv_file_3)
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

    // Process and insert CSV file 1 (CLASSES)
    $csv_file_1 = $_FILES['csv_file_1']['tmp_name'];
    $data_1 = array_map('str_getcsv', file($csv_file_1));
    $header_1 = array_shift($data_1);
    $query1_success = insertCSVData($conn, 'class', implode(', ', $header_1), $data_1);

    // Process and insert CSV file 2 (TEACHERS)
    $csv_file_2 = $_FILES['csv_file_2']['tmp_name'];
    $data_2 = array_map('str_getcsv', file($csv_file_2));
    $header_2 = array_shift($data_2);
    $query2_success = insertCSVData($conn, 'teacher', implode(', ', $header_2), $data_2);

    // Process and insert CSV file 3 (STUDENTS)
    $csv_file_3 = $_FILES['csv_file_3']['tmp_name'];
    $data_3 = array_map('str_getcsv', file($csv_file_3));
    $header_3 = array_shift($data_3);
    $query3_success = insertCSVData($conn, 'student', implode(', ', $header_3), $data_3);

    // Close the database connection
    $conn->close();

    if ($query1_success == true && $query2_success == true && $query3_success == true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO PULL LIST OF CLASSES FOR DROPDOWN SELECT
  public function getActiveClass()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT class FROM class WHERE uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      $_SESSION['viewActiveClassSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET SCHOOL DATA TO DISPLAY ON HOMEPAGE
  public function getSchoolData(){
    $uen = $_SESSION['uen'];

    $sql = "SELECT s.name as sname, s.uen as suen, t.name as cname FROM transports t left join school_transport st on t.uen = st.transportuen left join schools s on st.schooluen = s.uen WHERE s.uen = '$uen';

    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewSchoolDataSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO GET LIST OF CLASS WITH NO TEACHER
  public function getClassNoTeacher(){
    $uen = $_SESSION['uen'];

    $sql = "SELECT c.class from class c left join teacher t on c.class = t.class where c.uen = '$uen' AND t.class IS NULL;
    ";

    $result = $this->conn->query($sql);

    if ($result->num_rows > 0) {
      //SAVE THE TABLE TO SESSION
      $_SESSION['viewGetClassNoTeacherSQLTable'] = $result;
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO TEACHER TO CLASS
  public function assignTeacherClass($teacherid, $classid){
    $uen = $_SESSION['uen'];

    //EXISTING TEACHER UNSET CLASS FIRST
    $sql2 = "UPDATE teacher SET class = NULL WHERE class='$classid' AND uen = '$uen';
    ";

    $result2 = $this->conn->query($sql2);

    $sql = "UPDATE teacher SET class = '$classid' WHERE teacherid = '$teacherid' AND uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result2 === true && $result === true) {
      return true;
    } else {
      return false;
    }
  }

  //FUNCTION TO STUDENT TO CLASS
  public function assignStudentClass($studentid, $classid){
    $uen = $_SESSION['uen'];

    $sql = "UPDATE student SET class = '$classid' WHERE studentid = '$studentid' AND uen = '$uen';
    ";

    $result = $this->conn->query($sql);

    if ($result === true) {
      return true;
    } else {
      return false;
    }
  }

  public function getTrips()
  {
    $uen = $_SESSION['uen'];

    $sql = "SELECT bd.busid, bd.driverid, bd.tripstatus, bd.area, s.pcode, s.fname, s.lname, s.busid as 'busid2', concat(d.fname, ' ',d.lname, ' - ', d.driverid) as 'driver' 
    FROM bus_driver bd
    LEFT JOIN student s ON bd.busid = s.busid
    LEFT JOIN driver d ON bd.driverid = d.driverid
    WHERE s.uen = '$uen'
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
    where s.uen = '$uen'
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

}
