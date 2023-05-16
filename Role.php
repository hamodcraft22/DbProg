<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Role
 *
 * @author ADMIN
 */
class Role {
    //put your code here
    private $roleID;
    private $roleName;
    private $roleDescription;
    
    public function __construct($roleID, $roleName, $roleDescription) {
        $this->roleID = $roleID;
        $this->roleName = $roleName;
        $this->roleDescription = $roleDescription;
    }
    public function getRoleID() {
        return $this->roleID;
    }

    public function getRoleName() {
        return $this->roleName;
    }

    public function getRoleDescription() {
        return $this->roleDescription;
    }

    public function setRoleID($roleID): void {
        $this->roleID = $roleID;
    }

    public function setRoleName($roleName): void {
        $this->roleName = $roleName;
    }

    public function setRoleDescription($roleDescription): void {
        $this->roleDescription = $roleDescription;
    }


}
