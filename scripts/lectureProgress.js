/**
 * Created by Wizlight on 05.09.2015.
 */
$(document).ready(function(){
    $('#pointer').show();
    var position = $('#pagePressed').position();
    $('#pointer').css('margin-top',-12);
    $('#pointer').css('margin-left',position.left+6);
});
$(document).on('mouseenter', '.pageTitle', function (e) {
    var tooltipHtml='<p>'+$(this).attr("title")+'</p>';
    if($(this).is('.pageNoAccess')) {
        var partNotAvailable = document.querySelector("#scriptData [data-part-not-available]").getAttribute("data-part-not-available");
        tooltipHtml='<p class="titleNoAccess">'+$(this).attr("title")+'<span class="noAccess"> ('+partNotAvailable+')</span></p>';
    }
    $('#pointer').hide();
    $('#arrowCursor').show();
    var position = $(this).position();
    $('#arrowCursor').css('margin-top',-12);
    $('#arrowCursor').css('margin-left',position.left+6);
    $('#tooltip').html(tooltipHtml);
    $('#labelBlock').hide();
    $('#tooltip').css('display','inline-block');
});
$(document).on('mouseleave', '.pageTitle', function (e) {
    $('#pointer').show();
    $('#arrowCursor').hide();
    $('#tooltip').hide();
    $('#labelBlock').show();
});