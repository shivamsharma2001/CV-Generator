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
    <a href="register.php"><span class="glyphicon glyphicon-user"></span> SignUp</a>
  </div>
  </div>
   <div class="container">
        <div class="main">
        <h2>LogIn</h2>
        <form  method="post"  action="login.php">
  	<?php include('errors.php'); ?>
  	</br></br><label>Email:</label>
        <input type="email" name="email" id="email" required/>
        <label>Password :</label>
        <input type="password" name="password" id="password" required/>
        <button type="submit" value="Login" name="login_user" >LogIn</button><br>
        </br><p>Not Registered? <a href="register.php">Create an account</a></p>
        </form>
      </div>
    </div>
</body>
</html>
