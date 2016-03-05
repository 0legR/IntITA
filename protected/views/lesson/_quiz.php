<?php
/**
 * Created by PhpStorm.
 * User: Wizlight
 * Date: 07.12.2015
 * Time: 16:57
 */
?>
<?php
/* @var $page LecturePage*/
if (!is_null($page->quiz)) {
    if (isset($message)){
        $buttonName = $message;
    } else {
        $buttonName = Yii::t('lecture','0089');
    }

    switch (LectureElement::getQuizType($page->quiz)) {
        case '5':
            $this->renderPartial('_taskBlock', array(
                'data' => LectureElement::model()->findByPk($page->quiz),
                'editMode' => $editMode,
                'user' => $user,
                'buttonName' => $buttonName
            ));
            break;
        case '6':
            $this->renderPartial('_plainTaskBlock', array(
                'data' => LectureElement::model()->findByPk($page->quiz),
                'editMode' => $editMode,
                'user' => $user,
                'buttonName' => $buttonName
            ));
            break;
        case '9' :
            $this->renderPartial('_skipTaskBlock', array(
                'data' => LectureElement::model()->findByPk($page->quiz),
                'editMode' => $editMode,
                'user' => $user,
                'buttonName' => $buttonName
            ));
            break;
        case '12':
        case '13':
            $this->renderPartial('_testBlock', array(
                'data' => LectureElement::model()->findByPk($page->quiz),
                'editMode' => $editMode,
                'user' => $user,
                'buttonName' => $buttonName
            ));
            break;
        default:
            break;
    }
}
?>

