Vue.component('edit-usuario', {
    template: '#edit-usuario-template',
    props: [],
    data: function () {
        return {
            pagination: {
                total: 0,
                per_page: 15,
                from: 1,
                to: 0,
                current_page: 1
            },
            offset: 4,
            users: [],
            name: ''
        };
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }

            return pagesArray;
        }
    },
    mounted: function () {
        this.fetchDataUsers(1);
    },
    methods: {
        filter: function (event) {
            var tecla = (document.all) ? event.keyCode : event.which;
            if(tecla == 8 && document.getElementById('name').value.length == 1){
                document.getElementById('name').value = "";
                this.name = "";
            }
            this.fetchDataUsers(document.getElementById('currentPage').value);

        },
        fetchDataUsers: function (pageSelected) {
            var vueComponente = this;
            if (pageSelected == undefined) {
                pageSelected = 1;
            }
            document.getElementById('currentPage').value = pageSelected;
            var url = window.url + '/api/users?page='+pageSelected;
            var formData = new FormData(document.getElementById('usuarioForm'));
            $.ajax({
                method: "post",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    Vue.set(vueComponente.$data, 'users', data.model.data.data);
                    Vue.set(vueComponente.$data, 'pagination', data.model.pagination);
                },
                error: function (error) {
                    console.log(error);

                }
            });
        },
        changePage: function (event, page) {
            event.preventDefault();
            this.pagination.current_page = page;
            this.fetchDataUsers(page);
        },
        editView: function (userId) {
            window.location = window.url+"/users/edit/"+userId;
        }
    }
});

var vm = new Vue({
    el: '#usuario'
});