<?php
/**
 * @var $student RegisteredUser
 */
$modules = $student->getAttributesByRole(UserRoles::STUDENT)[0]["value"];
$courses = $student->getAttributesByRole(UserRoles::STUDENT)[1]["value"];
?>
<div class="row">
    <table class="table table-hover">
        <tbody>
        <tr>
            <td width="20%">Курси:</td>
            <td>
                <?php if (!empty($courses)) { ?>
                    <ul>
                        <?php foreach ($courses as $course) {
                        if(!$course["cancelled"]){?>
                            <li>
                                <a href="<?= Yii::app()->createUrl("course/index", array("id" => $course["id"])); ?>"
                                   target="_blank">
                                    <?=$course["title"]." (".$course["lang"].")";?>
                                </a>
                            </li>
                        <?php } else {?>
                            <li>
                                <?=$course["title"]." (".$course["lang"].") - скасований";?>
                            </li>
                        <?php }
                        } ?>
                    </ul>
                <?php } else {
                    echo "Немає проплачених курсів.";
                }?>
            </td>
        </tr>
        <tr>
            <td width="20%">Модулі:</td>
            <td>
                <?php if (!empty($modules)) { ?>
                    <ul>
                        <?php foreach ($modules as $module) {
                            if(!$module["cancelled"]){?>
                                <li>
                                    <a href="<?= Yii::app()->createUrl("module/index", array("idModule" => $module["id"])); ?>"
                                       target="_blank">
                                        <?=$module["title"]." (".$module["lang"].")";?>
                                    </a>
                                </li>
                            <?php } else {?>
                                <li>
                                    <?=$module["title"]." (".$module["lang"].") - скасований";?>
                                </li>
                        <?php }
                        } ?>
                    </ul>
                <?php } else {
                    echo "Немає проплачених модулів.";
                }?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
