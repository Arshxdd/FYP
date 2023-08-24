<?php
include('CLASSES/User.php');

class Login{
  function login($type, $email, $password)
  {
    $userLogin = new User();
    $success = $userLogin ->login($type, $email, $password);

    if ($success === true) {
      return true;
    } else {
      return false;
    }
  }
}

?>