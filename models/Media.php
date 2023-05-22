<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Media
 *
 * @author ADMIN
 */
include 'ArticleSection.php';
class Media{
    //put your code here
    private $mediaID;
    private $mediaName;
    private $mediaPath;
    private $mediaType;
        
    public function __construct($mediaID, $mediaName, $mediaPath, $mediaTyp,$sectionID) {
        parent::__construct($sectionID);
        $this->mediaID = $mediaID;
        $this->mediaName = $mediaName;
        $this->mediaPath = $mediaPath;
        $this->mediaType = $mediaType;
    }
    public function getMediaID() {
        return $this->mediaID;
    }

    public function getMediaName() {
        return $this->mediaName;
    }

    public function getMediaPath() {
        return $this->mediaPath;
    }

    public function getMediaType() {
        return $this->mediaType;
    }

    public function setMediaID($mediaID): void {
        $this->mediaID = $mediaID;
    }

    public function setMediaName($mediaName): void {
        $this->mediaName = $mediaName;
    }

    public function setMediaPath($mediaPath): void {
        $this->mediaPath = $mediaPath;
    }

    public function setMediaType($mediaType): void {
        $this->mediaType = $mediaType;
    }


}
