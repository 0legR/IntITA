function getName (str){
 if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }						
    var filename = str.slice(i);		
    var uploaded = document.getElementById("avatarInfo");
    uploaded.innerHTML = filename;
}
$(document).ready(function(e) {
    $('.avatar').bind('click',function(e) {
        $('#chooseAvatar').click();
    });
    });
$(document).ready(function(e) {
    $('.uploadAvatar').bind('click',function(e) {
        $('#uploadAvatar').click();
    });
    });