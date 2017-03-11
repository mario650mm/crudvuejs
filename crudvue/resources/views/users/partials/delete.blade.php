<form action="{{url("/users/delete/".$user->id)}}" method="post">
    {{ csrf_field() }}
    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
        <i class="fa fa-trash"></i>
        @lang('general.delete')
    </button>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@lang('users.delete_user')</h4>
                </div>
                <div class="modal-body">
                    @lang('users.deleted_confirmation') <b>{{    $user->name}}</b> ?
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-sm"><i
                                class="fa fa-trash"></i> @lang('general.delete')</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i
                                class="fa fa-times"></i> @lang('general.cancel')</button>
                </div>
            </div>
        </div>
    </div>
</form>