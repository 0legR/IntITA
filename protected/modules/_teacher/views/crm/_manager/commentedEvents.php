<div class="panel panel-default">
    <div class="panel-body">
        <div class="dataTable_wrapper">
            <table ng-table="commentedEventsTableParams" class="table table-bordered table-striped table-condensed">
                <colgroup>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                </colgroup>
                <tr ng-repeat="row in $data track by $index">
                    <td data-title="'Користувач'" filter="{'idUser.fullName': 'text'}" sortable="idUser.fullName">
                        <a ng-href="#/users/profile/{{row.id_user}}" target="_blank">{{row.idUser.fullName}}</a>
                    </td>
                    <td data-title="'Додав коментар'" filter="{'message': 'text'}">
                        <em ng-bind-html="row.message | htmlToPlaintext | limitTo:50"></em>
                    </td>
                    <td data-title="'Завдання'" filter="{'idTask.name': 'text'}" sortable="'idTask.name'">
                        <a ng-href="" ng-click="getTask(row.idTask.id)">{{row.idTask.name}}</a>
                        <div class="svgContainer pull-right">
                            <a ng-href="#task/{{row.idTask.id}}" target="_blank">
                                <div class="openIco" ng-include="pathToCrmTemplates+'/svg/new_window.svg'" title="Відкрити в новому вікні" ></div>
                            </a>
                        </div>
                    </td>
                    <td data-title="'Дата'" filter="{'create_date': 'text'}" sortable="'create_date'">
                        {{row.create_date}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>