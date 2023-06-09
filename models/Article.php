<?php

class Article
{

    //attributes
    private $articleID;
    private $header;
    private $title;
    private $body;
    private $date;
    private $thumbnail;
    private $rating;
    private $rates;
    private $views;
    private $statusID;
    private $categoryID;
    private $userID;
    
    public function __construct()
    {
        $this->articleID = null;
        $this->header = null;
        $this->title = null;
        $this->body = null;
        $this->date = null;
        $this->thumbnail = null;
        $this->rating = 0.0;
        $this->rates = 0;
        $this->views = 0;
        $this->statusID = 0;
        $this->categoryID = null;
        $this->userID = null;
    }

    //getters and setters
    public function getArticleID()
    {
        return $this->articleID;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getRates()
    {
        return $this->rates;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function getStatusID()
    {
        return $this->statusID;
    }

    public function getCategoryID()
    {
        return $this->categoryID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function setArticleID($articleID)
    {
        $this->articleID = $articleID;
    }

    public function setHeader($header)
    {
        $this->header = $header;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function setRates($rates)
    {
        $this->rates = $rates;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function setStatusID($statusID)
    {
        $this->statusID = $statusID;
    }

    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    // function to retrive status as name not id
    function getStatus()
    {
        try 
        {
            $db = Database::getInstance();
            $q = 'select statusType from dbProj_status where statusID = ' . $this->getStatusID() . ';';
            $data = $db->singleFetch($q);
            return $data->statusType;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    // function to retrive category as name not id
    function getCategory()
    {

        try 
        {
            $db = Database::getInstance();
            $q = 'select catgoryName from dbProj_category where categoryID = ' . $this->getCategoryID() . ';';
            $data = $db->singleFetch($q);
            return $data->catgoryName;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

    // function to retrive user full name as name not id
    function getUserFullName()
    {
        try 
        {
            $db = Database::getInstance();
            $q = 'select fullname from dbProj_user where userID = ' . $this->getUserID() . ';';
            $data = $db->singleFetch($q);
            return $data->fullname;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }
    
    // constructer
    public function initArticle($articleID, $header, $title, $body, $date, $thumbnail, $rating, $rates, $views, $statusID, $categoryID, $userID)
    {
        $this->articleID = $articleID;
        $this->header = $header;
        $this->title = $title;
        $this->body = $body;
        $this->date = $date;
        $this->thumbnail = $thumbnail;
        $this->rating = $rating;
        $this->rates = $rates;
        $this->views = $views;
        $this->statusID = $statusID;
        $this->categoryID = $categoryID;
        $this->userID = $userID;
    }

    //get article with id
    public function initAwithID()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article where articleID = ' . $this->getArticleID() . ';';
            $data = $db->singleFetch($q);
            $this->initArticle($data->articleID, $data->header, $data->title, $data->body, $data->date, $data->thumbnail, $data->rating, $data->rates, $data->views, $data->statusID, $data->categoryID, $data->userID);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
    }

    // save article to db
    public function saveArti()
    {
        try {
            $db = Database::getInstance();
            $q = 'insert into dbProj_article (header, title, body, thumbnail, rating, rates, views, statusID, categoryID, userID) values ("' . $this->getHeader() . '", "' . $this->getTitle() . '", "' . $this->getBody() . '", "' . $this->getThumbnail() . '", ' . $this->getRating() . ', ' . $this->getRates() . ', ' . $this->getViews() . ', ' . $this->getStatusID() . ', ' . $this->getCategoryID() . ', ' . $this->getUserID() . ')';
            $data = $db->querySql($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // update article in db
    public function updateArti()
    {
        try {
            $db = Database::getInstance();
            $q = 'update dbProj_article set header = "' . $this->getHeader() . '", title = "' . $this->getTitle() . '", body = "' . $this->getBody() . '", thumbnail = "' . $this->getThumbnail() . '", rating = ' . $this->getRating() . ', rates = ' . $this->getRates() . ', views = ' . $this->getViews() . ', statusID = ' . $this->getStatusID() . ', categoryID = ' . $this->getCategoryID() . ', userID = ' . $this->getUserID() . ' where articleID =' . $this->getArticleID() . ';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // delete article from db - actual delete
    public function deleteArti()
    {
        try {
            $db = Database::getInstance();
            $q = 'delete from dbProj_article where articleID = ' . $this->getArticleID() . ';';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // retrives all the articles
    function getAllArtis()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article ';

            // if there is a user id set, get the articles for that user id
            if ($this->getUserID() != null)
            {
                $q .= 'where userID =' . $this->getUserID();
            }

            $q .= ' order by rates DESC;';

            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    //function to retrive articles by date (filter function for admin view)
    public function getAllbyDate($dateStart, $dateEnd)
    {
        try {
            $db = Database::getInstance();
            $q = "select * from dbProj_article where date >= '$dateStart' and date <= '$dateEnd' ";
            
            if ($this->getUserID() != null)
            {
                $q .= 'where userID =' . $this->getUserID();
            }

            $q .= ' order by rates DESC;';
            
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // retrive all of the published articles (with pagenation)
    function getPubArtis($start, $end, $catID)
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article where statusID in (2,3) ';
            
            if(isset($catID))
            {
                $q .= ' and categoryID = '.$catID;
            }
            
            $q .= ' ORDER by date DESC';
            
            if (isset($start))
            {
                $q .= ' limit '.$start.', '.$end;
            }
            
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // function to get the home article (big article for the home with video)
    function getHomeArti()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article where statusID = 3;';
            $data = $db->singleFetch($q);
            $this->initArticle($data->articleID, $data->header, $data->title, $data->body, $data->date, $data->thumbnail, $data->rating, $data->rates, $data->views, $data->statusID, $data->categoryID, $data->userID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // retrive all the category names
    function getAllCategories()
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_category';
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // call publish procd when article is published
    public function setPubDate()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_setPubDate(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // function to add likes (increase rate)
    public function increaseRate()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_incRate(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // function to remove like 
    public function decreaseRate()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_decRate(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // function to increase the views of the article
    public function increaseViews()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_incViews(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // function to keep the article as the main home article (call procd)
    public function setHome()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_setHome(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // pricuder call to set the article as deleted (author delete)
    public function setDeleted()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_setDelete(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // pricuder call to set the article as deleted (admin delete)
    public function setAdminDeleted()
    {
        try {
            $db = Database::getInstance();
            $q = 'CALL dbProj_setAdminDelete(' . $this->getArticleID() . ')';
            $data = $db->querySql($q);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
}
