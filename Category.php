<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Category
 *
 * @author ADMIN
 */
include 'Article.php';
class Category extends Article{
    //put your code here
    private $categoryID;
    private $categoryName;
    
    public function __construct($categoryID, $categoryName, $articleID) {
        parent::__construct($articleID);
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;
    }
    public function getCategoryID() {
        return $this->categoryID;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function setCategoryID($categoryID): void {
        $this->categoryID = $categoryID;
    }

    public function setCategoryName($categoryName): void {
        $this->categoryName = $categoryName;
    }


}
