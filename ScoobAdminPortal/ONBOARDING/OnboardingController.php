<?php
include("../CLASSES/Onboarding.php");

class CreateSchoolApplication{
  public function createSchoolApplication($name, $uen, $dismissal, $region, $size, $email, $password) {
    $result = new Onboarding();
    $success = $result->createSchoolApplication($name, $uen, $dismissal, $region, $size, $email, $password);
    
    if ($success === true) {
      return true;
    } else {
      return false;
    }
  }
}

class CreateTransportApplication{
  public function createTransportApplication($name, $uen, $region, $size, $email, $password) {
    $result = new Onboarding();
    $success = $result->createTransportApplication($name, $uen, $region, $size, $email, $password);
    
    if ($success === true) {
      return true;
    } else {
      return false;
    }
  }
}

class CreateParentGuardianAccount{
  public function createParentGuardianAccount($fname, $lname, $parentid, $email, $password) {
    $result = new Onboarding();
    $success = $result->createParentGuardianAccount($fname, $lname, $parentid, $email, $password);
    
    if ($success === true) {
      return true;
    } else {
      return false;
    }
  }
}

?>