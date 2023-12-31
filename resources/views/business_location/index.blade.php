@extends('layouts.app')
@section('title', __('business.business_locations'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'business.business_locations' )
        <small>@lang( 'business.manage_your_business_locations' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang( 'business.all_your_business_locations' )</h3>
        	<div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                	data-href="{{action('BusinessLocationController@create')}}" 
                	data-container=".location_add_modal">
                	<i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="business_location_table">
                    <thead>
                        <tr>
                            <th>@lang( 'lang_v1.location_id' )</th>
                            <th>@lang( 'invoice.name' )</th>
                            <th>@lang( 'business.city' )</th>
                            <th>@lang( 'business.state' )</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade location_add_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade location_edit_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade add_update_accounting_account_modal" tabindex="-1" role="dialog" 
        data-backdrop="static" aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script src="{{ asset('js/location.js?v=') . $asset_v }}"></script>
@endsection