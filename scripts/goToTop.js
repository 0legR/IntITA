/**
 * Created by Wizlight on 28.07.2015.
 */
/*��� ������ ����� � �������� �������*/
function rocketMove(element,w) {
    element.animate({
        top:-500,
        left:w
    }, 3500);

    setTimeout(function () {
        $('#exhaust').hide();
    }, 1000);
}
/*���� �� ������� � ������ - ��������� ��, ���� ���� - ��������� �����*/
function goUp(){
    if($("div").is('#rocket')){
        var hPosR=$(document).outerHeight()-750;
        var wPosR=$(document).outerWidth()/2-400;
        var hPosE=$(document).outerHeight()-515;
        var wPosE=$(document).outerWidth()/2-690;
        $('#rocket').offset({top:hPosR, left:wPosR});
        $('#exhaust').show();
        $('#exhaust').offset({top:hPosE, left:wPosE});

        $('#rocket').show();

        $('body,html').animate({scrollTop: 0}, 3000);
        rocketMove($('#rocket'),wPosR);
    } else{
        $('body,html').animate({scrollTop: 0}, 3000);
    }

};
