<table class="table table-responsive table-condensed table-text-center" style="font-size: inherit;"
    id="types_relationships-table">
    <thead>
        <tr class="active">
            <th>@lang('rrhh.name')</th>
            <th>@lang('rrhh.relationships')</th>
            <th>@lang('rrhh.birthdate')</th>
            <th width="12%">@lang('rrhh.phone')</th>
            <th width="10%">@lang('rrhh.status')</th>
			@if(!isset($show))
            <th width="15%" id="dele">@lang('rrhh.actions')</th>
			@endif
        </tr>
    </thead>
    <tbody id="referencesItems">
        @if (count($economicDependences) > 0)
            @foreach ($economicDependences as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        @if ($item->birthdate != null)
                            {{ @format_date($item->birthdate) }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if ($item->status == 1)
                            {{ __('rrhh.active') }}
                        @else
                            {{ __('rrhh.inactive') }}
                        @endif
                    </td>
					@if(!isset($show))
                    <td>
                        @can('rrhh_economic_dependence.update')
                            <button type="button" onClick='editEconomicDependence({{ $item->id }})'
                                class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></button>
                        @endcan
                        @can('rrhh_economic_dependence.delete')
                            <button type="button" onClick='deleteEconomicDependence({{ $item->id }})'
                                class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                        @endcan
                    </td>
					@endif
                </tr>
            @endforeach
        @else
            <tr>
                @if(!isset($show))
                <td colspan="6" class="text-center">@lang('lang_v1.no_records')</td>
                @else
                <td colspan="5" class="text-center">@lang('lang_v1.no_records')</td>
                @endif
            </tr>
        @endif
    </tbody>
</table>
<input type="hidden" name="_employee_id" value="{{ $employee->id }}" id="_employee_id_ed">



<script type="text/javascript">
    function editEconomicDependence(id) {
        $("#modal_content_edit_document").html('');
        var url = "{!! URL::to('/rrhh-economic-dependence/:id/edit') !!}";
        url = url.replace(':id', id);
        $.get(url, function(data) {
            $("#modal_content_edit_document").html(data);
            $('#modal_edit_action').modal({
                backdrop: 'static'
            });
        });
        $('#modal_action').modal('hide').data('bs.modal', null);
    }

    function deleteEconomicDependence(id) {
        employee_id = $('#_employee_id_ed').val();
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
                route = '/rrhh-economic-dependence/' + id;
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

                            getEconomicDependence(employee_id);

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

    function btnAddEconomicDependencies(){
        $("#modal_content_document").html('');
        var url = "{!! URL::to('/rrhh-economic-dependence-create/:id') !!}";
        id = $('#_employee_id_ed').val();
        url = url.replace(':id', id);
        $.get(url, function(data) {
            $("#modal_content_document").html(data);
            $('#modal_doc').modal({
                backdrop: 'static'
            });
        });
        $('#modal_action').modal('hide').data('bs.modal', null);
    }

    function getEconomicDependence(id) {
        //$('#_employee_id_ed').val('');
        $("#modal_action").html('');
        var route = '/rrhh-economic-dependence-getByEmployee/'+id;
        $("#modal_action").load(route, function() {
            $(this).modal({
                backdrop: 'static'
            });
        });
    }
</script>
