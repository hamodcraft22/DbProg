<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of User
 *
 * @author ADMIN
 */

include 'Role.php';

class User extends Role {
    //put your code here
    private $userID;
    private $userName;
    private  $password;
    private $email;
    private $phone;
    public function __construct($userID, $userName, $password, $email, $phone, $roleID) {
        parent::__construct($roleID);
        $this->userID = $userID;
        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
    }
    public function getUserID() {
        return $this->userID;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setUserID($userID): void {
        $this->userID = $userID;
    }

    public function setUserName($userName): void {
        $this->userName = $userName;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setPhone($phone): void {
        $this->phone = $phone;
    }


}
