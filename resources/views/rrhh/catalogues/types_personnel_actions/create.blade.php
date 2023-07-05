<div class="modal-header">
	<h4 class="modal-title" id="formModal">@lang('rrhh.types_personnel_actions')
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</h4>
</div>
<div class="modal-body">
	<form id="form_add" method="post">
		<div class="row">
			<div class="col-sm-8">
				<div class="form-group">
					<label>@lang('rrhh.name')</label>
					<input type="text" name='name' id='name' class="form-control" placeholder="@lang('rrhh.name')">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<br>
					<label> 
						<input type="checkbox" name='required_authorization' id='required_authorization' onclick="requiredAuthorization()"> {{ __('rrhh.required_authorization') }} @show_tooltip(__('rrhh.message_authorization'))
					</label>
				</div>
			</div>
			@foreach ($clases as $class)
				<div class="col-md-6">
					<label style="text-transform: uppercase;">Clase: {{ $class->name }}</label> <br>
					<ul class="list-group">
						@foreach ($actions as $action)
							@if($action->class_id == $class->id)
							<label class="list-group-item"> 
								<input type="checkbox" name='action[]' id='action' value="{{ $action->id }}"> {{ $action->name }}
							</label>
							@endif
						@endforeach
					</ul>
				</div>	
			@endforeach
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" id="btn_add_type_personnel_action">@lang('rrhh.add')</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal">@lang( 'messages.cancel' )</button>
</div>

<script>
	$( document ).ready(function() {	
		requiredAuthorization();
	});
	$("#btn_add_type_personnel_action").click(function() {
		console.log($('#action').val());
		route = "/rrhh-type-personnel-action";
		datastring = $("#form_add").serialize();
		token = $("#token").val();
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': token},
			type: 'POST',
			dataType: 'json',
			data: datastring,
			success:function(result){
				if(result.success == true) {
					Swal.fire
					({
						title: result.msg,
						icon: "success",
						timer: 2000,
						showConfirmButton: false,
					});
					$("#types_personnel_actions-table").DataTable().ajax.reload(null, false);
					$('#modal_type').modal('hide');
				
				} else {
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
	});


	function requiredAuthorization() {
		if ($("#required_authorization").is(":checked")) {
		$("#required_authorization").val('1');
		console.log('1');
		} else {
		$("#required_authorization").val('0');
		console.log('0');
		}
	}

</script>