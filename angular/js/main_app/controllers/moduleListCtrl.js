/**
 * Created by Wizlight on 15.02.2016.
 */
angular
    .module('mainApp')
    .controller('moduleListCtrl',moduleListCtrl)

function moduleListCtrl($http,$scope) {
    var date = new Date();
    var currentTime=Math.round(date.getTime()/1000);
    $scope.getModuleProgressForUser=function (idCourse) {
        $('#modulesLoading').show();
        var promise = $http({
            url: basePath+'/course/modulesData',
            method: "POST",
            data: $.param({id: idCourse}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            return response.data;
        }, function errorCallback() {
            return false;
        });
        return promise;
    };
    $scope.getModuleProgressForUser(idCourse).then(function (response) {
        $scope.basePath=basePath;
        $scope.modulesProgress=response;
        if(!$scope.modulesProgress.userId){
            $scope.modulesProgress.ico='disabled.png';
        }else if(!$scope.modulesProgress.courseStatus)
            $scope.modulesProgress.ico='development.png';

        for(var i=0;i<$scope.modulesProgress.modules.length;i++){
            if(!$scope.modulesProgress.modules[i].access){
                $scope.modulesProgress.modules[i].ico='disabled.png';
            }else if(!$scope.modulesProgress.isAdmin && !$scope.modulesProgress.modules[i].isAuthor && $scope.modulesProgress.courseStatus){
                if(!($scope.modulesProgress.modules[i].startTime || $scope.modulesProgress.modules[i].finishTime)){
                    $scope.modulesProgress.modules[i].progress='inLine';
                    $scope.modulesProgress.modules[i].ico='future.png';
                }
                else if($scope.modulesProgress.modules[i].startTime && !$scope.modulesProgress.modules[i].finishTime){
                    $scope.modulesProgress.modules[i].progress='inProgress';
                    var days=Math.round((currentTime-$scope.modulesProgress.modules[i].startTime)/86400)+1;
                    $scope.modulesProgress.modules[i].spentTime=days;
                    $scope.modulesProgress.modules[i].ico='inProgress.png';
                }
                else if($scope.modulesProgress.modules[i].startTime && $scope.modulesProgress.modules[i].finishTime){
                    $scope.modulesProgress.modules[i].progress='finished';
                    var days=Math.round(($scope.modulesProgress.modules[i].finishTime-$scope.modulesProgress.modules[i].startTime)/86400)+1;
                    $scope.modulesProgress.modules[i].spentTime=days;
                    $scope.modulesProgress.modules[i].ico='finished.png';
                }else if(!$scope.modulesProgress.modules[i].startTime && $scope.modulesProgress.modules[i].finishTime){
                    $scope.modulesProgress.modules[i].progress='inLine';
                    $scope.modulesProgress.modules[i].ico='future.png';
                }
            }
        }
        if($scope.modulesProgress.modules.length>0)
        $scope.finishedCourse=true;
        for(var j = 0; j < $scope.modulesProgress.modules.length; j++){
            if($scope.modulesProgress.modules[j].ico!='finished.png'){
                $scope.finishedCourse=false;
                break;
            }
        }
        if($scope.finishedCourse){
            var fullTime=0;
            var recommendedTime=0;
            for(var j = 0; j < $scope.modulesProgress.modules.length; j++){
                fullTime=fullTime+$scope.modulesProgress.modules[j].spentTime;
                recommendedTime=recommendedTime+$scope.modulesProgress.modules[j].time;
            }
            $scope.modulesProgress.fullTime=fullTime;
            $scope.modulesProgress.recommendedTime=recommendedTime;
        }

        $('#modulesLoading').hide();
        if($scope.modulesProgress.isAdmin){
            bootbox.addLocale('uk', { OK: 'Добре', CANCEL: 'Ні', CONFIRM: 'Так' });
            bootbox.addLocale('ru', { OK: 'Хорошо', CANCEL: 'Нет', CONFIRM: 'Да' });
            bootbox.addLocale('en', { OK: 'OK', CANCEL: 'Cancel', CONFIRM: 'Yes' });
            bootbox.setLocale(lang);
        }
    });
    $scope.daysTermination=function(day){
        day=day.toString();
        var number = day.substr(-2);
        var term;
        if (number > 10 && number < 15) {
            term = $scope.modulesProgress.termination[0];
        } else {
            number = number.substr(-1);
            if (number == 0) {
                term = $scope.modulesProgress.termination[0];
            }
            if (number == 1) {
                term = $scope.modulesProgress.termination[1];
            }
            if (number > 1 && number <= 4) {
                term = $scope.modulesProgress.termination[2];
            }
            if (number > 4) {
                term = $scope.modulesProgress.termination[0];
            }
        }
        return term;
    };
    $scope.upModule=function (idModule,idCourse) {
        $('#moduleForm').hide();
        $http({
            url: basePath+'/course/upModule',
            method: "POST",
            data: $.param({idModule: idModule,idCourse: idCourse}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback() {
            $scope.getModuleProgressForUser(idCourse).then(function (response) {
                $scope.modulesProgress = response;
                $('#modulesLoading').hide();
            });
        }, function errorCallback() {
            bootbox.alert('Не вдалось перемістити модуль');
        });
    }
    $scope.downModule=function (idModule,idCourse) {
        $('#moduleForm').hide();
        $http({
            url: basePath+'/course/downModule',
            method: "POST",
            data: $.param({idModule: idModule,idCourse: idCourse}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback() {
            $scope.getModuleProgressForUser(idCourse).then(function (response) {
                $scope.modulesProgress = response;
                $('#modulesLoading').hide();
            });
        }, function errorCallback() {
            bootbox.alert('Не вдалось перемістити модуль');
        });
    }
    $scope.deleteModule=function (idModule,idCourse) {
        $('#moduleForm').hide();
        var msg;
        switch (lang) {
            case 'uk':
                msg='Ти впевнений, що хочеш видалити даний модуль?';
                break;
            case 'ru':
                msg='Ты уверен, что хочешь удалить данный модуль?';
                break;
            case 'en':
                msg='Are you sure you want to remove this module?';
                break;
            default:
                msg='Ти впевнений, що хочеш видалити даний модуль?';
                break;
        }

        bootbox.confirm(msg, function(result){
            if(result){
                $http({
                    url: basePath+'/course/unableModule',
                    method: "POST",
                    data: $.param({idModule: idModule,idCourse: idCourse}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback() {
                    $scope.getModuleProgressForUser(idCourse).then(function (response) {
                        $scope.modulesProgress = response;
                        $('#modulesLoading').hide();
                    });
                }, function errorCallback() {
                    bootbox.alert('Не вдалось дезактивувати модуль');
                });
            };
        })
    }
    $scope.enableEdit=function () {
        $scope.editVisible=true;
    };
    $scope.showForm=function () {
        document.getElementById('moduleForm').style.display = 'block';
        $('html, body').animate({
            scrollTop: $("#titleUA").offset().top
        }, 1000);
    }
    $scope.showRevisionForm=function () {
        document.getElementById('moduleRevisionForm').style.display = 'block';
        $('html, body').animate({
            scrollTop: $("#revTitleUA").offset().top
        }, 1000);
    }
}
