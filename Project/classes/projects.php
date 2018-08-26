<?php

class Projects
{
	protected $id;
    protected $proj_date;
    protected $art_name;
    protected $picture;
	protected $projectName;
	protected $country;

   
    public function getId()   
	{
		return $this->id;
	}
	
	public function setId($id)   
	{
		$this->id=$id;
	}
	public function getCountry()   
	{
		return $this->country;
	}
	public function setCountry($country)   
	{
		$this->country=$country;
	}
	
	public function getName()   
	{
		return $this->art_name;
	}
	public function setName($name)   
	{
	  $this->art_name=$name;
	}
	public function getprojName()   
	{
		return $this->projectName;
	}
	public function setprojName($name)   
	{
	  $this->projectName=$name;
	}
	
	public function getthedate()   
	{
		return $this->proj_date;
	}
	public function setTheDate( $d)
	{
		$this->proj_date=$d;
	}
	public function getPicture()   
	{
		return $this->picture;
	}
	public function setPicture($picture)   
	{
	  $this->picture=$picture;
	}
	
	public function toString()   
	{
		$output="";
        $output.=$this->getId().";";
		$output.=$this->getprojName().";";
		$output.=$this->getName().";";
		$output.=$this->getthedate().";";
		$output.=$this->getCountry().";";
		$output.=$this->getPicture().";";
	  return $output;
	}
	
	
	
}














?>