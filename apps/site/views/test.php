<?php

use app\site\models\Acquire;

?>

<div class="container">
    <h1 class="header-text">PHP + VueJs Testing</h1>
    Author: Zemlyansky Alexander.<p>
    Empowered by author's Patri PHP MVC framework. VueJs 2.6, without JQuery, Bootstrap 4.0

    <hr>

    <div id="vue-app">
        <zaa-form class="row" :field-data='formData'>
            <template slot="inputs">
                <div class="col-md-6">
                    <label><?= Acquire::getLabel('name')  ?></label>
                    <input field="name" class="form-control">
                    <span class="text-danger">{{ errors.name }}</span>
                </div>
                <div class="col-md-6 pt-sm-3 pt-md-0">
                    <label><?= Acquire::getLabel('phone')  ?></label>
                    <input field="phone" class="form-control">
                    <span class="text-danger">{{ errors.phone }}</span>
                </div>
                <div class="col-md-12 pt-3">
                    <label><?= Acquire::getLabel('description')  ?></label>
                    <textarea rows="5" field="description" class="form-control"></textarea>
                    <span class="text-danger">{{ errors.description }}</span>
                </div>
            </template>
        </zaa-form>

        <div class="row p-3">
            <a class="btn btn-primary" @click="submitForm">Сохранить</a>
        </div>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        Vue.component('zaa-form', {
            data: function() {
                return {
                    values: {},
                    errors: {}
                }
            },
            mounted() {
                this._registerFormParams()
            },
            methods: {
                _registerFormParams() {
                    for (let el of this.$el.querySelectorAll('*')) {
                        if (field = el.getAttribute('field')) {
                            this.$set(this.values, field, el.getAttribute('value'));
                            this.$set(this.errors, field)
                        }
                    }
                }
            },
            template: `<div>
            <slot name="inputs"></slot>
            </div>`
        });

        vm = new Vue({
            el: '#vue-app',
            data: {
                // formData: [
                //     {name: 'name', type: input, label: 'name label'},
                //     {name: 'phone', type: input, label: 'phone'},
                //     {name: 'description', type: input, label: 'description'},
                // ]
                formData
            },
            methods: {
                submitForm: function() {
                    var _this = this;

                    this.errors = {}

                    this.name = this.name.trim();
                    this.phone = this.phone.trim();
                    this.description = this.description.trim();

                    ajax(
                        '/site/site/save-acquire',
                        {
                            storage_type: this.storageType,
                            attributes: {
                                name: this.name,
                                phone: this.phone,
                                description: this.description
                            }
                        },
                        function() {
                            _this.isSent = true;
                        },
                        function(data) {
                            data = JSON.parse(data.response);
                            _this.errors = data.error;
                        }
                    )
                },
                reset: function() {
                    this.name = this.phone = this.description = '';
                    this.isSent = false
                }
            }
        })

    })

</script>
