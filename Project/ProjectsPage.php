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
                            <label>Delete Project:</label>
                            <input type="text" id="Delete_project" name="Delete_project"/>
                            <input class="button"  name="delProject" type="submit" value="Delete"/>
                        </p>
                        <p>
                            <label>Show Project Details :</label>
                            <input type="text" name="projectID"/>
                            <input class="button"  name="serchProject" type="submit" value="Search"/>
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
                <div style="padding-top: 20px">
                    <lable>Add Project</lable>
                    <form  method="post" enctype="multipart/form-data">
                            <div>
                                <input class="form-control" name="projName" placeholder="Project Name" type="text"
                                       required />
                            </div>
                            <input class="form-control" name="ID" placeholder="ID" type="text" />
                            <input class="form-control" name="artist" placeholder="Artist Name" type="text" />
                            <input class="form-control" name="country" placeholder="country" type="text" />
                            <label>Image</label>
                            <input type="file" name="load_user_file"/>
                                        <br />
                                        <br />
                            <button class="btn btn-lg btn-primary btn-block" type="submit" name="AddProject">
                                            Add Project</button>
                    </form>
                </div>

        </main>
        <?php

        require_once("classes/person.php");
        require_once("classes/address.php");
        require_once("classes/ex28-DB.php");
        require_once("classes/projects.php");
        require_once ("classes/pdf.php");
        session_start();
        $person=new Person();
        $Address=new address();
        $DB=new dbClass();
        $pdf=new mypdf();
        $project=new Projects();

        function LoadFile()//loading the file image and retturn the path to the image
        {

            $extentions=array("jpg","png","jpeg","gif");

            if(isset($_FILES['load_user_file']['tmp_name']))
            {
                $f_name=$_FILES['load_user_file']['tmp_name'];
                $uploadDir='images/';
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
        if(isset($_POST['AddProject']))//adding project
        {
            if(!empty($_POST['ID'])&&!empty($_POST['projName'])&&!empty($_POST['country'])&&!empty($_POST['artist']))//&&isset($_FILES['load_user_file']['tmp_name']))
            {

                if($DB->getProjectByid($_POST['ID'])==null) {
                    $project->setprojName($_POST['projName']);
                    $project->setId($_POST['ID']);
                    $project->setCountry($_POST['country']);
                    $project->setTheDate(date("m-d-y"));
                    $project->setName($_POST['artist']);
                    $project->setPicture(LoadFile());
                    $DB->insertProject($project);

                    echo "<p>The Project Have Added Successfully</p>";
                }
                else
                {
                    echo "<p class='error'>There is a project with that ID</p>";
                }
            }
            else
                echo "<p class='error'>Please Fill All The Labels</p>";
        }




        if(isset($_POST['delProject']))
        {
            if(!empty($_POST['Delete_project']))
            {
                if($DB->getProjectByid($_POST['Delete_project'])!=null) {
                    $DB->Delete_project($_POST['Delete_project']);
                    echo "<p class='success'>project ID: " . $_POST['Delete_project'] . " have been deleted </p><br>";
                }
                else
                {
                    echo "<p class='error'>Project not exist in storage </p>";
                }
            }
            else
            {
                echo "<p class='error'>Please fill the empty label before </p>";
            }
        }


        if(isset($_POST['serchProject']))
        {
            if(isset($_POST['projectID']))
            {
                $project=$DB->getProjectByid($_POST['projectID']);
                if($project!=null)
                {
                    $DB->ProjectDisplay($project);
                }
                else
                {
                    echo "<p class='error'>Project not exist in storage </p>";
                }
            }



        }


        if(isset($_POST['Show_All']))
        {
            $projects=$DB->getProjects();
            if($projects!=null) {
                $DB->ProjectDisplay($projects);
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
                $_SESSION['LastPage']="ProjectsPage.php";
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
                <p>on Email : Davidshato@gmail.com</p>
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