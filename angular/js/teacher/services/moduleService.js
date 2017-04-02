'use strict';

/* Services */

angular
    .module('teacherApp')
    .factory('moduleService', ['$resource',
        function ($resource) {
            var url = basePath+'/module';
            return $resource(
                '',
                {},
                {
                    typeahead: {
                        url: url + '/getTypeahead',
                        isArray:true
                    },
                    updateModulePrice: {
                        url: basePath + '/_teacher/_admin/module/updateModulePrice',
                        method: 'GET',
                    },
                });
        }]);
