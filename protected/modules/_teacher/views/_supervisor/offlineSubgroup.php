<div class="panel panel-default" ng-controller="offlineSubgroupCtrl">
    <div class="panel-body">
        <ul class="list-inline">
            <li>
                <a type="button" class="btn btn-primary" ng-href="#/supervisor/editSubgroup/{{subgroup.id}}">
                    Редагувати підгрупу
                </a>
            </li>
            <li>
                <a type="button" class="btn btn-primary" ng-href="#/supervisor/offlineGroup/{{group.id}}">
                    Група підгрупи
                </a>
            </li>
            <li>
                <a type="button" class="btn btn-success" ng-href="" ng-click="updateSubgroupChat(subgroup.id)">
                    Оновити чат підгрупи
                </a>
            </li>
        </ul>
        <div class="panel-body" style="padding:15px 0 0 0">
            <uib-tabset active="0" >
                <uib-tab index="0" heading="Головне">
                    <ul class="list-group" >
                        <li class="list-group-item">
                            <label>Група: </label> {{group.name}}
                        </li>
                        <li class="list-group-item">
                            <label>Підрупа: </label> {{subgroup.name}}
                        </li>
                        <li class="list-group-item">
                            <label>Тренер в підгрупі: </label>
                            <a ng-href="#/users/profile/{{subgroupTrainer.id}}">{{subgroupTrainer.fullName}}</a>
                        </li>
                        <li class="list-group-item">
                            <label>Інформація(розклад):</label> <span ng-bind-html="subgroup.data | linky:'_blank'">
                        </li>
                    </ul>
                </uib-tab>
                <uib-tab index="1" heading="Студенти">
                    <?php $this->renderPartial('/_supervisor/tables/_offlineStudents', array());?>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
</div>

