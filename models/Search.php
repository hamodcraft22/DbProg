<?php

class Search
{

    // function to searchg by title
    public function byTitleDesc($text)
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article where statusID in (2,3) and match(`header`,`title`) against("' . $text . '" in boolean mode)  ORDER by `date` DESC';
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // function to search by author
    public function byAuthor($text)
    {
        try {
            $db = Database::getInstance();
            $q = 'select `userID` from dbProj_user where roleID != 1 and match(`username`,`fullname`) against("' . $text . '" in boolean mode) limit 1';
            $userID = $db->singleFetch($q)->userID;

            $q2 = 'select * from dbProj_article where statusID = 2 and userID = ' . $userID;
            echo $q2;
            $data = $db->multiFetch($q2);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // function to serach by date 
    public function byDate($date)
    {
        try {
            $db = Database::getInstance();
            $q = 'select * from dbProj_article where statusID in (2,3) and date =\'' . $date . '\';';
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // function to serach by date range
    public function byDateRange($dateStart, $dateEnd)
    {
        try {
            $db = Database::getInstance();
            $q = "select * from dbProj_article where statusID in (2,3) and date >= '$dateStart' and date <= '$dateEnd'";
            echo $q;
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    // function to search by the most read artilces (limited to the top 5)
    public function byMostRead()
    {
        try {
            $db = Database::getInstance();
            $q = "select * from dbProj_article order by views DESC limit 5";
            echo $q;
            $data = $db->multiFetch($q);
            return $data;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    // advance search functions
    function handleAll($text)
    {

        echo $text;
        $search = explode(' ', $text);

        $returnText = '';

        foreach ($search as $term)
        {
            $term = '+' . $term . ' ';
            $returnText .= $term;
        }

        $returnText = trim($returnText);

        return $returnText;
    }

    function handleNone($text)
    {

        $search = explode(' ', $text);

        $returnText = '';

        foreach ($search as $term)
        {
            $term = '-' . $term . ' ';
            $returnText .= $term;
        }

        return $returnText;
    }

    function handlePart($text)
    {

        $search = explode(' ', $text);

        $returnText = '';

        foreach ($search as $term)
        {
            $term = $term . '* ';
            $returnText .= $term;
        }

        $returnText = trim($returnText);

        return $returnText;
    }

    function handleExact($text)
    {

        $returnText = '"' . $text . '"';

        return $returnText;
    }

    function handleFirst($text)
    {

        $search = explode(' ', $text);

        $returnText = '+' . $search[0] . ' -' . $search[1];

        return $returnText;
    }

}
