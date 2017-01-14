<?php
/* @var $scenario */
?>
<div class="panel-body" ng-controller="paymentsSchemaTemplateCtrl">
    <div class="row">
        <div class="formMargin">
            <div class="col-lg-8">
                <div class="form-group">
                    <label>Назва шаблону схеми*</label>
                    <input name="name" class="form-control" ng-model="template.name" required maxlength="64" size="50">
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Кількість проплат</th>
                        <th>Назва схеми</th>
                        <th>Відсоток знижки</th>
                        <th>Відсоток кредиту</th>
                        <th>
                            Додати схему
                            <button type="button" class="btn btn-default btn-sm" ng-click="operation.addScheme()">
                                <span class="glyphicon glyphicon-plus-sign"></span>
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="scheme in schemes track by $index">
                        <td>
                            <select
                                class="form-control"
                                ng-model="schemes[$index].pay_count"
                                ng-options="pay_count.value as pay_count.value for pay_count in payCount"
                                ng-change="updateScheme(schemes[$index].pay_count,$index)" >
                            </select>
                        </td>
                        <td>
                            <input type="text" ng-disabled=true class="form-control" ng-value="schemes[$index].name">
                        </td>
                        <td>
                            <input type="number" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/"
                                   step="0.01" ng-model="schemes[$index].discount" min="0" max="100" ng-disabled="schemes[$index].pay_count>12"/>
                        </td>
                        <td>
                            <input type="number" class="form-control" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/"
                                   step="0.01" ng-model="schemes[$index].loan" min="0" max="100" ng-disabled="schemes[$index].pay_count<=12"/>
                        </td>
                        <td ng-if="$index!=0">
                            <button type="button" class="btn btn-default btn-sm" ng-click="operation.removeScheme($index)">
                                <span class="glyphicon glyphicon-minus-sign"></span>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" ng-click="createTemplate(template)" ng-disabled="!template.name || !template.schemes.length">
                    Зберегти
                </button>
                <a type="button" class="btn btn-default" ng-click='back()'>
                    Назад
                </a>
            </div>
        </div>
    </div>
</div>