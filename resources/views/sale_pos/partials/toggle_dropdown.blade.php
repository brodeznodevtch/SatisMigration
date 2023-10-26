@if ($status != "annulled")
    @if (auth()->user()->can("sell.view") || auth()->user()->can("direct_sell.access"))
        <li>
            <a href="#" data-href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$id]) }}" class="btn-modal" data-container=".view_modal">
                <i class="fa fa-external-link" aria-hidden="true"></i> @lang("messages.view")
            </a>
        </li>
    @endif
    @if (auth()->user()->can("sell.view") && !empty($parent_doc) )
        <li>
            <a href="#" data-href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$parent_doc]) }}" class="btn-modal" data-container=".view_modal">
                <i class="fa fa-external-link" aria-hidden="true"></i> @lang("sale.parent_doc")
            </a>
        </li>
    @endif
    @if ($is_direct_sale == 0)
        @if (auth()->user()->can("sell.update"))
            <li>
                <a target="_blank" href="{{ action([\App\Http\Controllers\SellPosController::class, 'edit'], [$id]) }}" data-container=".view_modal">
                    <i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")
                </a>
            </li>
            <li>
                <a href="#" data-href="{{ action([\App\Http\Controllers\SellController::class, 'editInvoiceTrans'], [$id]) }}" class="edit_transaction_button">
                    <i class="glyphicon glyphicon-edit"></i> @lang("messages.edit_header_data")
                </a>
            </li>
        @endif
    @else
        @if (auth()->user()->can("sell.update"))
            <li>
                <a target="_blank" href="{{ action([\App\Http\Controllers\SellController::class, 'edit'], [$id]) }}">
                    <i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")
                </a>
            </li>
        @endif
    @endif


    @if($enable_sell_delete == 1)


    @if (auth()->user()->can("sell.delete"))
        <li>
            <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'destroy'], [$id]) }}" class="delete-sale">
                <i class="fa fa-trash"></i> @lang("messages.delete")
            </a>
        </li>
    @endif

    @endif


    @if (auth()->user()->can("sell.annul"))
        @if ($status == 'final')
            @php
            $transaction_date = date('Y-m-d', strtotime($transaction_date));
            $now = date('Y-m-d', strtotime(now()));
            $now = \Carbon\Carbon::parse($now);
            $transaction_date = \Carbon\Carbon::parse($transaction_date);
            @endphp
            {{-- It is validated that the transaction date is the same as now --}}
            @if ($transaction_date->eq($now))
                <li>
                    <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'annul'], [$id]) }}" class="annul-sale">
                        <i class="fa fa-ban"></i> @lang("messages.annul")
                    </a>
                </li>
            @elseif ($business->annull_sale_expiry)
                <li>
                    <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'annul'], [$id]) }}" class="annul-sale">
                        <i class="fa fa-ban"></i> @lang("messages.annul")
                    </a>
                </li>
            @endif
        @endif
    @endif
    @if (auth()->user()->can("sell.view") || auth()->user()->can("direct_sell.access"))
        <li>
            <a href="#" class="print-invoice" data-href="{{ route('sell.printInvoice', [$id]) }}">
                <i class="fa fa-print" aria-hidden="true"></i> @lang("messages.print")
            </a>
        </li>
        @if ($doc_type == "CCF")
            <li>
                <a href="#" class="print-ccf" data-href="{{ route('sell.print-ccf', [$id]) }}">
                    <i class="fa fa-print" aria-hidden="true"></i> @lang("messages.print_ccf")
                </a>
            </li>
        @endif
    @endif
    @if($sale_accounting_entry_mode == 'transaction')
        @if (auth()->user()->can('entrie.create') && is_null($accounting_entry_id))
        <li>
            <a class="gen-account-entry" href="{{ action([\App\Http\Controllers\SellPosController::class, 'createTransAccountingEntry'], [$id]) }}">
                <i class="fa fa-book" aria-hidden="true"></i> @lang("accounting.generate_accounting_entry")
            </a>
        </li>
        @elseif(auth()->user()->can('entrie.view') && !is_null($accounting_entry_id))
        <li>
            <a class="show-account-entry" href="{{ url('/entries/singleEntrie', [$accounting_entry_id, 'pdf']) }}" target="_blank">
                <i class="fa fa-book" aria-hidden="true"></i> @lang("accounting.accounting_entry")
            </a>
        </li>
        @endif
    @endif
    <li class="divider"></li> 
    @if ($payment_status != 'paid')
        @if (auth()->user()->can("sell.create_payments") || auth()->user()->can("direct_sell.access"))
            <li>
                <a href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, 'addPayment'], [$id]) }}" class="add_payment_modal">
                    <i class="fa fa-money"></i> @lang("purchase.add_payment")
                </a>
            </li>
        @endif
    @endif
    <li>
        <a href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, 'show'], [$id]) }}" class="view_payment_modal">
            <i class="fa fa-money"></i> @lang("purchase.view_payments")
        </a>
    </li>
    @if (auth()->user()->can('sell.create'))
        <li>
            <a href="{{ action([\App\Http\Controllers\SellReturnController::class, 'add'], [$id]) }}">
                <i class="fa fa-undo"></i> @lang("lang_v1.sell_return")
            </a>
        </li>
    @endif
    @if (auth()->user()->can('send_notification'))
        <li>
            <a href="#" data-href="{{ action([\App\Http\Controllers\NotificationController::class, 'getTemplate'], ['transaction_id' => $id, 'template_for' => 'new_sale']) }}" class="btn-modal" data-container=".view_modal">
                <i class="fa fa-envelope" aria-hidden="true"></i> @lang("lang_v1.new_sale_notification")
            </a>
        </li>
    @endif
@else
    @if (auth()->user()->can("sell.view") || auth()->user()->can("direct_sell.access"))
        <li>
            <a href="#" data-href="{{ action([\App\Http\Controllers\SellController::class, 'show'], [$id]) }}" class="btn-modal" data-container=".view_modal">
                <i class="fa fa-external-link" aria-hidden="true"></i> @lang("messages.view")
            </a>
        </li>
        <li>
            <a data-href="{{ action([\App\Http\Controllers\SellController::class, 'editInvoiceTrans'], [$id]) }}" class="edit_transaction_button">
                <i class="glyphicon glyphicon-edit"></i> @lang("messages.edit_invoice")
            </a>
        </li>
    @endif
    {{--@if (auth()->user()->can("sell.delete"))
        <li>
            <a href="{{ action([\App\Http\Controllers\SellPosController::class, 'destroy'], [$id]) }}" class="delete-sale">
                <i class="fa fa-trash"></i> @lang("messages.delete")
            </a>
        </li>
    @endif--}}
@endif