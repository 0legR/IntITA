<?php
/**
 * @var $plainTaskAnswer PlainTaskAnswer
 * @var $teacherPlainTasks array
 * @var $mark boolean
 */
if (!empty($teacherPlainTasks)) { ?>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="tasksTable">
                        <thead>
                        <tr>
                            <th style="width: 3%"></th>
                            <th style="width: 15%">Курс/модуль</th>
                            <th style="width: 20%">Задача</th>
                            <th style="width: 15%">Користувач</th>
                            <th>Відповідь</th>
                            <th style="width: 10%">Оцінка</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($teacherPlainTasks as $plainTaskAnswer) {
                            $mark = $plainTaskAnswer->mark();?>
                            <tr onclick="showPlainTask('<?php echo Yii::app()->createUrl('/_teacher/teacher/showPlainTask') ?>',
                                '<?php echo $plainTaskAnswer->id; ?>'); return false;" <?php if (!$mark) echo 'class="success"'; ?>
                                style="cursor: pointer">
                                <td><i class="fa <?php echo ($mark) ? ' fa-check' : ' fa-exclamation'; ?> fa-fw"></i>
                                </td>
                                <td class="center"></td>
                                <td class="center"><?php echo strip_tags($plainTaskAnswer->plainTask->getShortDescription()); ?></td>
                                <td class="center"><?php echo $plainTaskAnswer->getStudentName(); ?></td>
                                <td class="center">
                                    <?php echo $plainTaskAnswer->getShortDescription(); ?></td>
                                <td><?php if ($mark) {
                                        echo ($mark['mark']) ? "зарах." : "не зарах.";
                                    } ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    echo "Нових задач немає.";
} ?>
<script>
    $jq(document).ready(function () {
        $jq('#tasksTable').DataTable({
                language: {
                    "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Ukranian.json"
                }
            }
        );
    });
</script>
