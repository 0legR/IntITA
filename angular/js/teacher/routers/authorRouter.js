/**
 * Created by adm on 26.07.2016.
 */
angular
    .module('authorRouter',['ui.router']).
config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
    $stateProvider
        .state('author', {
            url: "/author",
            cache         : false,
            templateUrl: basePath+"/_teacher/cabinet/loadPage/?page=author",
            controller: function($scope){
                $scope.changePageHeader('Автор');
            },
        })
        .state('author/modules', {
            url: "/author/modules",
            cache         : false,
            templateUrl: basePath+"/_teacher/_author/author/modules/id/"+user,
            controller: function($scope){
                $scope.changePageHeader('Модулі автора');
            },
        })
});
