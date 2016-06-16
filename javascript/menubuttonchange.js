/* 
 * 
 * 
 * 
 */


$(document).ready(function()
{

    $(".menubutton").mouseenter(function()
    {
        $(this).css("background-color", "orange");
    });
    $(".menubutton").mouseleave(function()
    {
        $(this).css("background-color", "powderblue");
    });
    
    $("#searchbutton").mouseenter(function()
    {
        $("#menusearch").toggle();
    });
    
    $("#searchtotal").mouseleave(function()
    { 
        $("#menusearch").toggle();
    });
        
    $("#regbutton").mouseenter(function()
    {
        $("#menulogindiv").toggle();
    });
    
    $("#logintotal").mouseleave(function()
    { 
        $("#menulogindiv").toggle();
    });
    
});

