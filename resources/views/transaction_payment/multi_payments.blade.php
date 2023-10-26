@extends('layouts.app')
@section('title', __('payment.multi_payments'))

@section('css')
    <style>
        table#invoices tbody tr td {
            vertical-align: middle;
        }

        table#invoices thead tr th {
            text-align: center;
        }

        .fa.fa-times {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>@lang('payment.multi_payments')
        <small>Registrar pagos múltiples</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-body">
            {!! Form::open(['url' => action([\App\Http\Controllers\TransactionPaymentController::class, 'storeMultiPayments']),
                'method' => 'post', 'id' => 'multi_payments_form', 'files' => true]) !!}
            <div class="row">
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="form-group">
                        {!! Form::label('customer', __('customer.customer')) !!} <span class="text-danger">*</span>
                        {!! Form::select('customer', [], null, ['class' => 'form-control', 'id' => 'customer']) !!}
                        {!! Form::hidden(null, null, ['id' => 'customer_id']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <div class="form-group">
                        {!! Form::label('amount', __('payment.amount')) !!} <span class="text-danger">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-money"></i>
                            </span>
                            {!! Form::text('amount', null, ['class' => 'form-control input_number',
                                'placeholder' => __('payment.amount'), 'id' => 'amount']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <div class="form-group">
                        {!! Form::label('paid_on', __('payment.paid_on')) !!} <span class="text-danger">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            {!! Form::text('paid_on', date('d/m/Y', strtotime('now')), ['class' => 'form-control input-date', 'readonly']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <div class="form-group">
                        {!! Form::label('method', __('payment.payment_method')) !!} <span class="text-danger">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-credit-card-alt"></i>
                            </span>
                            {!! Form::select('method', $payment_methods, 'cash', ['class' => 'form-control', 'id' => 'payment_method']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12 payment-details card-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("card_holder_name", __('payment.card_holder_name')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            {!! Form::text("card_holder_name", null,
                                ['class' => 'form-control', 'placeholder' => __('payment.card_holder_name')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details card-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("card_authotization_number", __('payment.card_authotization_number')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa">#</i>
                            </span>
                            {!! Form::text("card_authotization_number", null,
                                ['class' => 'form-control input_number', 'placeholder' => __('messages.please_select')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details card-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("card_type", __('payment.card_type')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-credit-card-alt"></i>
                            </span>
                            {!! Form::select("card_type", ['credit' => __('payment.credit_card'),
                                'debit' => __('payment.debit_card'), 'visa' => 'Visa', 'master' => 'MasterCard'],
                                'credit', ['class' => 'form-control']); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details card-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("card_pos", __('payment.card_pos')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-credit-card"></i>
                            </span>
                            {!! Form::select("card_pos", $pos, null, ['class' => 'form-control',
                                'placeholder' => __('messages.please_select')]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details check-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("check_number", __('payment.check_number')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa">#</i>
                            </span>
                            {!! Form::text("check_number", null,
                                ['class' => 'form-control input_number', 'placeholder' => __('payment.check_number')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details check-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("check_account", __('payment.check_account')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-file-o"></i>
                            </span>
                            {!! Form::text("check_account", null,
                                ['class' => 'form-control input_number', 'placeholder' => __('payment.check_account')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details check-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("check_bank", __('payment.check_bank')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-university"></i>
                            </span>
                            {!! Form::select("check_bank", $banks, null,
                                ['class' => 'form-control', 'placeholder' => __('messages.please_select')]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12 payment-details check-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("check_account_owner", __('payment.check_account_owner')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            {!! Form::text("check_account_owner", null,
                                ['class' => 'form-control', 'placeholder' => __('payment.check_account_owner')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details bank_transfer-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("transfer_ref_no", __('payment.transfer_ref_no')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa">#</i>
                            </span>
                            {!! Form::text( "transfer_ref_no", null,
                                ['class' => 'form-control input_number', 'placeholder' => __('payment.transfer_ref_no')]); !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details bank_transfer-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("transfer_issuing_bank", __('payment.transfer_issuing_bank')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-university"></i>
                            </span>
                            {!! Form::select("transfer_issuing_bank", $banks, null,
                                ['class' => 'form-control', 'placeholder' => __('messages.please_select')]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 payment-details bank_transfer-method" style="display: none;">
                    <div class="form-group">
                        {!! Form::label("transfer_receiving_bank", __('payment.transfer_receiving_bank')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-file-o"></i>
                            </span>
                            {!! Form::select("transfer_receiving_bank", $bank_accounts, null,
                                ['class' => 'form-control', 'placeholder' => __('messages.please_select')]) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <div class="form-group">
                        {!! Form::label('document', __('purchase.attach_document')) !!}
                        {!! Form::file('document', ['style' => 'margin-bottom: 23px;']) !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="form-group">
                        {!! Form::label('note', __('payment.note')) !!}
                        {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('payment.note')]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('search_invoice', __('sale.search_invoices')) !!}
                        {!! Form::select(null, [], null, ['class' => 'form-control', 'id' => 'search_invoices', 'disabled']) !!}
                    </div>
                </div>
            </div>
            <div class="row payment-exceed" style="display: none;">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        @lang('payment.payment_exceed')
                    </div>
                </div>
            </div>
            <div class="row invoices-row">
                <div class="col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="invoices">
                            <thead>
                                <tr>
                                    <th style="width: 17%;">{{ mb_strtoupper(__('lang_v1.date')) }}</th>
                                    <th style="width: 17%;">{{ mb_strtoupper(__('lang_v1.correlative')) }}</th>
                                    <th style="width: 17%;">{{ mb_strtoupper(__('purchase.due')) }}</th>
                                    <th style="width: 17%;">{{ mb_strtoupper(__('payment.payment')) }}</th>
                                    <th style="width: 17%;">{{ mb_strtoupper(__('sale.total')) }}</th>
                                    <th>{{ mb_strtoupper(__('messages.actions')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Invoinces table records here -->
                            </tbody>
                            <tfoot>
                                <tr> 
                                    <th colspan="2" style="text-align: center;">
                                        {{ mb_strtoupper(__('sale.total')) }}
                                    </th>
                                    <th id="total_due" style='text-align: right;'></th>
                                    <th id="total_payment" style='text-align: right;'></th>
                                    <th id="total_final" style='text-align: right;'></th>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 text-right">
                    <button type="button" id="reset_payments"
                        class="btn btn-danger btn-flat">@lang('messages.cancel')</button>
                    <button type="button" id="save_payments"
                        class="btn btn-primary btn-flat">@lang('messages.save')</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
<!-- /.content -->
@stop
@section('javascript')
    <script>
        $(function () {
            /** Date picker */
            $('input.input-date').datepicker({
                autoclose: true,
                format: datepicker_date_format
            });

            /** Get customers */
            $("select#customer").select2({
                ajax: {
                    type: "get",
                    url: "/customers/get_only_customers",
                    dataType: "json",
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                placeholder: LANG.search_customer,
                minimumInputLength: 3,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            /** On select customer */
            $("select#customer").on("select2:select", function (d) {
                let id = d.params.data.id;

                if (id) {
                    let amount = $('input#amount').val();

                    $('input#customer_id').val(id);
                    $('table#invoices tbody').empty();
                    updateInvoiceTableTotals();

                    if (amount > 0) {
                        $('select#search_invoices').removeAttr('disabled');
                    }
                }
            });

            /** Get due invoices */
            $('select#search_invoices').select2({
                ajax: {
                    type: 'get',
                    url: function () {
                        customer_id = $('input#customer_id').val();
                        return '/sells/get-trans-due-by-customer/'+ customer_id;
                    },
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                placeholder: LANG.search_invoices,
                minimumInputLength: 1,
                escapeMarkup: function (markup) {
                    return markup;
                }
            });

            /**  On select invoince */
            $('select#search_invoices').on('select2:select', function (d) {
                let data = d.params.data;
                let table = $('table#invoices tbody');

                if (transExists(data.id)) {
                    swal({
                        title: LANG.notice,
                        text: LANG.invoice_added_already,
                        icon: 'info'
                    });

                    return;
                }

                let tr = `
                    <tr>
                        <td>
                            ${data.transaction_date}
                            <input type='hidden'
                                class='transaction_id'
                                data-name='transaction_id'
                                value='${data.id}' />
                        </td>
                        <td style='text-align: center;'>${data.correlative}</td>
                        <td style='text-align: right;'>
                            <span class='display_currency'
                                data-currency_symbol='true'
                                data-currency_precission='2'>
                                ${data.balance}
                            </span>
                            <input type='hidden' class='balance' value='${parseFloat(data.balance).toFixed(2)}' />
                        </td>
                        <td>
                            <input type='text' value='${parseFloat(data.balance).toFixed(2)}'
                                class='form-control input-sm input_number payment'
                                style='text-align: right;' data-name='amount'>
                        </td>
                        <td style='text-align: right;'>
                            <span class='display_currency'
                                data-currency_symbol='true'
                                data-currency_precission='2'>
                                ${data.final_total}
                            </span>
                            <input type='hidden' class='total_final' value='${data.final_total}' />
                        </td>
                        <td style='text-align: center;'>
                            <i class='fa fa-times text-danger' title='${LANG.delete}'></i>
                        </td>
                    </tr>
                `;

                table.prepend(tr);
                updateInvoiceTableIndexes();
                updateInvoiceTableTotals();
                $('select#search_invoices').val('').trigger('change');
                __currency_convert_recursively($('table#invoices'));

                /** Valid if payment amount exceeded */
                payAmountExceeded();
            });

            /** On click on delete button */
            $(document).on('click', 'i.fa-times', function () {
                let tr = $(this).closest('tr');

                swal({
                    title: LANG.sure,
                    text: LANG.wont_be_able_revert,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((remove) => {
                    if (remove) {
                        tr.remove();
                        updateInvoiceTableIndexes();
                        updateInvoiceTableTotals();
                        payAmountExceeded();
                        __currency_convert_recursively($('table#invoices'));
                    }
                });
            });

            /** On payment method change */
            $('select#payment_method').on('change', function () {
                let method = $(this).val();
                let payment_details = $('div.payment-details');

                $.each(payment_details, function (i, div) {
                    if ($(div).hasClass(method+'-method')) {
                        $(div).show();
                    } else {
                        $(div).hide();
                    }
                });
            });

            /** On payment amount change */
            $('input#amount').on('change', function () {
                let amount = $(this).val();
                let customer = $('select#customer').val();
                let search_invoices = $('select#search_invoices');

                if (amount > 0 && customer) {
                    search_invoices.removeAttr('disabled');

                } else {
                    search_invoices.attr('disabled', true);
                }

                payAmountExceeded();
            });

            /** On change any payment value */
            $(document).on('change', 'input.payment', function () {
                let input = $(this);
                let payment = __read_number(input);
                let tr = input.closest('tr');
                let balance = __read_number($(tr).find('input.balance'));

                if (payment > balance) {
                    __write_number(input, balance);

                    swal({
                        title: LANG.error,
                        text: LANG.pay_amount_higher_than_due_balance,
                        icon: 'error'
                    }).then(function () {
                        input.focus();
                    });
                }

                updateInvoiceTableTotals();
                payAmountExceeded();
                __currency_convert_recursively($('table#invoices'));
            });

            /** On click on reset button */
            $('button#reset_payments').on('click', function () {
                swal({
                    title: LANG.sure,
                    text: LANG.wont_be_able_revert,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((reset) => {
                    if (reset) {
                        resetForm();
                    }
                });
            });

            /** On click on submit button */
            $('button#save_payments').on('click', function () {
                if (payAmountExceeded()) {
                    swal({
                        title: LANG.error,
                        text: LANG.payment_exceed,
                        icon: 'error'
                    });
                }

                $('button#save_payments').attr('disabled', true);
                let form = document.getElementById('multi_payments_form');
                let data = new FormData(form);

                $.ajax({
                    method: 'post',
                    url: $(form).attr('action'),
                    data: data,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.success) {
                            swal({
                                title: LANG.success,
                                text: res.msg,
                                icon: 'success'
                            });

                            resetForm();
                            $('button#save_payments').removeAttr('disabled');

                        } else {
                            swal({
                                title: LANG.error,
                                text: res.msg,
                                icon: 'error'
                            });

                            $('button#save_payments').removeAttr('disabled');
                        }
                    }
                });
            });

            /**
             * Update indexes on invoices table
             * @return void
            */
            function updateInvoiceTableIndexes() {
                let rows = $('table#invoices tbody tr');

                $.each(rows, function (index, row) {
                    let inputs = $(row).find('input');

                    $.each(inputs, function (i, input) {
                        let name = $(input).data('name');

                        if (name) {
                            $(input).attr('name', 'payments['+ index +']['+ name +']');
                        }
                    });
                });
            }

            /**
             * Update total on invoices table
             * 
             * @return void
            */
            function updateInvoiceTableTotals() {
                let rows = $('table#invoices tbody tr');
                let foot = $('table#invoices tfoot tr');
                let total_due = 0;
                let total_payment = 0;
                let total_final = 0;

                $.each(rows, function (index, row) {
                    let due = __read_number($(row).find('input.balance'));
                    let pay = __read_number($(row).find('input.payment'));
                    let total = __read_number($(row).find('input.total_final'));

                    total_due += due;
                    total_payment += pay;
                    total_final += total;
                });

                if (!(total_due > 0) &&
                    !(total_payment > 0) &&
                    !(total_final > 0)) {
                        foot.find('th#total_due').empty();
                        foot.find('th#total_payment').empty();
                        foot.find('th#total_final').empty();

                        return;
                }

                foot.find('th#total_due')
                    .html('<span class="display_currency" data-currency_symbol="true" data-currency_precission="2">'+ total_due +'</span>');
                foot.find('th#total_payment')
                    .html('<span class="display_currency" data-currency_symbol="true" data-currency_precission="2">'+ total_payment +'</span>');
                foot.find('th#total_final')
                    .html('<span class="display_currency" data-currency_symbol="true" data-currency_precission="2">'+ total_final +'</span>');
            }

            /**
             * Determinate if transactions already exists
             * 
             * @return boolean
            */
            function transExists(id) {
                let rows = $('table#invoices tbody tr');
                let transaction_id = null;
                let exists = false;

                $.each(rows, function (index, row) {
                    transaction_id = $(row).find('input.transaction_id').val();
                   
                    if (transaction_id == id) {
                        exists = true;
                    }
                });

                return exists;
            }


            /**
             * Determinate if total payments exceeded payment amount
             * 
             * @return boolean
            */
            function payAmountExceeded() {
                let pay_amount = __read_number($('input#amount'));
                let rows = $('table#invoices tbody tr');
                let pay_total = 0;
                let exceed = false;

                $.each(rows, function (index, row) {
                    pay_total += __read_number($(row).find('input.payment'));

                    if ((pay_total - pay_amount) > 0.01) {
                        exceed = true;
                    }
                });

                if (exceed) {
                    $('div.payment-exceed').show();
                    $('button#save_payments').attr('disabled', true);
                } else {
                    $('div.payment-exceed').hide();
                    $('button#save_payments').removeAttr('disabled');
                }

                return exceed;
            }

            /**
             * Reset multi payments form
             * 
             * @return void
            */
            function resetForm() {
                $('select#customer').val('').trigger('change');
                $('select#search_invoices').val('').trigger('change');
                $('input#amount').val('');
                $('select#payment_method').val('cash').trigger('change');
                $('input[type="file"]').val('');
                $('textarea').val('');
                $("input.input-date").datepicker('setDate', moment().format(moment_date_format));
                $('table#invoices tbody tr').empty();
                updateInvoiceTableTotals();
                payAmountExceeded();
            }
        });
    </script>
@endsection
