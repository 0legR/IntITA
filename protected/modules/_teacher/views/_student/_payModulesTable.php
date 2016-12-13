<div class="panel panel-default">
    <div class="panel-body">
        <table ng-table="paidModuesTable" class="table table-striped table-bordered table-hover">
            <tr ng-repeat="row in $data">
                <td data-title="'Назва'"><div ng-if="!row.module.cancelled"><a href="/module/{{row.module.language}}/{{row.id_module}}">{{row.module.title_ua}}</a></div>
                    <div ng-if="row.module.cancelled">{{row.module.title_ua}} (скасований)</div>
                </td>
                <td data-title="'Сума, грн'">
                    <div ng-if="row.module.module_price">{{row.module.module_price *usd}}</div>
                    <div ng-if="!row.module.module_price">безкоштовно</div>
                </td>
            </tr>
        </table>
    </div>
</div>