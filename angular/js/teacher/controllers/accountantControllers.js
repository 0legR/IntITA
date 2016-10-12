/**
 * Created by adm on 19.07.2016.
 */

angular
    .module('teacherApp')
    .controller('agreementsCtrl', ['$scope', 'agreementsService', 'paymentSchemaService', 'NgTableParams',
        function ($scope, agreements, paymentSchema, NgTableParams) {
            $scope.agreementsTableParams = new NgTableParams({}, {
                getData: function (params) {
                    return agreements
                        .list(params.url())
                        .$promise
                        .then(function (data) {
                            params.total(data.count);
                            return data.rows;
                        });
                }
            });

            $scope.confirm = function (id) {
                return agreements
                    .confirm({id: id})
                    .$promise
                    .then(function (data) {
                        $scope.agreementsTableParams.reload();
                        return data;
                    });
            };

            $scope.cancel = function (id) {
                return agreements
                    .cancel({id: id})
                    .$promise
                    .then(function (data) {
                        $scope.agreementsTableParams.reload();
                        return data;
                    });
            };

            $scope.getSchemas = paymentSchema
                .query()
                .$promise
                .then(function (data) {
                    return data.map(function (item) {
                        return {id: item.id, title: item.name}
                    })
                });
        }])

    .controller('agreementDetailCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {
        $scope.agreementId = $stateParams.agreementId;
    }])

    .controller('invoiceDetailCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {
        $scope.invoiceId = $stateParams.invoiceId;
    }])

    .controller('invoicesCtrl', ['$scope', 'invoicesService', 'NgTableParams', function ($scope, invoicesService, NgTableParams) {
    }])

    .controller('operationCtrl', ['$scope', '$state', function ($scope, $state) {
        $scope.createOperation = function createOperation() {
            $state.go('accountant/operation/create');
        };
    }])

    .controller('createOperationCtrl', [
        '$scope',
        '$state',
        '$q',
        'lodash',
        'agreementsService',
        'invoicesService',
        'userService',
        'operationsService',
        'externalPaymentsService',
        function ($scope, $state, $q, _, agreements, invoices, user, operations, externalPayments) {

            $scope.typeaheadProviders = {
                user: {
                    name: 'користувачу',
                    searchField: 'email',
                    provider: user,
                    label: function (user) {
                        return user ? ((user.firstName || '' ) + ' ' + (user.middleName || '') + ' ' + (user.secondName || '') + ', ' + (user.email || '')) : '';
                    },
                    onSelect: function ($model) {
                        $scope.operation.userId = $model.id;
                        $scope.updateUserData({id: $scope.operation.userId});
                        $scope.updateAgreementData({'extraParams[user_id]': $scope.operation.userId})
                            .then(function (data) {
                                if (data && data.length) {
                                    $scope.operation.agreementId = data[0].id;
                                }
                            });
                    }
                },
                agreement: {
                    name: 'номеру договору',
                    searchField: 'number',
                    provider: agreements,
                    label: function (agreements) {
                        return agreements ? ((agreements.number || '') + ' від ' + (agreements.create_date || '')) : '';
                    },
                    onSelect: function ($model) {
                        $scope.operation.agreementId = $model.id;
                        $scope.operation.userId = $model.user_id.user_id;
                        $scope.updateUserData({id: $model.user_id.user_id});
                        $scope.updateAgreementData({'extraParams[id]': $model.id});
                        $scope.updateInvoiceData({'extraParams[agreement_id]': $scope.operation.agreementId});

                    }
                },
                invoice: {
                    name: 'номеру рахунку',
                    searchField: 'number',
                    provider: invoices,
                    label: function (invoice) {
                        return invoice ? ((invoice.number || '') + ' від ' + (invoice.date_created || '') + ' сума ' + (invoice.summa || '')) : '';
                    },
                    onSelect: function ($model) {
                        $scope.operation.invoiceId = $model.id;
                        $scope.operation.agreementId = $model.agreement_id.agreement_id;
                        $scope.updateInvoiceData({'extraParams[id]': $model.id});
                        $scope.updateAgreementData({'extraParams[id]': $model.agreement_id.agreement_id})
                            .then(function () {
                                $scope.operation.userId = $scope.agreementsList[0].user_id;
                                $scope.updateUserData({id: $scope.operation.userId})
                            });
                    }
                }
            };

            $scope.operation = {
                addInvoice: function addInvoice(id) {
                    if (id && _.find($scope.operation.invoices, ['id', id]) === undefined) {
                        $scope.operation.invoices.push(_.find($scope.invoicesList, ['id', id]));
                    }
                },
                removeInvoice: function removeInvoice(id) {
                    _.remove($scope.operation.invoices, function (item) {
                        return item.id == id
                    });
                }
            };

            $scope.initData = function initData() {
                $scope.externalPayment = {};
                $scope.providerId = 'user';
                $scope.currentProvider = $scope.typeaheadProviders[$scope.providerId];
                $scope.operation.userId = null;
                $scope.operation.agreementId = null;
                $scope.operation.invoiceId = null;
                $scope.operation.invoices = [];
                $scope.operation.sum = 0;
                $scope.usersList = [];
                $scope.agreementsList = [];
                $scope.invoicesList = [];
                $scope.selected = '';
                $scope.messages = [];
            };
            $scope.initData();

            $scope.clearDocument = function clearDocument($event, $selectedIndex) {
                $scope.externalPayment = {};
            };

            $scope.invoicesSum = function () {
                return $scope.operation.invoices.reduce(function (sum, item) {
                    return sum += Number(item.amount)
                }, 0);
            };

            $scope.cleanUp = function cleanUp() {
                $scope.initData();
            };

            $scope.invoiceById = function invoiceById(id) {
                return $scope.invoicesList.filter(function (item) {
                    return item.id == id
                })[0];
            };

            $scope.$watch('providerId', function (newValue, oldValue) {
                if (newValue != oldValue) {
                    $scope.currentProvider = $scope.typeaheadProviders[newValue];
                    $scope.selected = '';
                }
            });

            $scope.$watch('operation.agreementId', function (newValue, oldValue) {
                if (newValue != oldValue && newValue != null) {
                    $scope.updateInvoiceData({'extraParams[agreement_id]': newValue});
                }
            });

            $scope.$watch('operation.userId', function (newValue, oldValue) {
                if (newValue != oldValue && newValue != null) {
                    $scope.updateAgreementData({'extraParams[user_id]': newValue});
                }
            });

            $scope.getTypeahead = function getTypeahead(value) {
                return $scope.currentProvider.provider
                    .typeahead({
                        query: value
                    })
                    .$promise
            };

            $scope.onSelect = function onSelect($item, $model, $label, $event) {
                $scope.currentProvider.onSelect($model);
            };

            $scope.getExternalPayment = function () {
                if (!$scope.externalPayment.id) {
                    return externalPayments
                        .create($scope.externalPayment)
                        .$promise
                        .then(function (data) {
                            if (data.status && data.status == 'error') {
                                return $q.reject(data);
                            } else {
                                return data
                            }
                        })
                } else {
                    return $q.when($scope.externalPayment);
                }
            };

            $scope.createOperation = function createOperation() {
                $scope.messages = [];
                $scope.loaderControl.show();
                var sendData = {};
                sendData.userId = $scope.operation.userId;
                sendData.agreementId = $scope.operation.agreementId;
                sendData.invoices = $scope.operation.invoices.map(function (item) {
                    return {id: item.id, amount: item.summa}
                });

                $scope.getExternalPayment()
                    .then(
                        function success(data) {
                            sendData.sourceId = data.id;
                            sendData.amount = data.amount;
                            return operations
                                .create(null, sendData)
                                .$promise;
                        }
                    )
                    .then(
                        function (response) {
                            if (response.status !== 'error') {
                                if (response.message) {
                                    if (_.isArray(response.message)) {
                                        response.message.forEach(function(item) {
                                            $scope.messages.push({type: 'success', message: item});
                                        });
                                    } else {
                                        $scope.messages.push({type: 'success', message: 'Операція пройшла успішно'});
                                    }
                                }
                            } else {
                                $scope.messages.push({type: 'danger', message: response.message});
                            }
                            $scope.loaderControl.hide();
                        })
                    .catch(
                        function (response) {
                            if (response.message) {
                                if (_.isArray(response.message)) {
                                    response.message.forEach(function(item) {
                                        $scope.messages.push({type: 'danger', message: item});
                                    });
                                } else {
                                    $scope.messages.push({type: 'danger', message: response.message});
                                }
                            } else {
                                $scope.messages.push({type: 'danger', message: 'Невдачка'});
                            }
                            $scope.loaderControl.hide();
                        });
            };

            $scope.updateUserData = function updateUserSelect(params) {
                var defer = $q.defer();
                user
                    .query(params)
                    .$promise
                    .then(function (data) {
                        $scope.usersList = data;
                        defer.resolve(data);
                    });

                return defer.promise;
            };

            $scope.updateAgreementData = function updateAgreementSelect(params) {
                var defer = $q.defer();
                agreements
                    .list(params)
                    .$promise
                    .then(function (data) {
                        $scope.agreementsList = data.rows;
                        defer.resolve(data.rows);
                    });

                return defer.promise;
            };

            $scope.updateInvoiceData = function updateInvoiceData(params) {
                var defer = $q.defer();

                invoices
                    .list(params)
                    .$promise
                    .then(function (data) {
                        $scope.invoicesList = data.rows.map(function (item) {
                            item.summa = Number(item.summa);
                            item.amount = Number(item.summa);
                            return item;
                        });
                        defer.resolve(data.rows);
                    });

                return defer.promise;
            };

            $scope.showAgreement = function showAgreement(id) {
                if (id) {
                    $state.go('accountant/agreement/', {agreementId: id});
                }
            };

            $scope.showInvoice = function showInvoice(id) {
                if (id) {
                    $state.go('accountant/invoice/', {invoiceId: id});
                }
            };

            $scope.closeMessage = function closeMessage(index) {
                $scope.messages.splice(index, 1);
            };
        }])

    .controller('companiesCtrl', function ($scope, $http, $state, NgTableParams, $resource) {
        $scope.changePageHeader('Компанії');
        $scope.companiesTable = new NgTableParams({
            sorting: {},
        }, {
            getData: function (params) {
                return $resource(basePath + '/_teacher/_accountant/company/getCompaniesList').get(params.url()).$promise.then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
            }
        });
    })
    .controller('oneCompanyCtrl', function ($scope, $http, $state, NgTableParams, $resource) {
        $scope.changePageHeader('Компанія');

        $scope.addCompany=function(url) {
            $http({
                url: url,
                method: "POST",
                data: $jq.param({
                    title: $jq('[name="title"]').val(),
                    EDPNOU: $jq('[name="edpnou"]').val(),
                    certificate_of_vat: $jq('[name="certificate_of_vat"]').val(),
                    edpnou_issue_date: $jq('#edpnou_issue_date').val(),
                    certificate_of_vat_issue_date: $jq('#certificate_of_vat_issue_date').val(),
                    tax_certificate: $jq('[name="tax_certificate"]').val(),
                    tax_certificate_issue_date: $jq('#tax_certificate_issue_date').val(),
                    legal_address: $jq('[name="legal_address"]').val(),
                    legal_address_city_code: $jq('#cityLegal').val(),
                    legal_address_city_value: $jq('[name="cityLegal"]').val(),
                    actual_address: $jq('[name="actual_address"]').val(),
                    actual_address_city_code: $jq('#cityActual').val(),
                    actual_address_city_value: $jq('[name="cityActual"]').val()
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
            }).then(function successCallback(response) {
                bootbox.alert(response.data, function(){
                    if(response.data != "Неправильні дані.")
                        $state.go("accountant/company", {}, {reload: true});
                });
            }, function errorCallback() {
                bootbox.alert("Операцію не вдалося виконати.");
            });
        }
    })
    .controller('representativesCtrl', function ($scope, NgTableParams, $resource) {
        $scope.changePageHeader('Представники');
        $scope.companyRepresentativesTable = new NgTableParams({
            sorting: {},
        }, {
            getData: function (params) {
                return $resource(basePath + '/_teacher/_accountant/representative/getCompanyRepresentativesList').get(params.url()).$promise.then(function (data) {
                    params.total(data.count);
                    // return data.rows;
                    return data.data;
                });
            }
        });

        $scope.representativesTable = new NgTableParams({
            sorting: {},
        }, {
            getData: function (params) {
                return $resource(basePath + '/_teacher/_accountant/representative/getRepresentativesList').get(params.url()).$promise.then(function (data) {
                    params.total(data.count);
                    return data.rows;
                });
            }
        });
    })

    .controller('oneRepresentativeCtrl', function ($scope, $http, $state) {
        $scope.changePageHeader('Представник');
        
        $scope.$watch('newRepresentative', function() {
            if ($scope.newRepresentative)
                $jq('#typeaheadRepresentative').css('background-color', '#eee');
            else $jq('#typeaheadRepresentative').css('background-color', 'inherit');
        });

        $scope.addRepresentative=function(url) {
            var error=false;
            if ($jq('#representative').val() == 0 && !($jq('[name="full_name"]').val())) {
                bootbox.alert('Виберіть існуючого представника зі списку або додайте нового.');
                error=true;
            } if($jq('#companyId').val()==0){
                bootbox.alert('Виберіть існуючу компанію зі списку або створіть нову');
                error=true;
            }
            if(!error) {
                $http({
                    url: url,
                    method: "POST",
                    data: $jq.param({
                        representative: $jq('#representative').val(),
                        fullName: $jq('[name="full_name"]').val(),
                        position: $jq('[name="position"]').val(),
                        company: $jq('#companyId').val(),
                        order: $jq('[name="order"]').val(),
                    }),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
                }).then(function successCallback(response) {
                    bootbox.alert(response.data, function () {
                        $state.go("accountant/representative", {}, {reload: true});
                    });
                }, function errorCallback() {
                    bootbox.alert("Операцію не вдалося виконати.");
                });
            }
        }
    })
    
    .controller('operationTypeCtrl', function ($scope) {
        $jq('#operationTypes').DataTable({
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                }
            }
        );
    })

    .controller('externalSourcesCtrl', function ($scope) {
        $jq('#externalSources').DataTable({
                "autoWidth": false,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                }
            }
        );
    })

    .controller('cancelReasonTypeCtrl', function ($scope) {
        $jq('#cancelReasonTypes').DataTable({
                "autoWidth": false,
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                }
            }
        );
    })

    .controller('paymentsSchemaCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {
        $scope.schemeType = $stateParams.schemeType;
    }])
    .controller('addPaymentsSchemaCtrl',
        [
            '$scope',
            '$stateParams',
            'userService',
            'courseService',
            'moduleService',
            function ($scope, $stateParams, user, course, module) {
                $scope.schemeType = $stateParams.schemeType;
                if (['module', 'user', 'course'].indexOf($scope.schemeType) === -1) {
                    $scope.schemeType = 'default'
                }


                $scope.user = {
                    isSelect : $scope.schemeType === 'user',
                    typeahead: function getUserTypeahead(value) {
                        return user.typeahead({query: value}).$promise
                    },
                    label: function (user) {
                        return user ? ((user.firstName || '' ) + ' ' + (user.middleName || '') + ' ' + (user.secondName || '') + ', ' + (user.email || '')) : '';
                    },
                    onSelect: function onSelectUser($item, $model, $label, $event) {
                    }
                };

                $scope.course = {
                    isSelect : $scope.schemeType === 'user' || $scope.schemeType === 'course',
                    typeahead: function getCourseTypeahead(value) {
                        return course.typeahead({query: value}).$promise
                    },
                    label: function (course) {
                        return course ? ((course.title_ua || '' ) + ', ' + (course.language || '')) : '';
                    },
                    onSelect: function onSelectUser($item, $model, $label, $event) {
                    }
                };

                $scope.module = {
                    isSelect : $scope.schemeType === 'user' || $scope.schemeType === 'module',
                    typeahead: function getModuleTypeahead(value) {
                        return module.typeahead({query: value}).$promise
                    },
                    label: function (module) {
                        return module ? ((module.title_ua || '' ) + ', ' + (module.language || '')) : '';
                    },
                    onSelect: function onSelectUser($item, $model, $label, $event) {
                    }
                };

                

            }
        ]
    );
