<div class="modal-dialog" role="dialog" id="modal-create">
  <div class="modal-content" style="border-radius: 10px;">
    {!! Form::open(['url' => action([\App\Http\Controllers\Optics\MaterialTypeController::class, 'store']), 'method' => 'post',
      'id' => $quick_add ? 'quick_add_material_type_form' : 'material_type_add_form']) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <h4 class="modal-title">@lang('material_type.add_material_type')</h4>
    </div>

    <div class="modal-body">
      <!-- Name -->
      <div class="form-group">
        {!! Form::label('name', __('cashier.name') . ': *') !!}
        <div class="wrap-inputform">
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('cashier.name')]) !!}
        </div>
      </div>
      <!-- Description -->
      <div class="form-group">
        {!! Form::label('description', __('accounting.description') . ': ') !!}
        <div class="wrap-inputform">
          {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' =>
          __('accounting.description')]) !!}
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
      <button type="button" data-dismiss="modal" aria-label="Close"
        class="btn btn-default">@lang('messages.close')</button>
    </div>
    {!! Form::close() !!}
  </div>
</div>
