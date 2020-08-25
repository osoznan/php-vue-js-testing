<?php

use app\site\models\Acquire;

?>

<div class="container">
    <h1 class="header-text">PHP + VueJs Testing</h1>
    Author: Zemlyansky Alexander.<p>
    Empowered by author's Patri PHP MVC framework. VueJs 2.6, without JQuery, Bootstrap 4.0

    <hr>

    <div id="vue-app">

        <div v-if="!isSent">
            <div class="row">
                <div class="col-md-6">
                    <label><?= Acquire::getLabel('name')  ?></label>
                    <input v-model="name" class="form-control">
                    <span class="text-danger">{{ errors.name }}</span>
                </div>
                <div class="col-md-6 pt-sm-3 pt-md-0">
                    <label><?= Acquire::getLabel('phone')  ?></label>
                    <input v-model="phone" class="form-control">
                    <span class="text-danger">{{ errors.phone }}</span>
                </div>
                <div class="col-md-12 pt-3">
                    <label><?= Acquire::getLabel('description')  ?></label>
                    <textarea rows="5" v-model="description" class="form-control"></textarea>
                    <span class="text-danger">{{ errors.description }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 pt-3">
                    <label>Место сохранения</label>
                    <select v-model="storageType" class="form-control">
                        <option for="storage2" value="FileStorage">Файл</option>
                        <option for="storage1" value="DbStorage">База данных</option>
                        <option for="storage3" value="MailStorage">Почта</option>
                    </select>
                </div>
            </div>

            <div class="row p-3">
                <a class="btn btn-primary" @click="submitForm">Сохранить</a>
            </div>
        </div>
        <div v-else class="text-center">
            Ваша заявка обработана с помощью хранилища "{{ storageType }}" <br>
            <a class="btn btn-primary mt-3" @click="reset">Ввести заявку снова</a>
        </div>
    </div>

</div>
