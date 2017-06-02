/**
 * Created by adm on 10.08.2016.
 */
angular
    .module('teacherApp')
    .controller('graduateCtrl',graduateCtrl);

function graduateCtrl ($scope, $http, graduates, NgTableParams, typeAhead  ){


    $scope.addGraduate = function () {
        alert();
    }

    $scope.getAllUsersByOrganization = function (value) {
        $scope.newGraduate = "";

        $scope.newGraduate.user =  $http.get(basePath+"/_teacher/graduate/getusers?q="+value).success(function (response) {
            console.log(response);
        })
        console.log($scope.newGraduate.user);
    }

    $scope.tableParams = new NgTableParams({}, {
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
                bootbox.confirm('Операцію відмінено.')
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
                bootbox.confirm('Операцію відмінено.')
            }
        })
    };
}
