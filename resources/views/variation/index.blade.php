@extends('layouts.app')
@section('title', __('product.variations'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('product.variations')
        <small>@lang('lang_v1.manage_product_variations')</small>
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
        	<h3 class="box-title">@lang('lang_v1.all_variations')</h3>
        	<div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                	data-href="{{action([\App\Http\Controllers\VariationTemplateController::class, 'create'])}}" 
                	data-container=".variation_modal">
                	<i class="fa fa-plus"></i> @lang('messages.add')</button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="variation_table">
        		<thead>
        			<tr>
        				<th>@lang('product.variations')</th>
        				<th>@lang('lang_v1.values')</th>
                        <th>@lang('messages.action')</th>
        			</tr>
        		</thead>
        	</table>
            </div>
        </div>
    </div>

    <div class="modal fade variation_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
