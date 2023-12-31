<style>
	div#main { width: 100%;  font-size: 7.5pt;
		font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; }
	div#container { width: 9.1cm; }
	div#head { height: 3.5cm; width: 100%; }
	div#header { height: 2cm; width: 100%; }
	div#container table{ width: 100%; }
	div#container table td { vertical-align: middle; }
	@if ($receipt_details->discount_amount > 0)
	div#details { height: 6.2cm; width: 100%; }
	div#extra-details { position: relative; height: 0.8cm; }
	div#extra-details #discount-text { position: absolute; left: 5.2cm; top: 0.1cm; padding-left: 0.2cm; }
	div#extra-details #discount-amount { position: absolute; left: 7.9cm; top: 0.1cm; width: 1.2cm; text-align: right; }
	@else
	div#details { height: 7cm; width: 100%; }
	@endif
	div#container div#header table { width: 100%; }
	div#container div#header table td { height: 0.5cm; }
	div#details table#sell_lines,
	div#header table { table-layout: fixed; }
	div#details table#sell_lines thead th { height: 0.4cm; }
	div#details table#sell_lines tbody td  { height: 0.4cm; }
	div#details table#sell_lines tbody td { padding-left: 0.1cm; }
	div#footer table td { padding-left: 0.1cm; }
	div#footer table tr { height: 0.5cm; }
	.cutter { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>

<div id="main">
	<div id="container" style="margin: 0 0.6cm 0 0.8cm; display: inline-block;">
		<div id="head"></div>
		<div id="header">
			<table id="header">
				<tr>
					<td style="width: 5.5cm;">&nbsp;</td>
					<td style="width: 3.6cm;">
						{{
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("d",strtotime($receipt_details->invoice_date))
							. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("m",strtotime($receipt_details->invoice_date))
							. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("Y",strtotime($receipt_details->invoice_date))
						}}
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 1.3cm;" class="cutter">{{ $receipt_details->customer_name }}</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 1.5cm;" class="cutter">{{ $receipt_details->customer_location }}</td>
				</tr>
				<tr>
					<td style="padding-left: 2.5cm;" class="cutter">{{ $receipt_details->customer_employee_name }}</td>
					<td style="padding-left: 1.2cm;" class="cutter">{{ $receipt_details->customer_dui }}</td>
				</tr>
			</table>
		</div>
		<div id="details">
			<table id="sell_lines">
				<thead>
					<tr>
						<th style="width: 1.4cm; text-align: center;">&nbsp;</th><!-- CÓDIGO -->
						<th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- CANT -->
						<th style="width: 3.5cm; text-align: center;">&nbsp;</th><!-- DESCRIPCIÓN -->
						<th style="width: 1cm; text-align: center;">&nbsp;</th><!-- PRECIO UNITARIO -->
						<th style="width: 0.4cm; text-align: center;">&nbsp;</th><!-- VTA. NO SUJETA -->
                        @if (!$receipt_details->customer_is_exempt)
                            <th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- VTA. EXENTA -->
                            <th style="width: 1.2cm; text-align: center;">&nbsp;</th><!-- VTAS. GRABADAS -->
                        @else
                            <th style="width: 1.2cm; text-align: center;">&nbsp;</th><!-- VTA. EXENTA -->
                            <th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- VTAS. GRABADAS -->
                        @endif
					</tr>
				</thead>
				<tbody>
					@forelse($receipt_details->lines as $line)
					<tr>
						<td class="cutter">{{ $line['sub_sku']}}</td>
						<td style="text-align: right;">{{ $line['quantity'] }}</td>
						<td class="cutter">
							{{ $line['name']}} {{$line['variation'] }}
							@if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif 
							@if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
							@if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif
						</td>
						<td style="text-align: right;">
                            @if (!$receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false" data-precision="4">
                                    {{ $line['unit_price'] }}
                                </span>
                            @else
                                <span class="display_currency" data-currency_symbol="false" data-precision="4">
                                    {{ $line['unit_price_exc'] }}
                                </span>
                            @endif
						</td>
						<td style="text-align: right;">
                            @if ($receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false">
                                    {{ $line['line_total_exc_tax'] }}
                                </span>
                            @else
                                &nbsp;
                            @endif
                        </td>
						<td>&nbsp;</td>
						<td style="text-align: right;">
                            @if (!$receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false">
                                    {{ $line['line_total'] }}
                                </span>
                            @else
                                &nbsp;
                            @endif
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		@if ($receipt_details->discount_amount > 0)
		<div id="extra-details">
			<div id="discount-text">
				DESCUENTO (-) {{ $receipt_details->discount_percent }}
			</div>
			<div id="discount-amount">
				<span class="display_currency" data-currency_symbol="false">
					{{ $receipt_details->discount_amount }}
				</span>
			</div>
		</div>
		@endif
		<div id="footer">
			<table>
				<tr>
					<td style="width: 5.9cm; padding-left: 1cm;" rowspan="2">{{ $receipt_details->total_letters }}</td>
					<td style="width: 2cm;" rowspan="2">&nbsp;</td>
					<td style="width: 1.3cm; text-align: right;">
						<span class="display_currency" data-currency_symbol="false">
							{{ $receipt_details->total_before_tax }}
						</span>
					</td>	
				</tr>
				<tr>
					<td style="text-align: right;">
						@if ($receipt_details->withheld)
							<span class="display_currency" data-currency_symbol="false">
								{{ $receipt_details->withheld }}
							</span>
						@else
							&nbsp;
						@endif
					</td>
				</tr>
				<tr>
					<td rowspan="4">&nbsp;</td>
					<td rowspan="4">&nbsp;</td>
					<td style="text-align: right;">
						<span class="display_currency" data-currency_symbol="false">
							{{ $receipt_details->total }}
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td> <!-- VTA. NO SUJETA -->
				</tr>
				<tr> <!-- VTA. EXENTA -->
                    @if ($receipt_details->customer_is_exempt)
                        <td style="text-align: right;">
                            <span class="display_currency" data-currency_symbol="false">
                                {{ $receipt_details->total }}
                            </span>
                        </td>
                    @else
                        <td>&nbsp;</td>
                    @endif
				</tr>
				<tr>
                    @if (!$receipt_details->customer_is_exempt)
                        <td style="text-align: right;">
                            <span class="display_currency" data-currency_symbol="false">
                                {{ $receipt_details->total }}
                            </span>
                        </td>
                    @else
                        <td>&nbsp;</td>
                    @endif
				</tr>
			</table>
		</div>
	</div>
	<div id="container" style="margin: 0 0.8cm 0 0.6cm; display: inline-block;">
		<div id="head"></div>
		<div id="header">
			<table id="header">
				<tr>
					<td style="width: 5.5cm;">&nbsp;</td>
					<td style="width: 3.6cm;">
						{{
							"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("d",strtotime($receipt_details->invoice_date))
							. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("m",strtotime($receipt_details->invoice_date))
							. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . date("Y",strtotime($receipt_details->invoice_date))
						}}
					</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 1.3cm;" class="cutter">{{ $receipt_details->customer_name }}</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 1.5cm;" class="cutter">{{ $receipt_details->customer_location }}</td>
				</tr>
				<tr>
					<td style="padding-left: 2.5cm;" class="cutter">{{ $receipt_details->customer_employee_name }}</td>
					<td style="padding-left: 1.2cm;" class="cutter">{{ $receipt_details->customer_nit }}</td>
				</tr>
			</table>
		</div>
		<div id="details">
			<table id="sell_lines">
				<thead>
					<tr>
						<th style="width: 1.4cm; text-align: center;">&nbsp;</th><!-- CÓDIGO -->
						<th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- CANT -->
						<th style="width: 3.5cm; text-align: center;">&nbsp;</th><!-- DESCRIPCIÓN -->
						<th style="width: 1cm; text-align: center;">&nbsp;</th><!-- PRECIO UNITARIO -->
						<th style="width: 0.4cm; text-align: center;">&nbsp;</th><!-- VTA. NO SUJETA -->
                        @if (!$receipt_details->customer_is_exempt)
                            <th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- VTA. EXENTA -->
                            <th style="width: 1.2cm; text-align: center;">&nbsp;</th><!-- VTAS. GRABADAS -->
                        @else
                            <th style="width: 1.2cm; text-align: center;">&nbsp;</th><!-- VTA. EXENTA -->
                            <th style="width: 0.8cm; text-align: center;">&nbsp;</th><!-- VTAS. GRABADAS -->
                        @endif
					</tr>
				</thead>
				<tbody>
					@forelse($receipt_details->lines as $line)
					<tr>
						<td class="cutter">{{ $line['sub_sku']}}</td>
						<td style="text-align: right;">{{ $line['quantity'] }}</td>
						<td class="cutter">
							{{ $line['name']}} {{$line['variation'] }}
							@if(!empty($line['sell_line_note']))({{$line['sell_line_note']}}) @endif 
							@if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
							@if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif
						</td>
						<td style="text-align: right;">
                            @if (!$receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false" data-precision="4">
                                    {{ $line['unit_price'] }}
                                </span>
                            @else
                                <span class="display_currency" data-currency_symbol="false" data-precision="4">
                                    {{ $line['unit_price_exc'] }}
                                </span>
                            @endif
						</td>
						<td style="text-align: right;">
                            @if ($receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false">
                                    {{ $line['line_total_exc_tax'] }}
                                </span>
                            @else
                                &nbsp;
                            @endif
                        </td>
						<td>&nbsp;</td>
						<td style="text-align: right;">
                            @if (!$receipt_details->customer_is_exempt)
                                <span class="display_currency" data-currency_symbol="false">
                                    {{ $line['line_total'] }}
                                </span>
                            @else
                                &nbsp;
                            @endif
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div id="footer">
			<table>
				<tr>
					<td style="width: 5.9cm; padding-left: 1cm;" rowspan="2">{{ $receipt_details->total_letters }}</td>
					<td style="width: 2cm;" rowspan="2">&nbsp;</td>
					<td style="width: 1.3cm; text-align: right;">
						<span class="display_currency" data-currency_symbol="false">
							{{ $receipt_details->total_before_tax }}
						</span>
					</td>	
				</tr>
				<tr>
					<td style="text-align: right;">
						@if ($receipt_details->withheld)
							<span class="display_currency" data-currency_symbol="false">
								{{ $receipt_details->withheld }}
							</span>
						@else
							&nbsp;
						@endif
					</td>
				</tr>
				<tr>
					<td rowspan="4">&nbsp;</td>
					<td rowspan="4">&nbsp;</td>
					<td style="text-align: right;">
						<span class="display_currency" data-currency_symbol="false">
							{{ $receipt_details->total }}
						</span>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td> <!-- VTA. NO SUJETA -->
				</tr>
				<tr> <!-- VTA. EXENTA -->
                    @if ($receipt_details->customer_is_exempt)
                        <td style="text-align: right;">
                            <span class="display_currency" data-currency_symbol="false">
                                {{ $receipt_details->total }}
                            </span>
                        </td>
                    @else
                        <td>&nbsp;</td>
                    @endif
				</tr>
				<tr>
                    @if (!$receipt_details->customer_is_exempt)
                        <td style="text-align: right;">
                            <span class="display_currency" data-currency_symbol="false">
                                {{ $receipt_details->total }}
                            </span>
                        </td>
                    @else
                        <td>&nbsp;</td>
                    @endif
				</tr>
			</table>
		</div>
	</div>
</div>