$(document).ready(function(){
    $("p").filter(".intro").css("background-color", "yellow");
});
$(document).ready(function(){
    $("p").filter(".intro1").css("background-color", "#ff9999");
});

$(document).ready(function(){
    $(".ex .hide").click(function(){
        $(this).parents(".ex").hide("slow");
    });
});