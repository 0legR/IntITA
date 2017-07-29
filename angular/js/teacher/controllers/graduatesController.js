/**
 * Created by adm on 10.08.2016.
 */
angular
    .module('teacherApp')
    .controller('graduateCtrl',graduateCtrl);

function graduateCtrl ($rootScope, $scope, $filter, $http, graduates, NgTableParams, translitService, typeAhead, $httpParamSerializerJQLike, $state, $stateParams, $ngBootbox, $timeout){

    $scope.publishStatus = [{id:'0', title:'Не опубліковано'},{id:'1', title:'Опубліковано'}];
    $rootScope.$on('userCreated', function (event, data) {
        $scope.graduate.user = data;
        $scope.noResults = false;
    });

    if ($state.is('graduate/edit/:graduateId')){
        $scope.courseCollapsed = true;
        $scope.modulesCollapsed = true;
        $http.get('/_teacher/graduate/getGraduateData/'+$stateParams.graduateId).then(function (response) {
            $scope.graduate = response.data;
            $scope.graduate.graduate_date = new Date($scope.graduate.graduate_date);
        });

    }

    $scope.addGraduate = function () {

        $http({
            method:'POST',
            url: basePath+'/_teacher/graduate/addGraduate',
            data: $httpParamSerializerJQLike({Graduate:$scope.graduate}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).success(function (response) {
            if (typeof response === 'object'){
                $scope.errors = response.errors;
                bootbox.alert(JSON.stringify($scope.errors));
                return false;
            }
            else{
                $state.go('graduate');
            }
        })
    }

    $scope.selectedUser = function ($item, $model, $label, $event) {
        $scope.graduate.first_name_en = translitService.translitPlease('ua-en',$item.firstName);
        $scope.graduate.last_name_en = translitService.translitPlease('ua-en',$item.secondName);
    }

    $scope.format = 'dd-MM-yyyy';
    $scope.dateOptions = {
        showWeeks: true
    };

    $scope.openDatepicker = function() {
        $scope.open = !$scope.open;
    };

    $scope.getAllUsersByOrganization = function (value) {

        return typeAhead.getData(basePath+"/_teacher/graduate/getusers",{query : value});
    };

    $scope.getAllCoursesByOrganization = function (value) {

        return typeAhead.getData(basePath+"/_teacher/graduate/getAllCourses",{query : value});
    };

    $scope.getAllModulesByOrganization = function (value) {

        return typeAhead.getData(basePath+"/_teacher/graduate/getAllModules",{query : value});
    };

    $scope.tableParams = new NgTableParams({
        sorting: {
            id: 'desc'
        },
    }, {
        getData: function(params) {
            return graduates.list(params.url())
                .$promise
                .then(function (data) {
                    params.total(data.count); // recal. page nav controls
                    return data.rows;
                });
        }
    });

    $scope.deleteGraduatePhoto = function(graduateId){
        bootbox.confirm('Видалити фото випускника?', function (result) {
            if(result){
                $http({
                    method: 'POST',
                    url: basePath+'/_teacher/_admin/graduate/deletePhoto/',
                    data: $jq.param({'id': graduateId}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).success(function(){
                    bootbox.alert('Операцію виконано успішно.');
                    location.hash = '/graduate';
                }).error(function(){
                    bootbox.alert('Операцію не вдалося виконати.');
                })
            }
            else{
                bootbox.alert('Операцію відмінено.')
            }
        })
    };
    $scope.deleteGraduate = function(graduateId){
        bootbox.confirm('Видалити випускника?', function (result) {
            if(result){
                $http({
                    method: 'POST',
                    url: basePath+'/_teacher/_admin/graduate/delete/',
                    data: $jq.param({'id': graduateId}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).success(function(response){
                    bootbox.alert(response);
                    location.hash = '/graduate';
                }).error(function(){
                    bootbox.alert('Операцію не вдалося виконати.');
                })
            }
            else{
                bootbox.alert('Операцію відмінено.')
            }
        })
    };

    $scope.changeGraduateStatus = function (item) {
        bootbox.confirm('Змінити статус публікації відгуку на сайті?', function (result) {
            if(result){
                $http({
                    method: 'POST',
                    url: basePath+'/_teacher/graduate/changeStatus/',
                    data: $jq.param({'id': item.id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).success(function(response){
                    item.published = !item.published;
                }).error(function(){
                    bootbox.alert('Операцію не вдалося виконати.');
                })
            }
        })
    };

    $scope.updateGraduate = function () {
        
        $http({
            method:'POST',
            url: basePath+'/_teacher/graduate/updateGraduate',
            data: $httpParamSerializerJQLike({'Graduate':$scope.graduate}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).success(function (response) {
            if (typeof response === 'object'){
                $scope.errors = response.errors;
                bootbox.alert(JSON.stringify($scope.errors));
                return false;
            }
            else{
                $state.go('graduate');
            }
        })
    }

    $scope.addRating = function (type, data) {
        $scope.customDialogButtons = {
            success: {
                label: "Застосувати!",
                className: "btn-success",
                callback: function() {
                    alert();
                }
            }
        };
        $scope.customDialogOptions = {
            templateUrl: '/angular/js/teacher/templates/addRate.html',
            scope: data,
            title: 'The title!',
            buttons: $scope.customDialogButtons
        };
        $ngBootbox.customDialog($scope.customDialogOptions);
    };

    $scope.getRatingScale = function () {
        return new Array(10);
    }

}
