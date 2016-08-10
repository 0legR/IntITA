<div class="col-lg-12">
    <br>
    <button class="btn btn-primary"
            onclick="load('<?php echo Yii::app()->createUrl('/_teacher/_admin/users/renderAddRoleForm',
                array('role'=>"contentManager")); ?>', 'Призначити контент менеджера')">
        Призначити контент менеджера
    </button>
    <br>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="contentManagersTable" datatable="ng" dt-options="dtOptions">
                    <thead>
                    <tr>
                        <th>ПІБ</th>
                        <th>Email</th>
                        <th>Призначено</th>
                        <th>Відмінено</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="row in contentManagersList">
                        <td><a ng-href="#/admin/users/teacher/{{row.id}}">{{row.name.name}}</a></td>
                        <td><a ng-href="#/admin/users/teacher/{{row.id}}">{{row.email.title}}</a></td>
                        <td>{{row.register}}</a> </td>
                        <td>{{row.cancelDate}}</td>
                        <td>
                            <a class="btnChat"  ng-href="{{row.mailto}}"  data-toggle="tooltip" data-placement="top" title="Приватне повідомлення">
                                <i class="fa fa-envelope fa-fw"></i>
                            </a>
                        </td>
                        <td><a ng-click="cancelRole(row.cancel,'content_manager',row.id)"><i class="fa fa-trash fa-fw"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>