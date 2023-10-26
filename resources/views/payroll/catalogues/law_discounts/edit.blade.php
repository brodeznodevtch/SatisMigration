{!! Form::open(['method' => 'put', 'id' => 'form_edit_law_discount']) !!}
<div class="modal-header">
    <h4 class="modal-title" id="formModal">@lang('payroll.law_discount_table')
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModal()">
            <span aria-hidden="true">&times;</span>
        </button>
    </h4>
</div>

<div class="modal-body">
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.institution_laws')</label> <span class="text-danger">*</span>
                <select name="institution_law_id" id="institution_law_id" class="form-control form-control-sm select2"
                    placeholder="{{ __('payroll.institution_laws') }}" style="width: 100%;" required>
                    <option value="">{{ __('payroll.institution_laws') }}</option>
                    @foreach ($institutions as $institution)
                        @if ($institution->id == $lawDiscount->institution_law_id)
                            <option value="{{ $institution->id }}" selected>{{ $institution->name }}</option>
                        @else
                            <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.from')</label> <span class="text-danger">*</span>
                {!! Form::number('from', $lawDiscount->from, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.from'),
                    'id' => 'from',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.until')</label>
                {!! Form::number('until', $lawDiscount->until, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.until'),
                    'id' => 'until',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.base')</label> <span class="text-danger">*</span>
                {!! Form::number('base', $lawDiscount->base, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.base'),
                    'id' => 'base',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.employee_percentage')</label> <span class="text-danger">*</span>
                {!! Form::number('employee_percentage', $lawDiscount->employee_percentage, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.employee_percentage'),
                    'id' => 'employee_percentage',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.fixed_fee')</label>
                {!! Form::number('fixed_fee', $lawDiscount->fixed_fee, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.fixed_fee'),
                    'id' => 'fixed_fee',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.employer_value')</label> <span class="text-danger">*</span>
                {!! Form::number('employer_value', $lawDiscount->employer_value, [
                    'class' => 'form-control form-control-sm',
                    'placeholder' => __('payroll.employer_value'),
                    'id' => 'employer_value',
                    'required',
                ]) !!}
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>@lang('payroll.calculation_types')</label> <span class="text-danger">*</span>
                <select name="payment_period_id" id="payment_period_id" class="form-control form-control-sm select2"
                    placeholder="{{ __('payroll.calculation_types') }}" style="width: 100%;" required>
                    @foreach ($paymentPeriods as $paymentPeriod)
                        @if ($paymentPeriod->id == $lawDiscount->payment_period_id)
                            <option value="{{ $paymentPeriod->id }}" selected>{{ $paymentPeriod->name }}</option>
                        @else
                            <option value="{{ $paymentPeriod->id }}">{{ $paymentPeriod->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label>@lang('rrhh.status')</label>
				{!! Form::select('status', [1 => __('rrhh.active'), 0 => __('rrhh.inactive')], $lawDiscount->status, ['class' => 'form-control select2', 'id' => 'status', 'required', 'style' => 'width: 100%;' ]) !!}
			</div>
		</div>

    </div>
</div>
<div class="modal-footer">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	<input type="hidden" name="id" value="{{ $lawDiscount->id }}" id="id">
    <button type="button" class="btn btn-primary" id="btn_edit_law_discount">@lang('payroll.edit')</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal"
        onClick="closeModal()">@lang('messages.cancel')</button>
</div>
{!! Form::close() !!}
<script>
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('.select2').select2();
    });


    $("#btn_edit_law_discount").click(function() {
		id = $("#id").val();
        route = "/law-discount/" + id;
        token = $("#token").val();

        var form = $("#form_edit_law_discount");
        var formData = new FormData(form[0]);
        
        $.ajax({
            url: route,
            headers: {
                'X-CSRF-TOKEN': token
            },
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function(result) {
                if (result.success == true) {
                    Swal.fire({
                        title: result.msg,
                        icon: "success",
                        timer: 1000,
                        showConfirmButton: false,
                    });
                    $("#law-discount-table").DataTable().ajax.reload(null, false);
                    $('#modal_edit').modal('hide').data('bs.modal', null);
                } else {
                    Swal.fire({
                        title: result.msg,
                        icon: "error",
                    });
                }
            },
            error: function(msj) {
                errormessages = "";
                $.each(msj.responseJSON.errors, function(i, field) {
                    errormessages += "<li>" + field + "</li>";
                });
                Swal.fire({
                    title: "@lang('payroll.error_list')",
                    icon: "error",
                    html: "<ul>" + errormessages + "</ul>",
                });
            }
        });
    });

    function closeModal() {
        $('#modal_edit').modal('hide').data('bs.modal', null);
    }
</script>
