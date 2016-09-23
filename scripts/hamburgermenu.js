/**
 * Created by Wizlight on 17.07.2015.
 */
$(document).ready(function(){
    if ($(window).scrollTop() > 80 || $(window).width() <= '800') {
        if($(window).height()<$("#hambMenu").height()){
            $("#hambMenu").css("overflow-y", "scroll");
            $("#hambMenu").css({height: 100+'%'});
        }else{
            $("#hambMenu").css("overflow-y", "visible");
            $("#hambMenu").css("height", "inherit");
        }
        $("#hambNav").css({display: "block"});
    }

    if ($(window).width() <= '800') {
        $('#share42').css({"margin-left":"20px"});
        $('.share42-item').css({"height":"28px","width":"36px","margin-bottom":"16px"});
        $('.share42-item a').css({"height":"28px","width":"36px"});
        $('.share42-item a').css({"background-image":"url(/scripts/share42/iconsMini.png)"});
        $('#sharing .share42-counter').css({"width":"34px"});
        $('#sharingMain .share42-counter').css({"width":"34px"});
    }
});

$(window).scroll(function() {
    if ($(window).scrollTop() > 80 || $(window).width() <= '800') {
        if($(window).height()<$("#hambMenu").height()){
            $("#hambMenu").css("overflow-y", "scroll");
            $("#hambMenu").css({height: 100+'%'});
        }else{
            $("#hambMenu").css("overflow-y", "visible");
            $("#hambMenu").css("height", "inherit");
        }
        $("#hambNav").css({display: "block"});
        if($('#hambMenu').css('display') == "none"){
            $("#sharing").css({display: "none"});
            $("#sharingMain").css({display: "none"});
        }
    }else{
        $("#hambNav").css({display: "none"});
        $("#hambMenu").hide();
    }
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
            $("#sharing").css({display: "block"});
            $("#sharingMain").css({display: "block"});
        }, 200);
    else
        setTimeout(function () {
            $("#hambMenu").css({display: "none"});
            $("#sharing").css({display: "none"});
            $("#sharingMain").css({display: "none"});
        }, 200);
});