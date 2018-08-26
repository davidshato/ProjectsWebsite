
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/Login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
</head>

<body >

<div class="container" >
    <br>  <p class="text-center">David & Shai Visit Our Website<a href="home.php"> Project Website</a></p>
    <hr>

    <div class="row" >
        <aside class="col-sm-4">
            <p>Login</p>
            <div class="card">
                <article class="card-body">
                    <a href="Register.php " class="float-right btn btn-outline-primary">Sign up</a>
                    <h4 class="card-title mb-4 mt-1">Sign in</h4>
                    <form METHOD="post">
                        <div class="form-group">
                            <label>Your ID</label>
                            <input name="ID" class="form-control" placeholder="ID" type="text">
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <label>Your password</label>
                            <input name="Password" class="form-control" placeholder="******" type="password">
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="Login"> Login  </button>
                        </div> <!-- form-group// -->
                    </form>
                </article>
            </div> <!-- card.// -->

        </aside> <!-- col.// -->
    </div> <!-- row.// -->

    <p>
        <?php

        require_once("classes/person.php");
        require_once("classes/address.php");
        require_once("classes/ex28-DB.php");
        $person=new Person();
        $Address=new address();
        $DB=new dbClass();

        //print_r($_POST);

        session_start();
        if(isset($_POST["Login"]))
        {


            if(!empty($_POST['ID'])&&!empty($_POST['Password']))
            {


                if($DB->existPerson($_POST['ID'])==false)//not exist return true, exists return false
                {
                    $person=$DB->getPersonByID($_POST['ID']);
                    if($DB->passwordVerify($_POST['ID'],$_POST['Password']))
                    {
                        $person=$DB->getPersonByID($_POST['ID']);
                        $_SESSION["user"]=serialize($person);
                        if($person->isAdmin())
                        {
                            header("Location: AdminPage.php");
                            die();
                        }
                        else{
                            header("Location:raport.php");
                            die();
                        }

                    }
                    else
                        echo "<p class='error'>Incorrect Password</p>";

                }
                else echo" <p class='error'>user not exist in system !</p>";

            }


        }



        ?>
    </p>

</div>
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