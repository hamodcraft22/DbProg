<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ArticleSection
 *
 * @author ADMIN
 */
include 'Article.php';
class ArticleSection extends Article{
    //put your code here
    private $sectionID;
    private $sectionHeader;
    private $sectionBody;
    
    public function __construct($sectionID, $sectionHeader, $sectionBody,$articleID) {
        parent::__construct($articleID);
        $this->sectionID = $sectionID;
        $this->sectionHeader = $sectionHeader;
        $this->sectionBody = $sectionBody;
    }
    public function getSectionID() {
        return $this->sectionID;
    }

    public function getSectionHeader() {
        return $this->sectionHeader;
    }

    public function getSectionBody() {
        return $this->sectionBody;
    }

    public function setSectionID($sectionID): void {
        $this->sectionID = $sectionID;
    }

    public function setSectionHeader($sectionHeader): void {
        $this->sectionHeader = $sectionHeader;
    }

    public function setSectionBody($sectionBody): void {
        $this->sectionBody = $sectionBody;
    }

}
