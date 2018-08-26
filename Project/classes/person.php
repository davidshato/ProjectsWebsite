<?php
require_once ("address.php");
 class person
 { 
	protected $ID;
	protected $lastname;
	protected $firstname;
	protected $phoneNumber;
	protected $password;
	protected $email;
	protected $Admin;
	protected $picture;
	
	
public function setPerson( $ID, $firstname,$lastname, $phoneNumber,$password, $email, $Admin,$picture)//set value in person
{

	$this->ID=$ID;
    $this->firstname=$firstname;
    $this->lastname=$lastname;
	$this->password= password_hash($password, PASSWORD_DEFAULT);
	$this->phoneNumber=$phoneNumber;
    $this->email=$email;
	$this->Admin=$Admin;
	$this->picture=$picture;
	
	
}
     public function setPersonForUpdate( $ID, $firstname,$lastname, $phoneNumber,$password, $email, $Admin,$picture)//set value in person
     {

         $this->ID=$ID;
         $this->firstname=$firstname;
         $this->lastname=$lastname;
         $this->password= $password;
         $this->phoneNumber=$phoneNumber;
         $this->email=$email;
         $this->Admin=$Admin;
         $this->picture=$picture;


     }


	public function isAdmin()
	{
		if($this->Admin=="1")
			return true;
		return false;
	}
     /**
      * @return mixed
      */
     public function getAdmin()
     {
         return $this->Admin;
     }

     /**
      * @param mixed $Admin
      */
     public function setAdmin($Admin)
     {
         $this->Admin = $Admin;
     }

	public function getPicture(){
		return $this->picture;
	}
	public function setPicture($picture){
		$this->picture=$picture;
	}
	public function getID()//getters and setters
	{
		
		return $this->ID;
	}
	
	public function setID($id)
	{
		$this->ID=$id;
	}
	
	public function getFirstName()
	{
		return $this->firstname;
	}
	
	public function setFirstName($name)
	{
		$this->firstname=$name;
	}
	public function getLastName()
	{
		return $this->lastname;
	}
	
	public function setLastName($name)
	{
		$this->lastname=$name;
	}

    public function getPhoneNumber()
	{
		return $this->phoneNumber;
	}
	
	public function setPhoneNumber($number)
	{
		$this->phoneNumber=$number;
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($pass)
	{
		$this->password= password_hash($pass, PASSWORD_DEFAULT);
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email=$email;
	}
	
   public function toString()//func to string
   {
	   return "id-".$this->getID()." name-".$this->getName()." age-".$this->getAge()." email-".$this->getEmail();   
   }
	
}
	 
	 
	 
	 
 



?>
