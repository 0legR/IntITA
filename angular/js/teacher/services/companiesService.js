'use strict';

/* Services */

angular
  .module('teacherApp')
  .factory('companiesService', ['$resource', 'transformRequest',
    function ($resource, transformRequest) {
      var url = basePath + '/_teacher/_accountant/company';
      return $resource(
        '',
        {},
        {
          list: {
            url: url + '/list',
            method: "GET"
          },
          get: {
            url: url + '/viewCompany',
            method: "GET"
          },
          upsert: {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded;charset=utf-8;'},
            transformRequest: transformRequest.bind(null),
            url: url + '/upsert'
          }
        });
    }]);
