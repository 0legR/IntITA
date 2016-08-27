function addTeacherAttr(url, attr, id, role,header,redirect) {
    user = $jq('#user').val();
    if (!role) {
        role = $jq('#role').val();
    }
    var value = $jq(id).val();

    if (value == 0) {
        showDialog('Введіть дані форми.');
    }
    if (parseInt(user && value)) {
        $jq.ajax({
            url: url,
            type: "POST",
            async: true,
            data: {user: user, role: role, attribute: attr, attributeValue: value},
            success: function (response) {
                if (response == "success") {
                    bootbox.alert("Операцію успішно виконано.", function () {
                        switch (role) {
                            case "trainer":
                                loadTrainerStudentList(user);
                                break;
                            case "author":
                                if(redirect=='teacherAccess')
                                    loadAddTeacherAccess(header,'0');
                                else if (id == '#moduleId')
                                    loadAddModuleAuthor();
                                else if (id == '#module')
                                    loadModuleEdit(value,header,'5');
                                else loadTeacherModulesList(user);
                                break;
                            case "consultant":
                                if(redirect=='teacherAccess')
                                    loadAddTeacherAccess(header,'2');
                                else if(redirect=='editModule')
                                    loadModuleEdit(value,header,'6');
                                else loadAddModuleConsultant(user);
                                break;
                            case "teacher_consultant":
                                loadTeacherConsultantList(user);
                                break;
                        }
                    });
                } else {
                    switch (role) {
                        case "trainer":
                            showDialog(response);
                            break;
                        case "author":
                            showDialog("Обраний модуль вже присутній у списку модулів даного викладача");
                            break;
                        case "consultant":
                            showDialog("Консультанту вже призначений даний модуль для консультацій");
                            break;
                        case "teacher_consultant":
                            showDialog("Обраний модуль вже присутній у списку модулів даного викладача");
                            break;
                        default:
                            showDialog("Операцію не вдалося виконати");
                            break;
                    }
                }
            },
            error: function () {
                showDialog("Операцію не вдалося виконати.");
            }
        });
    }
}

function cancelModuleAttr(url, id, attr, role, user, successUrl,tab,header) {
    if (!user) {
        user = $jq('#user').val();
    }
    if (!role) {
        role = $jq('#role').val();
    }
    if (user && role) {
        $jq.ajax({
            url: url,
            type: "POST",
            async: true,
            data: {user: user, role: role, attribute: attr, attributeValue: id},
            success: function (response) {
                if (response == "success") {
                    bootbox.alert("Операцію успішно виконано.", function () {
                        if (successUrl) {
                            load(successUrl,header,'',tab);
                        } else {
                            switch (role) {
                                case "trainer":
                                    loadTrainerStudentList(user);
                                    break;
                                case "author":
                                    if (id == '#moduleId')
                                        loadAddModuleAuthor();
                                    else loadTeacherModulesList(user);
                                    break;
                                case "consultant":
                                    loadAddModuleConsultant(user);
                                    break;
                                case "teacher_consultant":
                                    loadTeacherConsultantList(user);
                                    break;
                            }
                        }
                    });
                } else {
                    showDialog("Операцію не вдалося виконати.");
                }
            },
            error: function () {
                showDialog("Операцію не вдалося виконати.");
            }
        });
    }
}

function saveSchema(url, id) {

}

function addMandatory(url) {
    var mandatory = $jq("select[name=mandatory] option:selected").val();
    var courseId = $jq("input[name=course]").val();
    var moduleId = $jq("input[name=module]").val();
    if (mandatory && courseId && moduleId) {
        $jq.ajax({
            url: url,
            type: 'post',
            data: {'module': moduleId, 'course': courseId, 'mandatory': mandatory},
            success: function (response) {
                bootbox.confirm(response, function () {
                    location.hash = '/module/view/'+ moduleId;
                });
            },
            error: function () {
                showDialog('Операцію не вдалося виконати.');
            }
        });
    }
}

function sendError(form, data, hasError) {
    if (hasError) {
        for (var prop in data) {
            var err = document.getElementById(prop);
            err.focus();
            break;
        }
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Validations
function validateSliderForm(scenario) {
    var valid = [];
    valid.push(numberValidate($jq('#text_ua')));
    valid.push(numberValidate($jq('#text_ru')));
    valid.push(numberValidate($jq('#text_en')));
    if (scenario == 'insert')
        valid.push(filePicValidate($jq('#picture')));
    return checkValid(valid);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//input validation function
function filePicValidate(picture) {
    var message = '';
    var pattern = /^.*\.(?:jpg|png|gif)\s*$/ig;
    var error = false;

    if (!picture.val()) {
        message = 'Виберіть файл';
        error = true;
    }
    else if (!pattern.test(picture.val())) {
        message = 'Файл має бути у форматі jpg,gif або png';
        error = true;
    }

    processResult(error, message, picture);
    return !error;
}

function numberValidate(number) {
    var message = '';
    var error = false;

    if (!number.val()) {
        error = true;
        message = 'Поле для вводу коду текста має бути заповнене';
    }

    processResult(error, message, number);

    return !error;

}
//show or hide validation message
function processResult(error, message, element) {
    if (error) {
        showErrorMessage(message, element);
    }
    else {
        hideErrorMessage(element);
    }
}
function checkValid(arr) {
    var hasError = false;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i] == false) {
            return hasError;
        }
    }
    return !hasError;
}
function showErrorMessage(message, element) {
    var errorBlock = element.parent().find('.errorMessage');
    errorBlock.html(message);
    errorBlock.show();
    element.focus();
}


function hideErrorMessage(element) {
    var errorBlock = element.parent().find('.errorMessage');
    errorBlock.hide();
}
//Modal windows
function showDialog(str) {
    if (str) {
        $jq('#modalText').html(str);
    }
    $jq('#myModal').modal('show');
}

function moduleCancelled(str, url) {
    bootbox.confirm(str, function (result) {
        if (result) {
            var grid = getGridName();

            $jq.ajax({
                url: url,
                type: 'post',
                async: true,
                success: function (data) {
                    if (data == false) {
                        if (grid)
                            $.fn.yiiGridView.update(grid);
                        else
                            fillContainer(data);
                    } else {
                        bootbox.alert("Ти не можеш видалити модуль. Спочатку видали його з таких курсів: " + "<b>" + data + "</b>");
                        return false;
                    }
                },
                error: function () {
                    showDialog();
                }
            });
        }
    })
}

function getGridName() {
    return $jq('.grid-view').attr('id');
}

function refreshCache(url) {
    $jq.ajax({
        url: url,
        type: 'post',
        async: true,
        success: function (data) {
            if (data == "success") {
                showDialog("Кеш сайта успішно оновлено!");
            } else {
                showDialog();
            }
        },
        error: function () {
            showDialog();
        }
    });
}
function saveSliderTextPosition(url,id) {
    bootbox.confirm('Зберегти позицію тексту?', function (result) {
        if (result) {
            var text = document.getElementById('textPosition');
            var sliderBox=document.getElementById('sliderContainer');
            var left=(text.offsetLeft+text.offsetWidth/2)/sliderBox.offsetWidth*100;
            var top=text.offsetTop/sliderBox.offsetHeight*100;
            if(sliderColorPreview())
            var color=sliderColorPreview();
            else return;

            $jq.ajax({
                url: url,
                type: "POST",
                data: {
                    'id': id,
                    'left': left,
                    'top': top,
                    'color': color
                },
                async: true,
                success: function (response) {
                    bootbox.alert("Позицію тексту збережено", function () {
                    });
                },
                error: function () {
                    showDialog("Операцію не вдалося виконати.");
                }
            });
        }
    });
}
function sliderColorPreview(){
    var text = document.getElementById('textPosition');
    var color=document.getElementById('textColor').value;
    var regHEX = /^#(?:[0-9a-f]{3}){1,2}$/i;
    if (!regHEX.test(color)) {
        bootbox.alert('Заданий колір не відповідає HEX формату');
        return false;
    }else{
        text.style.color=color;
        return color;
    }
}
function moduleValidation(data,hasError) {
    if(hasError) {
        if(data['Module_title_ua'] !== undefined)
            $jq('#uaTab a').click();
        else $jq('#mainTab a').click();
        return false;
    }else return true;
}
function moduleCreate(url) {
    var formData = new FormData($("#module-form")[0]);
    if(typeof moduleTags!='undefined'){
        formData.append('moduleTags', JSON.stringify(moduleTags));
        delete moduleTags;
    }
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        datatype:'json',
        success: function () {
            bootbox.alert("Модуль успішно додано", function () {
               location.hash = "/modulemanage";
            });
        },
        error: function () {
            bootbox.alert("Модуль не вдалося створити. Перевірте вхідні дані або зверніться до адміністратора.");
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}
function moduleUpdate(url) {
    var formData = new FormData($("#module-form")[0]);
    if(typeof moduleTags!='undefined'){
        formData.append('moduleTags', JSON.stringify(moduleTags));
        delete moduleTags;
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        datatype:'json',
        success: function () {
            bootbox.alert("Модуль успішно відредаговано", function () {
                location.hash = "/modulemanage";
            });
        },
        error: function () {
            bootbox.alert("Модуль не вдалося відредагувати. Перевірте вхідні дані або зверніться до адміністратора.");
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}
function courseValidation(data,hasError) {
    if(hasError) {
        if(data['Course_title_ua'] !== undefined)
            $jq('#uaTab a').click();
        else if(data['Course_title_ru'] !== undefined)
            $jq('#ruTab a').click();
        else if(data['Course_title_en'] !== undefined)
            $jq('#enTab a').click();
        else $jq('#mainTab a').click();
        return false;
    }else return true;
}
function courseCreate(url) {
    var formData = new FormData($("#course-form")[0]);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        datatype:'json',
        success: function () {
            bootbox.alert("Курс успішно додано", function () {
                location.hash = "/admin/coursemanage";
            });
        },
        error: function () {
                bootbox.alert("Курс не вдалося створити. Перевірте вхідні дані або зверніться до адміністратора.");
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}
function courseActions(url) {
    var formData = new FormData($("#course-form")[0]);
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        datatype:'json',
        success: function (message) {
            bootbox.alert(message, function () {
                location.hash = "/admin/coursemanage";
            });
        },
        error: function (message) {
            bootbox.alert(message);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;
}

function loadMainSliderList() {
    load(basePath + '/_teacher/_admin/carousel/index/', 'Слайдер на головній сторінці');
}
function loadSliderAboutUsList() {
    load(basePath + '/_teacher/_admin/aboutusSlider/index/', 'Слайдер на сторінці Про нас');
}
function loadTeacherModulesList(id) {
    load(basePath + '/_teacher/_admin/teachers/editRole/id/' + id + '/role/author/', 'Редагувати роль');
}
function loadTrainerStudentList(id) {
    load(basePath + '/_teacher/_admin/teachers/editRole/id/' + id + '/role/trainer/', 'Редагувати роль');
}
function loadAddModuleAuthor() {
    load(basePath + '/_teacher/_admin/permissions/showAddTeacherAccess/');
}
function loadAddModuleConsultant(id) {
    load(basePath + '/_teacher/_admin/teachers/editRole/id/'+id+'/role/consultant/','Редагувати роль');
}
function loadModulesList() {
    load(basePath + "/_teacher/_admin/module/index/","Модулі");
}
function loadCourseList() {
    load(basePath + "/_teacher/_admin/coursemanage/index/","Курси");
}
function loadModuleEdit(id,header,tab) {
    load(basePath + "/_teacher/_admin/module/update/id/"+id,header,'',tab);
}
function loadAddTeacherAccess(header,tab) {
    load(basePath + "/_teacher/_admin/permissions/index/",header,'',tab);
}
function loadTeacherConsultantList(id) {
    load(basePath + '/_teacher/_admin/teachers/editRole/id/' + id + '/role/teacher_consultant/', 'Редагувати роль');
}

function initAllPhrasesTable() {
    $jq('#allPhrasesTable').DataTable({
        "autoWidth": false,
        "ajax": {
            "url": basePath + "/_teacher/_tenant/tenant/getAllPhrases",
            "dataSrc": "data"
        },
        "columns": [
            {
                type: 'string', targets: 1,
                "data": "text"
            },
            {

                "data": "id",
                "render": function (id) {
                    return '<a href="#" onclick="load(\'' + basePath + '/_teacher/_tenant/tenant/editPhrase?id=' + id + '\', \'Змінити фразу\');">Змінити</a>';
                }
            }, {

                "data": "id",
                "render": function (id) {
                    return '<a href="#" onclick="load(\'' + basePath + '/_teacher/_tenant/tenant/deletePhrase?id=' + id + '\', \'Видалити фразу\');">Видалити</a>';
                }
            }
        ],
        "createdRow": function (row, data, index) {
            $jq(row).addClass('gradeX');
        },
        language: {
            "url": basePath + "/scripts/cabinet/Ukranian.json",
        },
        processing: true,
    });
}

