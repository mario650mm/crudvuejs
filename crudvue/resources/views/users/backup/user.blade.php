@extends('layouts.app')

@section('content')
    <div id="usuario">
        <edit-usuario>
        </edit-usuario>
    </div>
    <template id="edit-usuario-template">
        <div class="container">
            <form id="usuarioForm">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <input type="hidden" id="currentPage" name="currentPage"/>
                    <div class="form-group col-sm-6">
                        <input type="text" id="name" name="name" class="form-control"
                               v-model="name" v-on:keydown="filter($event)"/>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
                <tr v-for="user in users">
                    <td>@{{user.name}}</td>
                    <td>@{{user.email}}</td>
                </tr>
            </table>
            <div class="row">
                <center>
                    <nav>
                        <ul class="pagination">
                            <li v-if="pagination.current_page > 1">
                                <a href="#" aria-label="Previous"
                                   v-on:click="changePage($event,pagination.current_page - 1)">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li v-for="page in pagesNumber"
                                v-bind:class="[ page == isActived ? 'active' : '']">
                                <a href="#"
                                   v-on:click="changePage($event,page)">@{{ page }}</a>
                            </li>
                            <li v-if="pagination.current_page < pagination.last_page">
                                <a href="#" aria-label="Next"
                                   v-on:click="changePage($event,pagination.current_page + 1)">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
            </div>
        </div>
        </div>
    </template>
@endsection

@section('scripts')
    <script type="text/javascript">
        var url = "{{url("")}}";
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
                    var url = window.url + '/api/users';
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
                }
            }
        });

        var vm = new Vue({
            el: '#usuario'
        });
    </script>
@endsection