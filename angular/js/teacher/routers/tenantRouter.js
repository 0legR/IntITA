/**
 * Created by adm on 26.07.2016.
 */
angular
    .module('tenantRouter',['ui.router']).
config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
    $stateProvider
        .state('tenant', {
            url: "/tenant",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Tenant');
            },
            templateUrl: "/_teacher/cabinet/loadPage/?page=tenant",
        })
        .state('tenant/bots', {
            url: "/tenant/bots",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Боти');
            },
            templateUrl: "/_teacher/_tenant/tenant/Bots",
        })
        .state('tenant/chats', {
            url: "/tenant/chats",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Розмови');
            },
            templateUrl: "/_teacher/_tenant/tenant/SearchChats",
        })
        .state('tenant/phrases', {
            url: "/tenant/phrases",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Типові фрази');
            },
            templateUrl: "/_teacher/_tenant/tenant/showPhrases",
        })
        .state('tenant/phrases/create', {
            url: "/tenant/phrases/create",
            cache         : false,
            controller: function($scope){
                $scope.changePageHeader('Створити фразу');
            },
            templateUrl: "/_teacher/_tenant/tenant/renderAddPhrase",
        })
        .state('tenant/searchchat/:user1/:user2', {
            url: "/tenant/searchchat/:user1/:user2",
            cache         : false,
            templateUrl: function($stateParams){
                return "/_teacher/_tenant/tenant/ShowChats?author="+$stateParams.user1+"&user="+$stateParams.user2; }
        })

});

