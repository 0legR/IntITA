<div class="col-lg-12">
    <br>
    <a type="button" class="btn btn-primary" ng-href="#/admin/users/addrole/tenant">
        Призначити tenant
    </a>
    <br>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table ng-table="tenantsTableParams" class="table table-bordered table-striped table-condensed">
                    <tr ng-repeat="row in $data track by $index">
                        <td data-title="'ПІБ'">
                            <a ng-href="#/admin/users/user/{{row.id}}">{{row.name}}</a>
                        </td>
                        <td data-title="'Email'">
                            <a ng-href="#/admin/users/user/{{row.id}}">{{row.email}}</a>
                        </td>
                        <td data-title="'Призначено'">{{row.register}}</td>
                        <td data-title="'Відмінено'">{{row.cancelDate}}</td>
                        <td data-title="'Профіль'"><a ng-href="{{row.profile}}" target="_blank">Профіль</a></td>
                        <td data-title="'Відправити листа'">
                            <a class="btnChat"  ng-href="#/newmessages/receiver/{{row.id}}"  data-toggle="tooltip" data-placement="top" title="Приватне повідомлення">
                                <i class="fa fa-envelope fa-fw"></i>
                            </a>
                        </td>
                        <td data-title="'Скасувати роль'"><a ng-if="!row.cancelDate" ng-click="cancelRole('/_teacher/_admin/users/cancelRole','tenant',row.id)"><i class="fa fa-trash fa-fw"></i></a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>