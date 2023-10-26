@extends('layouts.app')
@section('title', __( 'lang_v1.customer_groups' ))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'lang_v1.customer_groups' )</h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang( 'lang_v1.all_your_customer_groups' )</h3>
            @can('customer_group.create')
            	<div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                    	data-href="{{action('CustomerGroupController@create')}}" 
                    	data-container=".customer_groups_modal">
                    	<i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endcan
        </div>
        <div class="box-body">
            @can('customer_group.view')
                <div class="table-responsive">
            	<table class="table table-bordered table-striped" id="customer_groups_table">
            		<thead>
            			<tr>
            				<th>@lang( 'lang_v1.customer_group_name' )</th>
            				<th>@lang( 'lang_v1.calculation_percentage' )</th>
            				<th>@lang( 'messages.action' )</th>
            			</tr>
            		</thead>
            	</table>
                </div>
            @endcan
        </div>
    </div>

    <div class="modal fade customer_groups_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
