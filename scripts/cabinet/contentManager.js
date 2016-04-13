
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
                            showDialog("Для даного студента вже призначено тренера");
                            break;
                        case "author":
                            showDialog("Обраний модуль вже присутній у списку модулів даного викладача");
                            break;
                        case "consultant":
                            showDialog("Консультанту вже призначений даний модуль для консультацій");
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

function cancelTeacherAccess(url) {
    var user = $jq("#user").val();
    var moduleId = $jq("select[name=modules] option:selected").val();

    if(user == 0) {
        bootbox.alert("Виберіть викладача.");
    }else {
        $jq.ajax({
            type: "POST",
            url: url,
            data: {
                'module': moduleId,
                'user' : user
            },
            cache: false,
            success: function (data) {
                if(data == "success"){
                    showDialog("Операцію успішно виконано.");
                } else {
                    showDialog("Операцію не вдалося виконати.");
                }
            },
            error:function()
            {
                showDialog("Операцію не вдалося виконати.");
            }
        });
    }
}

function selectTeacherModules(url, teacher) {
    if (teacher == 0) {
        bootbox.alert("Виберіть викладача.");
    } else {
        $jq.ajax({
            type: "POST",
            url: url,
            data: {teacher: teacher},
            cache: false,
            success: function (response) {
                $jq('div[name="teacherModules"]').html(response);
            }
        });
    }
}

function initRequestsTable() {
    $jq('#teacherResponsesTable').DataTable({
        "autoWidth": false,
        "ajax": {
            "url": basePath + "/_teacher/_admin/request/getRequestList",
            "dataSrc": "data"
        },
        "columns": [
            {
                "width": "30%",
                "data": "user"
            },
            {
                "width": "50%",
                "data": "module",
                "render": function (module) {
                    return '<a href="#" onclick="load(' + module["link"] + ')">' + module["title"] + '</a>';
                }
            },
            {
                "width": "20%",
                "data": "type"
            },
            {
                "width": "20%",
                "data": "dateCreated"
            }
        ],
        "createdRow": function (row, data, index) {
            $jq(row).addClass('gradeX');
        },
        language: {
            "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
        }
    });
}


function setRequestStatus(url, message) {
    bootbox.confirm(message, function (result) {
        if (result) {
            $jq.ajax({
                url: url,
                type: "POST",
                success: function (response) {
                    bootbox.alert(response, function () {
                        load(basePath + '/_teacher/_admin/request/index', 'Запити');
                    });
                },
                error: function () {
                    bootbox.alert("Операцію не вдалося виконати.");
                }
            });
        } else {
            bootbox.alert("Операцію відмінено.");
        }
    });
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
function loadModuleEdit(id,header,tab) {
    load(basePath + "/_teacher/_admin/module/update/id/"+id,header,'',tab);
}
function loadAddTeacherAccess(header,tab) {
    load(basePath + "/_teacher/_admin/permissions/index/",header,'',tab);
}
function loadTeacherConsultantList(id) {
    load(basePath + '/_teacher/_admin/teachers/editRole/id/' + id + '/role/teacher_consultant/', 'Редагувати роль');
}
