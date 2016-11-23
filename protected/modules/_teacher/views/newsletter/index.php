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
        <form ng-app="myApp" name="newsletterForm" novalidate>

            <div class="row">
                <div class="form-group col-md-8" id="receiver">
                    <label>
                        Тип розсилки
                    </label>
                    <br>
                    <label>
                        <input type="radio" ng-model="newsletterType" value="allUsers"
                               ng-click="selectedRecipients = null">
                        Всі активні користувачі
                    </label>
                    <br>
                    <label>
                        <input type="radio" ng-model="newsletterType" value="roles"
                               ng-click="selectedRecipients = null">
                        Розсилка по ролях
                    </label>
                    <br>
                    <label>
                        <input type="radio" ng-model="newsletterType" value="users"
                               ng-click="selectedRecipients = null">
                        Розсилка по окремих користувачах
                    </label>

                </div>
                <div class="form-group col-md-8" id="receiver" ng-show="newsletterType=='roles'">
                    <label>Кому</label>
                    <br>
                    <oi-select
                        oi-options="role.name for role in getRoles($query, $selectedAs)"
                        ng-model="selectedRecipients"
                        multiple
                        placeholder="Кому"
                    ></oi-select>
                </div>

                <div class="form-group col-md-8" id="receiver" ng-show="newsletterType=='users'">
                    <label>Кориcтувачі</label>
                    <br>
                    <oi-select
                        oi-options="user.email for user in getUsers($query)"
                        ng-model="selectedRecipients"
                        multiple
                        placeholder="Кому"
                        oi-select-options="{
                      debounce: 200,
                      dropdownFilter: 'usersFilter',
                      searchFilter: 'usersSearchFilter',
                     }"
                    ></oi-select>
                </div>

                <div class="form-group col-md-8" id="receiver">
                </div>
                <div class="form-group col-md-8">
                    <label>Тема</label>
                    <input class="form-control" name="subject" placeholder="Тема листа" ng-model="subject" required>
                    <span style="color:red" ng-show="newsletterForm.subject.$dirty && newsletterForm.subject.$invalid">
                <span ng-cloak ng-show="newsletterForm.subject.$error.required">Заповніть поле!</span>
                </div>

                <div class="form-group col-md-8">
                    <label>Лист</label>
                    <textarea ckeditor="editorOptions" class="form-control" rows="6" name="message" id="message"
                              placeholder="Лист" required ng-model="message"></textarea>
                    <span style="color:red" ng-show="newsletterForm.message.$dirty && newsletterForm.message.$invalid">
                <span ng-cloak ng-show="newsletterForm.message.$error.required">Заповніть поле!</span>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary"
                            ng-click="send();">
                        Надіслати
                    </button>
                    <button type="reset" class="btn btn-default"
                            ng-click="clearForm()">
                        Очистити форму
                    </button>
                    <button type="reset" class="btn btn-default"
                            ng-click="cancel()">
                        Скасувати
                    </button>
                    <button type="reset" class="btn btn-default"
                            ng-bootbox-title="Оберіть шаблон повідомлення"
                            ng-bootbox-custom-dialog
                            ng-bootbox-class-name="mailTemplate"
                            ng-bootbox-custom-dialog-template="<?php echo StaticFilesHelper::fullPathTo('angular', 'js/teacher/templates/mailTemplate.html'); ?>">
                        Завантажити шаблон
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>