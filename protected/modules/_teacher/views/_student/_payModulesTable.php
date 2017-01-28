<div class="panel panel-default">
    <div class="panel-body">
        <table ng-table="paidModulesTable" class="table table-striped table-bordered table-hover">
            <tr ng-repeat="row in $data" ng-if="row.module">
                <td data-title="'Назва'">
                    <div ng-if="!row.module.cancelled">
                        <a href="" ng-click="moduleLink(row.module.module_ID)" target="_blank">
                            {{row.module.title_ua}}
                        </a>
                    </div>
                    <div ng-if="row.module.cancelled">{{row.module.title_ua}} (скасований)</div>
                </td>
                <td data-title="'Сума, грн'">
                    <div ng-if="row.agreement.summa">{{row.agreement.summa | number:2}}</div>
                    <div ng-if="!row.agreement.summa">безкоштовно</div>
                </td>
                <td data-title="'Сплачено, грн'">
                    <div>{{row.paidAmount | number:2}}</div>
                </td>
                <td data-title="'Доступний до:'">
                    {{row.endDate}}
                </td>
            </tr>
        </table>
    </div>
</div>