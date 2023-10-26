<div class="modal-dialog modal-xl" role="dialog">
    <div class="modal-content" style="border-radius: 10px;">
        {!! Form::open(['url' => action([\App\Http\Controllers\ExpenseController::class, 'update'], [$expense->id]), 'method' => 'PUT', 'id' => 'edit_expense_form', 'files' => true]) !!}

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">@lang('expense.edit_expense')</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                {{-- contact_id --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('proveedor_id', __('expense.expense_provider') . ':') !!}
                            {!! Form::select('contact_id', [$expense->contact_id => $expense->contact->contact_id], $expense->contact_id,
                                ['class' => 'form-control', 'placeholder' => __('contact.search_provider'), 'style' => 'width:100%', 'id' => 'supplier_id']) !!}
                    </div>
                </div>
                {{-- supplier_name, is_exempt --}}
                <div class="col-sm-8 col-md-6 col-lg-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('name', __('expense.expense_provider_name')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </span>
                            <input type="text" name="supplier_name" class="form-control" readonly id="supplier_name"
                                placeholder="@lang('expense.expense_provider_name')" value="{{ $expense->contact->name }}">
                            <input type="hidden" id="is_exempt" name="is_exempt" value="{{ $expense->contact->is_exempt }}">
                            <input type="hidden" id="is_excluded_subject" name="is_excluded_subject" value="{{ $expense->contact->is_excluded_subject }}">
                            <input type="hidden" id="tax_percent" value="0">
                            <input type="hidden" id="tax_min_amount" value="0">
                            <input type="hidden" id="tax_max_amount" value="0">
                        </div>
                    </div>
                </div>
                {{-- location_id --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('location_id', __('business.location')) !!}
                        <span style="color: red">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user-secret"></i>
                            </span>
                            {!! Form::select("location_id", $business_locations, $expense->location_id, ["class" => 'form-control', 'placeholder' => __('messages.please_select'), 'required']) !!}
                        </div>
                    </div>
                </div>
                {{-- transaction_date --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('transaction_date', __('messages.date') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" value="{{ @format_date($expense->transaction_date) }}" name="transaction_date" id="expense_transaction_date" required class="form-control">
                        </div>
                    </div>
                </div>
                {{-- document_date --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('document_date', __('retention.document_date') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" value="{{ @format_date($expense->document_date) }}" name="document_date" id="expense_document_date" required class="form-control">
                        </div>
                    </div>
                </div>
                {{-- document_types_id --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('document_types_id', __('expense.document_type') . ':') !!}<span style="color: red">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-file-text-o"></i>
                            </span>
                            {!! Form::select('document_types_id', $document, $expense->document_types_id, ['class' => 'form-control', 'required', 'style' => 'width:100%', 'placeholder' => __('messages.please_select')]) !!}
                        </div>
                    </div>
                </div>
                {{-- ref_no --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('ref_no', __('expense.document_n') . ':') !!}<span style="color: red">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-hashtag"></i>
                            </span>
                            {!! Form::text('ref_no', $expense->ref_no, ['class' => 'form-control', 'required', 'placeholder' => __('expense.document_n')]) !!}
                        </div>
                    </div>
                </div>
                {{-- serie --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('serie', __('accounting.serie') . ':') !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-hashtag"></i>
                            </span>
                            {!! Form::text('serie', $expense->serie, ['class' => 'form-control', 'placeholder' => __('accounting.serie')]) !!}
                        </div>
                    </div>
                </div>
                {{-- payment_condition --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label("payment_condition", __("lang_v1.payment_condition")) !!} <span style="color: red">*</span>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-credit-card-alt"></i>
                            </span>
                            <select name="payment_condition" id="payment_condition" class="form-control" required>
                                @if ($expense->payment_condition == 'cash')
                                    <option value="{{ $expense->payment_condition }}">{{ $expense->payment_condition }}
                                    </option>
                                    <option value="credit">@lang('sale.credit')</option>
                                @else
                                    <option value="{{ $expense->payment_condition }}">{{ $expense->payment_condition }}
                                    </option>
                                    <option value="cash">@lang('sale.cash')</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                {{-- payment_term_id --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label("payment_term_id", __("purchase.credit_terms")) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ol"></i>
                            </span>
                            {!! Form::select("payment_term_id", $payment_terms, null, ["class" => "form-control", "id" => "payment_term_id", "disabled", "style" => "width: 100%;"]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"><hr></div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label(null, __('lang_v1.search')) !!}
                        {!! Form::select(null, [], null, ['class' => 'form-control',
                            'style' => 'width:100%', 'id' => 'expense_search',
                            'placeholder' => __('expense.search_expense_category')]) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 sm-12">
                    <table class="table table-bordered table-striped table-sm" id="expense_lines">
                        <thead>
                            <tr>
                                <th class="text-center">@lang('expense.type_expense')</th>
                                <th class="text-center" style="width: 60%;">@lang('expense.expense_account')</th>
                                <th class="text-center" style="width: 15%;">@lang('sale.amount')</th>
                                <th class="text-center"><i class="fa fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expense_lines as $el)
                            <tr>
                                <td>
                                    <input type="hidden" name="expense_lines[{{ $loop->index }}][id]"
                                        data-name="id" value="{{ $el->id }}">
                                    <input type="hidden" data-name="category_id"
                                        name="expense_lines[{{ $loop->index }}][category_id]" value="{{ $el->category_id }}"/>
                                        {{ $el->name }}
                                </td>
                                <td>{{ $el->code .' '. $el->account_name }}</td>
                                <td>
                                    <input type="text" data-name="line_total" name=expense_lines[{{ $loop->index }}][line_total]
                                        class="form-control input-sm input_number" value="{{ $el->amount }}" />
                                </td>
                                <td class="text-center">
                                    <i class="fa fa-times del-exp text-danger cursor-pointer"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                {{-- total_before_tax --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        <label for="">@lang('sale.subtotal')</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-usd"></i>
                            </span>
                            {!! Form::text('total_before_tax', $expense->total_before_tax, ['class' => 'form-control input_number', 'id' => 'amount', 'placeholder' => __('sale.total_amount'), 'readonly']) !!}
                        </div>
                    </div>
                </div>
                {{-- excluded_subject_amount --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        <label for="">@lang('expense.excluded_subject_amount')</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-usd"></i>
                            </span>
                            {!! Form::text('excluded_subject_amount', $expense->excluded_subject_amount, ['class' => 'form-control input_number', 'id' => 'excluded_subject_amount', 'placeholder' => __('expense.excluded_subject_amount'), 'readonly']) !!}
                        </div>
                    </div>
                </div>
                {{-- tax_group_id --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('tax_group', __('tax_rate.tax_type') . ':') !!}
                        <div class="input-group">
                            @php
                            $dis = '';
                            if ($expense->contact->is_exempt == 1 || $expense->contact->is_excluded_subject == 1) {
                                $dis = 'disabled';
                            }
                            @endphp
                            <span class="input-group-addon">
                                <i class="fa fa-percent"></i>
                            </span>
                            <select name="tax_group_id" id="tax_percent_group" class="form-control select2" style="width: 100%;" {{ $dis }}>
                                <option value="nulled">@lang('messages.please_select')</option>
                                @foreach ($tax_groups as $tg)
                                <option data-tax_percent="{{ $tg['percent'] }}"
                                    value="{{ $tg['id'] }}" {{ $tg['id'] == $expense->tax_id ? 'selected' : '' }}> {{ $tg['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{-- exempt_amount --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        <label for="">@lang('tax_rate.exempt_amount')</label>
                        <div class="input-group">
                            @php
                                $dis = $expense->contact->is_excluded_subject == 1 ? 'disabled' : '';
                            @endphp
                            <span class="input-group-addon">
                                <input type="checkbox" id="enable_exempt_amount" @if ($expense->exempt_amount > 0) checked="true" @endif {{ $dis }}>
                            </span>
                            {!! Form::text('exempt_amount', $expense->exempt_amount > 0 ? $expense->exempt_amount : null, [
                                'class' => 'form-control input_number',
                                'id' => 'exempt_amount',
                                'placeholder' => __('tax_rate.exempt_amount'),
                                $expense->exempt_amount > 0 ? '' : 'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>
                {{-- perception_amount --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12" style="display: none;" id="perception_div">
					<div class="form-group">
                        <label for="perception_amount">@lang('tax_rate.perception')</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-usd"></i>
                            </span>
                            {!! Form::text('perception_amount', $expense->tax_amount, ['class' => 'form-control input_number', 'id' => 'perception_amount', 'placeholder' => __('tax_rate.perception'), 'readonly']) !!}
                        </div>
					</div>
				</div>
                {{-- tax_amount --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('iva', __('expense.taxes')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-usd"></i>
                            </span>
                            {!! Form::text('tax_amount', $expense->tax_group_amount, ['class' => 'form-control', 'id' => 'iva', 'readonly', 'required']) !!}
                        </div>
                    </div>
                </div>
                
                {{-- final_total --}}
                <div class="col-sm-4 col-md-3 col-lg-3 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('final_total', __('sale.total_amount_expense')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-usd"></i>
                            </span>
                            {!! Form::text('final_total', $expense->final_total, ['class' => 'form-control', 'id' => 'final_total', 'readonly', 'required']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    {{-- document --}}
                    <div class="form-group">
                        {!! Form::label('document', __('purchase.attach_document') . ':') !!}
                        {!! Form::file('document', ['id' => 'upload_document', 'size' => 1]) !!}
                        <p style="font-size: 10px;" class="help-block">@lang('purchase.max_file_size', ['size' =>
                            (config('constants.document_size_limit') / 1000000)])</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    {{-- additional_notes --}}
                    <div class="form-group">
                        {!! Form::label('additional_notes', __('expense.expense_note') . ':') !!}
                        <textarea name="additional_notes" id="additional_notes" class="form-control" style="resize: none;" cols="20" rows="3">{{ $expense->additional_notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            <button type="button" data-dismiss="modal" aria-label="Close"
                class="btn btn-default">@lang('messages.close')</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
