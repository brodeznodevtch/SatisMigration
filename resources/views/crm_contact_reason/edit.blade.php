<div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px;">
        {!! Form::open(['url' => action([\App\Http\Controllers\CRMContactReasonController::class, 'update'], [$contact_reason->id]), 'method' => 'PUT', 'id' => 'contactreason_edit_form']) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">@lang('crm.edit_contactreason')</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('name', __('crm.name') . ' : ') !!}
                <div class="wrap-inputform">
                    {!! Form::text('name', $contact_reason->name, ['class' => 'inputform2', 'required', 'placeholder' => __('crm.name')]); !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('description', __('crm.description') . ' : ') !!}
                <div class="wrap-inputform">
                    {!! Form::text('description', $contact_reason->description, ['class' => 'inputform2', 'placeholder' => __('crm.description')]); !!}
                </div>
            </div>
        </div>
        <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.update')</button>
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-default">@lang('messages.close')</button>
        </div>
            {!! Form::close() !!}
    </div>
</div>