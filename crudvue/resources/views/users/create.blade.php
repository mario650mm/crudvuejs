@extends('layouts.app')

@section('page_title')
    @lang('users.create_user')
@endsection

@section('content')
    <div id="usuario">
        <edit-usuario d_user="" d_countrys="{{$countrys}}">
        </edit-usuario>
    </div>
    <template id="edit-usuario-template">
        <div class="container">
            <div class="row">
                <div class="col-sm-2 pull-left">
                    <a href="{{url("/users/list")}}" class="btn btn-warning btn-sm">
                        <i class="fa fa-backward"></i> @lang('general.return')
                    </a>
                </div>
            </div>
            <h3>@lang('users.create_user')</h3>
            <form id="userForm">
                <br>
                @include('users.partials.inputs')
                <br>
                <button type="button" class="btn btn-success btn-sm" v-on:click="send($event)">
                    <i class="fa fa-floppy-o"></i> @lang('general.save')
                </button>
            </form>
        </div>
    </template>
@endsection

@section('scripts')
    <script type="text/javascript">
        var url = "{{url("")}}";
        var urlRegister = "{{url("/users/create")}}";
        var urlValidation = "{{url("/users/create")}}";
    </script>
    <script src="{{asset("/js/catalogos/user.js")}}"></script>
@endsection