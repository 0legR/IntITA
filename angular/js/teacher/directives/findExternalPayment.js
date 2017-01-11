"use strict";

angular
    .module('teacherApp')
    .directive('findExternalPayment', ['externalPaymentsService', 'lodash', addExternalPayment]);

function addExternalPayment(externalPayments, _) {

    function link($scope, element, attrs) {
        $scope.getExternalPaymentTypeahead = function (value) {
            return externalPayments
                .typeahead({
                    query: value
                })
                .$promise
        };

        $scope.formatLabel = function (item) {
            if(item){
                var name=item.payerName?item.payerName:'';
                var id=item.payerId?item.payerId:'';
                return item ? '№' + item.documentNumber + ' від ' + item.documentDate + ' (сума ' + item.amount + ' грн) '+name+' '+id : null;
            }
        };

        $scope.onSelect = function onSelect($item, $model, $label, $event) {
            externalPayments
                .getById({id:$model.id})
                .$promise
                .then(function (data) {
                    data.amount=Number(data.amount);
                    _.assignIn($scope.document, data);
                })
        };
    }

    return {
        scope: {
            'document': '=document'
        },
        link: link,
        templateUrl: basePath+'/angular/js/teacher/templates/accountancy/findExternalPayment.html'
    }
}