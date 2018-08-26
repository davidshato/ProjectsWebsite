<!DOCTYPE html>
<html>
<head>
<link href="style/style2.css" rel="stylesheet">
<meta charset="utf-8">    
<title>c</title>
</head>
<body>

<div class="header">
  <img src="#" alt="#">
</div>
<script src="jscripts/changepic.js"></script>

<div class="topnav">
  <a href="home.php">HOME</a>
  <a href="ContactUs.php">Contact US</a>
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
            <h2>Connect Us</h2>

            <form  method="post">

                full Name:<br>
                <input type="text" name="name"><br>

                email:<br>
                <input type="text" name="email"><br>
                phone number:<br>
                <input type="text" name="phone"><br>
                Subject:<br>
                <input type="text" name="subject"><br>
                <p>Comments:<br>
                    <textarea name="message" rows="10" cols="50">Some text will be written here...</textarea>

                <input type="submit" name="connectUs" value="Send"><br>

            </form>


            <?php

            require_once ("classes/ex28-DB.php");
            require_once ("classes/contact.php");

            function sendMailTous($input)//connect us page
            {
                $tpl=file_get_contents("mail.eml");//msg pattern
                $text=$input;

                $mail=$tpl;
                $mail=strtr($mail,array(
                    "{TO}"=>"david&shai@mail.co.il",
                    "{TEXT}"=>$text,
                ));
                list($head,$body)=preg_split("/\r?\ns\r?\n/s",$mail,2);
                mail("","",$body,$head);
            }


            if(isset($_POST['connectUs']))
            {
                if(!empty($_POST['name'])&&!empty($_POST['phone'])&&!empty($_POST['email'])&&!empty($_POST['subject'])&&!empty($_POST['message']))
                {
                    $contact=new contact($_POST['name'],$_POST['email'],$_POST['phone'],$_POST['subject'],$_POST['message']);
                    $input=$contact->createFullMessage();
                    sendMailTous($input);

                    echo "<p style='color: #f44336'>thank you</p>";


                }
                else
                {
                    echo "<p style='color: #f44336'>Please fill all the labels</p>";
                }

            }



            ?>
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
              $_SESSION['LastPage']="ContactUs.php";
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
