/**
 * Created by Wizlight on 12.10.2015.
 */
/**
 * Created by Wizlight on 17.07.2015.
 */
$(document).ready(function(){
        if($(window).height()<$("#hambMenu").height()){
            $("#hambMenu").css("overflow-y", "scroll");
            $("#hambMenu").css({height: 100+'%'});
        }else{
            $("#hambMenu").css("overflow-y", "visible");
            $("#hambMenu").css("height", "inherit");
        }
        $("#hambNav").css({display: "block"});
});

$(window).scroll(function() {
        if($(window).height()<$("#hambMenu").height()){
            $("#hambMenu").css("overflow-y", "scroll");
            $("#hambMenu").css({height: 100+'%'});
        }else{
            $("#hambMenu").css("overflow-y", "visible");
            $("#hambMenu").css("height", "inherit");
        }
        $("#hambNav").css({display: "block"});
});
$(document).click(function () {
    setTimeout(function () {
        $("#hambMenu").hide();
    }, 200);
});
$("#hambMenu").click(function (e) {
    e.stopPropagation();
});
$('#hambButton').click(function (e) {
    e.stopPropagation();
    if ($("#hambMenu").css('display') == "none")
        setTimeout(function () {
            $("#hambMenu").css({display: "block"});
        }, 200);
    else
        setTimeout(function () {
            $("#hambMenu").css({display: "none"});
        }, 200);

});