//WHEN THE SECTION IS CLICKED, THIS FUNCTION UNDERLINES IT!
$(document).ready(function(){
    $("#home").click(function(){
        $(this).css('text-decoration','underline');
        $("#login").css('text-decoration','none');
    });
    $("#login").click(function(){
        $(this).css('text-decoration','underline');
        $("#home").css('text-decoration','none');
    });
});

