<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
<title>CV Generator</title>
<meta charset="utf-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  
<!-- Include CSS File Here -->
<link rel="stylesheet" href="css/style.css"/>
<!-- Include JS File Here -->
<script src="js/login.js"></script>
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #3339f5 ;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.topnav-right {
  float: right;
}
</style>
</head>
<body>
    <div class="topnav">
  <a href="">CVGenerator</a>
  <a  href="index.html"><span class="glyphicon glyphicon-home"></span>Home</a>
  <div class="topnav-right">
    <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> LogIn</a>
  </div>
</div>
<div class="container">
<div class="main">
<h2 class="hea2">Sign Up</h2></br></br>
<form id="form_id" method="post" name="myform_register">
   <?php include('errors.php'); ?>
    <input type="text" name="fname" id="fname" placeholder="First Name" required/>
    <input type="text" name="lname" id="lname" placeholder="Last Name" required/>
    <input type="email" name="email" value="<?php echo $email; ?>" id="email" placeholder="Email Id" required/>
    <input type="password" name="password1" id="password1" placeholder="Password" required/>
    <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required/>
<button type="submit" name="register" >Register</button><br></form><br>
<span>Already registered  !  <a href="login.php">LogIn</a></span>
</div>
</div>
</body>
</html>
