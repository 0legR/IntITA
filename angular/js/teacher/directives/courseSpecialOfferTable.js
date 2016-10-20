"use strict";

angular
    .module('teacherApp')
    .directive('courseSpecialOfferTable', ['paymentSchemaService', 'NgTableParams', courseSpecialOfferTable]);

function courseSpecialOfferTable(paymentSchema, NgTableParams) {

    function link($scope, element, attrs) {

        $scope.courseSpecialOfferTable = new NgTableParams({}, {
            getData: function (params) {
                return paymentSchema
                    .courseList(params.url())
                    .$promise
                    .then(function (data) {
                        params.total(data.count);
                        return data.rows;
                    });
            }
        });

    }

    return {
        link: link,
        templateUrl: basePath+'/angular/js/teacher/templates/accountancy/courseSpecialOffersTable.html'
    }
}

