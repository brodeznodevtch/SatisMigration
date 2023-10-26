<tr class="product_row">
    {{-- Product --}}
    <td>
        {{$product->product_name}}
        <br/>
        {{$product->sub_sku}}

        @if ( session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
        @php
            $lot_enabled = session()->get('business.enable_lot_number');
            $exp_enabled = session()->get('business.enable_product_expiry');
            $lot_no_line_id = '';
            if (!empty($product->lot_no_line_id)) {
                $lot_no_line_id = $product->lot_no_line_id;
            }
        @endphp
        @if (!empty($product->lot_numbers))
            <select class="form-control lot_number" name="products[{{ $row_index }}][lot_no_line_id]">
                <option value="">
                    @lang('lang_v1.lot_n_expiry')
                </option>
                @foreach ($product->lot_numbers as $lot_number)
                    @php
                        $selected = "";
                        if ($lot_number->purchase_line_id == $lot_no_line_id) {
                            $selected = "selected";

                            $max_qty_rule = $lot_number->qty_available;
                            $max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit]);
                        }

                        $expiry_text = '';
                        if ($exp_enabled == 1 && !empty($lot_number->exp_date)) {
                            if( \Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date)) ){
                                $expiry_text = '(' . __('report.expired') . ')';
                            }
                        }
                    @endphp
                    <option
                        value="{{ $lot_number->purchase_line_id }}"
                        data-qty_available="{{ $lot_number->qty_available }}"
                        data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', ['qty'=> $lot_number->qty_formated, 'unit' => $product->unit  ])" {{$selected}}>
                            @if (!empty($lot_number->lot_number) && $lot_enabled == 1)
                                {{$lot_number->lot_number}}
                            @endif
                            @if ($lot_enabled == 1 && $exp_enabled == 1)
                                -
                            @endif
                            @if ($exp_enabled == 1 && !empty($lot_number->exp_date))
                                @lang('product.exp_date'): {{ @format_date($lot_number->exp_date) }}
                            @endif
                            {{ $expiry_text }}
                    </option>
                @endforeach
            </select>
        @endif
    @endif
    </td>

    {{-- Quantity --}}
    <td>
        {{-- If edit then transaction sell lines will be present --}}
        @if (!empty($product->transaction_sell_lines_id))
            <input
                type="hidden"
                name="products[{{ $row_index }}][transaction_sell_lines_id]"
                class="form-control"
                value="{{ $product->transaction_sell_lines_id }}">
        @endif

        <input
            type="hidden"
            name="products[{{ $row_index }}][product_id]"
            class="form-control product_id"
            value="{{ $product->product_id }}">

        <input
            type="hidden"
            value="{{ $product->variation_id }}"
            name="products[{{ $row_index }}][variation_id]"
            class="row_variation_id">

        <input
            type="hidden"
            value="{{ $product->enable_stock }}"
            name="products[{{ $row_index }}][enable_stock]">
        
        @if (empty($product->quantity_ordered))
            @php
                $product->quantity_ordered = 1;
            @endphp
        @endif

        <input
            type="text"
            class="form-control product_quantity input_number"
            value="{{ @num_format($product->quantity_ordered) }}"
            name="products[{{ $row_index }}][quantity]" 
            @if ($product->unit_allow_decimal == 1)
                data-decimal=1
            @else
                data-rule-abs_digit="true"
                data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')"
                data-decimal=0
            @endif
            data-rule-required="true"
            data-msg-required="@lang('validation.custom-messages.this_field_is_required')"
            @if ($product->enable_stock && $check_qty_available == 1)
                data-rule-max-value="{{ $product->qty_available - $product->qty_reserved }}"
                data-msg-max-value="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit])"
                data-qty_available="{{ $product->qty_available - $product->qty_reserved }}" 
                data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', ['qty'=> $product->formatted_qty_available, 'unit' => $product->unit])"
            @endif>
        {{ $product->unit }}
    </td>

    @php
        $unit_cost = $show_costs_or_prices == 'costs' ? $product->last_purchased_price : $product->sell_price_inc_tax;
    @endphp

    {{-- Cost/Price --}}
    <td>
        <input
            type="text"
            readonly
            class="form-control product_unit_price input_number"
            value="{{ number_format($unit_cost, $decimals_in_inventories) }}">

        <input
            type="hidden"
            name="products[{{ $row_index }}][unit_price]"
            class="product_unit_price_hidden"
            value="{{ $product->last_purchased_price }}">
    </td>

    {{-- Subtotal --}}
    <td>
        <input
            type="text"
            readonly
            class="form-control product_line_total"
            value="{{ number_format($product->quantity_ordered * $unit_cost, $decimals_in_inventories) }}">

        <input
            type="hidden"
            name="products[{{ $row_index }}][price]"
            class="product_line_total_hidden"
            value="{{ $product->quantity_ordered * $product->last_purchased_price }}">
    </td>

    {{-- Remove product row button --}}
    <td class="text-center">
        <i class="fa fa-trash remove_product_row cursor-pointer" aria-hidden="true"></i>
    </td>
</tr>