Vue.component('edit-usuario', {
    template: '#edit-usuario-template',
    props: ['d_user','d_countrys'],
    data: function () {
        return {
            user:{},
            countrys:[],
            states:[],
            citys:[]
        };
    },
    methods: {
        send:function (event) {
            event.preventDefault();
            $(".error").empty();
            var url = window.urlRegister;
            var formData = new FormData(document.getElementById('userForm'));
            $.ajax({
                method: "post",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data["result"] == "ok") {
                        if(window.urlValidation == window.urlRegister){
                            window.location = window.url + "/users/list/create/"+data["message"];
                        }else{
                            window.location = window.url + "/users/list/update/"+data["message"];
                        }
                    }
                },
                error: function (error) {
                    if (error.responseText.length > 0) {
                        this.errors = JSON.parse(error.responseText);
                        $.each(this.errors, function (key, value) {
                            document.getElementById("span_" + key).innerHTML = value;
                        });
                        console.clear();
                    }
                }
            });

        },
        selectedCountry: function () {
            var url = window.url + "/states/showStatesByCountry/"+this.user.country_id;
            this.getItems(url,'states');
        },
        selectedState: function () {
            var url = window.url + "/citys/showCitysByState/"+this.user.state_id;
            this.getItems(url,'citys');

        },
        getItems: function (url,selectNam) {
            var vueComponente = this;
            var selectName = selectNam;
            $.ajax({
                url: url,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    switch(selectName){
                        case "states":
                            vueComponente.states = JSON.parse(data);
                            break;
                        case "citys":
                            vueComponente.citys = JSON.parse(data);
                            break;
                    }
                    Vue.nextTick(function () {
                       $("#"+selectName+"").selectpicker("refresh");
                    });
                },
                error: function (error) {
                    console.log(error);

                }
            });

        }
    },
    created: function () {
        if(this.d_user.length > 0){
            this.user = JSON.parse(this.d_user);
            this.selectedCountry();
            this.selectedState();
        }
        if(this.d_countrys.length > 0){
            this.countrys = JSON.parse(this.d_countrys);
        }
    }
});

var vm = new Vue({
    el: '#usuario'
});