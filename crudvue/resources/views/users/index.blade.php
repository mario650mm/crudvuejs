@extends('layouts.app')

@section('page_title')
    @lang('users.users')
@endsection

@section('content')
    <div id="usuario">
        <edit-usuario>
        </edit-usuario>
    </div>
    <template id="edit-usuario-template">
        <div class="container">
            <form id="usuarioForm">
                <h3>@lang('users.users')</h3>
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"/>
                <input type="hidden" id="currentPage" name="currentPage"/>
                <div class="row">
                    <div class="form-group col-sm-2 pull-left">
                        <a href="{{url("/users/create")}}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> @lang('general.create')
                        </a>
                    </div>
                    <div class="form-group col-sm-4">
                        <input type="text" id="name" name="name" class="form-control input-sm"
                               v-model="name" v-on:keydown="filter($event)"
                               placeholder="Buscar por nombre"/>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <tr>
                    <th>@lang('users.name')</th>
                    <th>@lang('users.email')</th>
                    <th>@lang('users.city')</th>
                    <th>@lang('users.state')</th>
                    <th>@lang('users.country')</th>
                    <th>@lang('general.actions')</th>
                </tr>
                <tr v-for="user in users">
                    <td>@{{user.name}}</td>
                    <td>@{{user.email}}</td>
                    <td>@{{user.cityName}}</td>
                    <td>@{{user.stateName}}</td>
                    <td>@{{user.countryName}}</td>
                    <td><button type="button" class="btn btn-primary btn-sm" v-on:click="editView(user.id)">
                            <i class="fa fa-edit"></i> @lang('general.edit')
                        </button>
                    </td>
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
                </center>
            </div>
        </div>
    </template>
@endsection

@section('scripts')
    <script type="text/javascript">
        var url = "{{url("")}}";
    </script>
    <script src="{{asset("/js/catalogos/usersIndex.js")}}"></script>
@endsection