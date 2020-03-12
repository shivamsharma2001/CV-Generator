<?php session_start(); ?>
<?php
  
 //var_dump($_POST);
 if(isset($_POST['submit_btn'])){
   try//trying to establish connection with database 
   {
     $db = new \PDO("pgsql:host=127.0.0.1;dbname='cvgenerator'", 'postgres', 'Shivam@21');
   }
   catch(Exception $e) //else throwing exception
   {
     print $e->getMessage() . "\n";
   }
          
   
   $id=$_SESSION['id'];//getting id of the user
   
   //updating personal fields
   $res=$db->query("select * from users_personalinfo where user_id=$id")->fetch(PDO::FETCH_ASSOC);
   if($res)// if the personal fields already exists then updating,
   {
     $query="update users_personalinfo set mobile={$_POST['mobile']} , location='{$_POST['location']}' , linkedin_profile='{$_POST['linkedin']}' , github_profile='{$_POST['github']}' where user_id=$id ";
     $db->query($query);
   }
   else//else inserting personal information
   {
     $query="insert into users_personalinfo values($id,{$_POST['mobile']},'{$_POST['location']}','{$_POST['linkedin']}','{$_POST['github']}')";
     $db->query($query);
   }
   //echo "Personal Field Added Successfully";
   
   //updating or inserting educations
   $degree_count=count($_POST['degree']);//getting the no of educations posted
   for($i=0;$i<$degree_count;$i++)
   {
     $res=$db->query("select * from user_education where user_id=$id and degree_id=".($i+1))->fetch(PDO::FETCH_ASSOC);
     if($res)//if the education already exists then updating it
     {
        $query="update user_education set degree='{$_POST['degree'][$i]}' ,institute='{$_POST['univ'][$i]}' ,stream='{$_POST['stream'][$i]}' , startyear={$_POST['syear'][$i]} ,endyear={$_POST['pyear'][$i]} ,score='{$_POST['score'][$i]}' where user_id=$id and degree_id=".($i+1);
        $db->query($query);
     }
     else//else inserting new education
     {
       //echo "Inserting";
       $query="insert into user_education(user_id,degree,institute,stream,startyear,endyear,score) values($id,'{$_POST['degree'][$i]}','{$_POST['univ'][$i]}','{$_POST['stream'][$i]}','{$_POST['syear'][$i]}','{$_POST['pyear'][$i]}','{$_POST['score'][$i]}')";
       $db->query($query);
     }
   }
   //echo '<br>'."Educational Field Added Successfully";
   
   //updating or inserting experiences
   $exp_count=count($_POST['expr_name']);//getting the no of achievements posted
   for($i=0;$i<$exp_count;$i++)
   {
     $res=$db->query("select * from user_experiences where user_id=$id and exp_id=".($i+1))->fetch(PDO::FETCH_ASSOC);
     if($res)//if the achievement already exists then updating it
     {
        $query="update user_experiences set expr_name='{$_POST['expr_name'][$i]}' ,expr_host='{$_POST['expr_host'][$i]}' , expr_startdate='{$_POST['expr_startdate'][$i]}' ,expr_enddate='{$_POST['expr_enddate'][$i]}' ,expr_description='{$_POST['expr_description'][$i]}' where user_id=$id and expr_id=".($i+1);
        $db->query($query);
     }
     else//else inserting new achievement
     {
       //echo "Inserting";
       $query="insert into user_experiences(user_id,expr_name,expr_host,expr_startdate,expr_enddate,expr_description) values($id,'{$_POST['expr_name'][$i]}','{$_POST['expr_host'][$i]}','{$_POST['expr_startdate'][$i]}','{$_POST['expr_enddate'][$i]}','{$_POST['expr_description'][$i]}')";
       //echo $query;
       $db->query($query);
     }
   }
   //echo '<br>'."Experiences Field Added Successfully";
   
   //updating or inserting projects
   $proj_count=count($_POST['proj_name']);//getting the no of projects posted
   for($i=0;$i<$proj_count;$i++)
   {
     $res=$db->query("select * from user_projects where user_id=$id and proj_id=".($i+1))->fetch(PDO::FETCH_ASSOC);
     if($res)//if the project already exists then updating it
     {
        $query="update user_projects set proj_name='{$_POST['proj_name'][$i]}' ,proj_host='{$_POST['proj_host'][$i]}' , proj_startdate='{$_POST['proj_startdate'][$i]}' ,proj_enddate='{$_POST['proj_enddate'][$i]}' ,proj_description='{$_POST['proj_description'][$i]}' where user_id=$id and proj_id=".($i+1);
        $db->query($query);
     }
     else//else inserting new project
     {
       //echo "Inserting";
       $query="insert into user_projects(user_id,proj_name,proj_host,proj_startdate,proj_enddate,proj_description) values($id,'{$_POST['proj_name'][$i]}','{$_POST['proj_host'][$i]}','{$_POST['proj_startdate'][$i]}','{$_POST['proj_enddate'][$i]}','{$_POST['proj_description'][$i]}')";
       $db->query($query);
     }
   }
   //echo '<br>'."Projects Added Successfully";
   
   //updating or inserting skills 
   $skill_count=count($_POST['skills']);//getting the no of skills posted
   for($i=0;$i<$skill_count;$i++)
   {
     
     $res=$db->query("select * from user_skills where user_id=$id and skill_id=".($i+1))->fetch(PDO::FETCH_ASSOC);
     if($res)//if the skill already exists then updating it
     {
        $query="update user_skills set skill_name='{$_POST['skills'][$i]}' where user_id=$id and skill_id=".($i+1);
        $db->query($query);
     }
     else//else inserting new skill
     {
       //echo "Inserting";
       $query="insert into user_skills(user_id,skill_name) values($id,'{$_POST['skills'][$i]}')";
       //echo $query;
       $db->query($query);
     }
   }
   //echo '<br>'."Skills Added Successfully";
   
   //updating or inserting achievements
   $ach_count=count($_POST['achiv']);//getting the no of achievements posted
   for($i=0;$i<$ach_count;$i++)
   {
     $res=$db->query("select * from user_achievements where user_id=$id and achievement_id=".($i+1))->fetch(PDO::FETCH_ASSOC);
     if($res)//if the achievement already exists then updating it
     {
        $query="update user_achievements set achievement_description='{$_POST['achiv'][$i]}' where user_id=$id and achievement_id=".($i+1);
        $db->query($query);
     }
     else//else inserting new achievement
     {
       //echo "Inserting";
       $query="insert into user_achievements(user_id,achievement_description) values($id,'{$_POST['achiv'][$i]}')";
       $db->query($query);
     }
   }
   //echo '<br>'."Achievements Added Successfully";
   echo '<h3>Your Data has been submitted successfully</h3>';
   header('location: generateCV.php');
 }
?>
