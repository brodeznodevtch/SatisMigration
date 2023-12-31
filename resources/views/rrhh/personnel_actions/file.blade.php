{!! Form::open(['method' => 'post', 'id' => 'form_add_document','files' => true ]) !!}
<div class="modal-header">
	<h4 class="modal-title" id="formModal">@lang('rrhh.document')
		<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="closeModal()">
			<span aria-hidden="true">&times;</span>
		</button>
	</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label>@lang('rrhh.file')</label> <span class="text-danger">*</span>
				<input type="file" id="files" name="files[]" accept="image/png, image/jpeg, .pdf" multiple class="form-control form-control-sm">
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
	<input type="hidden" name="rrhh_personnel_action_id" value="{{ $personnelAction->id }}"
		id="rrhh_personnel_action_id">
	<input type="hidden" name="employee_id" value="{{ $employee_id }}" id="employee_id_pa2">
	<button type="button" class="btn btn-primary" id="btn_add_document_pa">@lang('rrhh.add')</button>
	<button type="button" class="btn btn-danger" data-dismiss="modal"
		onClick="closeModal()">@lang('messages.cancel')</button>
</div>
{!! Form::close() !!}

<script>
	$( document ).ready(function() {
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		select2 = $('.select2').select2();
	});


	validExt = ['pdf'];

	$('#files').on('change', function() {
		console.log(this.files);
		var invalidFormat = 0;
		for (var i = 0; i < this.files.length; i++) {
			extension = this.files[i].type.split('/')[1];

			if(validExt.indexOf(extension) == -1){
				$('#files').val('');
				invalidFormat++;
			} else {
				size = this.files[i].size;
				if(size > 5242880) {

					$('#files').val('');
					invalidFormat++;
				}
			}
		}
		if(invalidFormat > 0){
			Swal.fire
			({
				title: '@lang('rrhh.validation_file_pdf')',
				icon: "error",
			});
		}
	});

	$("#btn_add_document_pa").click(function() {
		route = "/rrhh-personnel-action-storeDocument";    
		token = $("#token").val();
		employee_id = $('#employee_id_pa2').val();

		var form = $("#form_add_document");
		var formData = new FormData(form[0]);
		
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': token},
			type: 'POST',
			processData: false,
			contentType: false,       
			data: formData,
			success:function(result) {
				if(result.success == true) {
					Swal.fire
					({
						title: result.msg,
						icon: "success",
						timer: 1000,
						showConfirmButton: false,
					});
					getPersonnelActions(employee_id);
                    //$("#personnel_actions-table").DataTable().ajax.reload(null, false);
					$('#modal_doc').modal( 'hide' ).data( 'bs.modal', null );
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
  	});

	function closeModal(){
		$('#modal_action').modal({backdrop: 'static'});
		$('#modal_doc').modal( 'hide' ).data( 'bs.modal', null );
	}
</script>