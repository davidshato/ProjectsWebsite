<?php


require_once ("fpdf.php");
require_once("ex28-DB.php");
require_once ("person.php");
require_once ("address.php");
require_once ("projects.php");


class mypdf extends FPDF
{

    function createHeader($reportName)
    {

        $this->image('images/logo.png',10,6);
        $this->SetFont("Arial","B",14);
        $this->Cell(276,5,$reportName." Report",0,0,'C');
        $this->Ln();
        $this->SetFont("Times",'',12);
        $this->Cell(276,10, $reportName." Details",0,0,'C');
        $this->Ln(20);

    }

    function footer()
    {

        $this->SetY(-15);
        $this->SetFont("Arial",'',8);
        $this->Cell(0,10,'page'.$this->PageNo().'/{nb}',0,0,'C');
    }

    function PersonheaderTable()
    {

        $this->SetFont('Times',"B",12);
        $this->Cell(30,10,"ID",1,0,"C");
        $this->Cell(50,10,"First Name",1,0,"C");
        $this->Cell(50,10,"Last Name",1,0,"C");
        $this->Cell(70,10,"Phone Number",1,0,"C");
        $this->Cell(70,10,"Email",1,0,"C");

        $this->Ln();

    }


    function PersonTableView($persons)
    {
        $this->SetFont('Times','',12);

        foreach ($persons as $person)
        {
            $this->Cell(30,10,$person->getID(),1,0,"C");
            $this->Cell(50,10,$person->getFirstName(),1,0,"L");
            $this->Cell(50,10,$person->getLastName(),1,0,"L");
            $this->Cell(70,10,$person->getPhoneNumber(),1,0,"L");
            $this->Cell(70,10,$person->getEmail(),1,0,"L");
            $this->Ln();

        }


    }

    function projectsHeaderTable()
    {

        $this->SetFont('Times',"B",12);
        $this->Cell(20,10,"ID",1,0,"C");
        $this->Cell(40,10,"Project Name",1,0,"C");
        $this->Cell(40,10,"Artist Name",1,0,"C");
        $this->Cell(60,10,"Project Country",1,0,"C");
        $this->Cell(60,10,"Project Date",1,0,"C");
        $this->Cell(60,10,"Pic Path",1,0,"C");
        $this->Ln();

    }


    function ProjectsTableView($projects)
    {
        $this->SetFont('Times','',12);

        foreach ($projects as $project)
        {
            $this->Cell(20,10,$project->getid(),1,0,"C");
            $this->Cell(40,10,$project->getprojName(),1,0,"L");
            $this->Cell(40,10,$project->getName(),1,0,"L");
            $this->Cell(60,10,$project->getCountry(),1,0,"L");
            $this->Cell(60,10,$project->getthedate(),1,0,"L");
            $this->Cell(60,10,$project->getPicture(),1,0,"L");
            $this->Ln();

        }


    }



}

?>