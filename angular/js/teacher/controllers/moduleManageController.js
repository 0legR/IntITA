/**
 * Created by adm on 08.08.2016.
 */
angular
    .module('teacherApp')
    .controller('modulemanageCtrl',modulemanageCtrl)
    .controller('createModuleCtrl',createModuleCtrl)
    .controller('updateModuleCtrl',updateModuleCtrl);

function modulemanageCtrl ($scope, $http, NgTableParams, $resource, $rootScope){
    $scope.selectedTeacher=null;

    var dataFromServer = $resource(basePath+'/_teacher/_admin/module/getModulesList');
    $scope.modulesTable = new NgTableParams({
        sorting:{'module_ID':"asc"}}, {
        getData: function(params) {
            return dataFromServer.get(params.url()).$promise.then(function(data) {
                params.total(data.count);
                return data.rows;
            });
        }
    });

    $scope.statuses = [{id:'0', title:'в розробці'},{id:'1', title:'готовий'}];
    $scope.cancelled = [{id:'0', title:'доступний'},{id:'1', title:'видалений'}];
    $scope.levels = $resource(basePath+'/_teacher/_admin/level/getlevelslist').get()
                   .$promise.then(function(data){
                    var levels = [];
                    data.rows.forEach(function(element){
                        levels.push({
                            'id': element.id,
                            'title': element.title_ua
                       })
                    });
                    return levels;
        });
    $scope.addTeacher = function(moduleId, role, userId){
        $http({
            method: "POST",
            url:  basePath+"/_teacher/_admin/teachers/setTeacherRoleAttribute",
            data: $jq.param({"user":userId, "role":role, "attribute":"module", "attributeValue":moduleId }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
        }).success(function(response){
            if (response == "success") {
                bootbox.alert("Операцію успішно виконано.", function () {
                        switch (role) {
                            case "trainer":
                                break;
                            case "author":
                                location.hash = "module/view/"+moduleId;
                                break;
                            case "consultant":
                                location.hash = "module/view/"+moduleId;
                                break;
                            case "teacher_consultant":
                                break;
                        }
                }
                )}
            else {
                switch (role) {
                    case "trainer":
                        showDialog(response);
                        break;
                    case "author":
                        showDialog("Обраний модуль вже присутній у списку модулів даного викладача");
                        break;
                    case "consultant":
                        showDialog("Консультанту вже призначений даний модуль для консультацій");
                        break;
                    case "teacher_consultant":
                        showDialog("Обраний модуль вже присутній у списку модулів даного викладача");
                        break;
                    default:
                        showDialog("Операцію не вдалося виконати");
                        break;
                }
                }
        })
    };

    $scope.getTeachers = function(value) {
            return $http.get(basePath+'/_teacher/_admin/module/teachersByQuery', {
            params: {
                query: value
            }
        }).then(function(response){
            if (response.data.results)
                return response.data.results.map(function(item){
                    console.log(item);
                    return item;
                });
        });
    };

    $scope.onSelect = function ($item) {
        $scope.selectedTeacher = $item;
        console.log($item);
    };

    $scope.changeStatus = function(moduleId, status){
        var url;
        switch (status){
            case 'delete':
                url = basePath+'/_teacher/_admin/module/delete/id/'+moduleId;
                break;
            case 'restore':
                url = basePath+'/_teacher/_admin/module/restore/id/'+moduleId;
                break;
        }
        bootbox.confirm("Ви впевнені?", function (result) {
            if(result){
                $http({
                    method: "POST",
                    url:  url,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'},
                }).success(function(message){
                    bootbox.alert(message);
                    location.hash = '/module/view/'+moduleId;
                }).error(function(){
                    bootbox.alert("Операцію не вдалося виконати.");
                })
            }
            else
            {
                bootbox.alert("Операцію відмінено");
            }
        })
    };
    
    //add module tags
    $scope.checkTags = function() {
        moduleTags=$rootScope.moduleTags;
    };
    
    $scope.languages = [
        {name: 'українською', value: 'ua'},
        {name: 'російською', value: 'ru'},
        {name: 'англійською', value: 'en'}
    ];

    //manipulations with module tags
    $scope.tagsList = function() {
        var promise = $http({
            url: basePath+'/module/getTagsList',
            method: "POST",
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $scope.allTags=response.data;
            $scope.tags=response.data;
        }, function errorCallback() {
            bootbox.alert('Виникла помилка при завантажені хмарини тегів');
            return false;
        });
        return promise;
    };
}
function createModuleCtrl ($scope, $rootScope){
    $rootScope.moduleTags=[];
    $scope.tagsList();
    $scope.tagsLoaded=true;

    $scope.addTag = function(tag,index) {
        $rootScope.moduleTags.push({id: tag.id, tag: tag.tag});
        $scope.tags.splice(index, 1);
    };
    $scope.removeTag = function(tag,index) {
        $scope.tags.push({id: tag.id, tag: tag.tag});
        $rootScope.moduleTags.splice(index, 1);
    };
}

function updateModuleCtrl ($scope,$http, $rootScope){
    $scope.tagsList().then(function successCallback() {
        $http({
            url: basePath+'/module/getModuleTags',
            method: "POST",
            data: $jq.param({"idModule":$scope.moduleId }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            $rootScope.moduleTags = response.data;
            $.each($rootScope.moduleTags, function(indexModuleTag) {
                $.each($scope.allTags, function(indexTag) {
                    if($scope.allTags[indexTag]['id']==$rootScope.moduleTags[indexModuleTag]['id']){
                        $scope.allTags.splice(indexTag, 1);
                        return false;
                    }
                });
            });
            $scope.tagsLoaded=true;
        }, function errorCallback() {
            bootbox.alert('Виникла помилка при завантажені хмарини тегів');
            return false;
        });
    });

    $scope.addTag = function(tag,index) {
        $rootScope.moduleTags.push({id: tag.id, tag: tag.tag});
        $scope.tags.splice(index, 1);
    };
    $scope.removeTag = function(tag,index) {
        $scope.tags.push({id: tag.id, tag: tag.tag});
        $rootScope.moduleTags.splice(index, 1);
    };
}