<?php

/* Class that holds a rating system. Rating system calculates an average
 * rating of between 1 and 10 between all of the ratings saved in the
 * database. Each logged in user can add a rating to each page.
 * 
 * usage: call rating->Show() to show the current rating of a page 
 * (only works with wikipages), and call ratingFormShow() to also
 * show the form with which users can rate the current page
 * 
 * author: Sybren Bos
 */

class FonRatingSystem
{
    
    protected $db;
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
//================================================
//                rating show
//================================================
/*
 * collects all ratings given to a page, calculates
 * an average, and returns that average.
 */  
//================================================  
    
    public function Show($id)
    {
        $rating = $this->db->getPageRating($id);
        
        $ratingcount = count($rating);
        $ratingsum = array_sum($rating);

        $ratingavg = $ratingsum / $ratingcount;
        
        $ratingrounded = round($ratingavg, 1);
        
        return $ratingrounded;
    }
    
//================================================
//                 rating calc
//================================================
/* 
 * function that is called by ajax controller
 * to serve as a middle man for Show()
 */  
//================================================  
    
    public function showAjax($id, $score, $userid)
    {
        $this->db->savePageRating($id, $score, $userid);
        
        echo '<p id="ratingshowref">'.$this->Show($id).'</p>';
    }
    
//================================================
//                 rating form show
//================================================
/* 
 * The form that gives the user the oppertunity to
 * rate a page. only works on wikipage.
 */  
//================================================  
    
    public function showForm($id)
    {
        
        $userid = $this->db->getActiveUserId();
        
        return '<form><select id="ratinginput">
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                    <option value=4>4</option>
                    <option value=5>5</option>
                    <option value=6>6</option>
                    <option value=7>7</option>
                    <option value=8>8</option>
                    <option value=9>9</option>
                    <option value=10>10</option>
                    </select>                    
                <input type="button" name="ratingbutton" id="ratingbuttonajax"
                value="rate!" onclick="ajaxRater('.$id.','.$userid.')"></form>';
        
    }
}