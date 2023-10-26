@extends('layouts.app')
@section('title', __('lab_order.lab_orders'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang( 'lab_order.lab_orders' )
        <small>@lang( 'lab_order.manage_lab_orders' )</small>
    </h1>
</section>

<!-- Main content -->
<section class="content no-print">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">
                @if ($auxiliar == 1)
                @lang('lab_order.work_sent_to_ext_lab')
                @elseif ($auxiliar == 2)
                @lang('lab_order.errors_report')
                @else
                @lang( 'lab_order.all_lab_orders' )
                @endif
            </h3>
            @can('lab_order.create')
            <div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                    data-href="{{ action([\App\Http\Controllers\Optics\LabOrderController::class, 'createLabOrder']) }}" 
                    data-container=".add_lab_order_modal" id="btn-new-lab-orders">
                    <i class="fa fa-plus"></i> @lang( 'messages.add' )
                </button>
                {{-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modal-add-order' data-backdrop="static" id="btn-new-order">
                    <i class="fa fa-plus"></i> @lang( 'messages.add' )
                </button> --}}
            </div>
            @endcan
        </div>
        
        <div class="box-body">
            @can('lab_order.view')
            <div class="table-responsive">
            <table class="table table-bordered table-striped show_detail" id="lab_orders_table">
                <thead>
                    <tr>
                        {{-- <th>@lang('lab_order.no_order')</th> --}}
                        <th>@lang('document_type.invoice')</th>
                        <th>@lang('accounting.location')</th>
                        @if ($auxiliar == 1)
                        <th>@lang('external_lab.external_lab')</th>
                        @endif
                        @if ($auxiliar == 2)
                        <th>@lang('lab_order.responsable')</th>
                        <th>@lang('lab_order.reason')</th>
                        @endif
                        @if ($auxiliar != 2)    
                        <th>@lang('contact.customer')</th>
                        <th>@lang('graduation_card.patient')</th>
                        <th>@lang('cashier.status')</th>
                        @endif
                        <th>@lang('business.register')</th>
                        <th>@lang('lab_order.delivery')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
            </table>
            </div>
            @endcan
        </div>
    </div>

    {{-- <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel" id="modal-add-order"> --}}
        {{-- @include('optics.lab_order.create') --}}
    {{-- </div> --}}
    
    @include('optics.lab_order.edit')

    <div class="modal fade lab_orders_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade view_lab_order_modal" tabindex="-1"
        role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade add_lab_order_modal" data-backdrop="static" data-keyboard="false"
	    id="modal-add-order" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
    </div>

</section>

<section id="order_section" class="print_section"></section>
<!-- /.content -->

@endsection

@section('javascript')
<script type="text/javascript" src="{{ asset('/plugins/tempus/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/tempus/tempusdominus-bootstrap-3.min.js') }}"></script>

<script src="{{ asset('js/lab_order.js?v=' . $asset_v) }}"></script>

<script>
    $(document).ready(function() {
        /* $('.di-mask').mask('00/00');
        $('.size-mask').mask('00-00-00');

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        // Select2
        $('.lab_orders_modal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2();
        });

        // Select2
        $('#modal-add-order').on('shown.bs.modal', function () {
            $(this).find('.select2').select2();
        });

        // Select2
        $('#modal-edit-order').on('shown.bs.modal', function () {
            $(this).find('.select2').select2();

            $('#btn-print-order').on('click', function () {
                var order_id = $('#order_id').val();
                printOrder(order_id);
            });
        });
        */
        // Data Table
        var auxiliar = '{{ $auxiliar }}';
        var col_target = [7];
        var url = '/lab-orders';
        if (auxiliar == 1) {
            col_target = [8];
            url = '/lab-orders?opc=1';
        }
        if (auxiliar == 2) {
            col_target = [6];
            url = '/lab-orders?opc=2';
        }
        var lab_orders_table = $('#lab_orders_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            rowCallback: function(row, data) {
                if (data.status_value == 'Nuevo') {
                    $('td:eq(4)', row).addClass('active');
                }
            },
            columnDefs: [{
                "targets": col_target,
                "orderable": false,   
                "searchable": false
            }]
        });

        // Delete
        $(document).on('click', 'button.delete_lab_orders_button', function() {
            swal({
                title: LANG.sure,
                text: LANG.confirm_delete_lab_order,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    var data = $(this).serialize();

                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        data: data,
                        success: function(result) {
                            if (result.success === true) {
                                Swal.fire({
                                    title: ""+result.msg+"",
                                    icon: "success",
                                });
                                lab_orders_table.ajax.reload(null, false);
                            } else {
                                Swal.fire
                                ({
                                    title: ""+result.msg+"",
                                    icon: "error",
                                });
                            }
                        }
                    });
                }
            });
        });

        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        // Hoop select (no sirve)
        $('#hoop').select2({
            ajax: {
                url: '/lab-orders/getHoops',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                    q: params.term, // search term
                    page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            },
            minimumInputLength: 1,
            escapeMarkup: function(m) {
                return m;
            },
            templateResult: function(data) {
                return data.text;
                /*
            if (!data.id) {
                return data.text;
            }
            var html = data.text + ' (<b>' + LANG.code + ': </b>' + data.contact_id + ' - <b>' + LANG.business + ': </b>' + data.business_name + ')';
            return html;
            */
            },
            templateSelection: function(data) {
                return data.text;
                /*
                if (!data.id) {
                    $('#supplier_name').val('');
                    return data.text;
                }
                // If it's a new supplier
                if (!data.contact_id) {
                    return data.text;
                // If a provider has been selected
                } else {
                    $('#supplier_name').val(data.text);
                    return data.contact_id || data.text;
                }
                */
            },
        });

        $('#lab_orders_table').on('click', 'tr', function(e) {
            if (!$(e.target).is('td.selectable_td input[type=checkbox]') && !$(e.target).is('td.selectable_td') && !$(e.target).is('td.clickable_td') && !$(e.target).is('a') && !$(e.target).is('button') && !$(e.target).hasClass('label') && !$(e.target).is('li') && $(this).data("href") && !$(e.target).is('i')) {
                $.ajax({
                    url: $(this).data("href"),
                    dataType: "html",
                    success: function(result) {
                        $('.view_lab_order_modal').html(result).modal('show');
                    }
                });
            }
        });
    });

    setInterval( function () {
        $('#lab_orders_table').DataTable().ajax.reload(null, false);
    }, 300000 );

    // Block optemetrist field
    function optometristBlock() {
        if ($('#is_prescription').is(':checked')) {
            $('#optometrist').val('0');
            $('#input-optometrist').prop('disabled', true);
            $('#input-optometrist').val('');
            $('#txt-optometrist').val('');
        } else {
            $('#optometrist').val('');
            $('#input-optometrist').prop('disabled', false);
            $('#input-optometrist').val('');
            $('#txt-optometrist').val('');
        }

        if ($('#eis_prescription').is(':checked')) {
            $('#eoptometrist').val('').change();
            $('#eoptometrist').prop('disabled', true);
        } else {
            $('#eoptometrist').prop('disabled', false);
            $('#eoptometrist').val('').change();
        }
    }

    // Show/hide graduation card fields
    function erepairCheck() {
        if ($('#eis_repair').is(':checked')) {
            $('.graduation_card_fields').hide();
        } else {
            $('.graduation_card_fields').show();
        }
    }

    // Show/hide external labs
    function extLabCheck() {
        if ($('#check_ext_lab').is(':checked')) {
            $('#lab_extern_box').show();
        } else {
            $('#lab_extern_box').hide();
        }

        if ($('#echeck_ext_lab').is(':checked')) {
            $('#elab_extern_box').show();
        } else {
            $('#elab_extern_box').hide();
        }
    }

    // Balance for right eye
    function balanceOD() {
        if ($('#balance_od').is(':checked')) {
            $('input[name="sphere_od"]').val('');
            $('input[name="sphere_od"]').prop('readonly', true);

            $('input[name="cylindir_od"]').val('');
            $('input[name="cylindir_od"]').prop('readonly', true);

            $('input[name="axis_od"]').val('');
            $('input[name="axis_od"]').prop('readonly', true);

            $('input[name="base_od"]').val('');
            $('input[name="base_od"]').prop('readonly', true);

            $('input[name="addition_od"]').val('');
            $('input[name="addition_od"]').prop('readonly', true);
        } else {
            $('input[name="sphere_od"]').val('');
            $('input[name="sphere_od"]').prop('readonly', false);

            $('input[name="cylindir_od"]').val('');
            $('input[name="cylindir_od"]').prop('readonly', false);

            $('input[name="axis_od"]').val('');
            $('input[name="axis_od"]').prop('readonly', false);

            $('input[name="base_od"]').val('');
            $('input[name="base_od"]').prop('readonly', false);

            $('input[name="addition_od"]').val('');
            $('input[name="addition_od"]').prop('readonly', false);
        }

        if ($('#ebalance_od').is(':checked')) {
            $('input[name="esphere_od"]').val('');
            $('input[name="esphere_od"]').prop('readonly', true);

            $('input[name="ecylindir_od"]').val('');
            $('input[name="ecylindir_od"]').prop('readonly', true);

            $('input[name="eaxis_od"]').val('');
            $('input[name="eaxis_od"]').prop('readonly', true);

            $('input[name="ebase_od"]').val('');
            $('input[name="ebase_od"]').prop('readonly', true);

            $('input[name="eaddition_od"]').val('');
            $('input[name="eaddition_od"]').prop('readonly', true);
        } else {
            $('input[name="esphere_od"]').val('');
            $('input[name="esphere_od"]').prop('readonly', false);

            $('input[name="ecylindir_od"]').val('');
            $('input[name="ecylindir_od"]').prop('readonly', false);

            $('input[name="eaxis_od"]').val('');
            $('input[name="eaxis_od"]').prop('readonly', false);

            $('input[name="ebase_od"]').val('');
            $('input[name="ebase_od"]').prop('readonly', false);

            $('input[name="eaddition_od"]').val('');
            $('input[name="eaddition_od"]').prop('readonly', false);
        }
    }

    function ebalanceOD() {
        if (! $('#ebalance_od').is(':checked')) {
            $('input[name="esphere_od"]').prop('readonly', false);
            $('input[name="ecylindir_od"]').prop('readonly', false);
            $('input[name="eaxis_od"]').prop('readonly', false);
            $('input[name="ebase_od"]').prop('readonly', false);
            $('input[name="eaddition_od"]').prop('readonly', false);
        }
    }

    // Balance for left eye
    function balanceOS() {
        if ($('#balance_os').is(':checked')) {
            $('input[name="sphere_os"]').val('');
            $('input[name="sphere_os"]').prop('readonly', true);

            $('input[name="cylindir_os"]').val('');
            $('input[name="cylindir_os"]').prop('readonly', true);

            $('input[name="axis_os"]').val('');
            $('input[name="axis_os"]').prop('readonly', true);

            $('input[name="base_os"]').val('');
            $('input[name="base_os"]').prop('readonly', true);

            $('input[name="addition_os"]').val('');
            $('input[name="addition_os"]').prop('readonly', true);
        } else {
            $('input[name="sphere_os"]').val('');
            $('input[name="sphere_os"]').prop('readonly', false);

            $('input[name="cylindir_os"]').val('');
            $('input[name="cylindir_os"]').prop('readonly', false);

            $('input[name="axis_os"]').val('');
            $('input[name="axis_os"]').prop('readonly', false);

            $('input[name="base_os"]').val('');
            $('input[name="base_os"]').prop('readonly', false);

            $('input[name="addition_os"]').val('');
            $('input[name="addition_os"]').prop('readonly', false);
        }

        if ($('#ebalance_os').is(':checked')) {
            $('input[name="esphere_os"]').val('');
            $('input[name="esphere_os"]').prop('readonly', true);

            $('input[name="ecylindir_os"]').val('');
            $('input[name="ecylindir_os"]').prop('readonly', true);

            $('input[name="eaxis_os"]').val('');
            $('input[name="eaxis_os"]').prop('readonly', true);

            $('input[name="ebase_os"]').val('');
            $('input[name="ebase_os"]').prop('readonly', true);

            $('input[name="eaddition_os"]').val('');
            $('input[name="eaddition_os"]').prop('readonly', true);
        } else {
            $('input[name="esphere_os"]').val('');
            $('input[name="esphere_os"]').prop('readonly', false);

            $('input[name="ecylindir_os"]').val('');
            $('input[name="ecylindir_os"]').prop('readonly', false);

            $('input[name="eaxis_os"]').val('');
            $('input[name="eaxis_os"]').prop('readonly', false);

            $('input[name="ebase_os"]').val('');
            $('input[name="ebase_os"]').prop('readonly', false);

            $('input[name="eaddition_os"]').val('');
            $('input[name="eaddition_os"]').prop('readonly', false);
        }
    }

    function ebalanceOS() {
        if (! $('#ebalance_os').is(':checked')) {
            $('input[name="esphere_os"]').prop('readonly', false);
            $('input[name="ecylindir_os"]').prop('readonly', false);
            $('input[name="eaxis_os"]').prop('readonly', false);
            $('input[name="ebase_os"]').prop('readonly', false);
            $('input[name="eaddition_os"]').prop('readonly', false);
        }
    }

    // Datetimepicker
    $(function () {
        $('#datetimepicker1').datetimepicker({
            locale: 'es'
        });

        $('#delivery').datetimepicker({
            locale: 'es'
        });

        $('#edatetimepicker1').datetimepicker({
            locale: 'es'
        });

        $('#edelivery').datetimepicker({
            locale: 'es'
        });
    });

    $("#products").change(function(event) {
        id = $("#products").val();
        if(id != 0){
            addProduct(id);
            $("#products").val(0).change();
        }
    });

    $("#eproducts").change(function(event) {
        id = $("#eproducts").val();
        if(id != 0){
            eaddProduct(id);
            $("#eproducts").val(0).change();
        }
    });

    var cont = 0;
    var product_ids = [];
    var rowCont=[];

    var econt = 0;
    var eproduct_ids=[];
    var erowCont=[];

    function addProduct(variation_id, warehouse_id) {
        var route = "/lab-orders/addProduct/"+variation_id+"/"+warehouse_id;
        $.get(route, function(res) {
            variation_id = res.variation_id;
            if(res.sku == res.sub_sku){
                name = res.name_product;
            }
            else {
                name = ""+res.name_product+" "+res.name_variation+"";
            }
            count = parseInt(jQuery.inArray(variation_id, product_ids));
            if (count >= 0) {
                Swal.fire
                ({
                    title: "{{__('product.product_already_added')}}",
                    icon: "error",
                });
            }
            else {
                product_ids.push(variation_id);
                rowCont.push(cont);
                location_id = $("#location_id").val();
                warehouse_id = $("#warehouse_id").val();
                qty_available = parseFloat(res.qty_available).toFixed(2);
                var row = '<tr class="selected" id="row'+cont+'" style="height: 10px">'+
                    '<td><button id="bitem'+cont+'" type="button" class="btn btn-danger btn-xs" onclick="deleteProduct('+cont+', '+variation_id+');"><i class="fa fa-times"></i></button></td>'+
                    '<td><input type="hidden" name="variation_id[]" value="'+variation_id+'">'+
                        '<input type="hidden" name="location_id[]" value="'+location_id+'">'+
                        '<input type="hidden" name="warehouse_id[]" value="'+warehouse_id+'">'+res.sub_sku+'</td>'+
                    '<td>'+name+'</td>'+
                    '<td><input type="text" name="qty_available[]" id="qty_available'+cont+'" value="'+qty_available+'" class="form-control form-control-sm" readonly></td>'+
                    '<td><input type="number" name="quantity[]" id="quantity'+cont+'" class="form-control form-control-sm input_number" value="1" max="'+res.qty_available+'"></td></tr>';
                $("#list").append(row);
                cont++;
            }
        });
    }

    function eaddProduct(variation_id, warehouse_id) {
        var route = "/lab-orders/addProduct/"+variation_id+"/"+warehouse_id;
        $.get(route, function(res) {
            variation_id = res.variation_id;
            if(res.sku == res.sub_sku) {
                name = res.name_product;
            }
            else {
                name = ""+res.name_product+" "+res.name_variation+"";
            }
            count = parseInt(jQuery.inArray(variation_id, eproduct_ids));
            if (count >= 0) {
                Swal.fire
                ({
                    title: "{{__('product.product_already_added')}}",
                    icon: "error",
                });
            }
            else {
                eproduct_ids.push(variation_id);
                erowCont.push(econt);
                location_id = $("#elocation_id").val();
                warehouse_id = $("#ewarehouse_id").val();
                qty_available = parseFloat(res.qty_available).toFixed(2);
                var erow = '<tr class="selected" id="erow'+econt+'" style="height: 10px">'+
                    '<td><button id="ebitem'+econt+'" type="button" class="btn btn-danger btn-xs" onclick="edeleteProduct('+econt+', '+variation_id+');"><i class="fa fa-times"></i></button></td>'+
                    '<td><input type="hidden" name="item_id[]" value="0">'+
                        '<input type="hidden" name="evariation_id[]" value="'+variation_id+'">'+
                        '<input type="hidden" name="elocation_id[]" value="'+location_id+'">'+
                        '<input type="hidden" name="ewarehouse_id[]" value="'+warehouse_id+'">'+res.sub_sku+'</td>'+
                    '<td>'+name+'</td>'+
                    '<td><input type="text" name="eqty_available[]" id="eqty_available'+econt+'" value="'+res.qty_available+'" class="form-control form-control-sm" readonly></td>'+
                    '<td><input type="number" name="equantity[]" id="equantity'+econt+'" class="form-control form-control-sm input_number" value="1" max="'+res.qty_available+'"></td></tr>';
                $("#elist").append(erow);
                econt++;
            }
        });
    }

    function deleteProduct(index, id){ 
        $("#row" + index).remove();
        product_ids.removeItem(id);
        if(product_ids.length == 0)
        {
            cont = 0;
            product_ids=[];
            rowCont=[];
        }
    }

    function edeleteProduct(index, id){ 
        $("#erow" + index).remove();
        eproduct_ids.removeItem(id);
        if(eproduct_ids.length == 0)
        {
            econt = 0;
            eproduct_ids=[];
            erowCont=[];
        }
    }

    Array.prototype.removeItem = function (a) {
        for (var i = 0; i < this.length; i++) {
            if (this[i] == a) {
                for (var i2 = i; i2 < this.length - 1; i2++) {
                    this[i2] = this[i2 + 1];
                }
                this.length = this.length - 1;
                return;
            }
        }
    };

    /* $("#search_product").autocomplete({
        source: function(request, response) {
            
            $.getJSON("/lab-orders/products/list_for_orders", { location_id: $('input#location_id').val(), term: request.term, warehouse_id: $('#warehouse_id').val() }, response);
        },
        minLength: 2,
        response: function(event,ui) {
            if (ui.content.length == 1) {
                ui.item = ui.content[0];
            } else if (ui.content.length == 0) {
                swal(LANG.no_products_found)
                .then((value) => {
                    $('input#search_product').select();
                });
            }
        },
        focus: function( event, ui ) {
            if(ui.item.qty_available <= 0) {
                return false;
            }
        },
        select: function( event, ui ) {
            if(ui.item.enable_stock != 1 || ui.item.qty_available > 0){
                $(this).val(null);
                warehouse_id = $("#warehouse_id").val();
                addProduct(ui.item.variation_id, warehouse_id);
            } else{
                alert(LANG.out_of_stock);
            }
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        if(item.enable_stock == 1 && item.qty_available <= 0) {

            var string = '<div><li class="ui-state-disabled"> '+ item.name;
            if(item.type == 'variable'){
                string += '-' + item.variation;
            } */
            /*
            var selling_price = item.selling_price;
            if(item.variation_group_price){
                selling_price = item.variation_group_price;
            }
            */

            /*
            string += ' (' + item.sub_sku + ')' + "<br> <b>" + LANG.price + ":</b>$" + selling_price
            + " <b>E:</b> " + item.rack + "<b>F:</b> " + item.row + "<b>P:</b> "+ item.position
            + ' (' + LANG.out_of_stock + ') </li>';
            */

            /* string += ' (' + item.sub_sku + ') <br> <b>' + LANG.stock + ':</b>' + Math.round(item.qty_available, 0);
            //string += ' (' + item.sub_sku + ')';
            string += ' </li></div>';
            return $(string).appendTo(ul);
        } else {

            var string =  "<div>" + item.name;
            if(item.type == 'variable'){
                string += '-' + item.variation;
            } */

            /*
            var selling_price = item.selling_price;
            if(item.variation_group_price){
                selling_price = item.variation_group_price;
            }

            string += ' (' + item.sub_sku + ')' + "<br> <b>" + LANG.price + ":</b>$" + selling_price + " <b>"
            + LANG.stock + ":</b>" + Math.round(item.qty_available, 0)
            + " <b>E:</b>" + item.rack + "  <b>F:</b>" + item.row + "  <b>P:</b>" + item.position + " </div>";
            */
           
            /* string += ' (' + item.sub_sku + ') <br> <b>' + LANG.stock + ':</b>' + Math.round(item.qty_available, 0);
            string += '</div>';
            return $( "<li>" )
            .append(string)
            .appendTo( ul );
        }
    }; */

    $("#esearch_product").autocomplete({
        source: function(request, response) {
            $.getJSON("/lab-orders/products/list_for_orders", {
                //location_id: $('input#elocation_id').val(),
                term: request.term,
                warehouse_id: $('#ewarehouse_id').val()
            }, response);
        },
        minLength: 2,
        response: function(event,ui) {
            if (ui.content.length == 1) {
                ui.item = ui.content[0];
            } else if (ui.content.length == 0) {
                swal(LANG.no_products_found)
                .then((value) => {
                    $('input#esearch_product').select();
                });
            }
        },
        focus: function( event, ui ) {
            if(ui.item.qty_available <= 0) {
                return false;
            }
        },
        select: function( event, ui ) {
            if(ui.item.enable_stock != 1 || ui.item.qty_available > 0){
                $(this).val(null);
                warehouse_id = $("#ewarehouse_id").val();
                eaddProduct(ui.item.variation_id, warehouse_id);
            } else{
                alert(LANG.out_of_stock);
            }
        }
    })
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        ul.css('overflow-y', 'scroll');
        ul.css('overflow-x', 'hidden');
        ul.css('height', '10em');
        if(item.enable_stock == 1 && item.qty_available <= 0) {

            var string = '<div><li class="ui-state-disabled""> '+ item.name;
            if(item.type == 'variable'){
                string += '-' + item.variation;
            }
            
            /*
            var selling_price = item.selling_price;
            if(item.variation_group_price){
                selling_price = item.variation_group_price;
            }

            string += ' (' + item.sub_sku + ')' + "<br> <b>" + LANG.price + ":</b>$" + selling_price
            + " <b>E:</b> " + item.rack + "<b>F:</b> " + item.row + "<b>P:</b> "+ item.position
            + ' (' + LANG.out_of_stock + ') </li>';
            */

            string += ' (' + item.sub_sku + ') <br> <b>' + LANG.stock + ':</b> (' + LANG.out_of_stock + ')';
            string += ' </li></div>';
            return $(string).appendTo(ul);
        } else {

            var string =  "<div>" + item.name;
            if(item.type == 'variable'){
                string += '-' + item.variation;
            }

            /*
            var selling_price = item.selling_price;
            if(item.variation_group_price){
                selling_price = item.variation_group_price;
            }

            string += ' (' + item.sub_sku + ')' + "<br> <b>" + LANG.price + ":</b>$" + selling_price + " <b>"
            + LANG.stock + ":</b>" + Math.round(item.qty_available, 0)
            + " <b>E:</b>" + item.rack + "  <b>F:</b>" + item.row + "  <b>P:</b>" + item.position + " </div>";
            */

            string += ' (' + item.sub_sku + ') <br> <b>' + LANG.stock + ':</b>' + Math.round(item.qty_available, 0);
            string += '</div>';
            return $( "<li>" )
            .append(string)
            .appendTo( ul );
        }
    };

    $('select#select_location_id').change(function(){
        reset_pos_form();
    });

    /*
    $('select#eselect_location_id').change(function(){
        ereset_pos_form();
    });
    */

    $('select#ewarehouse_id').change(function(){
        ereset_pos_form();
    });

    function reset_pos_form(){
        set_location();
    }

    function ereset_pos_form(){
        eset_location();
    }

    function set_location(){
        if($('select#select_location_id').length == 1){
            $('input#location_id').val($('select#select_location_id').val());
        }

        if($('input#location_id').val()){
            $('input#search_product').prop( "disabled", false ).focus();
        } else {
            $('input#search_product').prop( "disabled", true );
        }
    }

    function eset_location(){
        //if($('select#eselect_location_id').length == 1){
        if ($('select#ewarehouse_id').length == 1) {
            $('input#elocation_id').val($('select#ewarehouse_id').val());
        }

        if ($('input#elocation_id').val()){
            $('input#esearch_product').prop( "disabled", false ).focus();
        } else {
            $('input#esearch_product').prop( "disabled", true );
        }
    }

    $("#btn-new-order").click(function(event) {
        $("#search_product").prop('disabled', true);
        $("#select_location_id").val('').change();
        clear();
    });

    /* $("#btn-add-order").click(function(){
        $("#btn-add-order").prop('disabled', true);
        $("#btn-close-modal-add-order").prop('disabled', true);
        var data = $("#lab_order_add_form").serialize();
        route = "/lab-orders";
        token = $("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                if(result.success == true){
                    $("#btn-add-order").prop('disabled', false);
                    $("#btn-close-modal-add-order").prop('disabled', false);
                    clear();
                    $('#modal-add-order').modal('hide');
                    $("#lab_orders_table").DataTable().ajax.reload(null, false);
                    Swal.fire({
                        title: result.msg,
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                }else{
                    $("#btn-add-order").prop('disabled', false);
                    $("#btn-close-modal-add-order").prop('disabled', false);
                    Swal.fire({
                        title: result.msg,
                        icon: "error",
                    });
                }
            },
            error:function(msj){
                $("#btn-add-order").prop('disabled', false);
                $("#btn-close-modal-add-order").prop('disabled', false);
                var errormessages = "";
                $.each(msj.responseJSON.errors, function(i, field){
                    errormessages+="<li>"+field+"</li>";
                });
                Swal.fire
                ({
                    title: LANG.errors,
                    icon: "error",
                    html: "<ul>"+ errormessages+ "</ul>",
                });
            }
        });
    }); */

    $("#btn-edit-order").click(function(){
        $("#btn-edit-order").prop('disabled', true);
        $("#btn-close-modal-edit-order").prop('disabled', true);
        var data = $("#form-edit-order").serialize();
        var id = $("#order_id").val();
        route = "/lab-orders/"+id;
        //token = $("#token").val();

        $.ajax({
            url: route,
            //headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',            
            dataType: 'json',
            data: data,
            success:function(result){
                if (result.success == true) {
                    $("#btn-edit-order").prop('disabled', false);
                    $("#btn-close-modal-edit-order").prop('disabled', false);
                    $("#lab_orders_table").DataTable().ajax.reload(null, false);
                    Swal.fire
                    ({
                        title: result.msg,
                        icon: "success",
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    $("#modal-edit-order").modal('hide');
                }else{
                    $("#btn-edit-order").prop('disabled', false);
                    $("#btn-close-modal-edit-order").prop('disabled', false);
                    Swal.fire({
                        title: result.msg,
                        icon: "error",
                    });
                }
            },
            error:function(msj){
                $("#btn-edit-order").prop('disabled', false);
                $("#btn-close-modal-edit-order").prop('disabled', false);
                var errormessages = "";
                $.each(msj.responseJSON.errors, function(i, field){
                    errormessages+="<li>"+field+"</li>";
                });
                Swal.fire
                ({
                    title: LANG.errors,
                    icon: "error",
                    html: "<ul>"+ errormessages+ "</ul>",
                });
            }
        });
    });
    
    function viewOrder(id) {
        var route = '/lab-orders/' + id;
        $.ajax({
            url: route,
            dataType: "html",
            success: function(result) {
                $('.view_lab_order_modal').html(result).modal('show');
            }
        });
    }
    
    function editOrder(id) {
        var route = "/lab-orders/"+id+"/edit";
        $("#esearch_product").prop('disabled', true);
        $("#eselect_location_id").val('').change();
        $.get(route, function(res) {

            $("#elist").empty();
            econt = 0;
            eproduct_ids=[];
            erowCont=[];

            $('#order_id').val(res.loid);

            $("#epatient_id").val(res.patient_id).change();

            $('input[name="eno_order"]').val(res.no_order);

            $("#ecustomer_id").val(res.customer_id).change();

            if (res.is_reparation == 1) {
                $('input[name="eis_reparation"]').prop('checked', true);
                $('.graduation_card_fields').hide();
            } else {
                $('input[name="eis_reparation"]').prop('checked', false);
                $('.graduation_card_fields').show();
            }

            if (res.is_prescription == 1) {
                $('input[name="eis_prescription"]').prop('checked', true);
                optometristBlock()
            } else {
                $('input[name="eis_prescription"]').prop('checked', false);
                $('#eoptometrist').prop('disabled', false);
            }

            $('input[name="esphere_od"]').val(res.sphere_od);
            $('input[name="esphere_os"]').val(res.sphere_os);

            $('input[name="ecylindir_od"]').val(res.cylindir_od);
            $('input[name="ecylindir_os"]').val(res.cylindir_os);

            $('input[name="eaxis_od"]').val(res.axis_od);
            $('input[name="eaxis_os"]').val(res.axis_os);

            $('input[name="ebase_od"]').val(res.base_od);
            $('input[name="ebase_os"]').val(res.base_os);

            $('input[name="eaddition_od"]').val(res.addition_od);
            $('input[name="eaddition_os"]').val(res.addition_os);

            $('input[name="ednsp_od"]').val(res.dnsp_od);
            $('input[name="ednsp_os"]').val(res.dnsp_os);

            $('input[name="edi"]').val(res.di);

            $('input[name="eao"]').val(res.ao);

            $('input[name="eap"]').val(res.ap);

            if (res.is_own_hoop == 1) {
                $('input[name="eis_own_hoop"]').prop('checked', true);
                $("#ehoop").hide();
                $('input[name="ehoop_name"]').show();
                $('input[name="ehoop_name"]').val(res.hoop_name);
            } else {
                $('input[name="eis_own_hoop"]').prop('checked', false);
                $('input[name="ehoop_name"]').hide();
                $("#ehoop").show();
                $("#ehoop").val(res.hoop_value).change();
            }
            
            $('input[name="esize"]').val(res.size);

            $('input[name="ecolor"]').val(res.color);

            $('.ht_rb').each(function() {
                if ($(this).val() == res.hoop_type) {
                    $(this).prop('checked', true);
                }
            });

            // $('#eglass option[value=' + res.glass_value + ']').attr('selected', true);

            $("#div_glass_empty").hide();

            if (res.glass_value) {
                $("#div_glass").show();
                $("#eglass").val(res.glass_value).change();
            } else {
                $("#div_glass").hide();
            }

            if (res.glass_os_value) {
                $("#div_glass_os").show();
                $("#eglass_os").val(res.glass_os_value).change();
            } else {
                $("#div_glass_os").hide();
            }

            if (res.glass_od_value) {
                $("#div_glass_od").show();
                $("#eglass_od").val(res.glass_od_value).change();
            } else {
                $("#div_glass_od").hide();
            }

            if (!res.glass_value && !res.glass_os_value && !res.glass_od_value) {
                $("#div_glass_empty").show();
            }

            $('#ejob_type').val(res.job_type);

            if (res.check_ext_lab == 1) {
                $('input[name="echeck_ext_lab"]').prop('checked', true);
                $('#elab_extern_box').show();
            } else {
                $('input[name="echeck_ext_lab"]').prop('checked', false);
                $('#elab_extern_box').hide();
            }

            $("#eexternal_lab_id").val(res.external_lab_id).change();

            $('.ar_rb').each(function() {
                if ($(this).val() == res.ar) {
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            });

            $('.status_rb').each(function() {
                if ($(this).val() == res.status_lab_order_id) {
                    $(this).prop('checked', true);
                }
            });

            $('input[name="edelivery"]').val(res.delivery_value);

            $("#eemployee_id").val(res.employee_id).change();

            $("#eoptometrist").val(res.optometrist).change();

            $('#ereason').val(res.reason);

            if (res.transaction_id) {
                $("#elocation_lo").val(res.location_id).change();
                $("#einvoice_lo").val(res.correlative);
            } else {
                $("#elocation_lo").val(res.business_location_id).change();
            }

            if (res.balance_os == 1) {
                $('input[name="ebalance_os"]').prop('checked', true);
                balanceOS();
            } else {
                $('input[name="ebalance_os"]').prop('checked', false);
                ebalanceOS();
            }
            
            if (res.balance_od == 1) {
                $('input[name="ebalance_od"]').prop('checked', true);
                balanceOD();
            } else {
                $('input[name="ebalance_od"]').prop('checked', false);
                ebalanceOD();
            }

            $('#div_second_time').hide();

            if (res.show_fields) {
                $('#div_second_time').show();
                $('#eemployee_id').val(res.employee_id).change();
                $('#ereason').val(res.reason);
            }

            //$('input[name="select_location_id"]').val('').change();

            $('#ewarehouse_id').val('').change();

            $('#esearch_product').val('').change();

            var route = "/lab-orders/getProductsByOrder/"+id;
            $.get(route, function(res) {
                $(res).each(function(key, value){
                    if(value.sku == value.sub_sku){
                        name = value.product_name;
                    }
                    else{
                        name = ""+value.product_name+" "+value.variation_name+"";
                    }

                    eproduct_ids.push(value.variation_id);
                    erowCont.push(econt);
                    var erow = '<tr class="selected" id="erow'+econt+'" style="height: 10px">'+
                        '<td><button id="ebitem'+econt+'" type="button" class="btn btn-danger btn-xs" onclick="edeleteProduct('+econt+', '+value.variation_id+');"><i class="fa fa-times"></i></button></td>'+
                        '<td><input type="hidden" name="item_id[]" value="'+value.id+'">'+
                            '<input type="hidden" name="evariation_id[]" value="'+value.variation_id+'">'+
                            '<input type="hidden" name="elocation_id[]" value="'+value.location_id+'">'+
                            '<input type="hidden" name="ewarehouse_id[]" value="'+value.warehouse_id+'">'+value.sub_sku+'</td>'+
                        '<td>'+name+'</td>'+
                        '<td><input type="text" name="eqty_available[]" id="eqty_available'+econt+'" value="'+value.qty_available+'" class="form-control form-control-sm" readonly></td>'+
                        '<td><input type="number" name="equantity[]" id="equantity'+econt+'" class="form-control form-control-sm input_number" value="'+value.quantity+'" onchange="ecalculate()"></td></tr>';
                    $("#elist").append(erow);
                    econt++;
                });
            });
            $("#modal-edit-order").modal({backdrop: 'static'});
        });
    }

    function deleteOrder(id) {
        swal({
            title: LANG.sure,
            text: LANG.confirm_delete_lab_order,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                /* var href = $(this).data('href');
                var data = $(this).serialize(); */

                var href = '/lab-orders/' + id;

                $.ajax({
                    method: "DELETE",
                    url: href,
                    dataType: "json",
                    //data: data,
                    success: function(result) {
                        if (result.success === true) {
                            Swal.fire({
                                title: ""+result.msg+"",
                                icon: "success",
                            });
                            $('#lab_orders_table').DataTable().ajax.reload(null, false);
                        } else {
                            Swal.fire
                            ({
                                title: ""+result.msg+"",
                                icon: "error",
                            });
                        }
                    }
                });
            }
        });
    }

    function clear() {
        $('input[name="patient_id"]').val('').change();

        $('input[name="no_order"]').val(''); // obtener nuevo

        $('input[name="customer_id"]').val('').change();

        $('input[name="is_reparation"]').prop('checked', false);

        $('.graduation_card_fields').show();

        $('input[name="balance_od"]').prop('checked', false);
        $('input[name="balance_os"]').prop('checked', false);

        $('input[name="sphere_od"]').val('');
        $('input[name="sphere_od"]').prop('readonly', false);
        $('input[name="sphere_os"]').val('');
        $('input[name="sphere_os"]').prop('readonly', false);

        $('input[name="cylindir_od"]').val('');
        $('input[name="cylindir_od"]').prop('readonly', false);
        $('input[name="cylindir_os"]').val('');
        $('input[name="cylindir_os"]').prop('readonly', false);

        $('input[name="axis_od"]').val('');
        $('input[name="axis_od"]').prop('readonly', false);
        $('input[name="axis_os"]').val('');
        $('input[name="axis_os"]').prop('readonly', false);

        $('input[name="base_od"]').val('');
        $('input[name="base_od"]').prop('readonly', false);
        $('input[name="base_os"]').val('');
        $('input[name="base_os"]').prop('readonly', false);

        $('input[name="addition_od"]').val('');
        $('input[name="addition_od"]').prop('readonly', false);
        $('input[name="addition_os"]').val('');
        $('input[name="addition_os"]').prop('readonly', false);

        $('input[name="dnsp_od"]').val('');
        $('input[name="dnsp_os"]').val('');

        $('input[name="di"]').val('');

        $('input[name="ao"]').val('');

        $('input[name="ap"]').val('');

        $('input[name="hoop"]').val('').change();

        $('input[name="is_own_hoop"]').prop('checked', false);
        
        $('input[name="size"]').val('');

        $('input[name="color"]').val('');

        $('input[name="hoop_type"]').prop('checked', false);

        $('input[name="glass"]').val('').change();

        $('input[name="job_type"]').val('');

        $('input[name="check_ext_lab"]').prop('checked', false);

        $('#lab_extern_box').hide();

        $('input[name="external_lab_id"]').val('').change();

        $('input[name="ar"]').prop('checked', false);

        $('input[name="status_lab_order_id"]').prop('checked', false);

        $('input[name="delivery"]').val('');

        $('input[name="select_location_id"]').val('').change();

        $('input[name="warehouse_id"]').val('').change();

        $('input[name="search_product"]').val('');

        //actual_date = '{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}';
        //$('input[name="delivery"]').val(actual_date);

        code = '{{ $code }}';
        $('input[name="no_order"]').val(code);

        $("#list").empty();

        cont = 0;
        product_ids=[];
        rowCont=[];
    }

    $('.second_time').on('click', function() {
        if($(this).is(':checked')) {
            $('#modal_second_time').modal('show');
        }
    });

    $('.re_stock').on('click', function() {
        if($(this).is(':checked')) {
            $('#modal_return_stock').modal('show');
        }
    });

    /** Print order */
    function printOrder(id) {
        var url = '{!! URL::to('/lab-orders/get-report/:id') !!}';
        url = url.replace(':id', id);
        window.open(url, '_blank');
    }

    /** Mark printed status */
    function markPrinted(id) {
        var route = "/lab-orders/markPrinted/" + id;
        $.get(route, function(res) {
            if (res.success) {
                $('#lab_orders_table').DataTable().ajax.reload(null, false);
            }
        });
    }

    /** Mark second status */
    function markSecondTime(id) {
        var route = "/lab-orders/second-time/" + id;
        $.get(route, function(res) {
            if (res.success) {
                $('#lab_orders_table').DataTable().ajax.reload();
                editOrder(res.id);
            }
        });
    }

    /** Validation dnsp and di */
    var _dnsp_od = $('input[name="dnsp_od"]');
    var _dnsp_os = $('input[name="dnsp_os"]');
    var _di = $('input[name="di"]');

    var _ednsp_od = $('input[name="ednsp_od"]');
    var _ednsp_os = $('input[name="ednsp_os"]');
    var _edi = $('input[name="edi"]');

    _dnsp_od.on('change', function(e) {
        if(_dnsp_od.val() != '') {
            _di.prop('readonly', true);
            _dnsp_os.prop('required', true);
        } else {
            if (_dnsp_os.val() == '') {
                _di.prop('readonly', false);
                _dnsp_os.prop('required', false);
            }
        }
    });

    _dnsp_os.on('change', function(e) {
        if(_dnsp_os.val() != '') {
            _di.prop('readonly', true);
            _dnsp_od.prop('required', true);
        } else {
            if (_dnsp_od.val() == '') {
                _di.prop('readonly', false);
                _dnsp_od.prop('required', false);
            }
        }
    });

    _di.on('change', function(e) {
        if(_di.val() != '') {
            _dnsp_od.prop('readonly', true);
            _dnsp_os.prop('readonly', true);
        } else {
            _dnsp_od.prop('readonly', false);
            _dnsp_os.prop('readonly', false);
        }
    });

    _ednsp_od.on('change', function(e) {
        if(_ednsp_od.val() != '') {
            _edi.prop('readonly', true);
            _ednsp_os.prop('required', true);
        } else {
            if (_ednsp_os.val() == '') {
                _edi.prop('readonly', false);
                _ednsp_os.prop('required', false);
            }
        }
    });

    _ednsp_os.on('change', function(e) {
        if(_ednsp_os.val() != '') {
            _edi.prop('readonly', true);
            _ednsp_od.prop('required', true);
        } else {
            if (_ednsp_od.val() == '') {
                _edi.prop('readonly', false);
                _ednsp_od.prop('required', false);
            }
        }
    });

    _edi.on('change', function(e) {
        if(_edi.val() != '') {
            _ednsp_od.prop('readonly', true);
            _ednsp_os.prop('readonly', true);
        } else {
            _ednsp_od.prop('readonly', false);
            _ednsp_os.prop('readonly', false);
        }
    });

    $(document).on('click', 'a.print-order', function(e) {
        e.preventDefault();
        var href = $(this).data('href');
        $.ajax({
            method: "GET",
            url: href,
            dataType: "json",
            success: function(result) {
                if (result.success == 1 && result.order.html_content != '') {
                    $('#lab_orders_table').DataTable().ajax.reload(null, false);
                    $('#order_section').html(result.order.html_content);
                    __currency_convert_recursively($('#order_section'));
                    setTimeout(function() { window.print(); }, 1000);
                } else {
                    Swal.fire
                    ({
                        title: ""+result.msg+"",
                        icon: "error",
                    });
                }
            }
        });
    });
</script>
@endsection