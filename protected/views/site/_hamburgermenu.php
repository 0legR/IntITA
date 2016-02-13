<?php $header = new Header(); ?>
<!-- Hamburger menu -->
<div id="hambNav">
    <div id="hambButton">
        <img src="<?php echo StaticFilesHelper::createPath('image', 'mainpage', 'hamburger.png'); ?>">
    </div>
    <div id="hambMenu">
        <a href="<?php echo Yii::app()->homeUrl; ?>" class="logo">
            <img src="<?php echo StaticFilesHelper::createPath('image', 'mainpage', 'hamburgerlogo.png') ?>"/>
        </a>

        <div class="humblang">
            <?php
            if(Yii::app()->session['lg']==NULL) Yii::app()->session['lg']='ua';
            foreach (array("ua", "en", "ru") as $val) {
                ?>
                <a href="<?php echo Yii::app()->createUrl('site/changeLang', array('lg'=>$val)); ?>" <?php echo (Yii::app()->session['lg'] == $val) ? 'class="selectedLang"' : ''; ?>><?php echo $val; ?></a>
            <?php
            }
            ?>
        </div>
        <ul class="menulist">
            <li><a href="<?php echo Config::getBaseUrl().'/courses'; ?>"><?php echo Yii::t('header', '0016'); ?></a></li>
            <li><a href="<?php echo Config::getBaseUrl().'/teachers'; ?>"><?php echo Yii::t('header', '0021'); ?></a></li>
            <li><a href="<?php echo Config::getBaseUrl().'/graduate'; ?>"><?php echo Yii::t('header', '0137'); ?></a></li>
            <li><a href="<?php echo Config::getBaseUrl().'/forum'; ?>" target="_blank"><?php echo Yii::t('header', '0017'); ?></a></li>
            <li><a href="<?php echo Config::getBaseUrl().'/aboutus'; ?>"><?php echo Yii::t('header', '0018'); ?></a></li>
        </ul>
        <div class="humundline"></div>
        <?php if (Yii::app()->user->isGuest) {
            echo CHtml::link($header->getEnterButton(), '', array('id' => 'hum_button', 'onclick' => 'openSignIn();',));
        } else {?>
            <a id="hum_button" href="<?php echo Config::getBaseUrl(); ?>/site/logout">
                <?php echo $header->getLogoutButton(); ?>
            </a>
            <?php
            $humuser = Yii::app()->user->model;
            ?>
            <div class="humStatus">
                <a href="<?php echo Yii::app()->createUrl('/studentreg/profile', array('idUser' => Yii::app()->user->id)); ?>">
                    <div class="humavatar"><img src="<?php echo StaticFilesHelper::createPath('image', 'avatars', $humuser->avatar); ?>"/></div><div class="humName">
                        <?php echo StudentReg::getStatusInfo($humuser); ?><br>
                        <span class='statusColor' style="font-size: smaller">&#x25A0; online</span>
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>