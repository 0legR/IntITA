/**
 * Created by Wizlight on 06.09.2015.
 */
/**-------������� ����� � ������ ��������--------*/
$(document).ready(function(){
    $('.spoilerLinks').click(function(){
        var nameSpoiler = $(this).children("span:first").text();
        if(nameSpoiler=="(��������)"){
            $(this).children("span:first").text("(�������)");
            $(this).children("span:last").text("\u25B2");
        } else if(nameSpoiler=="(�������)"){
            $(this).children("span:first").text("(��������)");
            $(this).children("span:last").text("\u25BC");
        }
        $(this).next('.spoilerBody').toggle('normal');
        return false;
    });
});