"use strict";

angular
  .module('teacherApp')
  .directive('companyOneRepresentative', [
    'companiesService',
    'ngToast',
    companyOneRepresentative]);

function companyOneRepresentative(companiesService, ngToast) {
  function link($scope, element, attrs) {
    $scope.datePopup = {
      credentialsTo: false,
      credentialsFrom: false
    };
    $scope.representative = {};
    $scope.toggleDPPopup = toggleDPPopup;

    if ($scope.companyId && $scope.representativeId) {
      companiesService
        .representatives({companyId: $scope.companyId, representativeId: $scope.representativeId})
        .$promise
        .then(function (data) {
          if (data.rows.length) {
            $scope.representative = setupModel(data.rows[0]);
          } else {
            dangerToast('Помилка завантаження данних');
          }
        })
        .catch(function () {
            dangerToast('Помилка завантаження данних');
        });
    }

    $scope.save = function() {
      companiesService
        .saveRepresentative($scope.representative)
        .$promise
        .then(function(response) {
          successToast('Дані збережено');
        })
        .catch(function (error) {
          console.error(error);
          dangerToast('Виникла помилка')
        });
    };

    $scope.revokeCredentials = function() {

    };

    function toggleDPPopup(name) {
      $scope.datePopup[name] = !$scope.datePopup[name];
    }

    function toast(type, message) {
      ngToast.create({
        dismissOnTimeout: true,
        dismissButton: true,
        className: type,
        content: message
      });
    }

    function dangerToast(message) {
      toast('danger', message);
    }

    function successToast(message) {
      toast('success', message);
    }

    function setupModel(data) {
      return {
        representativeId : data.id,
        companyId : data.corporateEntity[0].id,
        full_name: data.full_name,
        full_name_accusative: data.full_name_accusative,
        full_name_short: data.full_name_short,
        representative_order: Number(data.corporateEntityRepresentatives[0].representative_order),
        position: data.corporateEntityRepresentatives[0].position,
        position_accusative: data.corporateEntityRepresentatives[0].position_accusative,
        createdAt: new Date(data.corporateEntityRepresentatives[0].createdAt),
        deletedAt: new Date(data.corporateEntityRepresentatives[0].deletedAt)
      };
    }
  }

  return {
    scope: {
      'companyId': '=companyId',
      'representativeId': '=representativeId'
    },
    link: link,
    templateUrl: basePath + '/angular/js/teacher/templates/accountancy/company/oneRepresentative.html'
  }
}