@extends('layouts.app')
@section('title', __('home.business'))
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('business.business')<small>@lang('business.manage_business')</small></h1>
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="boxform_u box-solid_u">
            <div class="box-body">
                {!! Form::open(['url' => route('business.update', $business->id), 'method' => 'post', 
                'id' => 'business_register_form','files' => true ]) !!}
                <fieldset>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('name', __('business.business_name') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-suitcase"></i>
                            </span>
                            {!! Form::text('name', $business->name, [
                                'class' => 'form-control',
                                'placeholder' => __('business.business_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('line_of_business', __('business.line_of_business') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa glyphicon glyphicon-link"></i>
                            </span>
                            {!! Form::text('line_of_business', $business->line_of_business, [
                                'class' => 'form-control',
                                'placeholder' => __('business.line_of_business'),
                                'required',
                                
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('legal_representative', __('business.legal_representative') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa glyphicon glyphicon-blackboard"></i>
                            </span>
                            {!! Form::text('legal_representative', $business->legal_representative, [
                                'class' => 'form-control',
                                'placeholder' => __('business.legal_representative'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('business_full_name', __('business.business_full_name') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-suitcase"></i>
                            </span>
                            {!! Form::text('business_full_name', $business->business_full_name, [
                                'class' => 'form-control',
                                'placeholder' => __('business.business_full_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('nit', __('business.nit') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa glyphicon glyphicon-edit"></i>
                            </span>
                            {!! Form::text('nit', $business->nit, ['class' => 'form-control', 'placeholder' => __('business.nit'), 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('nrc', __('business.nrc') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa glyphicon glyphicon-pencil"></i>
                            </span>
                            {!! Form::text('nrc', $business->nrc, ['class' => 'form-control', 'placeholder' => __('business.nrc'), 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('start_date', __('business.start_date') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('start_date', $business->start_date, [
                                'class' => 'form-control start-date-picker',
                                'placeholder' => __('business.start_date'),
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('currency_id', __('business.currency') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </span>
                            {!! Form::select('currency_id', $currencies, $business->currency_id, [
                                'class' => 'form-control select2_register',
                                'placeholder' => __('business.currency_placeholder'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('business_logo', __('business.upload_logo') . ':') !!}
                        {!! Form::file('business_logo', ['accept' => 'image/*']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('website', __('lang_v1.website') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-globe"></i>
                            </span>
                            {!! Form::text('website', $location->website, ['class' => 'form-control', 'placeholder' => __('lang_v1.website')]) !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('mobile', __('lang_v1.business_telephone') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </span>
                            {!! Form::text('mobile', $location->mobile, ['class' => 'form-control', 'placeholder' => __('lang_v1.business_telephone')]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('alternate_number', __('business.alternate_number') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </span>
                            {!! Form::text('alternate_number', $location->alternate_number, [
                                'class' => 'form-control',
                                'placeholder' => __('business.alternate_number'),
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('country', __('business.country') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-globe"></i>
                            </span>
                            {!! Form::text('country', $location->country, [
                                'class' => 'form-control',
                                'placeholder' => __('business.country'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('state', __('business.state') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('state', $location->state, ['class' => 'form-control', 'placeholder' => __('business.state'), 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('city', __('business.city') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('city', $location->city, ['class' => 'form-control', 'placeholder' => __('business.city'), 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('zip_code', __('business.zip_code') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('zip_code', $location->zip_code, [
                                'class' => 'form-control',
                                'placeholder' => __('business.zip_code_placeholder'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('landmark', __('business.landmark') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-map-marker"></i>
                            </span>
                            {!! Form::text('landmark', $location->landmark, [
                                'class' => 'form-control',
                                'placeholder' => __('business.landmark'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('time_zone', __('business.time_zone') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                            </span>
                            {!! Form::select('time_zone', $timezone_list, $location->time_zone, [
                                'class' => 'form-control select2_register',
                                'placeholder' => __('business.time_zone'),
                                'required',
                            ]) !!}
                        </div>
                    </div>
                </div>
                </fieldset>

                <!-- tax details -->
                @if (empty($is_admin))
                    <fieldset>
                        <legend>@lang('business.business_settings'):</legend>
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tax_label_1', __('business.tax_1_name') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-info"></i>
                                    </span>
                                    {!! Form::text('tax_label_1', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('business.tax_1_placeholder'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tax_number_1', __('business.tax_1_no') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-info"></i>
                                    </span>
                                    {!! Form::text('tax_number_1', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tax_label_2', __('business.tax_2_name') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-info"></i>
                                    </span>
                                    {!! Form::text('tax_label_2', null, [
                                        'class' => 'form-control',
                                        'placeholder' => __('business.tax_1_placeholder'),
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tax_number_2', __('business.tax_2_no') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-info"></i>
                                    </span>
                                    {!! Form::text('tax_number_2', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div> --}}
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('fy_start_month', __('business.fy_start_month') . ':') !!} @show_tooltip(__('tooltip.fy_start_month'))
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    {!! Form::select('fy_start_month', $months, $business->fy_start_month, [
                                        'class' => 'form-control select2_register',
                                        'required',
                                        'style' => 'width:100%;',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('accounting_method', __('business.accounting_method') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calculator"></i>
                                    </span>
                                    {!! Form::select('accounting_method', $accounting_methods, $business->accounting_method, [
                                        'class' => 'form-control select2_register',
                                        'required',
                                        'style' => 'width:100%;',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endif
 
                    {!! Form::hidden('package_id', $package_id); !!}
                   <div class="text-right">
                    <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                    <button type="button" data-dismiss="modal" aria-label="Close"
                        class="btn btn-default">@lang('messages.close')</button>
                   </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@endsection
