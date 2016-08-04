<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li>
                    <a href="#ua" data-toggle="tab">Текст українською</a>
                </li>
                <li>
                    <a href="#ru" data-toggle="tab">Текст російською</a>
                </li>
                <li>
                    <a href="#en" data-toggle="tab">Текст англійською</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="ua">
                    <?php $this->renderPartial('_offerText', array('lang' => 'ua')); ?>
                </div>
                <div class="tab-pane fade" id="ru">
                    <?php $this->renderPartial('_offerText', array('lang' => 'ru')); ?>
                </div>
                <div class="tab-pane fade" id="en">
                    <?php $this->renderPartial('_offerText', array('lang' => 'en')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
