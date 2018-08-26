<!DOCTYPE html>
<html>
<head>
<link href="style/style2.css" rel="stylesheet">

<meta charset="utf-8">    
<title>Report search</title>

</head>
<body>

<div class="header">
  <img src="#" alt="#">
</div>
<script src="jscripts/changepic.js"></script>

<div class="topnav">
  <a href="home.php">HOME</a>
  <a href="ContactUs.php">Contact Us</a>
    <?php
    session_start();

    if(isset($_SESSION['user']))
        echo "<a href=\"raport.php\">Report Search</a>"
    ?>
</div>

<div class="row">
  <div class="leftcolumn">
    <main id="main">  
    <h1>search projects</h1>
    <div class="card">
    <form method='POST'>
           <fieldset>
			<p>
                <label for="">get project by artist name:</label>
                <input type="text" id="proj_by_art_name" name="proj_by_art_name" 
                       >
            </p>
            <p>
                <label for="fname">get project by country:</label>
                <input type="text" id="progbycountry" name="progbycountry" 
                       >
            </p>
            <p>
                <label for="lname">get project by date</label>
                <input type="text" id="projbydate" name="projbydate" 
                       >
            </p>
			
			 <p>
                <label for="lname">get project by project name</label>
                <input type="text" id="projbyname" name="projbyname" 
                       >
            </p>
            <p>
            <input class="button"  name="result" type="submit" value="result"/>
            </p>
        </fieldset>
    </form>

    </main>
<!--      <div class="card">-->

          <?php

          require_once("classes/person.php");
          require_once("classes/address.php");
          require_once("classes/ex28-DB.php");
          require_once("classes/projects.php");
          $person=new Person();
          $Address=new address();
          $DB=new dbClass();


          if(isset($_POST["result"]))
          {
              if(isset($_POST['proj_by_art_name'])&&$_POST['proj_by_art_name']!=null)
              {
                  $projectsArray=$DB->searchProjByArtist($_POST['proj_by_art_name']);
                  if($projectsArray!=null)
                  {
                      echo "".count($projectsArray)." result:"."<br>";
                      $DB->ProjectDisplay($projectsArray);
                  }
                  else echo "0 resault";

              }


              if(isset($_POST['projbyname'])&&$_POST['projbyname']!=null)
              {
                  $projectsArray=$DB->searchProjByName($_POST['projbyname']);
                  if($projectsArray!=null)
                  {
                      echo "".count($projectsArray)." result:"."<br>";
                      $DB->ProjectDisplay($projectsArray);
                  }
                  else echo "0 resault";
              }

              if(isset($_POST['projbydate'])&&$_POST['projbydate']!=null)
              {
                  $projectsArray=array();
                  $projectsArray=$DB->searchProjByDate($_POST['projbydate']);
                  if($projectsArray!=null)
                  {
                      echo "".count($projectsArray)." result:"."<br>";
                      $DB->ProjectDisplay($projectsArray);
                  }
                  else echo "0 resault";
              }

              if(isset($_POST['progbycountry'])&&$_POST['progbycountry']!=null)
              {
                  $projectsArray=array();
                  $projectsArray=$DB->searchProjBycountry($_POST['progbycountry']);
                  if($projectsArray!=null)
                  {
                      echo "".count($projectsArray)." result:"."<br>";
                      $DB->ProjectDisplay($projectsArray);
                  }
                  else echo "0 resault";
              }

          }



          ?>
<!--      </div>-->
  </div>
      <div class="rightcolumn">
          <?php
          ob_start();
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
                  unset($_SESSION['lastPage']);
                  header("LOCATION:Login.php");
                  die();
              }
          }

          if(isset($_POST['EditProfile']))
          {
              if(isset($_SESSION['user']))
              {
                  $_SESSION['EditProfile']="1";
                  $_SESSION['LastPage']="raport.php";
                  header("LOCATION:Register.php");
                  die();
              }
          }
          ?>
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



