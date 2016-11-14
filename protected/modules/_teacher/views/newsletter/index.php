<?php
/**
 * Created by PhpStorm.
 * User: adm
 * Date: 13.11.2016
 * Time: 22:43
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading">
Написати листа
</div>
    <div class="panel-body" ng-controller="newsletterCtrl">
        <div class="row">
            <div class="form-group col-md-8" id="receiver">
                <label>
                    Тип розсилки
                </label>
                <br>
                <label>
                    <input type="radio" ng-model="newsletterType" value="allUsers">
                    Зареєстровані користувачі
                </label>
                <br>
                <label>
                    <input type="radio" ng-model="newsletterType" value="roles">
                    Розсилка по ролях
                </label>
                <br>
                <label>
                    <input type="radio" ng-model="newsletterType" value="users">
                    Розсилка по окремих користувачах
                </label>

            </div>
            <div class="form-group col-md-8" id="receiver" ng-show="newsletterType=='roles'">
                <label>Кому</label>
                <br>
                <oi-select
                    oi-options="role.name for role in getRoles($query, $selectedAs)"
                    ng-model="selectedRoles"
                    multiple
                    placeholder="Кому"
                ></oi-select>
            </div>



            <div class="form-group col-md-8" id="receiver">
                </div>
            <div class="form-group col-md-8">
                <label>Тема</label>
                <input class="form-control" name="subject" placeholder="Тема листа">
            </div>

            <div class="form-group col-md-8">
                <label>Лист</label>
                <textarea class="form-control" rows="6" id="text" placeholder="Лист" required></textarea>
            </div>
            <div class="col-md-8">
            <button type="submit" class="btn btn-primary"
                    ng-click="send();">
                        Надіслати
            </button>
                <button type="reset" class="btn btn-default"
                        ng-click="loadMessagesIndex()">
                            Скасувати
                </button>
            </div>
    </div>
    </div>
</div>