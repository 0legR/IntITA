/**
 Вспливає меню справа при скролі уроку
 */
$(function() {
    var sideBarHeight =document.getElementById('titlesBlock').getBoundingClientRect().bottom - document.getElementById('titlesBlock').getBoundingClientRect().top+100;
    var mainBlockCoord =$(window).scrollTop()+document.getElementById('titlesBlock').getBoundingClientRect().bottom;

    $(window).scroll(function() {
        if (($(window).scrollTop() > mainBlockCoord-56) && ($(window).scrollTop()+sideBarHeight+100) < (document.getElementById('subViewLessons').getBoundingClientRect().top + $(window).scrollTop())) {
            document.getElementById('sidebarLesson').style.display='block';
            document.getElementById('sidebarLesson').style.position='fixed';
            document.getElementById('sidebarLesson').style.top='50px';
            ;
        } else {
            document.getElementById('sidebarLesson').style.display='none';
            $("#sidebarLesson").stop().animate({
                marginTop: 0
            },0);
        };
    });
});