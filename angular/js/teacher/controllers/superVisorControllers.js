/**
 * Created by adm on 19.07.2016.
 */
angular
    .module('teacherApp')
    .controller('superVisorCtrl', superVisorCtrl)
    .controller('offlineGroupsTableCtrl', offlineGroupsTableCtrl)
    .controller('offlineGroupCtrl', offlineGroupCtrl)
    .controller('offlineGroupSubgroupsTableCtrl', offlineGroupSubgroupsTableCtrl)
    .controller('offlineSubgroupsTableCtrl', offlineSubgroupsTableCtrl)
    .controller('offlineSubgroupCtrl', offlineSubgroupCtrl)
    .controller('offlineStudentsSVTableCtrl', offlineStudentsSVTableCtrl)
    .controller('studentsWithoutGroupSVTableCtrl', studentsWithoutGroupSVTableCtrl)
    .controller('specializationsTableCtrl', specializationsTableCtrl)
    .controller('specializationCtrl', specializationCtrl)
    .controller('usersSVTableCtrl', usersSVTableCtrl)
    .controller('studentsSVTableCtrl', studentsSVTableCtrl)
    .controller('groupAccessCtrl', groupAccessCtrl)
    .controller('offlineStudentSubgroupCtrl', offlineStudentSubgroupCtrl)

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


function offlineStudentsSVTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.changePageHeader('Студенти в підгрупах');
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

function studentsWithoutGroupSVTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.changePageHeader('Студенти(офлайн ф.н.), які не в групі');
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
            url: basePath+'/_teacher/_supervisor/superVisor/createSpecialization',
            method: "POST",
            data: $jq.param({title_ua: $scope.specialization.title_ua,title_ru: $scope.specialization.title_ru,title_en: $scope.specialization.title_en}),
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
            url: basePath+'/_teacher/_supervisor/superVisor/getSpecializationData',
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
            url: basePath+'/_teacher/_supervisor/superVisor/updateSpecialization',
            method: "POST",
            data: $jq.param({
                id:$stateParams.id,
                title_ua: $scope.specialization.title_ua,
                title_ru: $scope.specialization.title_ru,
                title_en: $scope.specialization.title_en
            }),
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

function offlineGroupCtrl ($scope, $state, $http, $stateParams, superVisorService, NgTableParams, typeAhead, $filter){
    $scope.changePageHeader('Офлайн група');
    if($stateParams.id){
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
        $scope.groupCoursesAccessParams = new NgTableParams({'idGroup':$scope.groupId}, {
            getData: function (params) {
                return superVisorService
                    .courseAccessList(params.url())
                    .$promise
                    .then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
            }
        });
        $scope.groupModulesAccessParams = new NgTableParams({'idGroup':$scope.groupId}, {
            getData: function (params) {
                return superVisorService
                    .moduleAccessList(params.url())
                    .$promise
                    .then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
            }
        });
        
        $scope.date = $filter('date')(new Date(), "yyyy-MM-dd");
    }

    $scope.cancelGroupAccess=function(idGroup, idService, type){
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/cancelGroupAccess',
            method: "POST",
            data: $jq.param({
                idGroup:idGroup,
                idService:idService
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback() {
           if(type=='course'){
               $scope.groupCoursesAccessParams.reload();
           }else if(type=='module'){
               $scope.groupModulesAccessParams.reload();
           }
        }, function errorCallback() {
            bootbox.alert("Виникла помилка");
        });
    };
    
    $scope.loadGroupData=function(){
        superVisorService.groupData({'id':$stateParams.id}).$promise
            .then(function successCallback(response) {
                $scope.group=response;
                $scope.loadCityToModel($scope.group.city);
                $scope.loadCuratorToModel($scope.group.id_user_curator);
                $scope.changePageHeader('Офлайн група: '+$scope.group.name);
                $scope.selectedSpecialization=$scope.specializations[$scope.group.specialization-1].id;
            }, function errorCallback() {
                bootbox.alert("Отримати дані групи не вдалося");
            });
    };
    
    $scope.loadSpecializations=function(){
        return superVisorService
            .getSpecializationsList()
            .$promise
            .then(function (data) {
                $scope.specializations=data;
                if($stateParams.id)
                    $scope.loadGroupData();
                else $scope.loadCuratorToModel();
            });
    };
    $scope.loadSpecializations();

    $scope.sendFormOfflineGroup= function (scenario) {
        if(scenario=='new') $scope.createOfflineGroup();
        else $scope.editOfflineGroup();
    };
    $scope.createOfflineGroup= function () {
        if(!$scope.selectedCity){
            bootbox.alert('Виберіть місто з існуючого списку');
            return;
        }
        if(!$scope.selectedCurator){
            bootbox.alert('Виберіть куратора з існуючого списку');
            return;
        }
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/createOfflineGroup',
            method: "POST",
            data: $jq.param({
                name: $scope.group.name,
                date:$scope.group.start_date,
                specialization:$scope.selectedSpecialization,
                city:$scope.selectedCity.id,
                curator:$scope.selectedCurator.id
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroups", {}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };
    $scope.editOfflineGroup= function () {
        if(!$scope.selectedCity){
            bootbox.alert('Виберіть місто з існуючого списку');
            return;
        }
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/updateOfflineGroup',
            method: "POST",
            data: $jq.param({
                id:$stateParams.id,
                name: $scope.group.name,
                date:$scope.group.start_date,
                specialization:$scope.selectedSpecialization,
                city:$scope.selectedCity.id,
                curator:$scope.selectedCurator.id
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroup/:id", {id:$stateParams.id}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };

    //select curator
    $scope.loadCuratorToModel=function(curatorId){
        curatorId = typeof curatorId !== 'undefined' ? curatorId :'';
        $http.get(basePath + "/_teacher/_supervisor/superVisor/getCuratorById/?id="+curatorId).then(function (response) {
            $scope.curatorEntered = response.data.fullName;
            $scope.selectedCurator={id: response.data.id, name: response.data.fullName};
        });
    };
    $scope.onSelectCurator = function ($item) {
        $scope.selectedCurator = $item;
    };
    $scope.reloadCurator = function(){
        $scope.selectedCurator=null;
    };
    var curatorsTypeaheadUrl = basePath + '/_teacher/_supervisor/superVisor/curatorsByQuery';
    $scope.getCurators = function(value){
        return typeAhead.getData(curatorsTypeaheadUrl,{query : value});
    };
    //select city
    $scope.loadCityToModel=function(cityId){
        $http.get(basePath + "/_teacher/_supervisor/superVisor/getCityById/?id="+cityId).then(function (response) {
            $scope.cityEntered = response.data;
            $scope.selectedCity={id: cityId, title: response.data};
        });
    };
    $scope.onSelect = function ($item) {
        $scope.selectedCity = $item;
    };
    $scope.reload = function(){
        $scope.selectedCity=null;
    };
    var citiesTypeaheadUrl = basePath + '/_teacher/_supervisor/superVisor/citiesByQuery';
    $scope.getCities = function(value){
        return typeAhead.getData(citiesTypeaheadUrl,{query : value});
    };
}

function offlineSubgroupCtrl ($scope, $state, $http, $stateParams, superVisorService, NgTableParams, typeAhead){
    //select curator
    $scope.loadCuratorToModel=function(curatorId){
        curatorId = typeof curatorId !== 'undefined' ? curatorId :'';
        $http.get(basePath + "/_teacher/_supervisor/superVisor/getCuratorById/?id="+curatorId).then(function (response) {
            $scope.curatorEntered = response.data.fullName;
            $scope.selectedCurator={id: response.data.id, name: response.data.fullName};
        });
    };
    $scope.onSelectCurator = function ($item) {
        $scope.selectedCurator = $item;
    };
    $scope.reloadCurator = function(){
        $scope.selectedCurator=null;
    };
    $scope.onSelectTrainer = function ($item) {
        $scope.selectedTrainer = $item;
    };
    $scope.reloadTrainer = function(){
        $scope.selectedTrainer=null;
    };
    var curatorsTypeaheadUrl = basePath + '/_teacher/_supervisor/superVisor/curatorsByQuery';
    $scope.getCurators = function(value){
        return typeAhead.getData(curatorsTypeaheadUrl,{query : value});
    };
    //select curator

    $scope.loadSubgroupData=function(subgroupId){
        superVisorService.subgroupData({'id':subgroupId}).$promise
            .then(function successCallback(response) {
                $scope.subgroup=response.subgroup;
                $scope.subgroupTrainer=response.subgroupTrainer;
                if($scope.subgroupTrainer){
                    $scope.trainerEntered = response.subgroupTrainer.fullName;
                    $scope.selectedTrainer={id: response.subgroupTrainer.id, name: response.subgroupTrainer.fullName};
                }
                $scope.changePageHeader('Офлайн підгрупа: '+$scope.subgroup.name);
                $scope.loadGroupData($scope.subgroup.group);
                $scope.loadCuratorToModel($scope.subgroup.id_user_curator);
            }, function errorCallback() {
                bootbox.alert("Отримати дані підгрупи не вдалося");
            });
    };

    $scope.loadGroupData=function(groupId){
        superVisorService.groupData({'id':groupId}).$promise
            .then(function successCallback(response) {
                $scope.group=response;
            }, function errorCallback() {
                bootbox.alert("Отримати дані групи не вдалося");
            });
    };

    if($stateParams.groupId) {
        $scope.groupId=$stateParams.groupId;
        $scope.loadGroupData($scope.groupId);
        $scope.loadCuratorToModel();
    }
    if($stateParams.id) {
        $scope.subgroupId = $stateParams.id;
        $scope.offlineStudentsTableParams = new NgTableParams({'idSubgroup': $scope.subgroupId}, {
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
        $scope.loadSubgroupData($scope.subgroupId);
    };

    $scope.sendFormSubgroup= function (scenario, name, groupId, subgroupData, selectedCurator, selectedTrainer,subgroupId) {
        if(scenario=='new') $scope.addSubgroup(name, groupId, subgroupData, selectedCurator, selectedTrainer);
        else $scope.editSubgroup(name, subgroupData, selectedCurator, selectedTrainer,subgroupId);
    };

    $scope.addSubgroup= function (name, groupId, subgroupData, selectedCurator, selectedTrainer) {
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/addSubgroup',
            method: "POST",
            data: $jq.param({
                name: name,
                group: groupId,
                data: subgroupData,
                curator: selectedCurator,
                trainer: selectedTrainer
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineGroup/:id", {id:$scope.groupId}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Створити групу не вдалося. Помилка сервера.");
        });
    };
    $scope.editSubgroup= function (name, subgroupData, selectedCurator, selectedTrainer,subgroupId) {
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/updateSubgroup',
            method: "POST",
            data: $jq.param({
                id:subgroupId,
                name: name,
                data: subgroupData,
                curator: selectedCurator,
                trainer: selectedTrainer
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data, function(){
                $state.go("supervisor/offlineSubgroup/:id", {id:$scope.subgroupId}, {reload: true});
            });
        }, function errorCallback() {
            bootbox.alert("Редагувати підгрупу не вдалося. Помилка сервера.");
        });
    };
    $scope.goBack= function () {
        if($stateParams.groupId) {
            $state.go('supervisor/offlineGroup/:id', {id:$stateParams.groupId}, {reload: true});
        } else if($stateParams.id) {
            $state.go('supervisor/offlineSubgroup/:id', {id:$stateParams.id}, {reload: true});
        }
    };
}

function usersSVTableCtrl ($scope, superVisorService, NgTableParams){
    $scope.changePageHeader('Зареєстровані користувачі');
    $scope.usersTableParams = new NgTableParams({}, {
        getData: function (params) {
            return superVisorService
                .usersList(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });
}

function studentsSVTableCtrl ($scope, superVisorService, NgTableParams, $http){
    $scope.changePageHeader('Усі студенти');

    $jq("#startDate").datepicker(lang);
    $jq("#endDate").datepicker(lang);

    $scope.studentsTableParams = new NgTableParams({}, {
        getData: function (params) {
            $scope.params=params.url();
            $scope.params.startDate=$scope.startDate;
            $scope.params.endDate=$scope.endDate;
            return superVisorService
                .studentsList($scope.params)
                .$promise
                .then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
        }
    });

    $scope.updateStudentList=function(startDate, endDate){
        $scope.studentsTableParams = new NgTableParams({}, {
            getData: function (params) {
                $scope.params=params.url();
                $scope.params.startDate=startDate;
                $scope.params.endDate=endDate;
                return superVisorService
                    .studentsList($scope.params)
                    .$promise
                    .then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
            }
        });
    }
    $scope.changeStudentEducForm=function (user,currentEducForm) {
        var form;
        if(currentEducForm=='Онлайн') form='Онлайн/Офлайн';
        else if(currentEducForm=='Онлайн/Офлайн') form='Онлайн';
        $http({
            method: 'POST',
            url: basePath+'/_teacher/user/setStudentEducForm',
            data: $jq.param({user: user,form:form}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback() {
            $scope.studentsTableParams.reload();
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    }
}


function groupAccessCtrl ($scope, $http, $stateParams, superVisorService){
    $scope.changePageHeader('Доступ групи до контенту');
    $scope.end_date='3000-12-31';

    $scope.loadGroupData=function(groupId){
        superVisorService.groupData({'id':groupId}).$promise
            .then(function successCallback(response) {
                $scope.selectedGroup=response;
                $scope.groupSelected=response.name;
            }, function errorCallback() {
                bootbox.alert("Отримати дані групи не вдалося");
            });
    };
    $scope.loadGroupAccess=function(groupId,serviceId){
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/getGroupAccess',
            method: "POST",
            data: $jq.param({
                groupId:groupId,
                serviceId:serviceId
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.groupSelected=response.data.group;
            $scope.serviceSelected=response.data.service;
            $scope.end_date=response.data.endDate;
        }, function errorCallback() {
            bootbox.alert("Отримати дані не вдалося");
        });
    };

    if($stateParams.service && $stateParams.group) {
        $scope.defaultService=$stateParams.service;
        $scope.defaultGroup=$stateParams.group;
        $scope.loadGroupAccess($scope.defaultGroup, $scope.defaultService);
    }else if(!$stateParams.service && $stateParams.group){
        $scope.defaultGroup=$stateParams.group;
        $scope.loadGroupData($stateParams.group);
    }

    $scope.onSelectGroup = function ($item) {
        $scope.selectedGroup = $item;
    };
    $scope.reloadGroup = function(){
        $scope.selectedGroup=null;
    };
    $scope.onSelectService = function ($item) {
        $scope.selectedContent = $item;
    };
    $scope.reloadService = function(){
        $scope.selectedContent=null;
    };
    $scope.clearContent = function(){
        $scope.selectedContent=null;
        $scope.serviceSelected=null;
    };
    
    $scope.sendGroupAccessToContent=function(scenario, idGroup, idContent, endDate, serviceType){
        if(scenario=='create')
            $scope.createGroupAccessToContent(idGroup, idContent, endDate, serviceType);
        else $scope.updateGroupAccessToContent($scope.defaultGroup, $scope.defaultService, endDate);
    };

    $scope.createGroupAccessToContent=function(idGroup, idContent, endDate, serviceType){
        if(idGroup && idContent && endDate && serviceType){
            $http({
                url: basePath+'/_teacher/_supervisor/superVisor/setGroupAccessToService',
                method: "POST",
                data: $jq.param({
                    idGroup:idGroup,
                    idContent:idContent,
                    endDate:endDate,
                    serviceType:serviceType
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
            }).then(function successCallback(response) {
                $scope.addUIHandlers(response.data);
                $scope.clearContent();
            }, function errorCallback(response) {
                console.log(response);
                bootbox.alert("Виникла помилка");
            });
        }else{
            bootbox.alert("Введіть всі необхідні дані форми");
        }
    };

    $scope.updateGroupAccessToContent=function(idGroup, idService, endDate){
        if(idGroup && idService && endDate){
            $http({
                url: basePath+'/_teacher/_supervisor/superVisor/updateGroupAccessToService',
                method: "POST",
                data: $jq.param({
                    idGroup:idGroup,
                    idService:idService,
                    endDate:endDate,
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
            }).then(function successCallback(response) {
                $scope.addUIHandlers(response.data);
            }, function errorCallback(response) {
                console.log(response);
                bootbox.alert("Виникла помилка");
            });
        }else{
            bootbox.alert("Введіть всі необхідні дані форми");
        }
    };

    $scope.cancelGroupAccess=function(idGroup, idService){
        $http({
            url: basePath+'/_teacher/_supervisor/superVisor/cancelGroupAccess',
            method: "POST",
            data: $jq.param({
                idGroup:idGroup,
                idService:idService
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback() {
            $scope.loadGroupAccess(idGroup, idService);
        }, function errorCallback() {
            bootbox.alert("Виникла помилка");
        });
    };
}

function offlineStudentSubgroupCtrl ($scope, $http, superVisorService, $stateParams, $filter){
    $scope.onSelectUser = function ($item) {
        $scope.selectedUser = $item;
    };
    $scope.reloadUser = function(){
        $scope.selectedUser=null;
    };
    $scope.onSelectGroup = function ($item) {
        $scope.selectedGroup = $item;
        superVisorService
            .offlineGroupSubgroupsList({'id':$scope.selectedGroup.id})
            .$promise
            .then(function (data) {
                $scope.subgroupsList=data.rows;
            });
    };
    $scope.reloadGroup = function(){
        $scope.selectedGroup=null;
        $scope.selectedSubgroup=null;
        $scope.subgroupsList=null;
    };
    
    $scope.clearInputs=function () {
        $scope.formData.userSelected=null;
        $scope.selectedModule=null;
        $scope.selectedUser=null;
        $scope.formData.moduleSelected=null;
    };
    
    $scope.loadUserData=function(userId){
        $http.get(basePath + "/_teacher/user/loadJsonUserModel/"+userId).then(function (response) {
            $scope.selectedUser = response.data.user;
            $scope.userSelected = response.data.user.fullName+' '+response.data.user.email;
            $scope.defaultStudent=$scope.selectedUser.id;
        });
    };

    $scope.loadGroupData=function(groupId) {
        superVisorService.groupData({'id':groupId}).$promise
            .then(function successCallback(response) {
                $scope.defaultGroup=true;
                $scope.selectedGroup=response;
                $scope.groupSelected=response.name;
            }, function errorCallback() {
                bootbox.alert("Отримати дані групи не вдалося");
            });
    };
    $scope.loadSubgroupData=function(subgroupId){
        superVisorService.subgroupData({'id':subgroupId}).$promise
            .then(function successCallback(response) {
                $scope.subgroup=response.subgroup;
                superVisorService
                    .offlineGroupSubgroupsList({'id':$scope.subgroup.group})
                    .$promise
                    .then(function (data) {
                        $scope.subgroupsList=data.rows;
                        $scope.selectedSubgroup={id:subgroupId};
                    });
                $scope.loadGroupData($scope.subgroup.group);
            }, function errorCallback() {
                bootbox.alert("Отримати дані підгрупи не вдалося");
            });
    };
    $scope.loadOfflineStudentModel=function(offlineStudentModelId){
        $http.get(basePath + "/_teacher/_supervisor/superVisor/getOfflineStudentModel/?id="+offlineStudentModelId).then(function (response) {
            $scope.start_date=response.data.startDate;
            $scope.graduate_date = response.data.graduateDate;
            $scope.end_date = response.data.endDate;
            $scope.loadUserData(response.data.id);
            $scope.loadGroupData(response.data.idGroup);
            $scope.loadSubgroupData(response.data.idSubgroup);
        });
    };
    
    if($stateParams.studentId) {
        $scope.start_date= $filter('date')(new Date(), "yyyy-MM-dd");
        $scope.loadUserData($stateParams.studentId);
    }else if($stateParams.studentModelId){
        $scope.studentModelId=$stateParams.studentModelId;
        $scope.loadOfflineStudentModel($scope.studentModelId);
    }else if($stateParams.subgroupId){
        $scope.defaultSubgroup=true;
        $scope.loadSubgroupData($stateParams.subgroupId);
        $scope.start_date= $filter('date')(new Date(), "yyyy-MM-dd");
    }

    $scope.sendOfflineStudentSubgroupForm=function(scenario, idUser,idSubgroup,startDate, graduateDate, modelId){
        if(scenario=='create')
            $scope.addStudentToSubgroup(idUser,idSubgroup,startDate);
        else $scope.updateOfflineStudentSubgroup(idUser, idSubgroup, startDate, graduateDate, modelId);
    };

    $scope.addStudentToSubgroup=function (idUser,idSubgroup,startDate) {
        if ($scope.selectedGroup==null) {
            bootbox.alert("Виберіть групу");
        } else if(idSubgroup==null){
            bootbox.alert("Виберіть підгрупу");
        } else if(idUser==null){
            bootbox.alert("Виберіть студента");
        }else{
            $http({
                method: 'POST',
                url: basePath+'/_teacher/_supervisor/superVisor/addStudentToSubgroup',
                data: $jq.param({userId: idUser, subgroupId: idSubgroup, startDate: startDate}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function successCallback(response) {
                $scope.addUIHandlers(response.data);
                if($stateParams.subgroupId){
                    $scope.reloadUser();
                    $scope.userSelected=null;
                    $scope.studentSubgroup.student.$setPristine();
                }else if($stateParams.studentId){
                    $scope.reloadGroup();
                    $scope.groupSelected=null;
                    $scope.studentSubgroup.group.$setPristine();
                    $scope.loadUserData(idUser);
                }
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати");
            });
        }
    };

    $scope.updateOfflineStudentSubgroup=function (idUser, idSubgroup, startDate, graduateDate, modelId) {
        $http({
            method: 'POST',
            url: basePath+'/_teacher/_supervisor/superVisor/updateOfflineStudent',
            data: $jq.param({
                userId: idUser, subgroupId: idSubgroup, 
                startDate: startDate, graduateDate: graduateDate, 
                modelId: modelId}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.addUIHandlers(response.data);
            $scope.loadOfflineStudentModel($scope.studentModelId);
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    };
    
    $scope.cancelStudentFromSubgroup=function (idUser, idSubgroup) {
        $http({
            method: 'POST',
            url: basePath+'/_teacher/_supervisor/superVisor/cancelStudentFromSubgroup',
            data: $jq.param({userId: idUser, subgroupId: idSubgroup}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function successCallback(response) {
            $scope.loadOfflineStudentModel($scope.studentModelId);
            $scope.addUIHandlers(response.data);
        }, function errorCallback() {
            bootbox.alert("Операцію не вдалося виконати");
        });
    };

    $scope.onSelectGroup = function ($item) {
        $scope.selectedGroup = $item;
        superVisorService
            .offlineGroupSubgroupsList({'id':$scope.selectedGroup.id})
            .$promise
            .then(function (data) {
                $scope.subgroupsList=data.rows;
            });
    };
    $scope.reloadGroup = function(){
        $scope.selectedGroup=null;
        $scope.selectedSubgroup=null;
        $scope.subgroupsList=null;
    };
}
