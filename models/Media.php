<?php

class Media
{
    private $mediaID;
    private $mediaName;
    private $mediaPath;
    private $mediaType;
    private $articleID;

    public function __construct()
    {
        $this->mediaID = null;
        $this->mediaName = null;
        $this->mediaPath = null;
        $this->mediaType = null;
        $this->articleID = null;
    }

    public function getMediaID()
    {
        return $this->mediaID;
    }

    public function getMediaName()
    {
        return $this->mediaName;
    }

    public function getMediaPath()
    {
        return $this->mediaPath;
    }

    public function getMediaType()
    {
        return $this->mediaType;
    }

    public function getArticleID()
    {
        return $this->articleID;
    }

    public function setMediaID($mediaID)
    {
        $this->mediaID = $mediaID;
    }

    public function setMediaName($mediaName)
    {
        $this->mediaName = $mediaName;
    }

    public function setMediaPath($mediaPath)
    {
        $this->mediaPath = $mediaPath;
    }

    public function setMediaType($mediaType)
    {
        $this->mediaType = $mediaType;
    }

    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }
    
    // constructer
    public function initMedia($mediaID, $mediaName, $mediaPath, $mediaType, $articleID)
    {
        $this->mediaID = $mediaID;
        $this->mediaName = $mediaName;
        $this->mediaPath = $mediaPath;
        $this->mediaType = $mediaType;
        $this->articleID = $articleID;
    }
    
    // init media with an id 
    public function initMwithID()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_media where mediaID = ' . $this->getMediaID() . ';';
            $data = $db->singleFetch($q);
            $this->initMedia($data->mediaID, $data->mediaName, $data->mediaPath, $data->mediaType, $data->articleID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    // save media to db
    public function saveMedia()
    {
        try {
            $db = Database::getInstance();
            $q = 'insert into dbProj_media (mediaName, mediaPath, mediaType, articleID) values ("'.$this->getMediaName().'" ,"'.$this->getMediaPath().'" ,"'.$this->getMediaType().'" ,'.$this->getArticleID().' )';
            $data = $db->querySql($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // update media in db 
    public function updateMedia()
    {
        try {
            $db = Database::getInstance();
            $q = 'update dbProj_media set mediaName = "'.$this->getMediaName().'", mediaPath = "'.$this->getMediaPath().'", mediaType = "'.$this->getMediaType().'" where mediaID = '.$this->getMediaID().';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // delete media from db
    public function deleteMedia()
    {
        try {
            $db = Database::getInstance();
            $q = 'delete from dbProj_media where mediaID = '.$this->getMediaID().';';
            $data = $db->querySql($q);
            unlink($this->getMediaPath());
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // retrive all the medais fro an article
    function getAllMedia()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_media ';
            
            if ($this->getArticleID() != null)
            {
                $q .= 'where articleID =' . $this->getArticleID();
            }
            
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // get a video for a spisifc article (sed for home video)
    function getVideo()
    {
        try {
            $db = Database::getInstance();
            $q = "select * from dbProj_media where articleID = $this->articleID and mediaType in ('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi', 'opus', 'flac', 'weba', 'wav', 'ogg', 'm4a', 'oga', 'mid', 'mp3', 'aiff', 'wma', 'au') limit 1;";
            $data = $db->singleFetch($q);
            $this->initMedia($data->mediaID, $data->mediaName, $data->mediaPath, $data->mediaType, $data->articleID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    //get a photo for a an article (used for home when video is not found)
    function getPhoto()
    {
        try {
            $db = Database::getInstance();
            $q = "select * from dbProj_media where articleID = $this->articleID and mediaType not in ('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi', 'opus', 'flac', 'weba', 'wav', 'ogg', 'm4a', 'oga', 'mid', 'mp3', 'aiff', 'wma', 'au') limit 1;";
            $data = $db->singleFetch($q);
            $this->initMedia($data->mediaID, $data->mediaName, $data->mediaPath, $data->mediaType, $data->articleID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
}
