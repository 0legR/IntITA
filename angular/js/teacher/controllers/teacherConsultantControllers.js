/**
 * Created by adm on 19.07.2016.
 */
angular
    .module('teacherApp')
    .controller('teacherConsultantModulesCtrl', function ($scope) {
        $jq(document).ready(function () {
            $jq('#teacherModulesTable').DataTable({
                    "autoWidth": false,
                    language: {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                    }
                }
            );
        });
    })
    .controller('teacherConsultantTasksCtrl', function ($scope, $http, $templateCache, $state) {
        $jq(document).ready(function () {
            $jq('#tasksTable').DataTable({
                    "autoWidth": false,
                    language: {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                    },
                    "columns": [
                        null,
                        null,
                        null,
                        null,
                        null,
                        {
                            "type": "de_date", targets: 1,
                        },
                        null,
                    ],
                    "order": [[6, "asc"], [5, "desc"]]
                }
            );
        });

        $scope.markTask = function () {
            console.log('ddd');
            var id = $jq('#plainTaskId').val();
            var mark = $jq('#mark').val();
            var comment = $jq('[name = comment]').val();
            var userId = $jq('#userId').val();
            $http({
                method: 'POST',
                url: basePath + '/_teacher/_teacher_consultant/teacherConsultant/markPlainTask',
                data: $jq.param({'idPlainTask': id, 'mark': mark, 'comment': comment, 'userId': userId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function () {
                bootbox.alert('Ваша оцінка записана в базу', function () {
                    $templateCache.remove(basePath + "/_teacher/_teacher_consultant/teacherConsultant/showPlainTask/idPlainTask/" + id);
                    $state.go('teacherConsultant/tasks');
                });
            }).error(function () {
                bootbox.alert('Помилка, зверніться до адміністратора');
            })

        }

    })
    .controller('teacherConsultantCtrl', function ($scope, typeAhead, $http, $state,$templateCache) {
        var teachersTypeaheadUrl = basePath+ '/_teacher/_trainer/trainer/teacherConsultantsByQuery';
        $scope.selectedTeacher = null;
        $scope.consultantSelected = null;
        $scope.getTeachers = function(value,module){
            return typeAhead.getData(teachersTypeaheadUrl,{query:value, module:module})
        };
        $scope.onSelect = function ($item) {
            $scope.selectedTeacher = $item;
            console.log($item);
        };

        $scope.onConsultantSelect = function ($item) {
            $scope.consultantSelected = $item;
            console.log($item);
        };

        $scope.assignTeacher = function (studentId,moduleId) {
            if ($scope.selectedTeacher)
            $http({
                method:'POST',
                url:basePath + '/_teacher/_trainer/trainer/assignTeacherForStudent',
                data: $jq.param({teacher: $scope.selectedTeacher.id, module: moduleId, student: studentId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(response){
                bootbox.alert(response,function(){
                    $templateCache.remove(basePath + "/_teacher/_trainer/trainer/viewStudent/id/" + studentId);
                    $state.go('trainer/viewStudent/:studentId',{studentId:studentId},{reload:true})
                });
            }).error(function(){
                bootbox.alert("Викладачу не вдалося призначити обраний модуль. Спробуйте повторити " +
                "операцію пізніше або напишіть на адресу " + adminEmail)
            })

        };
        $scope.cancelTeacher = function(teacherId, moduleId, studentId){
            $http({
                method:'POST',
                url: basePath+'/_teacher/_trainer/trainer/cancelTeacherForStudent',
                data: $jq.param({teacher: teacherId, module: moduleId, student: studentId}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (response){
                bootbox.alert(response,function(){
                    $templateCache.remove(basePath + "/_teacher/_trainer/trainer/viewStudent/id/" + studentId);
                    $state.go('trainer/viewStudent/:studentId',{studentId:studentId},{reload:true})
                });
            }).error(function(){
                bootbox.alert("Операцію не вдалося виконати. Спробуйте повторити " +
                    "операцію пізніше або напишіть на адресу " + adminEmail);
            });
        };

        $scope.assignConsultantModule = function(idModule){
            console.log($scope.consultantSelected);
            if ($scope.consultantSelected)
            $http({
                method: 'POST',
                url: basePath + '/_teacher/_teacher_consultant/teacherConsultant/assignModule',
                data: $jq.param({userId: $scope.consultantSelected.id, module: idModule}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function(response){
                bootbox.alert(response,function(){
                    $templateCache.remove(basePath + "/_teacher/_trainer/trainer/viewStudent/id/" + studentId);
                    $state.go('trainer/students',{studentId:studentId},{reload:true})
                });
            }).error(function(){
                bootbox.alert("Викладачу не вдалося призначити обраний модуль. Спробуйте повторити " +
                    "операцію пізніше або напишіть на адресу "+adminEmail);
            });
        }
    })
    .controller('consultantCtrl',function($scope, $resource, NgTableParams, $http, $state){
    
        $scope.getTodayConsultations = function() {
            initTodayConsultationsTable();
    
            // NEXT iteration
            $scope.todayConsultationsTable = new NgTableParams({
                page: 1,
                count: 10
            }, {
                getData: function (params) {
                    return $resource(basePath + '/_teacher/_teacher_consultant/teacherConsultant/getTodayConsultationsList').get(params.url()).$promise.then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
                }
            });
        };
        $scope.getPastConsultations = function(){
            $scope.pastConsultationsTable = new NgTableParams({
                page: 1,
                count: 10
            }, {
                getData: function (params) {
                    return $resource(basePath+'/_teacher/_teacher_consultant/teacherConsultant/getPastConsultationsList').get(params.url()).$promise.then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
                }
            });
        };
    
        $scope.getCanceledConsultations = function(){
            $scope.canceledConsultationsTable = new NgTableParams({
                page: 1,
                count: 10
            }, {
                getData: function (params) {
                    return $resource(basePath+'/_teacher/_teacher_consultant/teacherConsultant/getCancelConsultationsList').get(params.url()).$promise.then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
                }
            });
        };
    
        $scope.getPlannedConsultations = function(){
            $scope.plannedConsultationsTable = new NgTableParams({
                page: 1,
                count: 10
            }, {
                getData: function (params) {
                    return $resource(basePath+'/_teacher/_teacher_consultant/teacherConsultant/getPlannedConsultationsList').get(params.url()).$promise.then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
                }
            });
        };
    
        $scope.cancelConsultation = function(consultationId){
            bootbox.confirm('Відмінити консультацію?',function(result){
                if (result){
                    $http({
                        method:'POST',
                        url:basePath+'/_teacher/_teacher_consultant/teacherConsultant/cancelConsultation?id='+consultationId,
                    }).success(function(response){
                        if (response==='success'){
                            $state.go('teacherConsultant/consultations');
                        }
                        else{
                            bootbox.alert('Что-то пошло не так!')
                        }
                    }).error(function(){
                        bootbox.alert('Что-то пошло не так!')
                    })
                }
            })
        }
    })