@extends('layouts.app')
@section('title', __('rrhh.rrhh'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1> @lang('rrhh.authorizations')
		<small></small>
	</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="boxform_u box-solid_u">
		<div class="box-body">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-condensed table-hover" width="100%" id="personnel_actions-table">
						<thead>
							<tr class="active">
								<th>@lang('rrhh.type_personnel_action')</th>
								<th>@lang('rrhh.employee')</th>
								<th width="25%">@lang('rrhh.status')</th>
								<th>@lang('rrhh.created_date')</th>
								<th width="15%" id="dele">@lang('rrhh.actions' )</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_personnel_action" tabindex="-1">
		<div class="modal-dialog" role="document">
		  <div class="modal-content" id="modal_content_personnel_action">
	
		  </div>
		</div>
	</div>
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
</section>
@endsection

@section('javascript')
<script type="text/javascript">
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};

	$(document).ready(function() {
		loadPersonnelActions();
		$.fn.dataTable.ext.errMode = 'none';
	});

    function loadPersonnelActions() 
    {
        var table = $("#personnel_actions-table").DataTable();
        table.destroy();
        var table = $("#personnel_actions-table").DataTable({
            deferRender: true,
            processing: true,
            serverSide: true,
            ajax: "/rrhh-personnel-action-getByAuthorizer",
            columns: [
				{data: 'type', name: 'type'},
				{data: 'full_name', name: 'full_name'},
				{data: 'status', name: 'status'},
				{data: 'created_at', name: 'created_at'},
				{data: null, render: function(data) {
					html = "";
					
					@can('rrhh_personnel_action.authorize')
					html += '<button type="button" onClick="autorizerPersonnelAction('+data.id+')" class="btn btn-primary btn-xs"><i class="fa fa-check-square"></i></button>';
					@endcan

					return html;
				}, orderable: false, searchable: false, className: "text-center"}
            ],
            dom:'<"row margin-bottom-12"<"col-sm-12"<"pull-left"l><"pull-right"fr>>>tip',
        });
    }

	function autorizerPersonnelAction(id) {
        Swal.fire({
            title: "{{ __('messages.authorizer_question') }}",
            text: "{{ __('messages.authorizer_content') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('messages.accept') }}",
            cancelButtonText: "{{ __('messages.cancel') }}",
        }).then((willDelete) => {
            if (willDelete.value) {
				Swal.fire({
					title: "{{ __('rrhh.confirm_authorization') }}",
					text: "{{ __('rrhh.message_to_confirm_authorization') }}",
					input: 'password',
					inputAttributes: {
						autocapitalize: 'off'
					},
					showCancelButton: true,
					confirmButtonText: "{{ __('rrhh.authorize') }}",
					cancelButtonText: "{{ __('messages.cancel') }}",
					showLoaderOnConfirm: true,
					inputValidator: (value) => {
						if (!value) {
						return 'El campo de la contraseña es requerido.'
						}
					},
				}).then((result) => {
					if (result.isConfirmed) {
						var route = "{!!URL::to('/rrhh-personnel-action/:id/confirmAutorization')!!}";
						route = route.replace(':id', id);   
						token = $("#token").val();
						console.log(result.value);
						$.ajax({
							url: route,
							headers: {'X-CSRF-TOKEN': token},
							type: 'POST',
							dataType: 'json',      
							data: { 'password': result.value },
							success:function(result) {
								if(result.success == true) {
									Swal.fire
									({
										title: result.msg,
										icon: "success",
										timer: 2000,
										showConfirmButton: false,
									});
									$("#personnel_actions-table").DataTable().ajax.reload(null, false);
								}
								else {
									Swal.fire
									({
										title: result.msg,
										icon: "error",
									});
								}
							},
							error:function(msj){
								errormessages = "";
								$.each(msj.responseJSON.errors, function(i, field){
									errormessages+="<li>"+field+"</li>";
								});
								Swal.fire
									({
									title: "@lang('rrhh.error_list')",
									icon: "error",
									html: "<ul>"+ errormessages+ "</ul>",
								});
							}
						});
					}
				})
            }
        });
    }

</script>
@endsection