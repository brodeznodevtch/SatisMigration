@extends('layouts.app')
@section('title', __('rrhh.rrhh'))
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('rrhh.edit') @lang('rrhh.employee')</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="boxform_u box-solid_u">
            {!! Form::model($employee, [
                'url' => action('EmployeesController@update', $employee->id),
                'method' => 'patch',
                'id' => 'form_edit',
                'files' => true,
            ]) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">@lang('customer.general_information')
                                <div class="panel-tools pull-right">
                                    <button type="button" class="btn btn-panel-tool" data-toggle="collapse"
                                        data-target="#general-information-fields-box" id="btn-collapse-gi">
                                        <i class="fa fa-minus" id="create-icon-collapsed-gi"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-body collapse in" id="general-information-fields-box" aria-expanded="true">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.name')</label> <span class="text-danger">*</span>
                                            {!! Form::text('first_name', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.name'),
                                                'id' => 'first_name',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.last_name')</label> <span class="text-danger">*</span>
                                            {!! Form::text('last_name', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.last_name'),
                                                'id' => 'last_name',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.gender')</label> <span class="text-danger">*</span>
                                            {!! Form::select('gender', ['M' => __('rrhh.male'), 'F' => __('rrhh.female')], $employee->gender, [
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.gender'),
                                                'style' => 'width: 100%;',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.nationality')</label> <span class="text-danger">*</span>
                                            {!! Form::select('nationality_id', $nationalities, $employee->nacionality_id, [
                                                'id' => 'nationality_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.nationality'),
                                                'style' => 'width: 100%;',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.birthdate')</label> <span class="text-danger">*</span>
                                            {!! Form::text('birth_date', @format_date($employee->birth_date), [
                                                'class' => 'form-control form-control-sm',
                                                'id' => 'birth_date',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.dni')</label> <span class="text-danger">*</span>
                                            {!! Form::text('dni', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => '00000000-0',
                                                'id' => 'dni',
                                                'required',
                                                'pattern' => '[0-9]{8}-\d',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.tax_number')</label> <label id="text-approved"
                                                @if ($employee->approved == 0) disabled @endif>(Homologado)</label> <span
                                                class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    {!! Form::checkbox('approved', $employee->approved, $employee->approved, [
                                                        'id' => 'approved',
                                                        'onClick' => 'nitApproved()',
                                                    ]) !!}
                                                </span>
                                                @if ($employee->approved == 1)
                                                    {!! Form::text('tax_number', $employee->tax_number, [
                                                        'class' => 'form-control form-control-sm',
                                                        'id' => 'tax_number',
                                                        'placeholder' => __('rrhh.tax_number'),
                                                        'required',
                                                    ]) !!}
                                                @else
                                                    {!! Form::text('tax_number', $employee->tax_number, [
                                                        'class' => 'form-control form-control-sm',
                                                        'id' => 'tax_number',
                                                        'placeholder' => __('rrhh.tax_number'),
                                                        'required',
                                                        'disabled',
                                                    ]) !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.marital_status')</label> <span class="text-danger">*</span>
                                            {!! Form::select('civil_status_id', $civil_statuses, $employee->civil_status_id, [
                                                'id' => 'civil_status_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.marital_status'),
                                                'style' => 'width: 100%;',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.phone')</label>
                                            {!! Form::text('phone', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => '0000-0000',
                                                'id' => 'phone',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.mobile_phone')</label>
                                            {!! Form::text('mobile', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => '0000-0000',
                                                'id' => 'mobile',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.personal_email')</label> <span class="text-danger">*</span>
                                            @show_tooltip(__('rrhh.tooltip_email'))
                                            {!! Form::email('email', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.personal_email'),
                                                'id' => 'email',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.institutional_email')</label>
                                            {!! Form::email('institutional_email', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.institutional_email'),
                                                'id' => 'institutional_email',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.address')</label> <span class="text-danger">*</span>
                                            {!! Form::text('address', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.address'),
                                                'id' => 'address',
                                                'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.country')</label>
                                            {!! Form::select('country_id', $countries, $employee->country_id, [
                                                'id' => 'country_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.country'),
                                                'style' => 'width: 100%;',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.state')</label>
                                            {!! Form::select('state_id', $states, $employee->state_id, [
                                                'id' => 'state_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.state'),
                                                'style' => 'width: 100%;',
                                                'disabled',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.city')</label>
                                            {!! Form::select('city_id', $cities, $employee->city_id, [
                                                'id' => 'city_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.city'),
                                                'style' => 'width: 100%;',
                                                'disabled',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.social_security_number')</label>
                                            {!! Form::number('social_security_number', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.social_security_number'),
                                                'id' => 'social_security_number',
                                                'pattern' => '[0-9]+',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.afp')</label>
                                            {!! Form::select('afp_id', $afps, $employee->afp_id, [
                                                'id' => 'afp_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.afp'),
                                                'style' => 'width: 100%;',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.afp_number')</label>
                                            {!! Form::number('afp_number', null, [
                                                'class' => 'form-control form-control-sm',
                                                'placeholder' => __('rrhh.afp_number'),
                                                'id' => 'afp_number',
                                                'pattern' => '[0-9]+',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.date_admission')</label> <span class="text-danger">*</span>
                                            @if ($employee->date_admission != null)
                                                {!! Form::text('date_admission', @format_date($employee->date_admission), [
                                                    'class' => 'form-control form-control-sm',
                                                    'id' => 'date_admission',
                                                    'required',
                                                ]) !!}
                                            @else
                                                {!! Form::text('date_admission', @format_date('now'), [
                                                    'class' => 'form-control form-control-sm',
                                                    'id' => 'date_admission',
                                                    'required',
                                                ]) !!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.department')</label> <span class="text-danger">*</span>
                                            @if (count($position) != 0)
                                                {!! Form::select('department_id', $departments, count($position) != 0 ? $position[0]->new_department_id : null, [
                                                    'id' => 'department_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.department'),
                                                    'style' => 'width: 100%;',
                                                    'required',
                                                ]) !!}{{-- Disabled --}}
                                            @else
                                                {!! Form::select('department_id', $departments, count($position) != 0 ? $position[0]->new_department_id : null, [
                                                    'id' => 'department_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.department'),
                                                    'style' => 'width: 100%;',
                                                    'required',
                                                ]) !!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.position')</label> <span class="text-danger">*</span>
                                            @if (count($position) != 0)
                                                {!! Form::select('position1_id', $positions, count($position) != 0 ? $position[0]->new_position1_id : null, [
                                                    'id' => 'position1_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.position'),
                                                    'style' => 'width: 100%;',
                                                    'required',
                                                ]) !!}{{-- Disabled --}}
                                            @else
                                                {!! Form::select('position1_id', $positions, count($position) != 0 ? $position[0]->new_position1_id : null, [
                                                    'id' => 'position1_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.position'),
                                                    'style' => 'width: 100%;',
                                                    'required',
                                                ]) !!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.type_employee')</label>
                                            <select name="type_id" id="type_id"
                                                class="form-control form-control-sm select2"
                                                placeholder="{{ __('rrhh.type_employee') }}" style="width: 100%">
                                                <option value="">{{ __('rrhh.type_employee') }}</option>
                                                @foreach ($types as $type)
                                                    @if ($employee->type_id == $type->id)
                                                        <option value="{{ $type->id }}" selected>{{ $type->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.salary')</label> <span class="text-danger">*</span>
                                            @if (count($salary) != 0)
                                                {!! Form::number('salary', count($salary) != 0 ? $salary[0]->new_salary : null, [
                                                    'class' => 'form-control form-control-sm',
                                                    'placeholder' => __('rrhh.salary'),
                                                    'id' => 'salary',
                                                    'step' => '0.01',
                                                    'min' => '0.01',
                                                    'required',
                                                ]) !!} {{-- Disabled --}}
                                            @else
                                                {!! Form::number('salary', count($salary) != 0 ? $salary[0]->new_salary : null, [
                                                    'class' => 'form-control form-control-sm',
                                                    'placeholder' => __('rrhh.salary'),
                                                    'id' => 'salary',
                                                    'step' => '0.01',
                                                    'min' => '0.01',
                                                    'required',
                                                ]) !!}
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>@lang('rrhh.profession_occupation')</label>
                                            {!! Form::select('profession_id', $professions, $employee->profession_id, [
                                                'id' => 'profession_id',
                                                'class' => 'form-control form-control-sm select2',
                                                'placeholder' => __('rrhh.profession_occupation'),
                                                'style' => 'width: 100%;',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12"
                                        @if ($employee->payment_id != null) style="display: none" @endif>
                                        <div class="form-group">
                                            <label>@lang('rrhh.way_to_pay')</label> <span class="text-danger">*</span>
                                            @if ($employee->payment_id == null)
                                                {!! Form::select('payment_id', $payments, null, [
                                                    'id' => 'payment_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.way_to_pay'),
                                                    'style' => 'width: 100%;',
                                                    'required',
                                                ]) !!}
                                            @else
                                                {!! Form::select('payment_id', $payments, $employee->payment_id, [
                                                    'id' => 'payment_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.way_to_pay'),
                                                    'style' => 'width: 100%;',
                                                ]) !!}
                                            @endif
                                        </div>
                                    </div>

                                    <div id='bank_information'>
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12"
                                            @if ($employee->bank_id != null) style="display: none" @endif>
                                            <div class="form-group">
                                                <label>@lang('rrhh.bank')</label> <span class="text-danger">*</span>
                                                {!! Form::select('bank_id', $banks, $employee->bank_id, [
                                                    'id' => 'bank_id',
                                                    'class' => 'form-control form-control-sm select2',
                                                    'placeholder' => __('rrhh.bank'),
                                                    'style' => 'width: 100%;',
                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12"
                                            @if ($employee->bank_account != null) style="display: none" @endif>
                                            <div class="form-group">
                                                <label>@lang('rrhh.bank_account')</label> <span class="text-danger">*</span>
                                                {!! Form::number('bank_account', null, [
                                                    'class' => 'form-control form-control-sm',
                                                    'placeholder' => __('rrhh.bank_account'),
                                                    'id' => 'bank_account',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <br>
                                            <div class="checkbox" style="margin-top: 0;">
                                                <label>
                                                    {!! Form::checkbox('status', 1, $employee->status, ['id' => 'status']) !!}
                                                    <strong>@lang('rrhh.status')</strong>
                                                </label>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel panel-default">
                            <div class="panel-heading">@lang('rrhh.files')
                                <div class="panel-tools pull-right">
                                    <button type="button" class="btn btn-panel-tool" data-toggle="collapse"
                                        data-target="#files-information-fields-box" id="btn-collapse-li">
                                        <i class="fa fa-minus" id="create-icon-collapsed-li"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-body collapse in" id="files-information-fields-box" aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            {!! Form::label('photo', __('rrhh.photo') . ':') !!}
                                            {!! Form::file('photo', ['id' => 'photo', 'accept' => 'image/*']) !!}
                                            <small class="help-block">
                                                @lang('purchase.max_file_size', ['size' => config('constants.document_size_limit') / 1000000]).
                                                @if (!empty($employee->photo))
                                                    <br>@lang('lang_v1.previous_image_will_be_replaced')
                                                @endif
                                            </small>
                                        </div>
                                        <br>
                                        @if (!empty($employee->photo))
                                            <div class="col-lg-12 col-md-12 col-sm-12" id='div_photo'></div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            {!! Form::label('curriculum_vitae', __('rrhh.curriculum_vitae') . ':') !!}
                                            {!! Form::file('curriculum_vitae', ['id' => 'curriculum_vitae', 'accept' => 'application/pdf']) !!}
                                            <small class="help-block">
                                                @lang('purchase.max_file_size', ['size' => config('constants.document_size_limit') / 1000000]).
                                                @if (!empty($employee->curriculum_vitae))
                                                    <br>@lang('lang_v1.previous_file_will_be_replaced')
                                                @endif
                                            </small>
                                        </div>
                                        <br>
                                        @if (!empty($employee->curriculum_vitae))
                                        <ul class="list-group">
                                            @php
                                                $name = explode('_', $employee->curriculum_vitae);
                                            @endphp
                                            <li class="list-group-item"><a href="/rrhh-employees-downloadCv/{{ $employee->id }}"><i class="fa fa-file" aria-hidden="true"></i> {{ $name[1] }}</a></li>
                                        </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">@lang('rrhh.documents')
                                <div class="panel-tools pull-right">
                                    <button type="button" class="btn btn-panel-tool" data-toggle="collapse"
                                        data-target="#documents-information-fields-box" id="btn-collapse-fi">
                                        <i class="fa fa-minus" id="create-icon-collapsed-fi"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="panel-body collapse in" id="documents-information-fields-box"
                                aria-expanded="true">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <table class="table table-responsive table-condensed table-text-center"
                                            style="font-size: inherit;" id="documents-table">
                                            <thead>
                                                <tr class="active">
                                                    <th width="5%"></th>
                                                    <th width="20%">@lang('rrhh.document_type')</th>
                                                    <th>@lang('rrhh.date_expedition')</th>
                                                    <th>@lang('rrhh.date_expiration')</th>
                                                    <th width="12%">@lang('rrhh.number')</th>
                                                    <th width="10%">@lang('rrhh.status')</th>
                                                    <th width="15%">@lang('rrhh.file')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="referencesItems">
                                                @if (count($documents) > 0)
                                                    @if (count($type_documents) == 0)
                                                        @foreach ($documents as $item)
                                                            <tr style="background: #DFF0D8">
                                                                <td><i class="alert alert-success fa fa-check"></i></td>
                                                                <td>{{ $item->type }}</td>
                                                                <td>
                                                                    @if ($item->date_expedition != null)
                                                                        {{ @format_date($item->date_expedition) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->date_expiration != null && $item->date_required == 1)
                                                                        {{ @format_date($item->date_expiration) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->number != null)
                                                                        {{ $item->number }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->date_expiration == null || $item->date_expiration >= Carbon::now()->format('Y-m-d'))
                                                                        <span class="badge"
                                                                            style="background: #449D44">Vigente</span>
                                                                    @else
                                                                        <span class="badge"
                                                                            style="background: #C9302C">Expirado</span>
                                                                    @endif
                                                                </td>
                                                                <td><button type="button"
                                                                        onClick="viewFile({{ $item->id }})"
                                                                        class="btn btn-info btn-xs"><i
                                                                            class="fa fa-eye"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        @foreach ($documents as $item)
                                                            <tr style="background: #DFF0D8">
                                                                <td><i class="fa fa-check"></i></td>
                                                                <td>{{ $item->type }}</td>
                                                                <td>
                                                                    @if ($item->date_expedition != null)
                                                                        {{ @format_date($item->date_expedition) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->date_expiration != null && $item->date_required == 1)
                                                                        {{ @format_date($item->date_expiration) }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->number != null)
                                                                        {{ $item->number }}
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($item->date_expiration == null || $item->date_expiration >= Carbon::now()->format('Y-m-d'))
                                                                        <span class="badge"
                                                                            style="background: #449D44">Vigente</span>
                                                                    @else
                                                                        <span class="badge"
                                                                            style="background: #C9302C">Expirado</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @can('rrhh_document_employee.view')
                                                                        <button type="button"
                                                                            onClick="filesDocument({{ $item->id }}, {{ $employee->id }})"
                                                                            class="btn btn-info btn-xs"><i
                                                                                class="fa fa-list"></i>
                                                                        </button>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @foreach ($type_documents as $item)
                                                            @if ($item->value != '')
                                                                <tr>
                                                                    <td><i class="glyphicon glyphicon-remove"></i></td>
                                                                    <td>{{ $item->value }}</td>
                                                                    <td colspan="5" class="text-center">
                                                                        @lang('rrhh.no_file')</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @if (count($type_documents) > 0)
                                                        @foreach ($type_documents as $item)
                                                            <tr>
                                                                <td><i class="glyphicon glyphicon-remove"></i></td>
                                                                <td>{{ $item->value }}</td>
                                                                <td colspan="5" class="text-center">@lang('rrhh.no_file')
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">@lang('lang_v1.no_records')</td>
                                                        </tr>
                                                    @endif

                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ $employee->id }}">
                    </div>
                </div>
            </div>

            <div class="box-footer text-right">
                <button type="button" class="btn btn-primary" id="btn_edit_item">@lang('rrhh.update')</button>

                <a href="{!! URL::to('/rrhh-employees') !!}">
                    <button id="cancel_product" type="button" class="btn btn-danger">@lang('messages.cancel')</button>
                </a>
            </div>
            {!! Form::close() !!}
        </div>


        <div class="modal fade" id="modal_edit_action" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" id="modal_content_edit_document">

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_doc" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="modal_content_document">

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_photo" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" id="modal_content_photo">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            select2 = $('.select2').select2();
            showBankInformation();
            getPhoto();
            getDocuments();

            let dui = document.getElementById("dni");
            $(dui).mask("00000000-0");

            var fechaMaxima = new Date();
            fechaMaxima.setFullYear(fechaMaxima.getFullYear() - 18);
            fechaMaxima = fechaMaxima.toLocaleDateString("es-ES", {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            var fechaMinima = new Date();
            fechaMinima.setFullYear(fechaMinima.getFullYear() - 99);
            fechaMinima = fechaMinima.toLocaleDateString("es-ES", {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            var fechaActual = new Date();
            fechaActual = fechaActual.toLocaleDateString("es-ES", {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });


            $('#birth_date').datepicker({
                autoclose: true,
                format: datepicker_date_format,
                startDate: fechaMinima,
                endDate: fechaMaxima,
            });

            $('#date_admission').datepicker({
                autoclose: true,
                format: datepicker_date_format
            });

            let approved = $("#approved").val();
            if (approved == 1) {
                $("#approved").prop("checked", true);
                $("#text-approved").show();
                $("#tax_number").prop('disabled', true);
            } else {
                $("#approved").prop("checked", false);
                $("#text-approved").hide();
                $("#tax_number").prop('disabled', false);          
            }

            if ($('#state_id').val() != '') {
                $('#state_id').prop('disabled', false);
            }
            if ($('#city_id').val() != '') {
                $('#city_id').prop('disabled', false);
            }

        });

        function getDocuments() {
            id = {{ $employee->id }}
            var url = '{!! URL::to('/rrhh-documents-getByEmployee/:id') !!}';
            url = url.replace(':id', id);
            $.get(url, function(data) {
                $("#div_documents").html(data);
            });
        }

        function viewFile(id) {
            $("#modal_content_photo").html('');
            var url = "{!! URL::to('/rrhh-documents-viewFile/:id') !!}";
            url = url.replace(':id', id);
            $.get(url, function(data) {
                $("#modal_content_photo").html(data);
                $('#modal_photo').modal({
                    backdrop: 'static'
                });
            });
        }


        function filesDocument(id, employee_id) {
            $("#modal_content_edit_document").html('');
            var url = "{!! URL::to('/rrhh-documents-files/:id/:employee_id') !!}";
            url = url.replace(':id', id);
            url = url.replace(':employee_id', employee_id);
            $.get(url, function(data) {
                $("#modal_content_edit_document").html(data);
                $('#modal_edit_action').modal({
                    backdrop: 'static'
                });
            });
            $('#document_modal').modal('hide').data('bs.modal', null);
        }


        $('#dni').on('change', function() {
            let id = $("#employee_id").val();
            let valor = $(this).val();
            let route = '/rrhh-employees/verified_document/' + 'dni' + '/' + valor + '/' + id;
            $.get(route, function(data, status) {
                if (data.success == true) {
                    Swal.fire({
                        title: data.msg,
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: true,
                    });
                }
            });
            let approved = $("#approved").val();
            if (approved == 1) {
                $("#tax_number").val($('#dni').val());
            }
        });

        $('#tax_number').on('change', function() {
            let id = $("#employee_id").val();
            let valor = $(this).val();
            let route = '/rrhh-employees/verified_document/' + 'tax_number' + '/' + valor + '/' + id;
            $.get(route, function(data, status) {
                if (data.success == true) {
                    Swal.fire({
                        title: data.msg,
                        icon: "error",
                        timer: 3000,
                        showConfirmButton: true,
                    });
                }
            });
        });

        function getPhoto() {
            id = {{ $employee->id }}
            var url = "{!! URL::to('/rrhh-employees-getPhoto/:id') !!}";
            url = url.replace(':id', id);
            $.get(url, function(data) {
                $("#div_photo").html(data);
            });
        }

        $(document).on('click', '#btn_edit_item', function(e) {
            e.preventDefault();
            if ($("form#form_edit").valid()) {
                $("form#form_edit").submit();
            }
        });

        $("#btn_undo, #btn_undo2").click(function() {
            sendRequest();
        });


        $('#btn-collapse-fi').click(function() {
            if ($("#documents-information-fields-box").hasClass("in")) {
                $("#create-icon-collapsed-fi").removeClass("fa fa-minus");
                $("#create-icon-collapsed-fi").addClass("fa fa-plus");
            } else {
                $("#create-icon-collapsed-fi").removeClass("fa fa-plus");
                $("#create-icon-collapsed-fi").addClass("fa fa-minus");
            }
        });

        $('#btn-collapse-li').click(function() {
            if ($("#files-information-fields-box").hasClass("in")) {
                $("#create-icon-collapsed-li").removeClass("fa fa-minus");
                $("#create-icon-collapsed-li").addClass("fa fa-plus");
            } else {
                $("#create-icon-collapsed-li").removeClass("fa fa-plus");
                $("#create-icon-collapsed-li").addClass("fa fa-minus");
            }
        });

        $('#btn-collapse-gi').click(function() {
            if ($("#general-information-fields-box").hasClass("in")) {
                $("#create-icon-collapsed-gi").removeClass("fa fa-minus");
                $("#create-icon-collapsed-gi").addClass("fa fa-plus");
            } else {
                $("#create-icon-collapsed-gi").removeClass("fa fa-plus");
                $("#create-icon-collapsed-gi").addClass("fa fa-minus");
            }
        });

        function updateCities() {
            $("#city_id").empty();
            state_id = $('#state_id').val();

            if (state_id) {

                var route = "/cities/getCitiesByState/" + state_id;
                $.get(route, function(res) {

                    $("#city_id").append(
                        '<option value="0" disabled selected>{{ __('messages.please_select') }}</option>');

                    $(res).each(function(key, value) {
                        $("#city_id").append('<option value="' + value.id + '">' + value.name +
                        '</option>');

                    });
                });

            }

        }

        $('#state_id').change(function() {
            updateCities();
            $('#city_id').prop('disabled', false);
        });

        $('#country_id').change(function() {
            updateStates();
            $('#state_id').prop('disabled', false);
            $('#city_id').prop('disabled', true);
        });


        function updateStates() {
            $("#state_id").empty();
            $("#city_id").empty();
            country_id = $('#country_id').val();

            var route = "/states/getStatesByCountry/" + country_id;
            $.get(route, function(res) {
                $("#state_id").append(
                    '<option value="0" disabled selected>{{ __('messages.please_select') }}</option>');

                $(res).each(function(key, value) {
                    $("#state_id").append('<option value="' + value.id + '">' + value.name + '</option>');

                });
            });
        }

        function nitApproved() {
            if ($("#approved").is(":checked")) {
                var dni = $("#dni").val();
                $("#approved").val('1');
                $("#tax_number").prop('disabled', true);
                $("#tax_number").val(dni);
                $("#text-approved").show();
            } else {
                $("#approved").val('0');
                $("#tax_number").prop('disabled', false);
                $("#tax_number").val('');
                $("#text-approved").hide();
            }
        }

        function showBankInformation() {
            selected_option = $("#payment_id option:selected").text();

            if (selected_option == 'Transferencia bancaria') {
                $('#bank_information').show();
                $("#bank_account").prop('required', true);
                $("#bank_id").prop('required', true);
            } else {
                $('#bank_information').hide();
                $("#bank_account").prop('required', false);
                $("#bank_id").prop('required', false);
                $('#bank_id').val('').change();
                $('#bank_account').val('');
            }
        }

        $('#payment_id').change(function() {
            showBankInformation();
        });


        validExtPhoto = ['jpg', 'jpeg', 'png'];

        $('#photo').on('change', function() {
            extension = this.files[0].type.split('/')[1];

            if (validExtPhoto.indexOf(extension) == -1) {
                $('#photo').val('');
                Swal.fire({
                    title: '@lang('rrhh.only_img')',
                    icon: "error",
                });
            } else {
                size = this.files[0].size;
                if (size > 5242880) {

                    $('#photo').val('');
                    Swal.fire({
                        title: '@lang('rrhh.bad_size_img1')',
                        icon: "error",
                    });
                }
            }
        });


        validExtCV = ['pdf'];

        $('#curriculum_vitae').on('change', function() {
            extension = this.files[0].type.split('/')[1];

            if (validExtCV.indexOf(extension) == -1) {
                $('#curriculum_vitae').val('');
                Swal.fire({
                    title: '@lang('rrhh.only_pdf1')',
                    icon: "error",
                });
            } else {
                size = this.files[0].size;
                if (size > 5242880) {

                    $('#curriculum_vitae').val('');
                    Swal.fire({
                        title: '@lang('rrhh.bad_size_cv')',
                        icon: "error",
                    });
                }
            }
        });


        var img_fileinput_setting = {
            'showUpload': false,
            'showPreview': true,
            'browseLabel': LANG.file_browse_label,
            'removeLabel': LANG.remove,
            'previewSettings': {
                image: {
                    width: "100%",
                    height: "100%",
                    'max-width': "100%",
                    'max-height': "100%",
                }
            }
        };
        $("#photo").fileinput(img_fileinput_setting);
        $("#curriculum_vitae").fileinput(img_fileinput_setting);


        function deleteDocument(id) {
            $.confirm({
                title: '@lang('rrhh.confirm_delete')',
                content: '@lang('rrhh.delete_message')',
                icon: 'fa fa-warning',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    confirm: {
                        text: '@lang('rrhh.delete')',
                        action: function() {
                            route = '/rrhh-documents/' + id;
                            token = $("#token").val();
                            $.ajax({
                                url: route,
                                headers: {
                                    'X-CSRF-TOKEN': token
                                },
                                type: 'DELETE',
                                dataType: 'json',
                                success: function(result) {
                                    if (result.success == true) {
                                        Swal.fire({
                                            title: result.msg,
                                            icon: "success",
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });

                                        getDocuments();

                                    } else {
                                        Swal.fire({
                                            title: result.msg,
                                            icon: "error",
                                        });
                                    }
                                }
                            });
                        }
                    },
                    cancel: {
                        text: '@lang('rrhh.cancel')',
                    },
                }
            });
        }
    </script>
@endsection
