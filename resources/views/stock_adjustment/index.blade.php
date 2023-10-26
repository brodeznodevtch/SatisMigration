@extends('layouts.app')
@section('title', __('stock_adjustment.stock_adjustments'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('stock_adjustment.stock_adjustments')
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang('stock_adjustment.manage_stock_adjustments')</h3>
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('StockAdjustmentController@create')}}">
                <i class="fa fa-plus"></i> @lang('messages.add')</a>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="stock_adjustment_table" width="100%">
        		<thead>
        			<tr>
        				<th>@lang('messages.date')</th>
                        <th>@lang('stock_adjustment.adjustment_type')</th>
                        <th>@lang('purchase.ref_no')</th>
                        <th>@lang('warehouse.warehouse')</th>
                        <th>@lang('crm.responsable')</th>
                        <th>@lang('stock_adjustment.reason_for_stock_adjustment')</th>
                        <th>@lang('stock_adjustment.total_amount')</th>
						<th>@lang('messages.actions')</th>
        			</tr>
        		</thead>
        	</table>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
    {{-- Moment JS --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>

    {{-- Datetime JS --}}
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.13/dataRender/datetime.js"></script>

    <script src="{{ asset('js/stock_adjustment.js?v=' . $asset_v) }}"></script>
@endsection