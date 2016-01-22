<script>
    summa = "<?php echo CommonHelper::getPriceUah($account->summa);?>";
    user = "<?php echo $account->id_user;?>";
</script>
        <div id="account">
            <div id="accountTable">
                    <br>
                <b>Отримувач коштів:</b> ТОВ «Вінницька ІТ-Академія»
                    <br>
                <b>Банк: </b>АТ «ОТП Банк»
                    <br>
                <b>МФО </b> 300528<br>
                <b>р/р </b> 26005001352431<br>
                <b>код ЄДРПОУ </b> 33263663
                    <br>
                <b>Адреса </b> 21007, м. Вінниця, вул. Фрунзе, 4<br>
                <b>тел.</b> 555-220
                    <br> <br><br>
                <div class="row">
                    <div class="col-sm-2">
                         “<?php echo date("d");?>” <span id="month"><?php
                        if (isset($_GET['month'])) {
                            echo $_GET['month'];
                        } else {
                            echo date("F");
                        }?></span> 2016 р.
                    </div>
                        <div class="col-sm-5 text-center">
                            <span id="accountTitle">РАХУНОК № <?php echo $account->id_account;?></span>
                        </div>

                </div>


                <div class="row">
                <div class="col-sm-2"><b>Платник:</b></div>
                    </div>

                <br>
            </div>
            <div class="table-responsive col-md-9" style="padding:0;">
                <table id="accountTable" class="table">
                    <tr>
                        <td class="info" >№ п/п</td>
                        <td class="info" >Назва продукції (послуг)</td>
                        <td class="info" >Сума,
                            грн</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td style="text-align: left">Освітні послуги в науково-технічному напрямку - програмування та комп'ютерна
                            грамотність (<?php echo TempPay::getAccountProductTitle($account);?>)
                        </td>
                        <td><span id="summa"><?php echo CommonHelper::getPriceUah($account->summa).",00";?></span></td>
                    </tr>
                     <tr style="border: none;">
                        <td colspan="2" style="border: none;text-align: left">
                            Всього до сплати (прописом):
                            <br>
                            <b><span id="summaLetters"></span></b>
                        </td>
                        <td><?php echo CommonHelper::getPriceUah($account->summa).",00";?></td>
                    </tr>
                </table>
            </div>
        </div>


