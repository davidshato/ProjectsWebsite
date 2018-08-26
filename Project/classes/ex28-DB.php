<?php
require_once("person.php");
require_once("projects.php");
require_once("address.php");

class dbClass
{
    private $host;
    private $db;
    private $charset;
    private $user;
    private $pass;
    private $OPT = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    private $connection;

    public function __construct($host = "localhost", $db = "details", $charset = "utf8", $user = "root", $pass = "")//constructor
    {
        $this->host = $host;
        $this->db = $db;
        $this->charset = $charset;
        $this->user = $user;
        $this->pass = $pass;
    }

    private function connect()//connect to db
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $this->connection = new PDO($dsn, $this->user, $this->pass, $this->OPT);
    }

    public function disconnect()//disconnect
    {
        $this->connect = null;
    }

    public function getPersons()//get all persons in DB
    {
        $this->connect();
        $personsArray = array();

        $result = $this->connection->query("select * from person");
        while ($row = $result->fetchObject('person'))
            $personsArray[] = $row;

        $this->disconnect();
        return $personsArray;
    }

    public function getProjects()//get all persons in DB
    {
        $this->connect();
        $projectsArray = array();

        $result = $this->connection->query("select * from projects");


        while ($row = $result->fetchObject('Projects')) {
            $projectsArray[] = $row;

        }

        $this->disconnect();
        return $projectsArray;
    }
    public function insertProject(Projects $project)
    {
        $this->connect();
        $statment = $this->connection->prepare("INSERT INTO `projects`(`id`, `picture`, `proj_date`, `art_name`, `projectName`, `country`) VALUES (:id,:pic,:proj_date,:artName,:projName,:country)");
        $statment->execute([':id' => $project->getId(),':pic'=>$project->getPicture(),':proj_date'=>$project->getthedate(),':artName'=>$project->getName(),':projName'=>$project->getprojName(),':country'=>$project->getCountry()]);
        $this->disconnect();



    }
    public function sendMailToPerson($person)//personal mail after registration
    {
        $tpl = file_get_contents("mail.eml");//msg pattern
        $text = file_get_contents("msg.txt");//message to person

        $mail = $tpl;
        $mail = strtr($mail, array(
            "{TO}" => $person->getEmail(),
            "{TEXT}" => $text,
        ));
        list($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2);
        mail("", $body, $head);
    }

    public function sendMailTous($input)//connect us page
    {
        $tpl = file_get_contents("mail.eml");//msg pattern
        $text = $input;

        $mail = $tpl;
        $mail = strtr($mail, array(
            "{TO}" => "david&shai@mail.co.il",
            "{TEXT}" => $text,
        ));
        list($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2);
        mail("", $body, $head);
    }


    public function getPersonByID($id)//return  one person obj
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM person WHERE ID=:id");
        $statment->execute([':id' => $id]);
        $result = $statment->fetchObject('person');
        $this->disconnect();
        return $result;
    }


    public function getPersonByFirstName($Name)//return person array by name
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM person WHERE firstname=:Name");
        $statment->execute([':Name' => $Name]);
        while ($result = $statment->fetchObject('person'))
            $personsArray[] = $result;

        $this->disconnect();
        if (isset($personsArray))
            return $personsArray;
        return null;
    }

    public function existPerson($id)//return false if exists else true
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM person WHERE ID=:id");
        $statment->execute([':id' => $id]);
        $result = $statment->fetchObject('person');
        $this->disconnect();
        if ($result != null)
            return false;//if exists
        return true;//if not exists
    }


    public function passwordVerify($id,$password)
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM person WHERE ID=:id");
        $statment->execute([':id' => $id]);
        $result = $statment->fetchObject('person');
        $this->disconnect();


        if(password_verify($password,$result->getPassword()))
            return true;
        return false;
    }


    public function getAddressByID($id)//return one address obj
    {

        $this->connect();
        $statment = $this->connection->prepare("select * from address where ID=:id");
        $statment->execute([':id' => $id]);
        $result = $statment->fetchObject('address');
        $this->disconnect();
        return $result;
    }

    public function insertPerson(person $person,address $address)//insert person data
    {
        $this->connect();
        $statment=$this->connection->prepare("INSERT INTO `person`(ID,firstname,lastname,password,phoneNumber,email,Admin,picture) VALUES (:id, :firstName,:lastname,:password,:phoneNumber,:email,:Admin,:picture)");
        $statment->execute([':id'=>$person->getID(),':firstName'=>$person->getFirstName(),':lastname'=>$person->getLastName(),':password'=>$person->getPassword(),':phoneNumber'=>$person->getPhoneNumber(),':email'=>$person->getEmail(),':Admin'=>$person->getAdmin(),':picture'=>$person->getPicture()]);

        $this->insertPersonAddress($address);

        $this->disconnect();

    }

    public function updatePerson(person $person,address $address)//insert person data
    {
        $this->connect();
        $statment=$this->connection->prepare("UPDATE `person` SET `ID`=:id1,`firstname`=:firstName,`lastname`=:lastName,`password`=:password,`phoneNumber`=:phoneNumber,`email`=:email,`Admin`=:Admin,`picture`=:picture WHERE ID=:id");
        $statment->execute([':id'=>$person->getID(),':id1'=>$person->getID(),':firstName'=>$person->getFirstName(),':lastName'=>$person->getLastName(),':password'=>$person->getPassword(),':phoneNumber'=>$person->getPhoneNumber(),':email'=>$person->getEmail(),':Admin'=>$person->getAdmin(),':picture'=>$person->getPicture()]);

        $this->updatePersonAddress($address);

        $this->disconnect();

    }


    public function insertPersonAddress(address $address)//insert the person adderss info
    {
        $this->connect();

        $statment=$this->connection->prepare('INSERT INTO `address`(`ID`, `city`, `street`, `number`) VALUES (:id, :city,:street,:homeNum)');
        $statment->execute([':id'=>$address->getID(),':city'=>$address->getCity(),':street'=>$address->getStreet(),':homeNum'=>$address->getNumber()]);
        $this->disconnect();

    }

    public function updatePersonAddress(address $address)//insert the person adderss info
    {
        $this->connect();

        $statment=$this->connection->prepare("UPDATE address SET city =:city,street =:street,number=:homeNum  WHERE ID=:id");
        $statment->execute([':id'=>$address->getID(),':city'=>$address->getCity(),':street'=>$address->getStreet(),':homeNum'=>$address->getNumber()]);
        $this->disconnect();

    }


    public function Delete_user($id)
    {

        $this->connect();
        $statment1 = $this->connection->prepare("DELETE FROM address WHERE ID=:id");
        $statment1->execute([':id' => $id]);
        $statment = $this->connection->prepare("DELETE FROM  person WHERE ID=:id");
        $statment->execute([':id' => $id]);
        $this->disconnect();

    }

    public function Delete_project($id)
    {

        $this->connect();
        $statment = $this->connection->prepare("DELETE FROM  projects WHERE ID=:id");
        $statment->execute([':id' => $id]);
        $this->disconnect();

    }

    public function getProjectByid($id)//return one address obj
    {

        $this->connect();
        $statment = $this->connection->prepare("select * from projects where id=:id");
        $statment->execute([':id' => $id]);
        $result = $statment->fetchObject('Projects');
        $this->disconnect();
        return $result;
    }


    public function searchProjByName($Name)//return person array by nam
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM projects WHERE projectName=:Name");
        $statment->execute([':Name' => $Name]);
        while ($result = $statment->fetchObject('Projects'))
            $projectsArray[] = $result;

        $this->disconnect();
        if (isset($projectsArray))
            return $projectsArray;
        return null;
    }

    public function searchProjByArtist($Name)//return person array by nam
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM projects WHERE art_name=:Name");
        $statment->execute([':Name' => $Name]);
        while ($result = $statment->fetchObject('Projects'))
            $projectsArray[] = $result;

        $this->disconnect();
        if (isset($projectsArray))
            return $projectsArray;
        return null;
    }

    public function searchProjByDate($Date)//return person array by nam
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM projects WHERE proj_date=:Date");
        $statment->execute([':Date' => $Date]);
        while ($result = $statment->fetchObject('Projects'))
            $projectsArray[] = $result;

        $this->disconnect();
        if (isset($projectsArray))
            return $projectsArray;
        return null;
    }

    public function searchProjBycountry( $Country)//return person array by nam
    {

        $this->connect();
        $statment = $this->connection->prepare("SELECT * FROM projects WHERE country=:Country");
        $statment->execute([':Country' => $Country]);
        while ($result = $statment->fetchObject('Projects'))
            $projectsArray[] = $result;

        $this->disconnect();
        if (isset($projectsArray))
            return $projectsArray;
        return null;
    }



    public function ProjectDisplay($p)//create a display of the result from the search
    {
        if(gettype($p)=="array") {
            foreach ($p as $value) {
                print '<div class="card">';
                print '<table width="100%" frame="box">';
                print '<tr>';
                print '<td>';
                print '<p>ID: ' . $value->getID() . '</p>';
                print '<p>Name: ' . $value->getprojName() . '</p>';
                print '<p>Country: ' . $value->getCountry() . '</p>';
                print '<p>Artist Name:' . $value->getName() . '</p>';
                print '</td>';
                print '<td>';
                print '<a target="_blank" href=' . $value->getPicture() . '>';
                print '<img src=' . $value->getPicture() . ' alt="project_picture" width="300" height="200">';
                print '</a>';
                print '</td>';
                print '<div class="gallery">';
                print '</tr>';
                print '</table>';
                print "</div>";

            }
        }
        else
        {
            print '<div class="card">';
            print '<table width="100%" frame="box">';
            print '<tr>';
            print '<td>';
            print '<p>ID: ' . $p->getID() . '</p>';
            print '<p>Name: ' . $p->getprojName() . '</p>';
            print '<p>Country: ' . $p->getCountry() . '</p>';
            print '<p>Artist Name:' . $p->getName() . '</p>';
            print '</td>';
            print '<td>';
            print '<a target="_blank" href=' . $p->getPicture() . '>';
            print '<img src=' . $p->getPicture() . ' alt="project_picture" width="300" height="200">';
            print '</a>';
            print '</td>';
            print '</tr>';
            print '</table>';
            print "</div>";
        }

    }


    public function PersonDisplay($persons)
    {

            foreach ($persons as $p) {

                $ID = $p->getID();
                $add = $this->getAddressByID($ID);
                print '<div class="card">';
                print '<table width="100%" frame="box">';
                print '<tr>';
                print '<td>';
                print '<p>ID: ' . $p->getID() . '</p>';

                print '<p>First Name: ' . $p->getfirstName() . '</p>';
                print '<p>Last Name: ' . $p->getLastName() . '</p>';
                print '<p>Email: ' . $p->getEmail() . '</p>';
                print '</td>';
                print '<td>';
                print '<p>Phone Number: ' . $p->getPhoneNumber() . '</p>';
                print '<p>city: ' . $add->getCity() . '</p>';
                print '<p> Street: ' . $add->getStreet() . '</p>';
                print '<p>Home Number: ' . $add->getNumber() . '</p>';
                print '</td>';
                print '<td>';
                print '<a target="_blank" href=' . $p->getPicture() . '>';
                print '<img src=' . $p->getPicture() . ' alt="project_picture" width="300" height="200">';
                print '</a>';
                print '</td>';
                print '</tr>';
                print '</table>';
                print "</div>";

            }

    }

    public  function DisplayPerson($person)
    {

        $ID = $person->getID();
        $add = $this->getAddressByID($ID);
        print '<div class="card">';
        print '<table width="100%" frame="box">';
        print '<tr>';
        print '<td>';
        print '<p>ID: ' . $person->getID() . '</p>';

        print '<p>First Name: ' . $person->getfirstName() . '</p>';
        print '<p>Last Name: ' . $person->getLastName() . '</p>';
        print '<p>Email: ' . $person->getEmail() . '</p>';
        print '</td>';
        print '<td>';
        print '<p>Phone Number: ' . $person->getPhoneNumber() . '</p>';
        print '<p>city: ' . $add->getCity() . '</p>';
        print '<p> Street: ' . $add->getStreet() . '</p>';
        print '<p>Home Number: ' . $add->getNumber() . '</p>';
        print '</td>';
        print '<td>';
        print '<a target="_blank" href=' . $person->getPicture() . '>';
        print '<img src=' . $person->getPicture() . ' alt="project_picture" width="300" height="200">';
        print '</a>';
        print '</td>';
        print '</tr>';
        print '</table>';
        print "</div>";
    }

}

?>