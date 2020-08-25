document.addEventListener('DOMContentLoaded', function() {

    new Vue({
        el: '#vue-app',
        data: {
            name: '',
            phone: '',
            description: '',
            storageType: 'FileStorage',
            errors: {name: null, phone: null, description: null},
            isSent: false
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
