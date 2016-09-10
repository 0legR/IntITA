'use strict';

/* Services */

angular
    .module('teacherApp')
    .factory('invoicesService', ['$resource',
    function ($resource) {
        var url = basePath+'/_teacher/_accountant/invoices';
        return $resource(
            url,
            {},
            {
                list: {
                    url : url + '/getInvoices',
                    method: 'GET'
                },
                typeahead: {
                    url: url + '/getTypeahead',
                    params: {
                        query : 'query'
                    },
                    isArray:true
                },
                getByParams: {
                    url: url + '/getInvoicesByParams'
                }
            });
    }]);
