<?php session_start();
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

.right
{
  margin-left:20px;
  margin-top:10px;
  margin-bottom:0px;
}
.left
{
  margin-right:20px;
  margin-top:10px;
  margin-bottom:0px;
}
.column{
  float: left;
  width: 50%;
  padding: 50px;
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
   ?>
  <?php endif ?>
  <div class="topnav">
  <a href="">CVGenerator</a>
  <a  href="details.php">DetailsForm</a>
  <div class="topnav-right">
    <a href=""><span class="glyphicon glyphicon-user"></span><strong><?php echo ' '.$fname.' '.$lname;?></strong></a>
    <a href="details.php?logout='1'"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
  </div>
</div>

</body>
</html>
<?php
    //echo "Generating Template 2....";
    try{
       $db = new \PDO("pgsql:host=127.0.0.1;dbname='cvgenerator'", 'postgres', 'Shivam@21');
    }catch (Exception $e) {
        print $e->getMessage() . "\n";
    }
    $s="\\documentclass{resume}".PHP_EOL;
    $s=$s."\\usepackage[left=0.75in,top=0.6in,right=0.75in,bottom=0.6in]{geometry}".PHP_EOL;
    $s=$s."\\newcommand{\\tab}[1]{\\hspace{.2667\\textwidth}\\rlap{#1}}".PHP_EOL;
    $s=$s."\\newcommand{\\itab}[1]{\\hspace{0em}\\rlap{#1}}".PHP_EOL;
    $id=$_SESSION['id'];
    //echo $id;
    $query="select * from users where id=$id";
    $res=$db->query($query)->fetch(PDO::FETCH_ASSOC);
    if($res)
    {
      $s=$s."\\name{".$res['fname']." ".$res['lname']."}".PHP_EOL;
      $s=$s."\\address{".$res['email'];
            
      //getting personal details of the user from database and writing it to the file
      $query="select * from users_personalinfo where user_id=$id";
      $res=$db->query($query)->fetch(PDO::FETCH_ASSOC);
      $s=$s." \\\\ ".$res['mobile'];
      $s=$s." \\\\ ".$res['linkedin_profile'];
      $s=$s." \\\\ ".$res['github_profile']."}".PHP_EOL.PHP_EOL; 
      $s=$s."\\usepackage{hyperref}".PHP_EOL;
      $s=$s."\\begin{document}".PHP_EOL.PHP_EOL.PHP_EOL;
      
      
      //getting education details of the user from database and writing it to the file
      $query="select * from user_education where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\begin{rSection}{Education}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."{\\bf ".$res[$i]['degree']." , ".$res[$i]['institute']." } \\hfill {\\em ".$res[$i]['startyear']." - ".$res[$i]['endyear']." }".PHP_EOL."\\\\ ".$res[$i]['stream'].PHP_EOL."\\\\ Score : ".$res[$i]['score']." \\\\".PHP_EOL.PHP_EOL;
      }
      $s=$s."\\end{rSection}".PHP_EOL.PHP_EOL;
      
      //getting project details of the user from database and writing it to the file
      $query="select * from user_projects where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\begin{rSection}{Projects}".PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\begin{rSubsection}{".$res[$i]['proj_name']."}{".$res[$i]['proj_startdate']." - ".$res[$i]['proj_enddate']."}{".$res[$i]['proj_host']."}{}".PHP_EOL."\\item ".$res[$i]['proj_description'].PHP_EOL;
        $s=$s."\\end{rSubsection}".PHP_EOL;
      }
      $s=$s."\\end{rSection}".PHP_EOL.PHP_EOL;
      
      //getting experiences details of the user from database and writing it to the file
      $query="select * from user_experiences where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\begin{rSection}{Work Experience}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\begin{rSubsection}{".$res[$i]['expr_name']."}{".$res[$i]['expr_startdate']." - ".$res[$i]['expr_enddate']."}{".$res[$i]['expr_host']."}{}".PHP_EOL."\\item ".$res[$i]['expr_description'].PHP_EOL;
        $s=$s."\\end{rSubsection}".PHP_EOL;
      }
      $s=$s."\\end{rSection}".PHP_EOL.PHP_EOL;
      
      //getting strength details of the user from database and writing it to the file
      $query="select * from user_skills where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\begin{rSection}{Skills}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."{".$res[$i]['skill_name']."    ";
       // $s=$s."\divider";
      }
      $s=$s."}".PHP_EOL."\\end{rSection}".PHP_EOL.PHP_EOL;
      
      //getting achievements details of the user from database and writing it to the file
      $query="select * from user_achievements where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\begin{rSection}{Achievements}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\\\{ ".($i+1).". ".$res[$i]['achievement_description']." }".PHP_EOL;
      }
      $s=$s."\\end{rSection}".PHP_EOL.PHP_EOL;
      $s=$s."\\end{document}";
      //echo $s;
      $file=fopen('CVtemplate2.tex','w');
      fwrite($file,$s);
      fclose($file);
      $output=shell_exec('pdflatex -interaction=nonstopmode CVtemplate2.tex');
      
      //$window_width = "<script type='text/javascript'>alert($(window).width());</script>";
     /* echo '<div class="left"><embed src= "CVtemplate2.pdf" width="800" height= "700">';
      
      echo '<br><br><a href="CVtemplate2.pdf" download="CV.tex">Download .pdf File</a>';
      echo '<br><br><a href="CVtemplate2.tex" download="CV.tex">Download .tex File</a><br><br>';
      copy("CVtemplate2.pdf","CVtemplate2.docx");
      copy("CVtemplate2.pdf","CVtemplate2.doc");
      copy("CVtemplate2.pdf","CVtemplate2.odt");
      echo '<a href="CVtemplate2.docx" download="CVtemplate2.docx">Download .docx File</a><br><br>';
      echo '<a href="CVtemplate2.doc" download="CVtemplate2.doc">Download .doc File</a><br><br>';
      echo '<a href="CVtemplate2.odt" download="CVtemplate2.odt">Download .odt File</a><br><br>';
      echo '</div>';
      //unlink("CVtemplate1.pdf");
      /*$filename = "CVtemplate2.pdf"; 
 
      header("Content-type: application/pdf"); 

      header("Content-Length: " . filesize($filename)); 

      readfile($filename); */
    }
  
    //echo "Generating Template 1";
    try{
       $db = new \PDO("pgsql:host=127.0.0.1;dbname='cvgenerator'", 'postgres', 'Shivam@21');
    }catch (Exception $e) {
        print $e->getMessage() . "\n";
    }
    $s="\\PassOptionsToPackage{dvipsnames}{xcolor}".PHP_EOL;
    $s=$s."\\documentclass[10pt,a4paper,ragged2e]{altacv}".PHP_EOL;
    $s=$s."\\geometry{left=1.25cm,right=1.25cm,top=1.5cm,bottom=1.5cm,columnsep=1.2cm}".PHP_EOL;
    $s=$s."\\usepackage{paracol}".PHP_EOL;
    $s=$s."\\usepackage{hyperref}".PHP_EOL;
    $s=$s."\\ifxetexorluatex".PHP_EOL;
    $s=$s."  \\setmainfont{Lato}".PHP_EOL;
    $s=$s."\\else".PHP_EOL;
    $s=$s."  \\usepackage[utf8]{inputenc}".PHP_EOL;
    $s=$s."  \\usepackage[T1]{fontenc}".PHP_EOL;
    $s=$s."  \\usepackage[default]{lato}".PHP_EOL;
    $s=$s."\\fi".PHP_EOL;
    $s=$s."\\definecolor{Mulberry}{HTML}{72243D}".PHP_EOL;
    $s=$s."\\definecolor{SlateGrey}{HTML}{2E2E2E}".PHP_EOL;
    $s=$s."\\definecolor{LightGrey}{HTML}{666666}".PHP_EOL;
    $s=$s."\\definecolor{Black}{HTML}{000000}".PHP_EOL;
    $s=$s."\\definecolor{Purpe}{HTML}{B038E8}".PHP_EOL;
    $s=$s."\\colorlet{heading}{Black}".PHP_EOL;
    $s=$s."\\colorlet{accent}{Black}".PHP_EOL;
    $s=$s."\\colorlet{emphasis}{Purple}".PHP_EOL;
    $s=$s."\\colorlet{body}{Black}".PHP_EOL;
    $s=$s."\\renewcommand{\\itemmarker}{{\\small\\textbullet}}".PHP_EOL;
    $s=$s."\\renewcommand{\\ratingmarker}{\\faCircle}".PHP_EOL;
    $s=$s."\\addbibresource{sample.bib}".PHP_EOL;
    $s=$s."\\usepackage{xcolor}".PHP_EOL;
    $s=$s."\\begin{document}".PHP_EOL.PHP_EOL;
    $id=$_SESSION['id'];
    //echo $id;
    $query="select * from users where id=$id";
    $res=$db->query($query)->fetch(PDO::FETCH_ASSOC);
    if($res)
    {
      //echo "Inside";
      $s=$s."\\name{\\color{Black}".$res['fname']." ".$res['lname']."}".PHP_EOL;
      $s=$s."\\personalinfo{".PHP_EOL."\\email{".$res['email']."}".PHP_EOL;
            
      //getting personal details of the user from database and writing it to the file
      $query="select * from users_personalinfo where user_id=$id";
      $res=$db->query($query)->fetch(PDO::FETCH_ASSOC);
      $s=$s."\\phone{".$res['mobile']."}".PHP_EOL;
      $s=$s."\\location{".$res['location']."}".PHP_EOL;
      $s=$s."\\linkedin{".$res['linkedin_profile']."}".PHP_EOL;
      $s=$s."\\github{".$res['github_profile']."}".PHP_EOL; 
      $s=$s."}".PHP_EOL;
      $s=$s."\\makecvheader".PHP_EOL;
      $s=$s."\\columnratio{0.6}".PHP_EOL;
      $s=$s."\\begin{paracol}{2}".PHP_EOL;
      
      
      //getting education details of the user from database and writing it to the file
      $query="select * from user_education where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\cvsection{Education}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\cvevent{".$res[$i]['degree']." \ , ".$res[$i]['stream']."}{".$res[$i]['institute']."}{".$res[$i]['startyear']."--".$res[$i]['endyear']."}{}".PHP_EOL."Score : ".$res[$i]['score'].PHP_EOL.PHP_EOL;
      }
      
      //getting project details of the user from database and writing it to the file
      $query="select * from user_projects where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\cvsection{Projects}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\cvevent{".$res[$i]['proj_name']."}{".$res[$i]['proj_host']."}{".$res[$i]['proj_startdate']."--".$res[$i]['proj_enddate']."}{}".PHP_EOL.$res[$i]['proj_description'].PHP_EOL.PHP_EOL;
        $s=$s."\\divider".PHP_EOL;
      }
      
      //getting experiences details of the user from database and writing it to the file
      $query="select * from user_experiences where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\medskip".PHP_EOL.PHP_EOL;
      $s=$s."\\cvsection{Experiences}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\cvevent{".$res[$i]['expr_name']."}{".$res[$i]['expr_host']."}{".$res[$i]['expr_startdate']."--".$res[$i]['expr_enddate']."}{}".PHP_EOL.$res[$i]['expr_description'].PHP_EOL.PHP_EOL;
        $s=$s."\\divider".PHP_EOL;
      }
      
      //getting strength details of the user from database and writing it to the file
      $query="select * from user_skills where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s."\\switchcolumn".PHP_EOL;
      $s=$s."\\cvsection{Skills}".PHP_EOL.PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\cvtag{".$res[$i]['skill_name']."}".PHP_EOL;
       // $s=$s."\divider";
      }
      
      //getting achievements details of the user from database and writing it to the file
      $query="select * from user_achievements where user_id=$id";
      $res=$db->query($query)->fetchAll(PDO::FETCH_ASSOC);
      $s=$s.PHP_EOL.PHP_EOL."\\cvsection{Achievements}".PHP_EOL.PHP_EOL;
      $s=$s."\\begin{itemize}".PHP_EOL;
      for($i=0;$i<count($res);$i++)
      {
        $s=$s."\\item ".$res[$i]['achievement_description'].PHP_EOL;
      }
      $s=$s."\\end{itemize}".PHP_EOL;
      $s=$s."\\end{paracol}".PHP_EOL;
      $s=$s."\\end{document}";
      //echo $s;
      $file=fopen('CVtemplate1.tex','w');
      fwrite($file,$s);
      fclose($file);
      $output=shell_exec('pdflatex -interaction=nonstopmode CVtemplate1.tex');
      
      //$window_width = "<script type='text/javascript'>alert($(window).width());</script>";
      copy("CVtemplate1.pdf","CVtemplate1.docx");
      copy("CVtemplate1.pdf","CVtemplate1.doc");
      copy("CVtemplate1.pdf","CVtemplate1.odt");
      echo '<br><h5 style="color:red">&emsp;<span class="glyphicon glyphicon-alert"></span>&ensp;CV will only generate if you have correctly fill the Details Form , if you have not filled Details form yet then go to DetailsForm link given above to fill your details to get correct CV.</h5>';
      echo '<div class="row"><div class="column"><a href="CVtemplate1.pdf" download="CVtemplate1.pdf"><span class="glyphicon glyphicon-download-alt"></span> <strong>.PDF</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate1.tex" download="CVtemplate1.tex"><span class="glyphicon glyphicon-download-alt"></span><strong> .TEX</strong></a>'.'&emsp;';
      
      echo '<a href="CVtemplate1.docx" download="CVtemplate1.docx"><span class="glyphicon glyphicon-download-alt"></span><strong>.DOCX</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate1.doc" download="CVtemplate1.doc"><span class="glyphicon glyphicon-download-alt"></span><strong>.DOC</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate1.odt" download="CVtemplate1.odt"><span class="glyphicon glyphicon-download-alt"></span><strong>.ODT</strong></a>'.'<br>'.'<br>';
      echo '<embed src= "CVtemplate1.pdf" width="850" height= "1000"></div>';
      
      
      copy("CVtemplate2.pdf","CVtemplate2.docx");
      copy("CVtemplate2.pdf","CVtemplate2.doc");
      copy("CVtemplate2.pdf","CVtemplate2.odt");
      echo '<div class="column"><a href="CVtemplate2.pdf" download="CVtemplate2.pdf"><span class="glyphicon glyphicon-download-alt"></span> <strong>.PDF</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate2.tex" download="CVtemplate2.tex"><span class="glyphicon glyphicon-download-alt"></span><strong> .TEX</strong></a>'.'&emsp;';
      
      echo '<a href="CVtemplate2.docx" download="CVtemplate2.docx"><span class="glyphicon glyphicon-download-alt"></span><strong>.DOCX</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate2.doc" download="CVtemplate2.doc"><span class="glyphicon glyphicon-download-alt"></span><strong>.DOC</strong></a>'.'&emsp;';
      echo '<a href="CVtemplate2.odt" download="CVtemplate2.odt"><span class="glyphicon glyphicon-download-alt"></span><strong>.ODT</strong></a>'.'<br>'.'<br>';
      echo '<embed src= "CVtemplate2.pdf" width="850" height= "1000"></div></div>';
      
      //unlink("CVtemplate1.pdf");
      /*$output=shell_exec('pdflatex -interaction=nonstopmode CVtemplate1.tex');

      $filename = "CVtemplate1.pdf"; 
 
      header("Content-type: application/pdf"); 

      header("Content-Length: " . filesize($filename)); 

      readfile($filename); */
    }
  
?>
