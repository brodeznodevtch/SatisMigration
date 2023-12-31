<table class="table table-responsive table-condensed table-text-center" style="font-size: inherit;"
    id="types_relationships-table">
    <thead>
        <tr class="active">
            <th width="20%">@lang('rrhh.option')</th>
            <th width="30%">@lang('rrhh.type')</th>
            <th width="30%">@lang('rrhh.date')</th>
            <th width="20%">@lang('rrhh.amount_')</th>
			@if(!isset($show))
            <th width="15%" id="dele">@lang('rrhh.actions')</th>
			@endif
        </tr>
    </thead>
    <tbody id="referencesItems">
        @if (count($absenceInabilities) > 0)
            @foreach ($absenceInabilities as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>
                        @if ($item->type == 'Ausencia')
                            {{ $item->typeAbsence->value }}
                        @else
                            {{ $item->typeInability->value }}
                        @endif
                    </td>
                    <td>
                        @if ($item->type == 'Ausencia')
                            {{ @format_date($item->start_date) }}
                        @else
                            {{ @format_date($item->start_date) }} - {{ @format_date($item->end_date) }}
                        @endif
                    </td>
                    <td>
                        @if ($item->type == 'Ausencia')
                            {{ $item->amount }} Horas
                        @else
                            @php
                                $fecha1 = new DateTime($item->start_date);
                                $fecha2 = new DateTime($item->end_date);
                                $diff = $fecha1->diff($fecha2);
                            @endphp
                            {{ $diff->days }} Días
                        @endif
                    </td>
					@if(!isset($show))
					<td>
                        @can('rrhh_absence_inability.update')
                            <button type="button" onClick='editAbsenceInability({{ $item->id }})'
                                class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                        @endcan
                        @can('rrhh_absence_inability.delete')
                            <button type="button" onClick='deleteAbsenceInability({{ $item->id }})'
                                class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                        @endcan
                    </td>
					@endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">@lang('lang_v1.no_records')</td>
            </tr>
        @endif
    </tbody>
</table>
<input type="hidden" name="_employee_id" value="{{ $employee->id }}" id="_employee_id_ai">

<script type="text/javascript">
    function editAbsenceInability(id) {
        $("#modal_content_edit_document").html('');
        var url = "{!! URL::to('/rrhh-absence-inability/:id/edit') !!}";
        url = url.replace(':id', id);
        $.get(url, function(data) {
            $("#modal_content_edit_document").html(data);
            $('#modal_edit_action').modal({
                backdrop: 'static'
            });
        });
        $('#modal_action').modal('hide').data('bs.modal', null);
    }

    function deleteAbsenceInability(id) {
        employee_id = $('#_employee_id_ai').val();
        Swal.fire({
            title: LANG.sure,
            text: "{{ __('messages.delete_content') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "{{ __('messages.accept') }}",
            cancelButtonText: "{{ __('messages.cancel') }}"
        }).then((willDelete) => {
            if (willDelete.value) {
                route = '/rrhh-absence-inability/' + id;
                token = $("#token").val();
                $.ajax({
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(result) {
                        if (result.success == true) {
                            Swal.fire({
                                title: result.msg,
                                icon: "success",
                                timer: 1000,
                                showConfirmButton: false,
                            });

                            getAbsenceInability(employee_id);

                        } else {
                            Swal.fire({
                                title: result.msg,
                                icon: "error",
                            });
                        }
                    }
                });
            }
        });
    }
    
    function btnAddAbsenceInabilities(){
        $("#modal_content_document").html('');
        var url = "{!! URL::to('/rrhh-absence-inability-create/:id') !!}";
        id = $('#_employee_id_ai').val();
        url = url.replace(':id', id);
        $.get(url, function(data) {
            $("#modal_content_document").html(data);
            $('#modal_doc').modal({
                backdrop: 'static'
            });
        });
        $('#modal_action').modal('hide').data('bs.modal', null);
    }

    function getAbsenceInability(id) {
        //$('#_employee_id_ai').val('');
        $("#modal_action").html('');
        var route = '/rrhh-absence-inability-getByEmployee/'+id;
        $("#modal_action").load(route, function() {
            $(this).modal({
            backdrop: 'static'
            });
        });
    }
</script>
