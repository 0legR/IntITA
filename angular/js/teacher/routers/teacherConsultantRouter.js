/**
 * Created by adm on 26.07.2016.
 */
angular
    .module('teacherConsultantRouter',['ui.router']).
config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
    $stateProvider
        .state('teacherConsultant', {
            url: "/teacherConsultant",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Викладач');
            },
            templateUrl: basePath+"/_teacher/cabinet/loadPage/?page=teacher_consultant",
        })
        .state('teacherConsultant/modules', {
            url: "/teacherConsultant/modules",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Модулі');
            },
            templateUrl: basePath+"/_teacher/_teacher_consultant/teacherConsultant/modules/id/"+user,
        })
        .state('teacherConsultant/students', {
            url: "/teacherConsultant/students",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Студенти');
            },
            templateUrl: basePath+"/_teacher/_teacher_consultant/teacherConsultant/students/id/"+user,
        })
        .state('teacherConsultant/tasks', {
            url: "/teacherConsultant/tasks",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Всі задачі');
            },
            templateUrl: basePath+"/_teacher/_teacher_consultant/teacherConsultant/showTeacherPlainTaskList",
        })
        .state('teacherConsultant/task/:taskId', {
            url: "/teacherConsultant/task/:taskId",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Відповідь на задачу');
            },
            templateUrl: function($stateParams){
                return basePath+"/_teacher/_teacher_consultant/teacherConsultant/showPlainTask/idPlainTask/"+$stateParams.taskId
            }

        })
        .state('teacherConsultant/consultations', {
            url: "/teacherConsultant/consultations",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Консультації');
            },
            templateUrl: basePath+"/_teacher/_teacher_consultant/teacherConsultant/consultations/id/"+user,
        })
        .state('teacherConsultant/consultation/view/:consultationId', {
            url: "/teacherConsultant/consultation/view/:consultationId",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Консультація');
            },
            templateUrl: function($stateParams){
                return basePath+"/_teacher/_teacher_consultant/teacherConsultant/consultation/id/"+$stateParams.consultationId
            }
        
        })
        .state('teacherCalendarConsultation/calendarConsultations', {
            url: "/teacherCalendarConsultation/calendarConsultations",
            cache: false,
            controller: function ($scope) {
                $scope.changePageHeader('Календар консультацій');
            },
            templateUrl: basePath+"/_teacher/teacherCalendarConsultation/calendarConsultations"
        })

});


