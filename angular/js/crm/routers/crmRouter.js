/**
 * Created by adm on 16.07.2016.
 */
angular
    .module('crmRouter',['ui.router'])
    .config(function ($stateProvider) {
        $stateProvider
            .state('tasks', {
                url: "/tasks",
                cache: false,
                templateUrl: basePath+"/_teacher/crm/_tasks/tasks/index",
            })
            .state('task/:id', {
                url: "/task/:id",
                cache: false,
                templateUrl: function ($stateParams) {
                    return basePath+"/_teacher/crm/_tasks/tasks/view/?id="+$stateParams.id;
                }
            })
            .state('task_clone/:id', {
                url: "/task_clone/:id",
                cache: false,
                templateUrl: function ($stateParams) {
                    return basePath+"/_teacher/crm/_tasks/tasks/viewClone/?id="+$stateParams.id;
                }
            })
            .state('tasks.executant', {
                url: '/executant',
                views: {
                    'usersTasks': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/tasks",
                    }
                }
            })
            .state('tasks.collaborator', {
                url: '/collaborator',
                views: {
                    'usersTasks': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/tasks",
                    }
                }
            })
            .state('tasks.producer', {
                url: '/producer',
                views: {
                    'usersTasks': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/tasks",
                    }
                }
            })
            .state('tasks.observer', {
                url: '/observer',
                views: {
                    'usersTasks': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/tasks",
                    }
                }
            })
            .state('tasks.all', {
                url: '/all',
                views: {
                    'usersTasks': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/tasks",
                    }
                }
            })
            .state('tasksManager', {
                url: '/tasksManager',
                templateUrl: basePath+"/_teacher/crm/_tasks/tasks/manager",
            })
            .state('tasksManager.created', {
                url: '/created',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/createdEvents",
                    }
                }
            })
            .state('tasksManager.updated', {
                url: '/updated',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/updatedEvents",
                    }
                }
            })
            .state('tasksManager.changed', {
                url: '/changed',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/changedEvents",
                    }
                }
            })
            .state('tasksManager.commented', {
                url: '/commented',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/commentedEvents",
                    }
                }
            })
            .state('tasksManager.set_role', {
                url: '/set_role',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/setRoleEvents",
                    }
                }
            })
            .state('tasksManager.all', {
                url: '/all',
                views: {
                    'managerEvents': {
                        templateUrl: basePath+"/_teacher/crm/_tasks/tasks/allEvents",
                    }
                }
            })
    });