<?php

class User {

    private $userID;
    private $username;
    private $fullname;
    private $password;
    private $email;
    private $phone;
    private $roleID;

    public function __construct() {
        $this->userID = null;
        $this->username = null;
        $this->password = null;
        $this->email = null;
        $this->phone = null;
        $this->roleID = null;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }
    
    public function getFullname() {
        return $this->fullname;
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

    public function getRoleID() {
        return $this->roleID;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function setUserName($username) {
        $this->username = $username;
    }
    
    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setRoleID($roleID) {
        $this->roleID = $roleID;
    }

    //custome mthods start

    // get the role name 
    function getRole() {
        $db = Database::getInstance();
        $q = 'select roleName from dbProj_role where roleID = ' . $this->getRoleID() . ';';
        $data = $db->singleFetch($q);
        return $data->roleName;
    }

    // constructer
    function initUser($userID, $username, $fullname, $password, $email, $phone, $roleID) {
        $this->userID = $userID;
        $this->username = $username;
        $this->fullname = $fullname;
        $this->password = $password;
        $this->email = $email;
        $this->phone = $phone;
        $this->roleID = $roleID;
    }

    // get user by id
    function initWithID() {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_user where userID = ' . $this->getUserID() . ';';
            $data = $db->singleFetch($q);
            $this->initUser($data->userID, $data->username, $data->fullname, $data->password, $data->email, $data->phone, $data->roleID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

    // get user by username
    function initWithUsername() {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_user where username = "' . $this->getUserName() . '";';
            $data = $db->singleFetch($q);
            $this->initUser($data->userID, $data->username, $data->fullname, $data->password, $data->email, $data->phone, $data->roleID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

    // function to check if username alredy exists (before registration)
    function checkUsername() {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_user where username = "' . $this->getUsername() . '";';
            $data = $db->singleFetch($q);
            if ($data == null) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // register use and encrypt password methods - php password hashing 
    // very secure as a password thats hashed cannot be reverted + even if the password was hashed again it dosent give the same hashed value
    function register() {
        try {
            $db = Database::getInstance();
            // password hashing (passwords are hashed before they are sent to the server for security)
            $password = password_hash($this->getPassword(), PASSWORD_BCRYPT);
            $q = 'insert into dbProj_user (username, fullname, password, email, phone, roleID) values ("' . $this->getUsername() . '","'.$this->getFullname().'","' . $password . '","' . $this->getEmail() . '",' . $this->getPhone() . ',' . $this->getRoleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // delete user 
    function deRegister() {

        try {
            $db = Database::getInstance();
            $q = 'delete from dbProj_user where userID =' . $this->getUserID() . ';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // update user information 
    function updateUser() {
        try {
            $db = Database::getInstance();
            // password hashing (passwords are hashed before they are sent to the server for security)
            $password = password_hash($this->getPassword(), PASSWORD_BCRYPT);
            $q = 'update dbProj_user set username="' . $this->getUsername() . '", fullname="'.$this->getFullname().'", email="' . $this->getEmail() . '", phone=' . $this->getPhone() . ', roleID=' . $this->getRoleID() . ' where userID = ' . $this->getUserID() . ';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // update user with password chnage - not implemented (future updates)
    function updateUserWpass() {
        try {
            $db = Database::getInstance();
            // password hashing (passwords are hashed before they are sent to the server for security)
            $password = password_hash($this->getPassword(), PASSWORD_BCRYPT);
            $q = 'update dbProj_user set username="' . $this->getUsername() . '", fullname="'.$this->getFullname().'", password="' . $password . '", email="' . $this->getEmail() . '", phone=' . $this->getPhone() . ', roleID=' . $this->getRoleID() . ' where userID = ' . $this->getUserID() . ';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // login function - add user paramters to session variable
    function login() {
        try {
            $db = Database::getInstance();
            // password hashing (passwords are hashed before they are sent to the server for security)
            $password = password_hash($this->getPassword(), PASSWORD_BCRYPT);
            $q = 'select * from dbProj_user where username = "' . $this->getUsername() . '";';
            $data = $db->singleFetch($q);
            if ($data != null) {
                if(password_verify($this->getPassword(), $data->password)) {
                    $this->initWithUsername();

                    $_SESSION['userID'] = $this->getUserID();
                    $_SESSION['username'] = $this->getUsername();
                    $_SESSION['roleType'] = $this->getRole();
                    return true;
                }
                else
                {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // logout function
    function logout() {
        $_SESSION['userID'] = '';
        $_SESSION['username'] = '';
        $_SESSION['roleType'] = '';
        session_destroy();
    }
    
    // function to retrive all users (parameters for new updates)
    function getAllUsers($option)
    {
        try {
            $db = Database::getInstance();
            
            $q = 'select * from dbProj_user ';
            
            if ($option == 'admin')
            {
                $q .= ' where roleID = 1';
            }
            else if ($option == 'reader')
            {
                $q .= ' where roleID = 2';
            }
            else if ($option == 'author')
            {
                $q .= ' where roleID = 3';
            }
            
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

}
