<div class="panel panel-default">
    <div class="panel-body" ng-if="board==2">
        <div class="dataTable_wrapper">
            <table ng-table="tasksTableParams" class="table table-bordered table-striped table-condensed crmTaskTable">
                <colgroup>
                    <col width="70px"/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                    <col/>
                </colgroup>
                <tr ng-repeat="row in $data track by $index"
                    ng-class="{'expect_to_execute': row.idTask.id_state == 1, 'executed': row.idTask.id_state == 2,
                        'completed': row.idTask.id_state == 4,'paused': row.idTask.id_state == 3, 'bg-warning-kanban': (row.idTask.id_state!=4 && row.idTask.endTask && currentDate>=(row.idTask.endTask  | shortDate:'yyyy-MM-dd')),
                    'bg-danger-kanban': (row.idTask.id_state!=4 && row.idTask.deadline && currentDate>(row.idTask.deadline  | shortDate:'yyyy-MM-dd'))}">
                    <td data-title="'id'" filter="{'idTask.id': 'text'}" sortable="'idTask.id'">
                        {{row.idTask.id}}
                    </td>
                    <td data-title="'Назва'" filter="{'idTask.name': 'text'}" sortable="'idTask.name'">
                        <a ng-href="" ng-click="getTask(row.idTask.id)">{{row.idTask.name}}</a>
                        <div class="col-md-12 svgContainer">
                            <div class="openIco" ng-include="pathToCrmTemplates+'/svg/windows.svg'" title="Відкрити" ng-click="getTask(row.idTask.id)"></div>
                            <a ng-href="#task/{{row.idTask.id}}" target="_blank">
                                <div class="openIco" ng-include="pathToCrmTemplates+'/svg/new_window.svg'" title="Відкрити в новому вікні" ></div>
                            </a>
                        </div>
                        <div class="col-md-12 kanbanButtons">
                            <fieldset>
                                <i ng-if="row.idTask.id_state==1" class="fa fa-play executed" aria-hidden="true" title="ПОЧАТИ" ng-click="changeKanbanState(row.idTask,2)" ng-disabled="isDisabled"></i>
                                <i ng-if="row.idTask.id_state==3" class="fa fa-play executed" aria-hidden="true" title="ПРОДОВЖИТИ" ng-click="changeKanbanState(row.idTask,2)" ng-disabled="isDisabled"></i>
                                <i ng-if="row.idTask.id_state==2" class="fa fa-pause paused" aria-hidden="true" title="ПРИЗУПИНИТИ" ng-click="changeKanbanState(row.idTask,3)" ng-disabled="isDisabled"></i>
                                <i ng-if="row.idTask.id_state==2 || row.idTask.id_state==3" class="fa fa-check-square-o completed" aria-hidden="true" title="ЗАВЕРШИТИ" ng-click="changeKanbanState(row.idTask,4)" ng-disabled="isDisabled"></i>
                                <i ng-if="row.idTask.id_state==4" class="fa fa-clock-o expect_to_execute" aria-hidden="true" title="ВІДНОВИТИ" ng-click="changeKanbanState(row.idTask,1)" ng-disabled="isDisabled"></i>
                                <i ng-if="currentUser==row.idTask.created_by" class="fa fa-remove remove" aria-hidden="true" title="ВИДАЛИТИ" ng-click="cancelKanbanCrmTask(row.idTask)" ng-disabled="isDisabled"></i>
                            </fieldset>
                        </div>
                    </td>
                    <td data-title="'Пріоритет'" filter="{'crmPriority.id': 'select'}" filter-data="crmPrioritiesList">
                        <div class="svgContainer" ng-class="row.idTask.priorityModel.title">{{row.idTask.priorityModel.description}}
                            <div style="vertical-align: bottom" ng-class="row.idTask.priorityModel.title" ng-include="pathToCrmTemplates+'/svg/priority.svg'" ></div>
                        </div>
                    </td>
                    <td data-title="'Категорія'" filter="{'crmType.id': 'select'}" filter-data="crmTypesList">
                        <div ng-class="row.idTask.taskType.title">{{row.idTask.taskType.title_ua}}</div>
                    </td>
                    <td data-title="'Користувач'" filter="{'idUser.fullName': 'text'}">
                    </td>
                    <td data-title="'Постановник'" filter="{'idTask.producerName.fullName': 'text'}">
                        {{row.idTask.producerName.fullName}}
                    </td>
                    <td data-title="'Відповідальний'" filter="{'idTask.executantName.fullName': 'text'}" sortable="'idTask.executantName.fullName'">
                        {{row.idTask.executantName.fullName}}
                    </td>
                    <td data-title="'Дата'" filter="{'idTask.created_date': 'text'}" sortable="'idTask.created_date'">
                        {{row.idTask.created_date}}
                    </td>
                    <td data-title="'Статус'" filter="{'crmStates.id': 'select'}" filter-data="crmStateList">
                        {{row.idTask.taskState.description}}
                    </td>
                    <td data-title="'Затрачений час'">
                        <p>{{row.spent_time | spentTime}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div ng-show="board==1">
        <div ng-include="getKanban()" ></div>
    </div>

</div>