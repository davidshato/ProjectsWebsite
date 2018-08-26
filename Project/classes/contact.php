<?php



class contact
{

    private $name;
    private $email;
    private $tel;
    private $subject;
    private $message;

    /**
     * contact constructor.
     * @param $name
     * @param $email
     * @param $tel
     * @param $subject
     * @param $message
     */
    public function __construct($name, $email, $tel, $subject, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->tel = $tel;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function createFullMessage()
    {
        $output="";

        $output.="subject:".$this->subject."\n";
        $output.="name: ".$this->name."\n";
        $output.="phone: ".$this->tel."\n";
        $output.="email: ".$this->email."\n";
        $output.=$this->message."\n";

        return $output;



    }


}
?>