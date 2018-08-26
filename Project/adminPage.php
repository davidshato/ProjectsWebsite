<!DOCTYPE html>
<html>
<head>
<link href="style/style2.css" rel="stylesheet">
<meta charset="utf-8">    
<title>Form</title>
</head>
<body>

<div class="header">
  <img src="#" alt="#">
</div>
<script src="jscripts/changepic.js"></script>
  

<div class="topnav">
  <a href="adminPage.php">Users</a>
  <a href="ProjectsPage.php">Projects</a>
 
</div>

<div class="row">
  <div class="leftcolumn">
    <main id="main">  
    <h1>Admin Page</h1>
    <script src="scripts/chackpass.js"></script>
<div class="card">	
    <form method='POST'>
           <fieldset>
			<p>
                <label>Delete user from system:</label>
                <input type="text" id="Delete_user" name="Delete_user"/>
				<input class="button"  name="delPerson" type="submit" value="Delete"/>
            </p>
            <p>
                <label>Show User Details :</label>
                <input type="text" name="UserID"/>
                <input class="button"  name="serchUsers" type="submit" value="Search"/>
				<input class="button"  name="Show_All" type="submit" value="Show All"/>
            </p>
               
            <p>
                <label>reports</label>
                 <select name="reports">
					<option value="users">users report</option>
					<option value="projects">projects report</option>
					<option value="all">All reports</option>
				 </select>
				 <input class="button"  name="out_reports" type="submit" value="result"/>
            </p>
			
        </fieldset>
    </form> 
	

</div>



    </main>
      <?php
      require_once("classes/person.php");
      require_once("classes/address.php");
      require_once("classes/ex28-DB.php");
      require_once("classes/projects.php");
      require_once ("classes/pdf.php");
      ob_start();
      $person=new Person();
      $Address=new address();
      $DB=new dbClass();
      $pdf=new mypdf();


      if(isset($_POST['delPerson']))
      {
          if(!empty($_POST['Delete_user']))
          {
              $DB->Delete_user($_POST['Delete_user']);
              echo "user ID: ".$_POST['Delete_user']."have been deleted <br>";
          }
      }


      if(isset($_POST['serchUsers']))
      {
          if(isset($_POST['UserID']))
          {
              $p=$DB->getPersonByID($_POST['UserID']);
              if($p!=null) {
                  $DB->DisplayPerson($p);
              }
              else
              {
                  echo "<p class='error'>user not exist </p>";
              }
          }



      }


      if(isset($_POST['Show_All']))
      {
          $persons=$DB->getPersons();
          if($persons!=null) {
              $DB->PersonDisplay($persons);

          }
      }

      if(isset($_POST['out_reports']))
      {
          if($_POST['reports']=="users")
          {


              ob_clean();
              $pdf->AliasNbPages();
              $pdf->AddPage('L','A4',0);
              $pdf->createHeader("Users");
              $pdf->PersonheaderTable();
              $persons=$DB->getPersons();
              $pdf->PersonTableView($persons);
              $pdf->Output();


          }

          if($_POST['reports']=="projects")
          {
              ob_clean();
              $pdf->AliasNbPages();
              $pdf->AddPage('L','A4',0);
              $pdf->createHeader("Projects");
              $pdf->projectsHeaderTable();
              $projects=$DB->getProjects();
              $pdf->ProjectsTableView($projects);
              $pdf->Output();
          }

          if($_POST['reports']=="all")
          {
              ob_clean();
              $pdf->AliasNbPages();
              $pdf->AddPage('L','A4',0);
              $pdf->createHeader("Projects");
              $pdf->projectsHeaderTable();
              $projects=$DB->getProjects();
              $pdf->ProjectsTableView($projects);
              $pdf->AddPage('L','A4',0);
              $pdf->createHeader("Users");
              $pdf->PersonheaderTable();
              $persons=$DB->getPersons();
              $pdf->PersonTableView($persons);
              $pdf->Output();

          }
      }
      ?>
  </div>
  <div class="rightcolumn">
      <?php

      session_start();
      require_once ("classes/ex28-DB.php");
      require_once("classes/person.php");
      require_once("classes/address.php");
      $DB=new dbClass();

      if(isset($_SESSION['user']))
      {
          $user = unserialize($_SESSION['user']);
          $address=$DB->getAddressByID($user->getID());

          echo "<div class='card'>";
          echo '<img src='.$user->getPicture().' alt="profilePic"/>';
          echo '<h4>'.$user->getFirstName()." ".$user->getLastName().'</h4>';
          echo '<small><cite title='.$address->toString().'>'.$address->toString().'</cite></small>';
          echo "<p>";
          echo '<p>Tel:'.$user->getPhoneNumber().'</p>';
          echo '<p>Email: '.$user->getEmail().'</p>';
          echo "</p>";
          echo "<form method='post'>";
          echo "<button type='submit' name='disconnect' type='button' class='btn btn-primary'>disconnect</button>";
          echo "</form>";
          echo "<form method='post'>";
          echo "<button type='submit' name='EditProfile' type='button' class='btn btn-primary'>Edit Profile</button>";
          echo "</form>";
          echo "</div>";
      }
      else{
          echo  "<div class='card'>";
          echo "<p style='color: #f44336'>hello,guest</p>";
          echo "<p style='color: #f44336'>Registration Is One Click Away</p>";
          echo "<button><a href='Register.php'>Click Here</a></button>";
          echo  "</div>";
      }


      if(isset($_POST['disconnect']))
      {

          if(isset($_SESSION['user']))
          {

              unset($_SESSION['user']);
              unset($_SESSION['EditProfile']);
              unset($_SESSION['LastPage']);
              header("LOCATION:Login.php");
              die();
          }
      }

      if(isset($_POST['EditProfile']))
      {
          if(isset($_SESSION['user']))
          {
              $_SESSION['EditProfile']="1";
              $_SESSION['LastPage']="adminPage.php";
              header("LOCATION:Register.php");
              die();
          }
      }
      ?>
     <aside id="aside"> 
        <div class="card">
            <h2>About Us</h2>
			<!--connect_us -->
            <p>Developped and Designed By David Shato and Shai Bahare</p>
        </div>
        <div class="card">
            <h3>Follow Us</h3>
            <p>on Facebook : David shato or Bahar</p>
            <p>on Emai : Davidshato@gmail.com</p>
            <p>on TelePhon : 04-8756595</p>        
        </div>
      </aside>     
  </div>
</div>

<div id="foot" class="footer">
  <h2>&copy; Developped and Designed By David Shato and Shai Bahar,2018</h2>
</div>

</body>
</html>