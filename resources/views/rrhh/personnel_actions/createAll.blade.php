@extends('layouts.app')
@section('title', __('rrhh.personnel_actions_massive'))
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('rrhh.add') @lang('rrhh.personnel_actions_massive')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="boxform_u box-solid_u">
            {!! Form::open(['method' => 'post', 'id' => 'form_add_personnel_action']) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>@lang('rrhh.types_personnel_actions')</label> <span class="text-danger">*</span>
                            <select name="rrhh_type_personnel_action_id" id="rrhh_type_personnel_action_id"
                                class="form-control form-control-sm select2" style="width: 100%;" required>
                                @foreach ($typesPersonnelActions as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>@lang('rrhh.apply_to')</label> <span class="text-danger">*</span>
                            <select name="apply_to" id="apply_to" class="form-control form-control-sm select2"
                                style="width: 100%;" required>
                                <option value="all_active_employees">@lang('rrhh.all_active_employees')</option>
                                <option value="all_department">@lang('rrhh.all_department')</option>
                                <option value="all_position">@lang('rrhh.all_position')</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_department" style="display: none">
                        <div class="form-group">
                            <label>@lang('rrhh.to_the_department_of')</label> <span class="text-danger">*</span>
                            {!! Form::select('department_id', $departments, null, [
                                'id' => 'department_id',
                                'class' => 'form-control form-control-sm select2',
                                'placeholder' => __('rrhh.department'),
                                'style' => 'width: 100%;',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_position" style="display: none">
                        <div class="form-group">
                            <label>@lang('rrhh.to_the_position_of')</label> <span class="text-danger">*</span>
                            {!! Form::select('position1_id', $positions, null, [
                                'id' => 'position1_id',
                                'class' => 'form-control form-control-sm select2',
                                'placeholder' => __('rrhh.position'),
                                'style' => 'width: 100%;',
                            ]) !!}
                        </div>
                    </div>

                    <div id="div_salary_history">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>@lang('rrhh.change_by_percentage')</label> <span class="text-danger">*</span>
                                {!! Form::number('percentage', null, [
                                    'class' => 'form-control form-control-sm',
                                    'placeholder' => __('rrhh.change_by_percentage'),
                                    'id' => 'percentage',
                                    'step' => '0.01',
                                    'min' => '0.01',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div id="div_period">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>@lang('rrhh.start_date')</label> <span class="text-danger">*</span>
                                {!! Form::text('start_date', null, ['class' => 'form-control form-control-sm', 'id' => 'start_date']) !!}
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>@lang('rrhh.end_date')</label> <span class="text-danger">*</span>
                                {!! Form::text('end_date', null, ['class' => 'form-control form-control-sm', 'id' => 'end_date']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_effective_date">
                        <div class="form-group">
                            <label>@lang('rrhh.in_force_from')</label> <span class="text-danger">*</span>
                            {!! Form::text('effective_date', null, [
                                'class' => 'form-control form-control-sm',
                                'id' => 'effective_date',
                                'required',
                            ]) !!}
                        </div>
                    </div>

                    <div id="div_position_history">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>@lang('rrhh.new_department')</label> <span class="text-danger">*</span>
                                {!! Form::select('new_department_id', $departments, null, [
                                    'id' => 'new_department_id',
                                    'class' => 'form-control form-control-sm select2',
                                    'placeholder' => __('rrhh.department'),
                                    'style' => 'width: 100%;',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>@lang('rrhh.new_position')</label> <span class="text-danger">*</span>
                                {!! Form::select('new_position1_id', $positions, null, [
                                    'id' => 'new_position1_id',
                                    'class' => 'form-control form-control-sm select2',
                                    'placeholder' => __('rrhh.position'),
                                    'style' => 'width: 100%;',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_payment">
                        <div class="form-group">
                            <label>@lang('rrhh.way_to_pay')</label> <span class="text-danger">*</span>
                            {!! Form::select('payment_id', $payments, null, [
                                'id' => 'payment_id',
                                'class' => 'form-control form-control-sm select2',
                                'placeholder' => __('rrhh.way_to_pay'),
                                'style' => 'width: 100%;',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_bank">
                        <div class="form-group">
                            <label>@lang('rrhh.bank')</label> <span class="text-danger">*</span>
                            {!! Form::select('bank_id', $banks, null, [
                                'id' => 'bank_id',
                                'class' => 'form-control form-control-sm select2',
                                'placeholder' => __('rrhh.bank'),
                                'style' => 'width: 100%;',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12" id="div_bank_account">
                        <div class="form-group">
                            <label>@lang('rrhh.bank_account')</label> <span class="text-danger">*</span>
                            {!! Form::number('bank_account', null, [
                                'class' => 'form-control form-control-sm',
                                'placeholder' => __('rrhh.bank_account'),
                                'id' => 'bank_account',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12" id="div_authorizer">
                        <div class="form-group">
                            <label>@lang('rrhh.authorizer')</label> <span class="text-danger">*</span>
                            @show_tooltip(__('rrhh.message_authorizer'))
                            <select name="user_id[]" id="user_id" class="form-control form-control-sm select2"
                                style="width: 100%;" multiple>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endforeach
                                @foreach ($userAdmins as $userAdmin)
                                    <option value="{{ $userAdmin->id }}">{{ $userAdmin->first_name }} {{ $userAdmin->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>@lang('rrhh.description')</label> <span class="text-danger">*</span>
                            {!! Form::textarea('description', null, [
                                'id' => 'description',
                                'placeholder' => __('rrhh.description'),
                                'class' => 'form-control',
                                'rows' => 4,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-primary" id="btn_add_personnel_action">@lang('rrhh.add')</button>
        
                <a href="{!!URL::to('/rrhh-employees')!!}">
                    <button id="cancel_product" type="button" class="btn btn-danger">@lang('messages.cancel')</button>
                </a>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        select2 = $('.select2').select2();

        $('#start_date').datepicker({
            autoclose: true,
            format: datepicker_date_format,
        });

        $('#end_date').datepicker({
            autoclose: true,
            format: datepicker_date_format,
        });

        var fechaMaxima = new Date();
        fechaMaxima = fechaMaxima.toLocaleDateString("es-ES", {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });

        $('#effective_date').datepicker({
            autoclose: true,
            format: datepicker_date_format,
            //startDate: fechaMaxima,
        });

        $("#effective_date").datepicker("setDate", fechaMaxima);

        typePersonnelAction();
    });

    $('#rrhh_type_personnel_action_id').on('change', function() {
        typePersonnelAction();
    });

    function typePersonnelAction() {
        let type_personnel_action = $('#rrhh_type_personnel_action_id').val();
        var types = {!! json_encode($typesPersonnelActions) !!};
        var actions = {!! json_encode($actions) !!};

        $('#div_position_history').hide();
        $("#department_id").prop('required', false);
        $("#position1_id").prop('required', false);

        $('#div_salary_history').hide();
        $("#percentage").prop('required', false);

        $('#div_period').hide();
        $("#start_date").prop('required', false);
        $("#end_date").prop('required', false);

        $('#div_bank_account').hide();
        $("#bank_account").prop('required', false);

        $('#div_payment').hide();
        $("#payment_id").prop('required', false);

        $('#div_bank').hide();
        $("#bank_id").prop('required', false);

        $('#div_effective_date').hide();
        $("#effective_date").prop('required', false);

        //Evaluando si la accion de personal requiere autorizacion
        types.forEach(function(type) {
            if (type.id == type_personnel_action) {
                if (type.required_authorization == 1) { // requiere autorizacion
                    $('#div_authorizer').show();
                    $("#user_id").prop('required', true);
                } else {
                    $('#div_authorizer').hide();
                    $("#user_id").prop('required', false);
                }
            }
        });

        //Evaluaciones las acciones que requiere realizar el tipo de accion de personal
        actions.forEach(function(action) {
            if (action.rrhh_type_personnel_action_id == type_personnel_action) {
                if (action.rrhh_required_action_id == 2) { // Cambiar departamento/puesto
                    $('#div_position_history').show();
                    $("#department_id").prop('required', true);
                    $("#position1_id").prop('required', true);
                    $('#div_effective_date').show();
                    $("#effective_date").prop('required', true);
                }

                if (action.rrhh_required_action_id == 3) { // Cambiar salario
                    $('#div_salary_history').show();
                    $("#percentage").prop('required', true);
                }

                if (action.rrhh_required_action_id == 4) { // Seleccionar un periodo en específico
                    $('#div_period').show();
                    $("#start_date").prop('required', true);
                    $("#end_date").prop('required', true);
                }

                if (action.rrhh_required_action_id == 5) { // Cambiar cuenta bancaria
                    $('#div_bank_account').show();
                    $("#bank_account").prop('required', true);
                }

                if (action.rrhh_required_action_id == 6) { // Cambiar forma de pago
                    $('#div_payment').show();
                    $("#payment_id").prop('required', true);
                    showBankInformation();
                }

                if (action.rrhh_required_action_id == 7) { // Seleccionar la fecha en que entra en vigor
                    $('#div_effective_date').show();
                    $("#effective_date").prop('required', true);
                }
            }
        });
    }


    function showBankInformation() {
        selected_option = $("#payment_id option:selected").text();

        if (selected_option == 'Transferencia bancaria') {
            $('#div_bank').show();
            $("#bank_id").prop('required', true);
            $('#div_bank_account').show();
            $("#bank_account").prop('required', true);
        } else {
            $('#div_bank').hide();
            $("#bank_id").prop('required', false);
            $('#div_bank_account').hide();
            $("#bank_account").prop('required', false);
            $('#bank_id').val('').change();
            $('#bank_account').val('');
        }
    }

    $('#payment_id').change(function() {
        showBankInformation();
    });


    function showApplyToMany() {
        $('#div_position').hide();
        $('#div_department').hide();
        $("#department_id").prop('required', false);
        $('#department_id').val('').change();

        $("#position1_id").prop('required', false);
        $('#position1_id').val('').change();
        selected_option = $("#apply_to option:selected").val();

        if (selected_option == 'all_department') {
            $('#div_department').show();
            $("#department_id").prop('required', true);
        }

        if (selected_option == 'all_position') {
            $('#div_position').show();
            $("#position1_id").prop('required', true);
        }
    }

    $('#apply_to').change(function() {
        showApplyToMany();
    });


    $("#btn_add_personnel_action").click(function() {
        $('#btn_add_personnel_action').attr('disabled', 'disabled');
        route = "/rrhh-personnel-action-masive";
        token = $("#token").val();

        var form = $("#form_add_personnel_action");
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
                    $('#modal_personnel_action').modal('hide').data('bs.modal', null);
                } else {
                    Swal.fire({
                        title: "Error",
                        text: result.msg,
                        icon: "error",
                    });
                    $('#btn_add_personnel_action').prop('disabled', false);
                }
            },
            error: function(msj) {
                errormessages = "";
                $.each(msj.responseJSON.errors, function(i, field) {
                    errormessages += "<li>" + field + "</li>";
                });
                Swal.fire({
                    title: "@lang('rrhh.error_list')",
                    icon: "error",
                    html: "<ul>" + errormessages + "</ul>",
                });
                $('#btn_add_personnel_action').prop('disabled', false);
            }
        });
    });

    function closeModal() {
        $('#modal_personnel_action').modal('hide').data('bs.modal', null);
    }
</script>
@endsection
