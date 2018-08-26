<!DOCTYPE html>
<html>
<head>
<link href="style/style2.css" rel="stylesheet">
    <script src="jscripts/jquery.js"></script>
    <meta charset="utf-8">
<title>HOME</title>
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
            echo "<a href=\"raport.php\">Report Search</a>";
        else
        {
            echo "<a href=\"Login.php\" style='background-color: green; float: right;' >Login</a>";
        }
    ?>
</div>

<div class="row">
  <div class="leftcolumn">
    <main id="main">
        <div class="card">
            <h2><a id="linkheader" href="about.html">Artworks Search</a></h2>
            <h5>Title description, Dec 7, 2018</h5>
            
            <h3>MasterArt showcases more than 15,000 works of art from 300 of the world’s leading art dealers and galleries</h3>
			<p>Biography : Whether you are looking for an antique Japanese screen, a Renaissance signet ring or a set of Louis XV side tables—or simply indulging in a leisurely browse— MasterArt will guide you to a treasure trove of artworks and antiques…and perhaps help you to find that rare piece missing in your collection. Our portal invites you to search for artwork by keyword (artist or maker), category or gallery, and request to be informed by email of new acquisitions based on your specific search criteria. Take a moment to browse exquisite collections, zoom in on an-eye catching piece, and admire its beauty from a number of different angles.</p>
            <h3>A Reputation for Excellence and Integrity</h3>
			<p>MasterArt.com enjoys a solid reputation in the art market thanks to its deep-rooted commitment to excellence and integrity. Collectors and art professionals alike know that only long-established dealers who regularly exhibit at prestigious international art and antique fairs are invited to display their collections on the MasterArt portal. They know that a dealer’s participation at an international fair serves as a guarantee that the objects exhibited have been vetted by the most demanding of art specialists. In short, the artworks displayed on MasterArt are said to show exceptional beauty and true authenticity.</p>
		</div>
    </main>    
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
              $_SESSION['LastPage']="home.php";
              header("LOCATION:Register.php");
              die();
          }
      }
      ?>
      <div class="card">
        <h3>LINKS</h3>
        <div class="fakeimg"><p><a class="innav" href="#main">main</a></p></div>
        <div class="fakeimg"><p><a class="innav" href="#aside">aside</a></p></div>
        <div class="fakeimg"><p><a class="innav" href="#foot">footer</a></p></div>
    </div>
    <aside id="aside">  
        <div class="card">   
            <h2>About Us</h2>
            <p>Developped and Designed By David Shato and Shai Bahar</p>
        </div>
        <div class="card">
            <h3>Follow Us</h3>
            <p>on Facebook : David shato or Bahar</p>
            <p>on Emai : Davidshai@gmail.com</p>
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