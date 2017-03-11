@extends('layouts.app')

@section('page_title')
    @lang('users.edit_user')
@endsection

@section('content')
    <div id="usuario">
        <edit-usuario d_user="{{$user}}" d_countrys="{{$countrys}}">
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
                <div class="col-sm-2 pull-right">
                    @include('users.partials.delete')
                </div>
            </div>
            <h3>@lang('users.edit_user')</h3>
            <form id="userForm">
                <br>
                @include('users.partials.inputs')
                <br>
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">@lang('users.edit_user')</h4>
                            </div>
                            <div class="modal-body">
                                @lang('users.updated_confirmation') <b>{{    $user->name}}</b> ?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success btn-sm" v-on:click="send($event)"><i
                                            class="fa fa-floppy-o"></i> @lang('general.save')</button>
                                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i
                                            class="fa fa-times"></i> @lang('general.cancel')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#updateModal">
                    <i class="fa fa-floppy-o"></i> @lang('general.save')
                </button>
            </form>
        </div>
    </template>
@endsection

@section('scripts')
    <script type="text/javascript">
        var url = "{{url("")}}";
        var urlRegister = "{{url("/users/update/".$user->id)}}";
        var urlValidation = "";
    </script>
    <script src="{{asset("/js/catalogos/user.js")}}"></script>
@endsection