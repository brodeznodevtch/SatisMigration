@php
  $price_precision = config('app.price_precision');
@endphp

<tr class="product_row" data-row_index="{{ $row_count }}">
	{{-- Product --}}
	<td>
		@php
			$product_name = $product->product_name . '<br/>' . $product->sub_sku;

			if (!empty($product->brand)) {
				$product_name .= ' ' . $product->brand;
			}
		@endphp

		@if (auth()->user()->can('edit_product_price_from_sale_screen') || auth()->user()->can('edit_product_discount_from_sale_screen'))
			<div data-toggle="tooltip" data-placement="bottom" title="@lang('lang_v1.pos_edit_product_price_help')">
				<span
					class="text-link text-info cursor-pointer"
					data-toggle="modal"
					data-target="#row_edit_product_price_modal_{{ $row_count }}">
					{!! $product_name !!}&nbsp;
					<i class="fa fa-info-circle"></i>
				</span>
			</div>
		@else
			{!! $product_name !!}
		@endif

		<input type="hidden" class="enable_sr_no" value="{{ $product->enable_sr_no }}">

		<div data-toggle="tooltip" data-placement="bottom" title="@lang('lang_v1.add_description')">
			<i class="fa fa-commenting cursor-pointer text-primary add-pos-row-description"
				data-toggle="modal"
				data-target="#row_description_modal_{{ $row_count }}">
			</i>
		</div>

		@php
			$hide_tax = 'hide';

	        if (session()->get('business.enable_inline_tax') == 1 || $is_admin) {
	            $hide_tax = '';
	        }
	        
			$tax_id = $product->tax_id;
			$item_tax = !empty($product->item_tax) ? $product->item_tax : 0;
			$unit_price_inc_tax = $product->sell_price_inc_tax;

			// if ($hide_tax == 'hide') {
			// 	$tax_id = null;
			// 	$unit_price_inc_tax = $product->default_sell_price;
			// }
		@endphp

		<div class="modal fade row_edit_product_price_model" id="row_edit_product_price_modal_{{ $row_count }}" tabindex="-1" role="dialog">
			@include('sale_pos.partials.row_edit_product_price_modal')
		</div>

		{{-- Description modal start --}}
		<div class="modal fade row_description_modal" id="row_description_modal_{{$row_count}}" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>

						<h4 class="modal-title" id="myModalLabel">
							{{$product->product_name}} - {{$product->sub_sku}}
						</h4>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label>@lang('lang_v1.description')</label>
							@php
								$sell_line_note = '';

								if (!empty($product->sell_line_note)) {
									$sell_line_note = $product->sell_line_note;
								}
							@endphp
							
							<textarea class="form-control" name="products[{{ $row_count }}][sell_line_note]" rows="3">
								{{ $sell_line_note }}
							</textarea>
							
							<p class="help-block">@lang('lang_v1.sell_line_description_help')</p>
						</div>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							@lang('messages.close')
						</button>
					</div>
				</div>
			</div>
		</div>
		{{-- Description modal end --}}
		
		@if (in_array('modifiers', $enabled_modules))
			<div class="modifiers_html">
				@if (!empty($product->product_ms))
					@include('restaurant.product_modifier_set.modifier_for_product', array(
						'edit_modifiers' => true,
						'row_count' => $loop->index,
						'product_ms' => $product->product_ms
					))
				@endif
			</div>
		@endif

		@php
			if (config('app.business') == 'optics') {
				if (isset($reservation_id)) {
					if ($reservation_id > 0) {
						$max_qty_rule = $product->qty_available;
					} else {
						$max_qty_rule = $product->qty_available - $product->qty_reserved;
					}
				} else {
					$max_qty_rule = $product->qty_available;
				}

			} else {
				$max_qty_rule = $product->qty_available - $product->qty_reserved;
			}

			$max_qty_msg = __('validation.custom-messages.quantity_not_available', [
				'qty'=> $product->formatted_qty_available,
				'unit' => $product->unit
			]);
		@endphp

		@if (session()->get('business.enable_lot_number') == 1 || session()->get('business.enable_product_expiry') == 1)
			@php
				$lot_enabled = session()->get('business.enable_lot_number');
				$exp_enabled = session()->get('business.enable_product_expiry');
				$lot_no_line_id = '';

				if (!empty($product->lot_no_line_id)) {
					$lot_no_line_id = $product->lot_no_line_id;
				}
			@endphp

			@if (!empty($product->lot_numbers))
				<select
					class="form-control lot_number"
					name="products[{{ $row_count }}][lot_no_line_id]"
					@if (!empty($product->transaction_sell_lines_id))
						disabled
					@endif>
					<option value="">@lang('lang_v1.lot_n_expiry')</option>
					@foreach ($product->lot_numbers as $lot_number)
						@php
							$selected = "";

							if ($lot_number->purchase_line_id == $lot_no_line_id) {
								$selected = "selected";

								$max_qty_rule = $lot_number->qty_available;
								$max_qty_msg = __('lang_v1.quantity_error_msg_in_lot', [
									'qty'=> $lot_number->qty_formated,
									'unit' => $product->unit
								]);
							}

							$expiry_text = '';

							if ($exp_enabled == 1 && !empty($lot_number->exp_date)) {
								if (\Carbon::now()->gt(\Carbon::createFromFormat('Y-m-d', $lot_number->exp_date))) {
									$expiry_text = '(' . __('report.expired') . ')';
								}
							}
						@endphp

						<option
							value="{{ $lot_number->purchase_line_id }}"
							data-qty_available="{{ $lot_number->qty_available }}"
							data-msg-max="@lang('lang_v1.quantity_error_msg_in_lot', [
								'qty'=> $lot_number->qty_formated,
								'unit' => $product->unit
							])"
							{{ $selected }}>
							@if (!empty($lot_number->lot_number) && $lot_enabled == 1)
								{{ $lot_number->lot_number }}
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
				name="products[{{ $row_count }}][transaction_sell_lines_id]"
				class="form-control" value="{{ $product->transaction_sell_lines_id }}">
		@endif

		<input
			type="hidden"
			name="products[{{ $row_count }}][product_id]"
			class="form-control product_id"
			value="{{ $product->product_id }}">
		
		<input
			type="hidden"
			name="products[{{ $row_count }}][tax_group_id]"
			value="{{ $product->tax_id }}">
		
		<input type="hidden" id="tax_percent" value="{{ $product->tax_percent }}">

		<input
			type="hidden"
			value="{{ $product->variation_id }}" 
			name="products[{{ $row_count }}][variation_id]"
			class="row_variation_id">

		<input
			type="hidden"
			value="{{ $product->enable_stock }}"
			name="products[{{ $row_count }}][enable_stock]">
		
		@if ($product->quantity_ordered == 'N/A')
			@php
				$product->quantity_ordered = 0;
			@endphp
		@elseif (empty($product->quantity_ordered))
			@php
				$product->quantity_ordered = 1;
			@endphp
		@endif

		<div class="input-group input-number">
			<span class="input-group-btn">
				<button type="button" class="btn btn-default btn-flat quantity-down">
					<i class="fa fa-minus text-danger"></i>
				</button>
			</span>

			<input
				type="text"
				data-min="1"
				class="form-control pos_quantity input_number mousetrap"
				value="{{ @num_format($product->quantity_ordered) }}"
				name="products[{{ $row_count }}][quantity]"
				@if ($product->unit_allow_decimal == 1)
					data-decimal=1
				@else
					data-decimal=0
					data-rule-abs_digit="true"
					data-msg-abs_digit="@lang('lang_v1.decimal_value_not_allowed')"
				@endif
				data-rule-required="true"
				data-msg-required="@lang('validation.custom-messages.this_field_is_required')"
				@if ($product->enable_stock || $product->clasification == 'kits')
					data-rule-max-value="{{ $max_qty_rule }}"
					data-qty_available="{{ $max_qty_rule }}"
					data-msg-max-value="{{ $max_qty_msg }}"
					data-msg_max_default="@lang('validation.custom-messages.quantity_not_available', [
						'qty'=> $product->formatted_qty_available,
						'unit' => $product->unit
					])"
				@endif>

			<span class="input-group-btn">
				<button type="button" class="btn btn-default btn-flat quantity-up">
					<i class="fa fa-plus text-success"></i>
				</button>
			</span>
		</div>

		{{$product->unit}}
	</td>

	{{-- Price --}}
	<td class="{{ $hide_tax }}">
		<input
			type="text"
			name="products[{{ $row_count }}][unit_price_inc_tax_]"
			class="form-control pos_unit_price_inc_tax input_number"
			value="{{ number_format($product->sell_price_inc_tax, $price_precision) }}"
			@if (!auth()->user()->can('edit_product_price_from_sale_screen'))
				readonly
			@endif
			@if (!empty($pos_settings['enable_msp']))
				data-rule-min-value="{{ $unit_price_inc_tax }}"
				data-msg-min-value="{{ __('lang_v1.minimum_selling_price_error_msg', [
					'price' => @num_format($unit_price_inc_tax)
				]) }}"
			@endif>

		<input
			type="hidden"
			id="u_price_exc_tax"
			name="products[{{ $row_count }}][u_price_exc_tax]"
			value="{{ number_format($product->default_sell_price, $price_precision) }}">

		<input
			type="hidden"
			id="u_price_inc_tax"
			name="products[{{ $row_count }}][u_price_inc_tax]"
			value="{{ number_format($product->sell_price_inc_tax, $price_precision) }}">

		<input
			type="hidden"
			id="unit_price_exc_tax"
			name="products[{{ $row_count }}][unit_price_exc_tax]"
			value="{{ number_format($product->default_sell_price, $price_precision) }}">

		<input
			type="hidden"
			id="unit_price_inc_tax"
			name="products[{{ $row_count }}][unit_price_inc_tax]"
			value="{{ number_format($product->sell_price_inc_tax, $price_precision) }}">
	</td>

	{{-- Subtotal --}}
	<td class="text-center v-center">
		@php
			$subtotal_type = !empty($pos_settings['is_pos_subtotal_editable']) ? 'text' : 'hidden';
		@endphp

		<input
			type="{{ $subtotal_type }}"
			class="form-control pos_line_total @if (!empty($pos_settings['is_pos_subtotal_editable'])) input_number @endif"
			value="{{ number_format($product->quantity_ordered * $unit_price_inc_tax, $price_precision) }}">
		
		<span
			class="display_currency pos_line_total_text @if (!empty($pos_settings['is_pos_subtotal_editable'])) hide @endif"
			data-currency_symbol="true"
			data-precision="{{ $decimals_in_sales }}">
			{{ $product->quantity_ordered * $unit_price_inc_tax }}
		</span>
	</td>

	{{-- Service parent --}}
	@if (config('app.business') == 'workshop')
	<input
		type="hidden"
		id="service_parent_id"
		name="products[{{ $row_count }}][service_parent_id]"
		value="{{ $product->service_parent_id }}">
	@endif

	{{-- Button to remove row --}}
	<td class="text-center">
		<i class="fa fa-close text-danger pos_remove_row cursor-pointer" aria-hidden="true"></i>
	</td>
</tr>