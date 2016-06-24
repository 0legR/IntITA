/**
 * Created by Wizlight on 03.11.2015.
 */
angular
    .module('moduleRevisionsApp')
    .controller('courseModulesRevisionsCtrl',courseModulesRevisionsCtrl);

function courseModulesRevisionsCtrl($rootScope,$scope, modulesRevisionsTree, moduleRevisionsActions) {
    $scope.formData = {};
    modulesRevisionsTree.getModuleRevisionsAuthors().then(function(response){
        $scope.authors=response;
        $scope.authors.unshift({authorName:"Всі автори", id:"0"});
        $scope.selectedAuthor = $scope.authors[0];
    });
    //load current modules from main BD
    modulesRevisionsTree.getCurrentModules(idCourse).then(function (response) {
        $scope.currentModules = response;
    });

    //init tree after load json
    modulesRevisionsTree.getModuleRevisionsInCourse(idCourse).then(function(response){
        $rootScope.revisionsJson=response;
        $scope.revisionsTreeInit();
    });
    //init actions for revision tree
    var approverActions=[{
        "type": "button",
        "actionType": "approve",
        "title": "Затвердити",
        "visible": true,
        "userId":userId,
        "action": function(event) {
            var idRevision = $(event.data.el).attr('id');
            var nodeId = $(event.data.el).attr('data-nodeid');
            $scope.approveModuleRev(idRevision, nodeId);
        }
    },
        {
            "type": "button",
            "actionType": "reject",
            "title": "Відхилити",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.rejectModuleRev(idRevision, nodeId);
            }
        },
        {
            "type": "button",
            "actionType": "cancel",
            "title": "Скасувати",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.cancelModuleRev(idRevision, nodeId);
            }
        },
        {
            "type": "button",
            "actionType": "release",
            "title": "Реліз",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.releaseModuleRev(idRevision, nodeId);
            }
        }
    ];
    var authorActions=[
        {
            "type": "button",
            "title": "Переглянути ревізії даного модуля",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                $scope.openModuleRevisionsBranch(idRevision);
            }
        },
        {
            "type": "button",
            "title": "Створити нову ревізію",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                $scope.createModuleRev(idRevision);
            }
        },
        {
            "type": "button",
            "title": "Переглянути",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                $scope.previewModuleRev(idRevision);
            }
        },
        {
            "type": "button",
            "title": "Написати автору ревізії модуля",
            "visible": true,
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                $scope.sendModuleRevisionMessage(idRevision);
            }
        }
    ];
    var generalActions=[
        {
            "type": "button",
            "actionType": "edit",
            "title": "Редагувати",
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                $scope.editModuleRev(idRevision);
            }
        },
        {
            "type": "button",
            "actionType": "send",
            "title": "Відправити на затвердження",
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.sendModuleRev(idRevision, nodeId);
            }
        },
        {
            "type": "button",
            "actionType": "cancelSend",
            "title": "Скасувати відправлення на затвердження",
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.cancelSendModuleRev(idRevision, nodeId);
            }
        },
        {
            "type": "button",
            "actionType": "cancelEdit",
            "title": "Скасувати автором",
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.cancelEditModuleRev(idRevision, nodeId);
            }
        },
        {
            "type": "button",
            "actionType": "restoreEdit",
            "title": "Відновити автором",
            "userId":userId,
            "action": function(event) {
                var idRevision = $(event.data.el).attr('id');
                var nodeId = $(event.data.el).attr('data-nodeid');
                $scope.restoreEditModuleRev(idRevision, nodeId);
            }
        },
    ];
    if(isApprover){
        var actions=approverActions.concat(authorActions, generalActions);
    }else{
        var actions=authorActions.concat(generalActions);
    }

    //init buttons
    $rootScope.addButtonsNg= function(treeData) {
        var treeButtons = {
            "title": "Дії",
            "actions": actions
        };

        $.each(treeData, function(k, v) {
            v['ddbutton'] = treeButtons;

            if (v['nodes']) {
                $rootScope.addButtonsNg(v['nodes']);
            }
        });
    };

    //edit revision status
    $scope.sendModuleRev = function(id,nodeId) {
        moduleRevisionsActions.sendModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
        });
    };
    $scope.cancelSendModuleRev = function(id,nodeId) {
        moduleRevisionsActions.cancelSendModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
        });
    };
    $scope.approveModuleRev = function(id,nodeId) {
        moduleRevisionsActions.approveModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
            modulesRevisionsTree.getCurrentModules(idModule).then(function (response) {
                $scope.currentLectures = response;
            });
        });
    };
    $scope.rejectModuleRev = function(id,nodeId) {
        moduleRevisionsActions.rejectModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
        });
    };
    $scope.cancelModuleRev = function(id,nodeId) {
        moduleRevisionsActions.cancelModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
            modulesRevisionsTree.getCurrentModules(idModule).then(function (response) {
                $scope.currentLectures = response;
            });
        });
    };
    $scope.releaseModuleRev = function(id,nodeId) {
        moduleRevisionsActions.releaseModuleRevision(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
            modulesRevisionsTree.getCurrentModules(idModule).then(function (response) {
                $scope.currentLectures = response;
            });
        });
    };
    $scope.cancelEditModuleRev = function(id,nodeId) {
        moduleRevisionsActions.cancelModuleEditByEditor(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
            modulesRevisionsTree.getCurrentModules(idModule).then(function (response) {
                $scope.currentLectures = response;
            });
        });
    };
    $scope.restoreEditModuleRev = function(id,nodeId) {
        moduleRevisionsActions.restoreModuleEditByEditor(id).then(function(){
            $scope.updateModuleRevisionsTreeInCourse(nodeId);
            modulesRevisionsTree.getCurrentModules(idModule).then(function (response) {
                $scope.currentLectures = response;
            });
        });
    };
    //update module revisions tree
    $scope.updateModuleRevisionsTreeInCourse = function(nodeId){
        if($scope.allRevision || $scope.formData.revisionFilter=='undefined' || isEmptyFilter($scope.formData.revisionFilter) && $scope.selectedAuthor.id==0){
            modulesRevisionsTree.getModuleRevisionsInCourse(idCourse).then(function(response){
                $rootScope.revisionsJson=response;
                $scope.treeUpdate(nodeId);
            });
        }else{
            modulesRevisionsTree.revisionTreeFilterInCourse(idCourse,$scope.formData, $scope.selectedAuthor.id).then(function (response) {
                $rootScope.revisionsJson=response;
                $scope.treeUpdate(nodeId);
            });
        }
    };

    $scope.updateTree = function() {
        modulesRevisionsTree.getModuleRevisionsInCourse(idCourse).then(function (response) {
            $rootScope.revisionsJson = response;
            $scope.revisionsTreeInit();
        });
    };

    $scope.revisionFilter=function () {
        if($scope.allRevision || $scope.formData.revisionFilter=='undefined' || isEmptyFilter($scope.formData.revisionFilter) && $scope.selectedAuthor.id==0){
            $scope.updateTree();
        }else{
            modulesRevisionsTree.revisionTreeFilterInCourse(idCourse,$scope.formData, $scope.selectedAuthor.id).then(function (response) {
                $rootScope.revisionsJson=response;
                $scope.treeUpdate();
            });
        }
    };

    function isEmptyFilter(obj) {
        for (var key in obj) {
            if(obj[key])
                return false;
        }
        return true;
    }
}
