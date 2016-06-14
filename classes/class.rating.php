<?php

/* 
 * 
 * 
 * 
 */

class FonRatingSystem
{
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function fonRatingShow($id)
    {
        $rating = $this->db->fonGetPageRating($id);
        
        
        
        $ratingcount = count($rating);
        $ratingsum = array_sum($rating);

        
        $ratingavg = $ratingsum / $ratingcount;
        
        $ratingrounded = round($ratingavg, 1);
        
        Debug::writeToLogFile("new rating = ".$ratingrounded);
        
        return $ratingrounded;
    }
    
    
    public function fonRatingCalc($id, $score)
    {

        $this->db->fonSavePageRating($id, $score);
        
        echo '<p id="ratingshowref">'.$this->fonRatingShow($id).'</p>';
    }
    
    
    public function ratingFormShow($id)
    {
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
                <input type="button" name="ratingbutton" 
                value="rate!" onclick="fonAjaxRater('.$id.')"></form>'; 
    }
    
    
    
}