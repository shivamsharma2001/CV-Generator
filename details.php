<?php 
  session_start(); 

  if (!isset($_SESSION['email'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: index.html");
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Multistep CV Detail Form</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<meta content="noindex, nofollow" name="robots">
<!-- Including CSS File Here -->
<link href="css/style3.css" rel="stylesheet" type="text/css">
<!-- Including JS File Here -->
<script src="js/multi_step_form.js" type="text/javascript"></script>
<style>

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
  <?php  if (isset($_SESSION['email'])) : ?>
    <?php 
           try {
             $db = new \PDO("pgsql:host=127.0.0.1;dbname='cvgenerator'", 'postgres', 'Shivam@21');
           } catch (Exception $e) {
               print $e->getMessage() . "\n";
          }
          $email=$_SESSION['email'];
          $res=$db->query("select fname,lname,id from users where email='$email'");
          foreach($res as $row){
             $fname = $row['fname'];
             $lname = $row['lname'];
             $id=$row['id'];}
             
          $_SESSION['id']=$id;
    	?>
    <?php endif ?>
  <div class="topnav">
  <a href="">CVGenerator</a>
  <a  href="generateCV.php">MakeCV</a>
  <div class="topnav-right">
    <a href=""><span class="glyphicon glyphicon-user"></span><strong><?php echo ' '.$fname.' '.$lname;?></strong></a>
    <a href="details.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
  </div>
</div>
<div class="content">
<!-- Multistep Form -->
<div class="main">
<h5 style="color:red">If You've already fill this form then you can go to Make CV by clicking MakeCV above,if you wish to add more information then fill this form again.</h5>
<form action="postdata.php" class="regform" method="post">
<!-- Progressbar -->
<div class="sidenav">
<ul id="progressbar1">
<li id="active1">Personal Details</li>
<li id="active2">Education</li></br>
<li id="active3">Skills</li></br>
<li id="active4">Projects</li></br>
<li id="active5">Experience</li>
<li id="active6">Achievements</li>
</ul>
</div>
<!-- Fieldsets -->
<fieldset id="first">
<h2 class="title">Personal Details</h2>
<p class="subtitle">Step 1</p>
<label><b>Mobile No. :</b></label>
<input class="text_field" name="mobile" placeholder="Mobile" type="text" required></br>
<label><b>Gender:</b></label></br>
<input name="gender" type="radio" value="Male">Male
<input name="gender" type="radio" value="Female">Female</br></br>
<label><b>Location :</b></label></br>
<input class="text_field" name="location" placeholder="Enter your city and state" type="text"  required></br>
<label><b>Github :</b></label></br>
<input class="text_field" name="github" placeholder="Enter your github profile" type="text"  required></br>
<label><b>LinkedIn :</b></label>
<input class="text_field" name="linkedin" placeholder="Enter your linkedIn profile" type="text"  required></br>
<input id="next_btn1" onclick="next_step1()" type="button" value="Next">
</fieldset>
<fieldset id="second">
  <h2 class="title">Education</h2>
  <p class="subtitle">Step 2</p>
  <div id="dynamic_field2">  
  <table>
      <tr><td><input class="text_field" name="degree[]" id="degree" placeholder="Degree" type="text" value=""></td></tr>
      <tr><td> <input class="text_field" name="stream[]" id="stream" placeholder="Stream" type="text" value=""></td></tr>
      <tr><td><input class="text_field" name="syear[]" id="syear" placeholder="Start Year" type="text" value=""></td></tr>
      <tr><td><input class="text_field" name="pyear[]" id="pyear" placeholder="Passing Year" type="text" value=""></td></tr>
      <tr><td><input class="text_field" name="univ[]" id="univ" placeholder="University" type="text" value=""></td></tr>
      <tr><td><input class="text_field" name="score[]" id="score" placeholder="Score" type="text" value=""></td></tr>
      <tr><td><hr></td></tr>
      <tr><td><input style="background-color: forestgreen;" id="add2" type="button" value="Add Education"></td></tr> 
  </table>
  </div>
  <table>
    <tr>
      <td><input id="pre_btn1" onclick="prev_step1()" type="button" value="Previous"></td>
      <td><input id="next_btn2" name="next" onclick="next_step2()" type="button" value="Next"></td>
    </tr>
  </table>
  </fieldset>

<fieldset id="third">
<h2 class="title">Skills</h2>
<p class="subtitle">Step 3</p>
<div id="dynamic_field3">
<table>
  <tr><td><input class="text_field" name="skills[]" id="skills" placeholder="Skill" type="text"></td></tr>
   <tr><td><input style="background-color: forestgreen;" type="button" value="Add Skills" id="add3"></td></tr>
</table>
</div>
 <table>
   <tr>
    <td><input id="pre_btn2" onclick="prev_step2()" type="button" value="Previous"></td>
    <td><input id="next_btn3" name="next" onclick="next_step3()" type="button" value="Next"></td>
</tr>
</table>

</fieldset>
<fieldset id="fourth">
  <h2 class="title">Projects</h2>
      <p class="subtitle">Step 6</p>
      <div id="dynamic_field6">
        <table>
          <tr><td><input class="text_field" name="proj_name[]" id="proj_name" placeholder="Project Name" type="text" value=""></td></tr>
          <tr><td> <input class="text_field" name="proj_host[]" id="proj_host" placeholder="Institute or Company Name" type="text" value=""></td></tr>
          <tr><td><input class="text_field" name="proj_startdate[]" id="proj_startdate" placeholder="Start Date" type="text" value=""></td></tr>
          <tr><td><input class="text_field" name="proj_enddate[]" id="proj_enddate" placeholder="End Date" type="text" value=""></td></tr>
          <tr><td><textarea class="text_field" name="proj_description[]" id="proj_description" placeholder="Description" type="text" value=""></textarea></td></tr>
          <tr><td><hr></td></tr>
          <tr><td><input style="background-color: forestgreen;" id="add6" type="button" value="Add Projects"></td></tr> 
      </table>
        </div>
 <table>
   <tr>
    <td><input id="pre_btn5" onclick="prev_step3()" type="button" value="Previous"></td>
    <td><input id="next_btn5" name="next" onclick="next_step4()" type="button" value="Next"></td>
</tr>
</table>
  </fieldset>
  <fieldset id="fifth">
    <h2 class="title">Experience</h2>
    <p class="subtitle">Step 4</p>
    <div id="dynamic_field4">
      <table>
        <tr><td><input class="text_field" name="expr_name[]" id="expr_name" placeholder="Experience Name" type="text" value=""></td></tr>
        <tr><td> <input class="text_field" name="expr_host[]" id="expr_host" placeholder="Institute or Company Name" type="text" value=""></td></tr>
        <tr><td><input class="text_field" name="expr_startdate[]" id="expr_startdate" placeholder="Start Date" type="text" value=""></td></tr>
        <tr><td><input class="text_field" name="expr_enddate[]" id="expr_enddate" placeholder="End Date" type="text" value=""></td></tr>
        <tr><td><textarea class="text_field" name="expr_description[]" id="expr_description" placeholder="Description" type="text" value=""></textarea></td></tr>
        <tr><td><hr></td></tr>
        <tr><td><input style="background-color: forestgreen;" id="add4" type="button" value="Add More"></td></tr> 
    </table>
      </div>
 <table>
   <tr>
    <td><input id="pre_btn5" onclick="prev_step4()" type="button" value="Previous"></td>
    <td><input id="next_btn5" name="next" onclick="next_step5()" type="button" value="Next"></td>
</tr>
</table>
    </fieldset>
    <fieldset id="sixth">
      <h2 class="title">Achievements</h2>
    <p class="subtitle">Step 5</p>
    <div id="dynamic_field5">
      <table>
        <tr><td><textarea class="text_field" name="achiv[]" id="achiv" placeholder="Achievement Description" type="text"></textarea></td></tr>
         <tr><td><input style="background-color: forestgreen;" type="button" value="Add More" id="add5"></td></tr>
      </table>
      </div>
   <table>
     <tr>
      <td><input id="pre_btn5" onclick="prev_step5()" type="button" value="Previous"></td>
<td><button type="submit" class="submit_btn" name="submit_btn" onclick="validation(event)" value="Submit">Submit</button></td></form>
    <form method="post" action="generatetemplate1.php">
      <button type="submit" value="submit" name="generatetemplate1">Get CV in Template 1</button>
      </form>
      <form method="post" action="generatetemplate2.php">
      <button type="submit" value="submit" name="generatetemplate2">Get CV in Template 2</button>
      </form> 
  </tr>
  </table>
      </fieldset> 

</div>
</div>
<script>
  var i = 1;
    $('#add3').click(function(){
        i++;
        $('#dynamic_field3').append('<table id="row'+i+'"><tr><td><input class="text_field" name="skills[]" id="skills" placeholder="Skill" type="text"></td></tr><tr><td><input style="background-color: red;" type="button" name="remove skills" id="'+i+'" value="Remove Skill" class="btn btn-danger btn_remove"></td></tr></table>'
        );
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });
    var j = 1;
    $('#add2').click(function(){
        j++;
        $('#dynamic_field2').append('<table id="row'+j+'"><tr><td><input class="text_field" name="degree[]" id="degree" placeholder="Degree" type="text" value=""></td></tr><tr><td> <input class="text_field" name="stream[]" id="stream" placeholder="Stream" type="text" value=""></td></tr><tr><td><input class="text_field" name="syear[]" id="syear" placeholder="Start Year" type="text" value=""></td></tr><tr><td><input class="text_field" name="pyear[]" id="pyear" placeholder="Passing Year" type="text" value=""></td></tr><tr><td><input class="text_field" name="univ[]" id="univ" placeholder="University" type="text" value=""></td></tr><tr><td><input class="text_field" name="score[]" id="score" placeholder="Score" type="text" value=""></td></tr><tr><td><hr></td></tr><tr><td><input style="background-color: red;" type="button" name="remove education" id="'+j+'" value="Remove" class="btn btn-danger btn_remove"></td></tr></table>'
        );
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    }); 
    var k = 1;
    $('#add5').click(function(){
        k++;
        $('#dynamic_field5').append('<table id="row'+k+'"><tr><td><textarea class="text_field" name="achiv[]" id="achiv" placeholder="Achievement Description" type="text"></textarea></td></tr><tr><td><input style="background-color: red;" type="button" name="remove skills" id="'+k+'" value="Remove" class="btn btn-danger btn_remove"></td></tr></table>'
        );
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });
    var m = 1;
    $('#add4').click(function(){
        k++;
        $('#dynamic_field4').append('<table id="row'+m+'"><tr><td><input class="text_field" name="expr_name[]" id="expr_name" placeholder="Experiance Name" type="text" value=""></td></tr><tr><td> <input class="text_field" name="expr_host[]" id="expr_host" placeholder="Institute or Company Name" type="text" value=""></td></tr><tr><td><input class="text_field" name="expr_startdate[]" id="expr_startdate" placeholder="Start Date" type="text" value=""></td></tr><tr><td><input class="text_field" name="expr_enddate[]" id="expr_enddate" placeholder="End Date" type="text" value=""></td></tr><tr><td><textarea class="text_field" name="expr_description[]" id="expr_description" placeholder="Description" type="text" value=""></textarea></td></tr><tr><td><hr></td></tr><tr><td><input style="background-color: red;" type="button" name="remove skills" id="'+m+'" value="Remove" class="btn btn-danger btn_remove"></td></tr></table>'
        );
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });
    var n = 1;
    $('#add6').click(function(){
        k++;
        $('#dynamic_field6').append('<table id="row'+n+'"><tr><td><input class="text_field" name="proj_name[]" id="proj_name" placeholder="Project Name" type="text" value=""></td></tr><tr><td> <input class="text_field" name="proj_host[]" id="proj_host" placeholder="Institute or Company Name" type="text" value=""></td></tr><tr><td><input class="text_field" name="proj_startdate[]" id="proj_startdate" placeholder="Start Date" type="text" value=""></td></tr><tr><td><input class="text_field" name="proj_enddate[]" id="proj_enddate" placeholder="End Date" type="text" value=""></td></tr> <tr><td><textarea class="text_field" name="proj_description[]" id="proj_description" placeholder="Description" type="text" value=""></textarea></td></tr><tr><td><hr></td></tr><tr><td><input style="background-color: red;" type="button" name="remove skills" id="'+n+'" value="Remove" class="btn btn-danger btn_remove"></td></tr></table>'
        );
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });
</script>
</body>
</html>
