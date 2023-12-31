@extends('layouts.app')
@section('title', __('lang_v1.purchase_return'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('lang_v1.purchase_return')
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">@lang('lang_v1.all_purchase_returns')</h3>
        </div>
        <div class="box-body">
            @can('purchase.view')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                              <button type="button" class="btn btn-primary" id="daterange-btn">
                                <span>
                                  <i class="fa fa-calendar"></i> {{ __('messages.filter_by_date') }}
                                </span>
                                <i class="fa fa-caret-down"></i>
                              </button>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="table-responsive">
            	<table class="table table-bordered table-striped ajax_view" id="purchase_return_datatable">
            		<thead>
            			<tr>
            				<th>@lang('messages.date')</th>
    						<th>@lang('purchase.ref_no')</th>
                            <th>@lang('lang_v1.parent_purchase')</th>
                            <th>@lang('purchase.location')</th>
    						<th>@lang('purchase.supplier')</th>
    						<th>@lang('purchase.total')</th>
    						<th>@lang('messages.action')</th>
            			</tr>
            		</thead>
                    <tfoot>
                        <tr class="bg-gray font-17 text-center footer-total">
                            <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                            <td><span class="display_currency" id="footer_purchase_return_total" data-currency_symbol ="true"></span></td>
                            <td></td>
                        </tr>
                    </tfoot>
            	</table>
                </div>
            @endcan
        </div>
    </div>

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

</section>

<!-- /.content -->
@stop
@section('javascript')
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
<script>
    $(document).ready( function(){
        //Purchase table
        purchase_return_table = $('#purchase_return_datatable').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: '/purchase-return',
            columnDefs: [ {
                "targets": [6],
                "orderable": false,
                "searchable": false
            } ],
            columns: [
                { data: 'transaction_date', name: 'transaction_date'  },
                { data: 'ref_no', name: 'ref_no'},
                { data: 'parent_purchase', name: 'T.ref_no'},
                { data: 'location_name', name: 'BS.name'},
                { data: 'name', name: 'contacts.name'},
                { data: 'final_total', name: 'final_total'},
                { data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function (oSettings) {
                var total_purchase = sum_table_col($('#purchase_return_datatable'), 'final_total');
                $('#footer_purchase_return_total').text(total_purchase);
                
                __currency_convert_recursively($('#purchase_return_datatable'));
            },
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(5)').attr('class', 'clickable_td');
            }
        });
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                purchase_return_table.ajax.url( '/purchase-return?start_date=' + start.format('YYYY-MM-DD') +
                    '&end_date=' + end.format('YYYY-MM-DD') ).load();
            }
        );
        $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
            purchase_return_table.ajax.url( '/purchase-return').load();
            $('#daterange-btn span').html('<i class="fa fa-calendar"></i> {{ __("messages.filter_by_date") }}');
        });
    });
</script>
	
@endsection