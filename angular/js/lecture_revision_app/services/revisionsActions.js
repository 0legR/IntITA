angular
    .module('revisionTreesApp')
    .service('revisionsActions', [
        '$http',
        function($http) {
            this.sendRevision = function(id) {
                var promise = $http({
                    url: basePath+'/revision/sendForApproveLecture',
                    method: "POST",
                    data: $.param({idRevision: id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    if(response.data!='') bootbox.alert(response.data);
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Відправити заняття на затвердження не вдалося. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.cancelSendRevision = function(id,nodeId) {
                var promise = $http({
                    url: basePath+'/revision/cancelSendForApproveLecture',
                    method: "POST",
                    data: $.param({idRevision: id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Відмінити відправлення заняття на затвердження не вдалося. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.approveRevision = function(id,nodeId) {
                var promise = $http({
                    url: basePath+'/revision/approveLectureRevision',
                    method: "POST",
                    data: $.param({idRevision: id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Затвердити заняття не вдалося. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.rejectRevision = function(id,nodeId) {
                var promise = $http({
                    url: basePath+'/revision/rejectLectureRevision',
                    method: "POST",
                    data: $.param({idRevision: id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Відхилити відправку на затвердження не вдалося. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.cancelRevision = function(id,nodeId) {
                var promise = $http({
                    url: basePath+'/revision/cancelLectureRevision',
                    method: "POST",
                    data: $.param({idRevision: id}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Скасувати заняття не вдалося. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
        }
    ]);