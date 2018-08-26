<?php

class address
{
	protected $ID;
	protected $city;
	protected $street;
	protected $number;


//getters and setters


public function setAddress($ID,$city,$street,$number)//set value into person
{

	$this->ID=$ID;
    $this->city=$city;
    $this->street=$street;
    $this->number=$number;
	
}



	public function getID()
	{
		return $this->ID;
	}
	
	public function setID($id)
	{
		$this->ID=$id;
	}
	
	
	public function getCity()
	{
		return $this->city;
	}
	
	public function setCity($City)
	{
		$this->city=$City;
	}
	
	public function getStreet()
	{
		return $this->street;
	}
	
	public function setStreet($street)
	{
		$this->street=$street;
	}	
	
	public function getNumber()
	{
		return $this->number;
	}
	
	public function setNumber($number)
	{
		$this->number=$number;
	}
	public function toString()//func toString
	{
		return "".$this->city.",".$this->street.",".$this->number;
		
	}
	
	
	
	
}














?>