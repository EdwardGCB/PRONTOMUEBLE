<?php
require_once (__DIR__.'../../persistence/Conexion.php');
require_once (__DIR__.'../../persistence/AdministratorDAO.php');
require_once (__DIR__.'../../persistence/ClientDAO.php');
require_once (__DIR__.'../../persistence/SellerDAO.php');
class Person{
    protected $idPerson;
    protected $name;
    protected $lastname;
    protected $email;
    protected $password;
    protected $identification;
    protected $phones;

    public function getIdPerson(): int{
        return $this->idPerson;
    }

    public function setIdPerson($idPerson){
        $this->idPerson = $idPerson;
    }
    public function getName(): string{
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getLastName(): string{
        return $this->lastname;
    }
    public function setLastName($lastname){
        $this->lastname = $lastname;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getPassword(): string{
        return $this->password;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function getIdentification(){
        return $this->identification;
    }
    public function setIdentification($identification){
        $this->identification = $identification;
    }
    public function getPhones(){
        return $this->phones;
    }
    public function setPhones($phones){
        $this->phones = $phones;
    }

    public function __construct($idPerson, $name, $lastname, $email, $password, $identification, $phones) { 
        $this->idPerson = $idPerson; 
        $this->name = $name; 
        $this->lastname = $lastname; 
        $this->email = $email; 
        $this->password = $password; 
        $this->identification = $identification; 
        $this->phones = $phones; 
    }

}
?>