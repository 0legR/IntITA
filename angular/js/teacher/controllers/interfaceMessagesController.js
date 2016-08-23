/**
 * Created by adm on 13.08.2016.
 */
angular
    .module('teacherApp')
    .controller('interfaceMessagesCtrl',interfaceMessagesCtrl);

function interfaceMessagesCtrl ($scope, $http, interfaceMessages, NgTableParams,$state){
    $scope.cols = [
        { title: "ID", headerTitle: "ID", show: true },
        { title: "language", headerTitle: "Мова", show: true },
        { title: "category", headerTitle: "Категорія", show: true },
        { title: "translation", headerTitle: "Переклад", show: true },
        { title: "comment", headerTitle: "Коментар", show: true },
    ];

    $scope.tableParams = new NgTableParams({}, {
        getData: function(params) {
            return interfaceMessages.list({
                    page: params.page(),
                    pageCount: params.count()
                })
                .$promise
                .then(function (data) {
                    params.total(data.count); // recal. page nav controls
                    return data.rows;
                });
        }
    });

    $scope.english = '^[a-zA-Z ]+$';
    $scope.numbers = '^[0-9]+$';

    $scope.submitForm = function(translateForm){

       $scope.submitted = true;
        if (translateForm.$valid)
        {
         $http({
             method: 'POST',
             url: basePath+'/_teacher/_admin/translate/create',
             data: $jq.param({'id': $scope.message.id,
                            'category': $scope.message.category,
                            'translateUa': $scope.message.translateUa,
                            'translateRu': $scope.message.translateRu,
                            'translateEn': $scope.message.translateEn,
                            'comment': $scope.message.comment}),
             headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}
         }).success(function(response){
             if(response!=''){
                 bootbox.alert(response);
             }else{
                 bootbox.alert('Операцію успішно виконано',function(){
                     $state.go("interfacemessages", {}, {reload: true});
                 })
             }
         }).error(function(){
             bootbox.alert('Операцію виконати не вдалося.');
         })
        }
    };

    $scope.hasError = function(field, validation){
        if(validation){
            return ($scope.form[field].$dirty && $scope.form[field].$error[validation]) || ($scope.submitted && $scope.form[field].$error[validation]);
        }
        return ($scope.form[field].$dirty && $scope.form[field].$invalid) || ($scope.submitted && $scope.form[field].$invalid);
    };




}
