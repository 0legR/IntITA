angular
    .module('revisionTreesApp')
    .service('revisionsTree', [
        '$http',
        function($http) {
            this.getCurrentLectures = function (idModule) {
                var promise = $http({
                    url: basePath + '/revision/buildCurrentLectureJson',
                    method: "POST",
                    data: $.param({idModule: idModule}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені списку актуальних занять модуля. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.getLectureRevisionsInModuleJson  = function(idModule) {
                var promise = $http({
                    url: basePath+'/revision/buildRevisionsInModule',
                    method: "POST",
                    data: $.param({idModule: idModule}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені списку ревізій модуля. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.getRevisionsBranch  = function(idRevision) {
                var promise = $http({
                    url: basePath+'/revision/buildRevisionsBranch',
                    method: "POST",
                    data: $.param({idRevision: idRevision}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені списку ревізій заняття. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.getAllRevisionsJson = function() {
                var promise = $http({
                    url: basePath+'/revision/buildAllRevisions',
                    method: "POST",
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені списку ревізій. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };

            this.getApprovedBranchRevisions  = function(idRevision) {
                var promise = $http({
                    url: basePath+'/revision/buildApprovedLectureRevisions',
                    method: "POST",
                    data: $.param({idRevision: idRevision}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені затвердженої гілки ревізії. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
            this.getApprovedBranchPartInModule  = function(idModule) {
                var promise = $http({
                    url: basePath+'/revision/buildApprovedBranchPartInModule',
                    method: "POST",
                    data: $.param({idModule: idModule}),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    return response.data;
                }, function errorCallback() {
                    bootbox.alert("Виникла помилка при завантажені затверджених ревізій. Зв'яжіться з адміністрацією");
                    return false;
                });
                return promise;
            };
        }
    ]);