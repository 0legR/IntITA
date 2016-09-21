/**
 * Created by Quicks on 15.12.2015.
 */
angular
    .module('teacherApp', [
        'datatables',
        'ui.bootstrap',
        'ngBootbox',
        'directive.loading',
        'ngResource',
        'ngTable',
        'angular-loading-bar',
        'freeLecturesRouter',
        'messagesRouter',
        'cabinetRouter', 
        'adminRouter',
        'authorRouter',
        'consultantRouter',
        'teacherConsultantRouter',
        'trainerRouter',
        'studentRouter',
        'tenantRouter',
        'accountantRouter',
        'contentManagerRouter',
        'modulesRouter',
        'graduatesRouter',
        'sharedLinksRouter',
        'responseRouter',
        'interfaceMessagesRouter',
        'siteConfigRouter',
        'requestsRouter'
    ])
    .filter('shortDate', [
            '$filter', function($filter) {
                    return function(input, format) {
                            return $filter('date')(new Date(input), format);
                    };
            }
    ])
    .run(['$rootScope', '$templateCache','$state',
            function ($rootScope, $templateCache, $state) {

                    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
                            $templateCache.remove(fromState.templateUrl);
                            if (typeof($state.current) !== 'undefined'){
                                    // $templateCache.removeAll();
                            }
                    });
            }]);