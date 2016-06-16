<?php

class FonRatingSystem
{
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function ratingShow($id)
    {
        $rating = $this->db->getPageRating($id);
        
        
        
        $ratingcount = count($rating);
        $ratingsum = array_sum($rating);

        
        $ratingavg = $ratingsum / $ratingcount;
        
        $ratingrounded = round($ratingavg, 1);
        

        
        return $ratingrounded;
    }
    
    
    public function ratingCalc($id, $score)
    {

        $this->db->savePageRating($id, $score);
        
        echo '<p id="ratingshowref">'.$this->ratingShow($id).'</p>';
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
                value="rate!" onclick="ajaxRater('.$id.')"></form>'; 
    }
}