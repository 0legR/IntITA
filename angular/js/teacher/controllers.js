/* Directives */

angular
    .module('teacherApp')
    .controller('cabinetCtrl', cabinetCtrl);

angular
    .module('teacherApp')
    .controller('messagesCtrl', messagesCtrl);

angular
    .module('teacherApp')
    .controller('addressCtrl', addressCtrl);

angular
    .module('teacherApp')
    .controller('studentCtrl', studentCtrl);

angular
    .module('teacherApp')
    .controller('contentManagerCtrl', contentManagerCtrl);

angular
    .module('teacherApp')
    .controller('moduleAddTeacherCtrl', moduleAddTeacherCtrl);
angular
    .module('teacherApp')
    .controller('editTeacherRoleCtrl', editTeacherRoleCtrl);

function cabinetCtrl($http, $scope, $compile, $location, $state, $timeout,$rootScope, typeAhead, roleAttributeService) {
    //function back() redirect to prev link
    $rootScope.back = function () {
        window.history.back();
    };
    
    $scope.currentLanguage=currentLanguage;
    $scope.languages=['ua','en','ru'];
    $scope.changeLang = function (lang) {
        $http({
            method: "GET",
            url: basePath+'/_teacher/cabinet/changeLang?lg='+lang,
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
            cache: false
        }).then(function () {
            location.reload();
        });
    };

    $scope.countOfMessages = 0;
    var updateCounter = function() {
        $http.get(basePath+'/_teacher/cabinet/getNewMessages',{ignoreLoadingBar: true}).then(function(response){
            $scope.requests = response.data.requests;
            $scope.messages = response.data.messages;
        })
        $timeout(updateCounter, 10000);
    };
    updateCounter();

    $scope.changePageHeader = function (headerText) {
        angular.element(document.querySelector("#pageTitle")).text(headerText);

    };

    $scope.fillContainer = function (data) {
        container = angular.element(document.querySelector("#pageContainer"));
        container.html('');
        $compile(container.html(data))($scope);
    };

    //show information block during some time after some action
    $scope.addUIHandlers = function(msg) {
        holder = angular.element(document.querySelector("#operationMessageHolder"));
        holder.fadeIn();
        holder.html(msg);
        window.setTimeout(function(){ holder.fadeOut(); }, 3000);
    };

    $scope.ngLoad = function (url) {
        $http({
            method: "POST",
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
            cache: false
        }).then(function (data) {
            $scope.fillContainer(data.data);

        });
    };

    $scope.changeView = function (view) {
        $location.path(view);

    };
    //redirect to module page
    $scope.moduleLink = function (id) {
        $http({
            url: basePath + '/_teacher/cabinet/getModuleLink',
            method: "POST",
            data: $jq.param({id: id}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            window.open(response.data);
        }, function errorCallback() {
            return false;
        });
    };
    //redirect to course page
    $scope.courseLink = function (id) {
        $http({
            url: basePath + '/_teacher/cabinet/getCourseLink',
            method: "POST",
            data: $jq.param({id: id}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            window.open(response.data);
        }, function errorCallback() {
            return false;
        });
    };
    //different typeaheads data
    var activeUsersTypeaheadUrl = basePath+'/_teacher/cabinet/activeUsersByQuery';
    var teachersTypeaheadUrl = basePath+'/_teacher/cabinet/teachersByQuery';
    var moduleTypeaheadUrl = basePath + '/_teacher/cabinet/modulesByQuery';
    var consultantTypeaheadUrl = basePath + '/_teacher/cabinet/consultantsByQuery';
    var authorsTypeaheadUrl = basePath+'/_teacher/cabinet/authorsByQuery';
    var teachersConsultantTypeaheadUrl = basePath+'/_teacher/cabinet/teacherConsultantsByQuery';
    var usersTypeaheadUrl = basePath+'/_teacher/cabinet/usersByQuery';
    var coursesTypeaheadUrl = basePath+'/_teacher/cabinet/coursesByQuery';
    var usersNotTeacherTypeaheadUrl = basePath+'/_teacher/cabinet/usersNotTeacherByQuery';
    var usersForRoleTypeaheadUrl = basePath+'/_teacher/_admin/users/usersAddForm';
    var trainersTypeaheadUrl = basePath+'/_teacher/cabinet/trainers';
    var studentsTypeaheadUrl = basePath+'/_teacher/cabinet/studentsByQuery';
    var teacherConsultantsByQueryAndModuleTypeaheadUrl = basePath+'/_teacher/cabinet/teacherConsultantsByQueryAndModule';
    var groupTypeaheadUrl = basePath + '/_teacher/_supervisor/superVisor/groupsByQuery';

    $scope.getActiveUsers = function(value){
        return typeAhead.getData(activeUsersTypeaheadUrl,{query : value})
    };
    $scope.getTeachers = function(value){
        return typeAhead.getData(teachersTypeaheadUrl,{query : value})
    };
    $scope.getAuthors = function(value) {
        return typeAhead.getData(authorsTypeaheadUrl,{query : value})
    };
    $scope.getTeachersConsultant = function(value) {
        return typeAhead.getData(teachersConsultantTypeaheadUrl,{query : value})
    };
    $scope.getModules = function(value){
        return typeAhead.getData(moduleTypeaheadUrl,{query : value});
    };
    $scope.getConsultants = function(value){
        return typeAhead.getData(consultantTypeaheadUrl,{query : value});
    };
    $scope.getUsers = function(value){
        return typeAhead.getData(usersTypeaheadUrl,{query : value});
    };
    $scope.getCourses = function(value){
        return typeAhead.getData(coursesTypeaheadUrl,{query : value});
    };
    $scope.getUsersNotTeacher = function(value){
        return typeAhead.getData(usersNotTeacherTypeaheadUrl,{query : value});
    };
    $scope.getUsersForRole = function(role, value){
        return typeAhead.getData(usersForRoleTypeaheadUrl,{role:role, query : value});
    };
    $scope.getTrainers = function(value){
        return typeAhead.getData(trainersTypeaheadUrl,{query : value});
    };
    $scope.getStudents = function(value){
        return typeAhead.getData(studentsTypeaheadUrl,{query : value});
    };
    $scope.getTeacherConsultantsByQueryAndModule = function(value,module){
        return typeAhead.getData(teacherConsultantsByQueryAndModuleTypeaheadUrl,{query : value,module:module});
    };
    $scope.getGroups = function(value){
        return typeAhead.getData(groupTypeaheadUrl,{query : value});
    };
}

function messagesCtrl($http, $scope, $state, $compile, NgTableParams, $resource, $filter) {

    $scope.checkboxes = { 'checked': false, items: {} };

    // watch for check all checkbox
    $scope.$watch('checkboxes.checkAll', function() {
        if ($scope.checkboxes)
            angular.forEach($scope.receivedMessagesTable.data, function(item) {
                $scope.checkboxes.items[item.id_message] = $scope.checkboxes.checkAll;
            });

        });
    $scope.$watch('checkboxes.items', function(values) {
            $scope.deleteReceivedMessages = []
        for (var key in values) {
            if (values[key]){
                $scope.deleteReceivedMessages.push(key)
            }
        }
        if ($scope.deleteReceivedMessages.length < $scope.receivedMessagesTable.data.length && $scope.deleteReceivedMessages.length > 0)
            angular.element(document.querySelector("#select_all")).prop('indeterminate',true)
        else if ($scope.deleteReceivedMessages.length == 0){
            angular.element(document.querySelector("#select_all")).prop('indeterminate',false)
        }
    }, true);

    $scope.$watch('dt',function(){
        if ($scope.dt)
            $scope.params.filter()['message.create_date'] = $filter("shortDate")($scope.dt,'yyyy-MM-dd')
    });

    $scope.receivedMessagesTable = new NgTableParams({
        sorting: { 'message.create_date': "desc"},
    }, {
        getData: function (params) {
            delete $scope.deleteReceivedMessages;
            $scope.checkboxes = { 'checked': false, items: {} };
            return $resource(basePath + '/_teacher/messages/getUserReceiverMessages').get(params.url()).$promise.then(function (data) {
                params.total(data.count);
                return data.rows;
            });
        }
    });

    $scope.sentMessagesTable = new NgTableParams({
        sorting: { 'message.create_date': "desc"}

    }, {
        getData: function (params) {
            return $resource(basePath + '/_teacher/messages/getUserSentMessages').get(params.url()).$promise.then(function (data) {
                params.total(data.count);
                return data.rows;
            });
        }
    });

    $scope.deletedMessagesTable = new NgTableParams({
        sorting: { 'message.create_date': "desc"}
    }, {
        getData: function (params) {
            return $resource(basePath + '/_teacher/messages/getUserDeletedMessages').get(params.url()).$promise.then(function (data) {
                params.total(data.count);
                return data.rows;
            });
        }
    });

    $scope.deleteMessages = function(){
        bootbox.confirm("Видалити обрані повідомлення?",function(result){
            if (result){
                $http({
                    method:'POST',
                    url:basePath+'/_teacher/messages/delete',
                    data: $jq.param({
                        data: JSON.stringify({
                            messages: $scope.deleteReceivedMessages,
                        })}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                }).success(function(response){
                    if (response == 'success'){
                        bootbox.alert('Опрерацію успішно виконано',function(){
                            $scope.receivedMessagesTable.reload();
                        })
                    }
                    else{
                        bootbox.alert('Что-то пошло не так');
                    }
                }).error(function(){
                    bootbox.alert('Что-то пошло не так');
                })
            }
        } );
    };

    $scope.sendMessage = function (url) {
        receiver = $jq("#receiverId").val();
        if (receiver == "0") {
            bootbox.alert('Виберіть отримувача повідомлення.');
        } else {
            $http({
                method: "POST",
                url: url,
                data: $jq.param({
                    receiver: receiver,
                    subject: $jq("input[name=subject]").val(),
                    text: $jq("#text").val(),
                    scenario: "new"
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                cache: false
            }).then(function successCallback(response) {
                if (response.data == "success") {
                    bootbox.alert("Ваше повідомлення успішно відправлено.", function () {
                        $state.go("messages", {}, {reload: true})
                    });
                } else {
                    bootbox.alert("Повідомлення не вдалося відправити. Спробуйте надіслати пізніше або " +
                        "напишіть на адресу " + adminEmail, function () {
                        $state.go("messages", {}, {reload: true})
                    });
                }
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати.");
            });
        }
    };
    $scope.deleteMessage = function (idMessage, url, receiver) {
        bootbox.confirm('Ти дійсно хочеш видалити повідомлення?', function (result) {
            if (result)
                $http({
                    method: "POST",
                    url: url,
                    data: $jq.param({
                        data: JSON.stringify({
                            message: idMessage,
                            receiver: receiver
                        })
                    }),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                    cache: false
                }).then(function successCallback() {
                    $state.go('messages', {}, {reload: true});
                }, function errorCallback() {
                    bootbox.alert("Операцію не вдалося виконати.");
                });
        });
    };

    $scope.loadMessagesIndex = function () {
        $state.go("messages", {}, {reload: true});
    };

    $scope.reply = function (url) {
        var data = {
            receiver: $jq("input[name=receiver]").val(),
            parent: $jq("input[name=parent]").val(),
            subject: $jq("input[name=subject]").val(),
            text: $jq("#text").val()
        };
        $http({
            method: "POST",
            url: url,
            data: $jq.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
            cache: false
        }).then(function successCallback(response) {
            if (response.data == "success") {
                bootbox.alert("Ваше повідомлення успішно відправлено.", function () {
                    $state.go($state.current, {}, {reload: true});
                });
            } else {
                bootbox.alert("Повідомлення не вдалося відправити. Спробуйте надіслати пізніше або " +
                    "напишіть на адресу " + adminEmail);
            }
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати.");
        });
    };

    $scope.forward = function (url) {
        forwardTo = $jq("input[name=forwardToId]").val();
        if (forwardTo == "0") {
            bootbox.alert('Виберіть отримувача повідомлення.');
        } else {
            $http({
                method: "POST",
                url: url,
                data: $jq.param({
                    subject: $jq("input[name=subject]").val(),
                    parent: $jq("input[name=parent]").val(),
                    forwardToId: forwardTo,
                    text: $jq("#text").val()
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                cache: false
            }).then(function successCallback(response) {
                if (response.data == "success") {
                    bootbox.alert("Ваше повідомлення успішно відправлено.", function () {
                        $state.go($state.current, {}, {reload: true});
                    });
                } else {
                    bootbox.alert("Повідомлення не вдалося відправити. Спробуйте надіслати пізніше або " +
                        "напишіть на адресу " + adminEmail);
                }
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати.");
            });
        }
    };

    $scope.loadForm = function (url, receiver, scenario, message, subject) {
        idBlock = "#collapse" + message;
        $jq(idBlock).show();
        id = "#form" + message;
        var command = {
            user: user,
            message: message,
            receiver: receiver,
            scenario: scenario,
            subject: subject
        };
        $http({
            method: "POST",
            url: url,
            data: $jq.param({form: JSON.stringify(command)}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
            cache: false
        }).then(function successCallback(response) {
            $jq(id).empty();
            ($compile($jq(id).append(response.data))($scope));
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати.");
        });
    };

    $scope.collapse = function (el) {
        $jq(el).toggle("medium");
    }
}

function addressCtrl($scope, $http, $resource, NgTableParams, $state) {
    $scope.countriesTable = new NgTableParams({},
    {
        getData: function (params) {
            return $resource(basePath + "/_teacher/_admin/address/getCountriesList").get(params.url()).$promise.then(function (data) {
                params.total(data.count);
                return data.rows;
            });
        }
    });

    $scope.citiesTable = new NgTableParams({},
        {
            getData: function (params) {
                return $resource(basePath + "/_teacher/_admin/address/getCitiesList").get(params.url()).$promise.then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
            }
        }
    );

    $scope.editCity = function (url) {
        country = $jq('#country').val();
        if (country == 0) {
            bootbox.alert('Виберіть країну.');
        } else {
            id = $jq('[name="id"]').val();
            titleUa = $jq('[name="titleUa"]').val();
            titleRu = $jq('[name="titleRu"]').val();
            titleEn = $jq('[name="titleEn"]').val();

            $http({
                method: "POST",
                url: url,
                data: $jq.param({
                    id: id,
                    country: country,
                    titleUa: titleUa,
                    titleRu: titleRu,
                    titleEn: titleEn
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                cache: false
            }).then(function successCallback(response) {
                bootbox.alert(response.data, function () {
                    $state.go("admin/address", {}, {reload: true});
                });
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати.");
            });
        }
    };

    $scope.addCity = function (url) {
        country = $jq('#country').val();
        if (country == 0) {
            bootbox.alert('Виберіть країну.');
        } else {
            titleUa = $jq('[name="titleUa"]').val();
            titleRu = $jq('[name="titleRu"]').val();
            titleEn = $jq('[name="titleEn"]').val();

            $http({
                method: "POST",
                url: url,
                data: $jq.param({
                    country: country,
                    titleUa: titleUa,
                    titleRu: titleRu,
                    titleEn: titleEn
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                cache: false
            }).then(function successCallback(response) {
                bootbox.alert(response.data, function () {
                    $state.go("admin/address", {}, {reload: true});
                });
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати.");
            });
        }
    }
}

function studentCtrl($scope, $location) {
    $scope.changePageHeader('Студент');
}

function contentManagerCtrl($scope, $location) {
    $scope.changePageHeader('Контент менеджер');
}


function moduleAddTeacherCtrl($scope) {
    var teachers = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: basePath + '/_teacher/_admin/module/teachersByQuery?query=%QUERY',
            wildcard: '%QUERY',
            filter: function (users) {
                return $jq.map(users.results, function (user) {
                    return {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        url: user.url
                    };
                });
            }
        }
    });
    teachers.initialize();

    $jq('#typeahead').typeahead(null, {

            name: 'teachers',
            display: 'email',
            limit: 10,
            source: teachers,
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'немає користувачів з таким іменем або email\`ом',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile("<div class='typeahead_wrapper'><img class='typeahead_photo' src='{{url}}'/> <div class='typeahead_labels'><div class='typeahead_primary'>{{name}}&nbsp;</div><div class='typeahead_secondary'>{{email}}</div></div></div>")
            }
        }
    );
    $jq('#typeahead').on('typeahead:selected', function (e, item) {
        $jq("#user").val(item.id);
    });
}

function editTeacherRoleCtrl($scope, DTOptionsBuilder, teacherService, $stateParams, roleAttributeService) {
    $scope.formData = {};
    $scope.userId=$stateParams.id;
    $scope.currentRole=$stateParams.role;

    $scope.loadTeacherData = function (userId, role) {
        teacherService.dataList({
            id: userId,
            currentRole: role
        }).$promise.then(function (response) {
            $scope.data = response;
        });
    };
    $scope.loadTeacherData($scope.userId, $scope.currentRole);

    $scope.dtModulesOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('simple_numbers')
        .withLanguageSource('//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json')
        .withOption('order', [[2, 'desc']]);
    $scope.dtStudentsOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('simple_numbers')
        .withLanguageSource('//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json')
        .withOption('order', [[2, 'desc']]);

    $scope.onSelectModule = function ($item) {
        $scope.selectedModule = $item;
    };
    $scope.reloadModule = function(){
        $scope.selectedModule=null;
    };
    $scope.onSelectUser = function ($item) {
        $scope.selectedUser = $item;
    };
    $scope.reloadUser = function(){
        $scope.selectedUser=null;
    };
    $scope.clearInputs=function () {
        $scope.formData.userSelected=null;
        $scope.selectedModule=null;
        $scope.selectedUser=null;
        $scope.formData.moduleSelected=null;
    };
    // params: role, role's attribute, users's id, attribute's id
    $scope.setTeacherRoleAttribute = function(role, attribute, userId, attributeId){
        if (attributeId && userId){
            roleAttributeService
                .setRoleAttribute({
                    'attribute': attribute,
                    'attributeValue':attributeId,
                    'role': role,
                    'userId' : userId
                })
                .$promise
                .then(function successCallback(response) {
                    if(response.data=='success'){
                        $scope.loadTeacherData($scope.userId, $scope.currentRole);
                        $scope.addUIHandlers('Операцію успішно виконано');
                    }
                    else $scope.addUIHandlers(response.data);
                    $scope.clearInputs();
                }, function errorCallback(response) {
                    console.log(response);
                    bootbox.alert("Операцію не вдалося виконати");
                });
        }else{
            bootbox.alert("Введено не всі дані");
        }
    };

    // params: role, role's attribute, users's id, attribute's id
    $scope.cancelTeacherRoleAttribute = function(role, attribute, userId, attributeId){
        if (attributeId && userId){
            roleAttributeService
                .unsetRoleAttribute({
                    'attribute': attribute,
                    'attributeValue':attributeId,
                    'role': role,
                    'userId' : userId
                })
                .$promise
                .then(function successCallback(response) {
                    if(response.data=='success'){
                        $scope.loadTeacherData($scope.userId, $scope.currentRole);
                        $scope.addUIHandlers('Операцію успішно виконано');
                    }
                    else $scope.addUIHandlers(response.data);
                }, function errorCallback(data) {
                    console.log(data);
                    bootbox.alert("Операцію не вдалося виконати");
                });
        }else{
            bootbox.alert("Введено не всі дані");
        }

    };
}

