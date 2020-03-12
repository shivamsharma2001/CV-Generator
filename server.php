<?php
session_start();

// initializing variables
$email    = "";
$errors = array(); 

// connect to the database
    try {
      $db = new \PDO("pgsql:host=127.0.0.1;dbname='cvgenerator'", 'postgres', 'Shivam@21');
    } catch (Exception $e) {
     print $e->getMessage() . "\n";
    }
// REGISTER USER
if (isset($_POST['register'])) {
  // receive all input values from the form
  $email = $_POST['email'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $password1 = $_POST['password1'];
  $password2 = $_POST['confirmpassword'];

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($fname)) { array_push($errors, "First Name is required"); }
  if (empty($lname)) { array_push($errors, "Last name is required"); }
  if (empty($password1)) { array_push($errors, "Password is required"); }
  if ($password1 != $password2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = $db->query($user_check_query);
  
  if ($result->rowcount()) { // if user exists
      array_push($errors, "email already exists");
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (email, password,fname,lname) 
  			  VALUES('$email', '$password','$fname','$lname')";
  	
  	$res=$db->query($query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: details.php');
  }
}
if(isset($_POST['login_user']))
{
  $email=$_POST['email'];
  $password=$_POST['password'];
  if(empty($email))
  {
    array_push($errors,"Email is required");
  }
  if(empty($password))
  {
    array_push($errors,"Password is required");
  }
  if(count($errors)==0)
  {
    $password = md5($password);
    $query="select * from users where email='$email' and password='$password'";
    $result=$db->query($query);
    if($result->rowcount()==1)
    {
      $_SESSION['email'] = $email;
      $_SESSION['success'] = "You are now logged in";
      header('location: details.php');
    }
    else
    {
      array_push($errors,"Wrong Email/Password Combination");
    }
  }
}
