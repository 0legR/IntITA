<?php
/**
 * @var $form CActiveForm
 * @var $pageId integer
 * @var $lecture integer
 */
?>
<div id="addPlainTask">
    <br>
    <form  name="plainTask" method="post" action="<?php echo Yii::app()->createUrl('revision/addTest');?>">
        <fieldset>
            <label><?php echo Yii::t('lecture','0774'); ?></label>
            <br>
           <textarea ng-cloak ckeditor="editorOptionsTask" name="block_element" id="plainTask" class="plainTaskCondition" placeholder="<?php echo Yii::t('lecture','0773'); ?>" required ng-model="addTaskPlain"></textarea>
            <input name="revisionId" type="hidden" value="<?php echo $revisionId;?>"/>
            <input name="pageId" id="pageId" type="hidden" value="<?php echo $pageId;?>"/>
            <input name="idType" id="plainTaskType" type="hidden"/>
            <br>
            <input type="submit" value="<?=Yii::t('editor', '0787');?>" id='addtests' ng-disabled=plainTask.block_element.$error.required>
        </fieldset>
    </form>
    <button onclick='cancelTest()'><?php echo Yii::t('lecture', '0707'); ?></button>
</div>
