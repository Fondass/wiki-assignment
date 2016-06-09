/* 
 * 
 * 
 * 
 */


var popit = true;
window.onbeforeunload = function()
    {
        if(popit === true) 
        {
            popit = false;
            return "Leave? If you leave without pressing commit your edit will be lost";
        };
    };

