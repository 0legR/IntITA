//celebre
//deprecated
function  diploma_course_dialog(name, course) {

    bootbox.alert({
        message: '<div id="editor">'+'</div>'+
        '<button id="print-diploma" onclick="printPDF()">'+'Save'+'</button>'+
                '<div class="diploma-container" id="diploma">'+
                    '<div class="diploma-logo" >'+
                        '<img class="img-diploma" src="/images/diploma/logo_diplom.png" alt="logo_diploma_intita">'+
                    '</div>'+
                    '<h1 class="diploma-header">'+'diploma'+'</h1>'+
                    '<p class="certificate">'+'This Sertifies That:'+'</p>'+
                    '<h2 class="diploma-owner-name">'+name+'</h2>'+
                    '<p class="student_achievements">'+'has successfully completed the requirements for the'+
                        '<br>'+'<span>'+'certificate program'+'</span>'+
                        '<br>'+'in '+'<span>'+'information technologies'+'</span>'+
                        '<br>'+ 'and meets strong junior level of programmer'+'</p>'+
                    '<p class="course">'+'course:'+'</p>'+
                    '<h2 class="diploma-owner-name">'+course+'</h2>'+
                    '<div class="sign">'+
                        '<ul>'+
                            '<li>'+'CEO: Roman Melnyk'+'</li>'+
                            '<li>'+'Date: December, 27, 2017'+'</li>'+
                        '</ul>'+
                        '<img class="img-diploma" src="images/diploma/sing_intita.png" alt="director_sign">'+
                        '<p class="diplom-number">'+'A11 № 000002-001'+'</p>'+
                    '</div>'+
                '</div>',
        size: 'large'
    });
// // do something in the background
   $('.modal-footer > .btn').hide();
}
//deprecated
function  diploma_module_dialog(name, module) {

    bootbox.alert({
        message: '<div id="editor">'+'</div>'+
        '<button id="print-diploma" onclick="printPDF()">'+'Save'+'</button>'+
        '<div class="diploma-container">'+
        '<div class="diploma-logo" >'+
        '<img class="img-diploma" src="images/diploma/logo_diplom.png" alt="logo_diploma_intita">'+
        '</div>'+
        '<h1 class="diploma-header">'+'diploma'+'</h1>'+
        '<p class="certificate">'+'This Sertifies That:'+'</p>'+
        '<h2 class="diploma-owner-name">'+name+'</h2>'+
        '<p class="student_achievements">'+'has successfully completed the requirements for the'+
        '<br>'+'<span>'+'certificate program'+'</span>'+
        '<br>'+'in '+'<span>'+'information technologies'+'</span>'+
        '<br>'+ 'and meets strong junior level of programmer'+'</p>'+
        '<p class="course">'+'module:'+'</p>'+
        '<h2 class="diploma-owner-name">'+module+'</h2>'+
        '<div class="sign">'+
        '<ul>'+
        '<li>'+'CEO: Roman Melnyk'+'</li>'+
        '<li>'+'Date: December, 27, 2017'+'</li>'+
        '</ul>'+
        '<img class="img-diploma" src="images/diploma/sing_intita.png" alt="director_sign">'+
        '<p class="diplom-number">'+'A11 № 000002-001'+'</p>'+
        '</div>'+
        '</div>',
        size: 'large'
    });
// // do something in the background
    $('.modal-footer > .btn').hide();
}

// celebre
//export diploma to pdf
function printPDF() {
    var pdf = new jsPDF();
    var data = $(".diploma-container")[0];
    var options = {format:"PNG", background:"#ffffff"};
    pdf.addHTML(data,0,0,options, function() {
        pdf.save('diploma.pdf');
    });

}
//render diploma
function renderDiploma(graduateId,type) {
    $.get( "graduate/renderDiploma?graduateId="+graduateId+"&type="+type, function( data ) {
        bootbox.dialog({
            message: data,
            size:'large',
            onEscape:true
            })
    });
}