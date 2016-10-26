/**
 * Created by adm on 19.07.2016.
 */
angular
    .module('teacherApp')
    .controller('superVisorCtrl', superVisorCtrl)
    .controller('offlineGroupsTableCtrl', offlineGroupsTableCtrl)
    .controller('offlineGroupSubgroupsTableCtrl', offlineGroupSubgroupsTableCtrl)
    .controller('addOfflineGroupCtrl', addOfflineGroupCtrl)
    .controller('offlineGroupCtrl', offlineGroupCtrl)
    .controller('addOfflineSubgroupCtrl', addOfflineSubgroupCtrl)
    .controller('offlineSubgroupCtrl', offlineSubgroupCtrl)
    .controller('offlineSubgroupsTableCtrl', offlineSubgroupsTableCtrl)
    .controller('offlineStudentsTableCtrl', offlineStudentsTableCtrl)
    .controller('offlineStudentProfileCtrl', offlineStudentProfileCtrl)
    .controller('studentsWithoutGroupTableCtrl', studentsWithoutGroupTableCtrl)
    .controller('specializationsTableCtrl', specializationsTableCtrl)
    .controller('specializationCtrl', specializationCtrl)

function superVisorCtrl (){

}

function offlineGroupsTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.offlineGroupsTableParams = new NgTableParams({}, {
        getData: function (params) {
            return superVisorService
                .offlineGroupsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}

function offlineSubgroupsTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.offlineSubgroupsTableParams = new NgTableParams({}, {
        getData: function (params) {
            return superVisorService
                .offlineSubgroupsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}


function offlineStudentsTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.changePageHeader('Студенти(розподілені)');
    $scope.offlineStudentsTableParams = new NgTableParams({}, {
        getData: function (params) {
            return superVisorService
                .offlineStudentsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}

function studentsWithoutGroupTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.changePageHeader('Студенти(нерозподілені)');
    $scope.studentsWithoutGroupTableParams = new NgTableParams({}, {
        getData: function (params) {
            return superVisorService
                .studentsWithoutGroupList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}

function offlineGroupSubgroupsTableCtrl ($scope, superVisorService, NgTableParams, $stateParams){
    $scope.groupId=$stateParams.id;
    $scope.offlineGroupSubgroupsTableParams = new NgTableParams({'id':$scope.groupId}, {
        getData: function (params) {
            return superVisorService
                .offlineGroupSubgroupsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}

function specializationsTableCtrl ($scope, superVisorService, $state, $http, $stateParams){
    $scope.changePageHeader('Спеціалізації груп');

    $scope.loadSpecializations=function(){
        return superVisorService
            .getSpecializationsList()
            .$promise
            .then(function (data) {
                $scope.specializations=data;
            });
    };
    $scope.loadSpecializations();

    $scope.createSpecialization= function () {
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/createSpecialization',
            method: "POST",
            data: $jq.param({name: $scope.specialization.name}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/specializations", {}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити спеціалізацію не вдалося. Помилка сервера.");
        });
    };
}

function specializationCtrl ($scope, $state, $http, $stateParams){
    $scope.changePageHeader('Спеціалізація');
    
    $scope.loadSpecializationData=function(){
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/getSpecializationData',
            method: "POST",
            data: $jq.param({id:$stateParams.id}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.specialization=response.data;
        }, function errorCallback() {
            bootbox.alert("Отримати дані спеціалізації не вдалося");
        });
    };
    $scope.loadSpecializationData();

    $scope.editSpecialization= function () {
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/updateSpecialization',
            method: "POST",
            data: $jq.param({id:$stateParams.id,name: $scope.specialization.name}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/specializations", {}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Відредагувати спеціалізацію не вдалося. Помилка сервера.");
        });
    };
}

function addOfflineGroupCtrl ($scope, superVisorService, $state, $http){
    $scope.changePageHeader('Нова оффлайн група');
    $scope.loadSpecializations=function(){
        return superVisorService
            .getSpecializationsList()
            .$promise
            .then(function (data) {
                $scope.specializations=data;
            });
    };
    
    $scope.loadSpecializations();
    
    $scope.createOfflineGroup= function () {
        if($jq('#city').val()==0){
            bootbox.alert('Виберіть місто з існуючого списку');
            return;
        }

        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/createOfflineGroup',
            method: "POST",
            data: $jq.param({name: $scope.name,date:$scope.startDate,specialization:$scope.selectedSpecialization.id,city:$jq('#city').val()}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroups", {}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };
}

function addOfflineSubgroupCtrl ($scope, $state, $http, $stateParams){
    $scope.groupId=$stateParams.groupId;
    $scope.changePageHeader('Нова підгрупа');

    $scope.loadGroupData=function(){
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/getGroupData',
            method: "POST",
            data: $jq.param({id:$scope.groupId}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.group=response.data;
        }, function errorCallback() {
            bootbox.alert("Отримати дані групи не вдалося");
        });
    };
    $scope.loadGroupData();

    $scope.addSubgroup= function () {
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/addSubgroup',
            method: "POST",
            data: $jq.param({name: $scope.name, group: $scope.groupId, data: $scope.data}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroup/:id", {id:$scope.groupId}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };
}

function offlineGroupCtrl ($scope, $state, $http, $stateParams, superVisorService, NgTableParams){
    $scope.groupId=$stateParams.id;
    $scope.offlineStudentsTableParams = new NgTableParams({'idGroup':$scope.groupId}, {
        getData: function (params) {
            return superVisorService
                .offlineStudentsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
    
    $scope.loadSpecializations=function(){
        return superVisorService
            .getSpecializationsList()
            .$promise
            .then(function (data) {
                $scope.specializations=data;
                $scope.loadGroupData();
            });
    };
    $scope.loadGroupData=function(){
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/getGroupData',
            method: "POST",
            data: $jq.param({id:$stateParams.id}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.group=response.data;
            $scope.changePageHeader('Оффлайн група: '+$scope.group.name);
            $scope.selectedSpecialization=$scope.specializations[$scope.group.specialization-1].id;
        }, function errorCallback() {
            bootbox.alert("Отримати дані групи не вдалося");
        });
    };

    $scope.loadSpecializations();
    
    $scope.editOfflineGroup= function () {
        // if($jq('#city').val()==0){
        //     bootbox.alert('Виберіть місто з існуючого списку');
        //     return;
        // }
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/updateOfflineGroup',
            method: "POST",
            data: $jq.param({id:$stateParams.id,name: $scope.group.name,date:$scope.group.start_date,specialization:$scope.selectedSpecialization,city:$jq('#city').val()}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroups", {}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };
}

function offlineSubgroupCtrl ($scope, $state, $http, $stateParams, superVisorService, NgTableParams){
    $scope.subgroupId=$stateParams.id;
    $scope.offlineStudentsTableParams = new NgTableParams({'idSubgroup':$scope.subgroupId}, {
        getData: function (params) {
            return superVisorService
                .offlineStudentsList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });

    $scope.loadSubgroupData=function(){
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/getSubgroupData',
            method: "POST",
            data: $jq.param({id:$scope.subgroupId}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.subgroup=response.data;
            $scope.changePageHeader('Оффлайн підгрупа: '+$scope.subgroup.name);
            $scope.loadGroupData();
        }, function errorCallback() {
            bootbox.alert("Отримати дані підгрупи не вдалося");
        });
    };
    $scope.loadGroupData=function(){
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/getGroupData',
            method: "POST",
            data: $jq.param({id:$scope.subgroup.group}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.group=response.data;
        }, function errorCallback() {
            bootbox.alert("Отримати дані групи не вдалося");
        });
    };
    
    $scope.loadSubgroupData();

    $scope.editSubgroup= function () {
        $http({
            url: basePath+'/_teacher/_super_visor/superVisor/updateSubgroup',
            method: "POST",
            data: $jq.param({id:$scope.subgroupId,name: $scope.subgroup.name, data: $scope.subgroup.data}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineSubgroup/:id", {id:$scope.subgroupId}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Редагувати підгрупу не вдалося. Помилка сервера.");
        });
    };
}

function offlineStudentProfileCtrl ($scope, $state, $http, $stateParams, typeAhead, superVisorService){
    $scope.changePageHeader('Студенти(оффлайнова форма навчання)');

    $scope.loadStudentData=function(){
        $http.get(basePath + "/_teacher/_super_visor/superVisor/getStudentData/?id="+$stateParams.id).then(function (response) {
            $scope.student = response.data;
        });
    };
    $scope.loadOfflineStudentData=function(){
        $http.get(basePath + "/_teacher/_super_visor/superVisor/getOfflineStudentData/?id="+$stateParams.id).then(function (response) {
            $scope.offlineStudent = response.data;
            console.log($scope.offlineStudent);
        });
    };
    $scope.loadStudentData();

    $scope.addTrainer=function (url, scenario) {
        var id = document.getElementById('user').value;
        var trainerId = (scenario == "remove") ? 0 : $jq("#trainer").val();
        var oldTrainerId = 0;
        if (trainerId == 0 && scenario != "remove") {
            bootbox.alert("Виберіть тренера.");
        }
        $http({
            method: 'POST',
            url: url,
            data: $jq.param({userId: id, trainerId: trainerId, oldTrainerId: oldTrainerId}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            if (response.data == "success") {
                bootbox.alert('Операцію успішно виконано.', function () {
                    if(scenario == "new") $state.go('supervisor/student/:id/changetrainer', {id:id}, {reload: true});
                    else $scope.loadStudentData();
                });
            }else{
                $scope.loadStudentData();
                bootbox.alert(response.data)
            }
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    };

    $scope.addStudentToSubgroup=function () {
        if ($scope.selectedGroup==null) {
            bootbox.alert("Виберіть групу");
        } else if($scope.selectedSubgroup==null){
            bootbox.alert("Виберіть підгрупу");
        } else if($scope.student.id==null){
            bootbox.alert("Виберіть студента");
        }else{
            $http({
                method: 'POST',
                url: basePath+'/_teacher/_super_visor/superVisor/addStudentToSubgroup',
                data: $jq.param({userId: $scope.student.id, subgroupId: $scope.selectedSubgroup.id, startDate: $scope.startDate}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                bootbox.alert(response.data, function () {
                    $state.go('supervisor/studentsWithoutGroup');
                });
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати");
            });
        }
    };

    $scope.updateOfflineStudent=function (idUser, idSubgroup, startDate, graduateDate) {
        $http({
            method: 'POST',
            url: basePath+'/_teacher/_super_visor/superVisor/updateOfflineStudent',
            data: $jq.param({userId: idUser, subgroupId: idSubgroup, startDate: startDate, graduateDate: graduateDate}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data);
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    };

    $scope.cancelStudentFromSubgroup=function (idUser, idSubgroup) {
        $http({
            method: 'POST',
            url: basePath+'/_teacher/_super_visor/superVisor/cancelStudentFromSubgroup',
            data: $jq.param({userId: idUser, subgroupId: idSubgroup}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data);
            $scope.loadOfflineStudentData();
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    };
    
    $scope.onSelect = function ($item) {
        $scope.selectedGroup = $item;
        superVisorService
            .offlineGroupSubgroupsList({'id':$scope.selectedGroup.id})
            .$promise
            .then(function (data) {
                $scope.subgroupsList=data.rows;
            });
    };
    $scope.reload = function(){
        $scope.selectedGroup=null;
        $scope.selectedSubgroup=null;
        $scope.subgroupsList=null;
    };
    var groupTypeaheadUrl = basePath + '/_teacher/_super_visor/superVisor/groupsByQuery';
    $scope.getGroups = function(value){
        return typeAhead.getData(groupTypeaheadUrl,{query : value});
    };
}