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
            <div class="box-header">
                <h3 class="box-title">@lang('business.all_business')</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary"><i class="fa fa-plus"></i>
                        @lang('messages.add')</button>
                </div>

            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="business_table">
                        <thead>
                            <tr>
                                <th>@lang('business.legal_name')</th>
                                <th>@lang('business.comercial_name')</th>
                                <th>@lang('business.legal_representative')</th>
                                <th>@lang('business.iva_number')</th>
                                <th>@lang('business.tax_number')</th> 
                                <th>@lang('messages.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

    <!-- /.content -->
@endsection

@section('javascript')
<script>
     $(document).ready(function() {
        loadBusiness();      
        $.fn.dataTable.ext.errMode = 'none';      

        $('#modal_action').on('shown.bs.modal', function () {
		    $(this).find('#rrhh_type_personnel_action_id').select2({
                dropdownParent: $(this),
			})
		})
	});

    function loadBusiness() 
    {
        var table = $("#business_table").DataTable();
        table.destroy();
        var table = $("#business_table").DataTable({
            select: true,
            deferRender: true,
            processing: true,
            serverSide: true,
            ajax: "/business",
            columns: [
            {data: 'business_full_name', name: 'business_full_name', className: ""},
            {data: 'name', name: 'name', className: ""},
            {data: 'legal_representative', name: 'legal_representative', className: ""},
            {data: 'nrc', name: 'nrc', className: "text-center"},
            {data: 'nit', name: 'nit', className: "text-center"},
            {data: null, render: function(data) {
                html = '<div class="btn-group"><button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> @lang("messages.actions") <span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu dropdown-menu-right" role="menu">';
                html += '<li><a href="/business/'+data.id+'"><i class="fa fa-eye"></i>@lang('messages.view')</a></li>';
                
                @can('rrhh_employees.update')
                html += '<li><a href="/business/'+data.id+'/edit"><i class="glyphicon glyphicon-edit"></i>@lang('messages.edit')</a></li>';
                @endcan

                
                @can('rrhh_employees.delete')
                html += '<li> <a href="#" onClick="deleteItem('+data.id+')"><i class="glyphicon glyphicon-trash"></i>@lang('messages.delete')</a></li>';
                @endcan

                
                html += '</ul></div>';

                return html;
            } , orderable: false, searchable: false, className: "text-center"}
            ],
            dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',
        });
    }
</script>
@endsection