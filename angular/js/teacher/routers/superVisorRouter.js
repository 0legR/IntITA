/**
 * Created by adm on 26.07.2016.
 */
angular
    .module('superVisorRouter', ['ui.router']).
config(function ($stateProvider) {
    $stateProvider
        .state('supervisor', {
            url: "/supervisor",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Supervisor');
            },
            templateUrl: basePath+"/_teacher/cabinet/loadPage/?page=super_visor",
        })
        .state('supervisor/offlineGroups', {
            url: "/supervisor/offlineGroups",
            cache: false,
            controller: function ($scope) {
                $scope.changePageHeader('Оффлайнові групи');
            },
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/offlineGroups",
        })
        .state('supervisor/offlineGroup/:id', {
            url: "/supervisor/offlineGroup/:id",
            cache: false,
            controller: 'offlineGroupCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/offlineGroup/?id=" + $stateParams.id
            }
        })
        .state('supervisor/offlineSubgroups', {
            url: "/supervisor/offlineSubgroups",
            cache: false,
            controller: function ($scope) {
                $scope.changePageHeader('Оффлайнові підгрупи');
            },
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/offlineSubgroups",
        })
        .state('supervisor/offlineStudents', {
            url: "/supervisor/offlineStudents",
            cache: false,
            controller: 'offlineStudentsSVTableCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/offlineStudents",
        })
        .state('supervisor/studentsWithoutGroup', {
            url: "/supervisor/studentsWithoutGroup",
            cache: false,
            controller: 'studentsWithoutGroupSVTableCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/studentsWithoutGroup",
        })
        .state('supervisor/specializations', {
            url: "/supervisor/specializations",
            cache: false,
            controller: 'specializationsTableCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/specializations",
        })
        .state('supervisor/specialization/update/:id', {
            url: "/supervisor/specialization/update/:id",
            cache: false,
            controller: 'specializationCtrl',
            templateUrl: function ($stateParams) {
                return basePath+"/_teacher/_super_visor/superVisor/specializationUpdate/id/"+$stateParams.id;
            }
        })
        .state('supervisor/createSpecialization', {
            url: "/supervisor/createSpecialization",
            cache: false,
            controller: 'specializationsTableCtrl',
            templateUrl: basePath+"/_teacher/_super_visor/superVisor/specializationCreate"
        })
        .state('supervisor/userProfile/:id', {
            url: "/supervisor/userProfile/:id",
            cache: false,
            controller: 'offlineStudentProfileCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/userProfile"
        })
        .state('supervisor/student/:id/changetrainer', {
            url: "/supervisor/student/:id/changetrainer",
            cache: false,
            controller: 'offlineStudentProfileCtrl',
            templateUrl: function ($stateParams) {
                return basePath+"/_teacher/_super_visor/superVisor/changeTrainer/id/"+$stateParams.id;
            }
        })
        .state('supervisor/student/:id/addtrainer', {
            url: "/supervisor/student/:id/addtrainer",
            cache: false,
            controller: 'offlineStudentProfileCtrl',
            templateUrl: function ($stateParams) {
                return basePath+"/_teacher/_super_visor/superVisor/addTrainer/id/"+$stateParams.id;
            }
        })
        .state('supervisor/addOfflineGroup', {
            url: "/supervisor/addOfflineGroup",
            cache: false,
            controller: 'offlineGroupCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/addNewOfflineGroupForm",
        })
        .state('supervisor/editOfflineGroup/:id', {
            url: "/supervisor/editOfflineGroup/:id",
            cache: false,
            controller: 'offlineGroupCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/editOfflineGroupForm/?id=" + $stateParams.id
            }
        })
        .state('supervisor/offlineSubgroup/:id', {
            url: "/supervisor/offlineSubgroup/:id",
            cache: false,
            controller: 'offlineSubgroupCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/offlineSubgroup/?id=" + $stateParams.id
            }
        })
        .state('supervisor/group/:groupId/addOfflineSubgroup', {
            url: "/supervisor/group/:groupId/addOfflineSubgroup",
            cache: false,
            controller: 'offlineSubgroupCtrl',
            templateUrl: basePath + "/_teacher/_super_visor/superVisor/addSubgroupForm"
        })
        .state('supervisor/editSubgroup/:id', {
            url: "/supervisor/editSubgroup/:id",
            cache: false,
            controller: 'offlineSubgroupCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/editSubgroupForm/?id=" + $stateParams.id
            }
        })
        .state('supervisor/addStudentToSubgroup/:id', {
            url: "/supervisor/addStudentToSubgroup/:id",
            cache: false,
            controller: 'offlineStudentProfileCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/addOfflineStudent/?id=" + $stateParams.id
            }
        })
        .state('supervisor/editOfflineStudent/:idOfflineStudentModel', {
            url: "/supervisor/editOfflineStudent/:idOfflineStudentModel",
            cache: false,
            controller: 'updateOfflineStudentCtrl',
            templateUrl: function ($stateParams) {
                return basePath + "/_teacher/_super_visor/superVisor/editOfflineStudent/?id=" + $stateParams.idOfflineStudentModel
            }
        })
        .state('supervisor/users', {
            url: "/supervisor/users",
            cache: false,
            controller: 'usersSVTableCtrl',
            templateUrl: basePath+"/_teacher/_super_visor/superVisor/users",
        })
        .state('supervisor/students', {
            url: "/supervisor/students",
            cache: false,
            controller: 'studentsSVTableCtrl',
            templateUrl: basePath+"/_teacher/_super_visor/superVisor/students",
        })
});