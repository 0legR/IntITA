<p id="timeTitle">Виберіть годину</p>
<p  id="timeDate"></p>

<table id='timeGrid'>
    <?php
    for ($i = 9; $i < 23; $i++) {
        ?>
        <tr>
            <?php
            for ( $j = 0; $j < 3; $j++) {
                ?>
                <td class='<?php  echo Consultationscalendar::classTD($teacherId,Consultationscalendar::timeInterval($i,$j,20)); ?>'>
                    <?php  echo Consultationscalendar::timeInterval($i,$j,20); ?>
                </td>
            <?php
            }
            ?>
        </tr>
    <?php
    }
    ?>
</table>

<div id="timeInfo">
    Ви можете вибрать декілька консультацій.
    Використовуйте клавіші <span class="colorP">Ctrl</span> або <span class="colorP">Shift</span>.
</div>

<button id="consultationBack">Назад</button>
<button id="consultationNext">Далі</button>