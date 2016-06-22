angular
    .module('moduleRevisionsApp')
    .controller('moduleRevisionCtrl',moduleRevisionCtrl);

function moduleRevisionCtrl($rootScope,$scope, $http, getModuleData, moduleRevisionsActions) {
    $scope.tempId=[];
    //load from service lecture data for scope
    getModuleData.getData(idRevision).then(function(response){
        $rootScope.moduleData=response;
        $scope.lectureInModule=$rootScope.moduleData.lectures;
        getModuleData.getApprovedLecture().then(function(response){
            $scope.approvedLecture=response;
            if($scope.approvedLecture.current){
                $.each($scope.approvedLecture.current, function(index) {
                    $.each($scope.lectureInModule, function(indexInModule) {
                        if($scope.lectureInModule[indexInModule]['id_lecture_revision']==$scope.approvedLecture.current[index]['id_lecture_revision']){
                            $scope.tempId.push($scope.lectureInModule[indexInModule]['id_lecture_revision']);
                            return false;
                        }
                    });
                });
                $scope.approvedLecture.current = $scope.approvedLecture.current.filter(function(value) {
                    return !find($scope.tempId,value.id_lecture_revision)
                });
            }
        });
    });

    //find exist value in array or not
    function find(array, value) {

        for (var i = 0; i < array.length; i++) {
            if (array[i] == value) return true;
        }

        return false;
    }


    $scope.addRevisionToModuleFromCurrentList = function (lectureRevisionId, index) {
        var revision=$scope.approvedLecture.current[index];
        revision.list='current';
        $scope.approvedLecture.current.splice(index, 1);
        $scope.lectureInModule.push(revision);
    };
    $scope.addRevisionToModuleFromForeignList= function (lectureRevisionId, index) {
        var revision=$scope.approvedLecture.foreign[index];
        revision.list='foreign';
        $scope.approvedLecture.foreign.splice(index, 1);
        $scope.lectureInModule.push(revision);
    };
    
    $scope.removeRevisionFromModule= function (lectureRevisionId, index) {
        var revision=$scope.lectureInModule[index];
        $scope.lectureInModule.splice(index, 1);
        if(revision.list=='foreign'){
            $scope.approvedLecture.foreign.push(revision);
        }else{
            if($scope.approvedLecture.current){
                $scope.approvedLecture.current.push(revision);
            }
        }
    };
    //reorder pages
    $scope.upRevisionInModule = function(lectureRevisionId, index) {
        if(index>0){
            var prevRevision=$scope.lectureInModule[index-1];
            $scope.lectureInModule[index-1]=$scope.lectureInModule[index];
            $scope.lectureInModule[index]=prevRevision;
        }
    };
    $scope.downRevisionInModule = function(lectureRevisionId, index) {
        if(index<$scope.lectureInModule.length-1){
            var nextRevision=$scope.lectureInModule[index+1];
            $scope.lectureInModule[index+1]=$scope.lectureInModule[index];
            $scope.lectureInModule[index]=nextRevision;
        }
    };

    $scope.editModuleRevision = function (lectureList) {
        if($scope.enabled!=false){
            $scope.enabled=false;
            var object = {};
            lectureList.forEach(function (item, index) {
                object[item.id_lecture_revision] = {
                    id_lecture_revision: item.id_lecture_revision,
                    lecture_order: index + 1
                };
            });
            $http({
                url: basePath + '/moduleRevision/editModuleRevision',
                method: "POST",
                data: $.param({moduleLectures: JSON.stringify(object), id_module_revision: idRevision}),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
            }).then(function successCallback() {
                bootbox.alert("Зміни збережено", function () {
                    location.reload();
                });
                $scope.enabled=true;
            }, function errorCallback() {
                bootbox.alert("Зберегти зміни в ревізію не вдалося. Зв'яжіться з адміністрацією");
                $scope.enabled=true;
                return false;
            });
        }
    };
    $scope.previewModuleRevision = function(url) {
        location.href=url;
    };
    //edit revision
    $scope.editModuleRevisionPage = function(url) {
        location.href=url;
    };
    //approve revision
    $scope.approveModuleRevision = function(id) {
        moduleRevisionsActions.approveModuleRevision(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
            });
        });
    };
    //send revision for approve
    $scope.sendModuleRevision = function(id, redirect) {
        moduleRevisionsActions.sendModuleRevision(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
                if(redirect){
                    location.href=basePath+'/moduleRevision/previewModuleRevision?idRevision='+idRevision;
                }
            });
        });
    };
    //canceled edit revision by the editor
    $scope.cancelModuleEditByEditor = function(id, redirect) {
        moduleRevisionsActions.cancelModuleEditByEditor(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
                if(redirect){
                    location.href=basePath+'/moduleRevision/previewModuleRevision?idRevision='+idRevision;
                }
            });
        });
    };

    $scope.cancelSendModuleRevision = function(id) {
        moduleRevisionsActions.cancelSendModuleRevision(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
            });
        });
    };

    $scope.cancelModuleRevision = function(id) {
        moduleRevisionsActions.cancelModuleRevision(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
            });
        });
    };

    $scope.rejectModuleRevision = function(id) {
        moduleRevisionsActions.rejectModuleRevision(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
            });
        });
    };

    $scope.releaseModuleRevision = function(id) {
        if($scope.enabled!=false) {
            $scope.enabled = false;
            moduleRevisionsActions.releaseModuleRevision(id).then(function () {
                $scope.enabled=true;
                getModuleData.getData(idRevision).then(function (response) {
                    $rootScope.moduleData = response;
                });
            });
        }
    };

    $scope.restoreModuleEditByEditor = function(id) {
        moduleRevisionsActions.restoreModuleEditByEditor(id).then(function(){
            getModuleData.getData(idRevision).then(function(response) {
                $rootScope.moduleData = response;
            });
        });
    };

    $scope.checkModuleRevision = function() {
        $http({
            url: basePath+'/moduleRevision/checkModuleRevision',
            method: "POST",
            data: $.param({idRevision:idRevision}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
        }).then(function successCallback(response) {
            bootbox.alert(response.data);
        }, function errorCallback(response) {
            console.log('checkLecture error');
            console.log(response);
            return false;
        });
    };
}
