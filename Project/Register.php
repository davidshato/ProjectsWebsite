
<html>
<!--Add A password update platform and image update platform -->
<head>
    <?php
    require_once("classes/person.php");
    require_once("classes/address.php");
    require_once("classes/ex28-DB.php");
    $DB=new dbClass();
    session_start();
        if(isset($_SESSION['user'])&&isset($_SESSION['EditProfile']))//changing the page title according session
        {
            echo "<title>Edit Profile</title>";
        }
        else
        {

            echo "<title>Register</title>";
        }

    ?>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/Login.css">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body >


?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 well well-sm">
            <legend><a href=""><i class="glyphicon glyphicon-globe"></i></a> Sign up!</legend>
            <form  method="post" enctype="multipart/form-data" class="form" role="form">
                <?php

                //changing the page content according the session

                if(isset($_SESSION['user'])&&isset($_SESSION['EditProfile']))
                {


                        echo '<h2>Edit Profile</h2>';
                        $user=unserialize($_SESSION['user']);
                        $address=$DB->getAddressByID($user->getID());


                        echo '<input class="form-control" name="fName" value='.$user->getFirstName().' type="text"
                               required />';
                        echo '<input class="form-control" name="lName" value='.$user->getLastName().' type="text" required />';
                        echo '<input class="form-control" name="id" value='.$user->getID().' type="text" />';
                        echo '<input class="form-control" name="email" value='.$user->getEmail().' type="text" />';
                        echo '<input class="form-control" name="tel" value='.$user->getPhoneNumber().' type="text" />';
                        echo '<label>Address</label>';
                        echo '<input class="form-control" name="city" value='.$address->getCity().' type="text" /><br>';
                        echo '<input class="form-control" name="street" value='.$address->getStreet().' type="text" /><br>';
                        echo '<input class="form-control" name="homeNumber" value='.$address->getNumber().' type="text" /><br>';
                        echo '<br /><br /><button class="btn btn-lg btn-primary btn-block" type="submit" name="update">Update</button>';


                }
                else {
                    echo '<h2>Register</h2>';
                    echo "<input class=\"form-control\" name=\"fName\" placeholder=\"First Name\" type=\"text\"
                               required />
                <input class=\"form-control\" name=\"lName\" placeholder=\"Last Name\" type=\"text\" required />
                <input class=\"form-control\" name=\"id\" placeholder=\"ID\" type=\"text\" />
                <input class=\"form-control\" name=\"email\" placeholder=\"Email\" type=\"text\" />
                <input class=\"form-control\" name=\"tel\" placeholder=\"Phone Number\" type=\"text\" />
                <input class=\"form-control\" name=\"password\" placeholder=\"New Password\" type=\"password\" />
                <input class=\"form-control\" name=\"reEnterPassword\" placeholder=\"Re-enter Password\" type=\"password\" /><br>
                <label>Address</label>
                <input class=\"form-control\" name=\"city\" placeholder=\"City\" type=\"text\" /><br>
                <input class=\"form-control\" name=\"street\" placeholder=\"Street\" type=\"text\" /><br>
                <input class=\"form-control\" name=\"homeNumber\" placeholder=\"Home Number\" type=\"text\" /><br>
                <label>Profile Image</label>
                <input type=\"file\" name=\"load_user_file\"/>
                <br />
                <br />
                <button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" name=\"register\">
                    Sign up</button>";

                }
                ?>



            </form>
        </div>
    </div>
</div>

<p>
    <?php


    $person=new Person();
    $Address=new address();



    function LoadFile()//loading the file image and retturn the path to the image
    {

        $extentions=array("jpg","png","jpeg","gif");

        if(isset($_FILES['load_user_file']['tmp_name']))
        {
            $f_name=$_FILES['load_user_file']['tmp_name'];

            $uploadDir='uploads/';
            $uploadfile = $uploadDir . basename($_FILES['load_user_file']['name']);

            if(file_exists($f_name))
            {


                if(strpos($_FILES['load_user_file']['type'], "image")!==false)
                {
                    foreach($extentions as $k)
                        if(strpos($_FILES['load_user_file']['type'],$k)!==false)
                        {
                            move_uploaded_file($f_name,$uploadfile);
                            break;

                        }
                }

            }
            return $uploadfile;
        }
    }

    if(isset($_POST["register"]))
    {

        if(isset($_POST['fName'])&&isset($_POST['lName'])&&isset($_POST['id'])&&isset($_POST['email'])&&isset($_POST['tel'])&&isset($_POST['password'])&&isset($_POST['reEnterPassword'])&&isset($_POST['city'])&&isset($_POST['street'])&&isset($_POST['homeNumber']))//&&isset($_FILES['load_user_file']))
        {


            if(strpos($_FILES['load_user_file']['type'], "image")!==false) {

                if ($DB->existPerson($_POST['id'])) {

                    if ($_POST['password'] == $_POST['reEnterPassword']) {

                        $person->setPerson($_POST['id'], $_POST['fName'], $_POST['lName'], $_POST['tel'], $_POST['password'], $_POST['email'], 0, LoadFile());
                        $Address->setAddress($_POST['id'], $_POST['city'], $_POST['street'], $_POST['homeNumber']);
                        $DB->insertPerson($person, $Address);
                        $DB->sendMailToPerson($person);
                        header("Location: Login.php");
                        die();
                    } else
                        print '<p class="error">not good pass</p>';
                }
                else
                    echo "<p class='error'>person already exists</p>";
            }
            else echo "<p class='error'>the file format has to be and image</p>";
        }
        else echo "<p class='error'>please fill all the labels</p>";


    }

    if(isset($_POST['update']))
    {
        if(isset($_POST['fName'])&&isset($_POST['lName'])&&isset($_POST['id'])&&isset($_POST['email'])&&isset($_POST['tel'])&&isset($_POST['city'])&&isset($_POST['street'])&&isset($_POST['homeNumber']))//&&isset($_FILES['load_user_file']))
        {
            $user=unserialize($_SESSION['user']);
            $person->setPersonForUpdate($_POST['id'], $_POST['fName'], $_POST['lName'], $_POST['tel'],$user->getPassword(), $_POST['email'], 0, $user->getPicture());
            $Address->setAddress($_POST['id'], $_POST['city'], $_POST['street'], $_POST['homeNumber']);
            $DB->updatePerson($person,$Address);
            $user=$DB->getPersonByID($_POST['id']);
            $_SESSION["user"]=serialize($user);
            header("LOCATION:".$_SESSION['LastPage']);


        }
    }





    ?>


</p>
<!--container end.//-->

<br><br><br>
</body>

<footer class="bg-secondary mb-3">
    <div class="card-body text-center">
        <h4 class="text-white">David & Shai </h4>
        <p class="h5 text-white">For Contact Us Plaese Press The Button Below</p><br>
        <p><a class="btn btn-warning" target="_blank" href="ContactUs.php"> Contact Us
                <i class="fa fa-window-restore "></i></a></p>
    </div>
    <br><br><br>
</footer>


</html>