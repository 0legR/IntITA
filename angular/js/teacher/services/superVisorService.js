'use strict';

/* Services */

angular
    .module('teacherApp')
    .factory('superVisorService', ['$resource',
        function ($resource) { 
            var url = basePath+'/_teacher/_supervisor/superVisor';
            return $resource(
                '',
                {},
                {
                    offlineGroupsList: {
                        url: url + '/getOfflineGroupsList',
                        method: 'GET',
                    },
                    offlineSubgroupsList: {
                        url: url + '/getOfflineSubgroupsList',
                        method: 'GET',
                    },
                    offlineStudentsList: {
                        url: url + '/getOfflineStudentsList',
                        method: 'GET',
                    },
                    studentsWithoutGroupList: {
                        url: url + '/getStudentsWithoutGroupList',
                        method: 'GET',
                    },
                    offlineGroupSubgroupsList: {
                        url: url + '/getGroupsOfflineSubgroupsList',
                        method: 'GET',
                    },
                    getSpecializationsList: {
                        url: url + '/getSpecializationsList',
                        isArray:true
                    },
                    usersList: {
                        url: url + '/getUsersList',
                        method: 'GET',
                    },
                    studentsList: {
                        url: url + '/getStudentsList',
                        method: 'GET',
                    },
                    courseAccessList: {
                        url: url + '/getCourseAccessList',
                        method: 'GET',
                    },
                    moduleAccessList: {
                        url: url + '/getModuleAccessList',
                        method: 'GET',
                    },
                    subgroupData: {
                        url: url + '/getSubgroupData',
                        method: 'GET',
                    },
                    groupData: {
                        url: url + '/getGroupData',
                        method: 'GET',
                    },
                });
        }]);