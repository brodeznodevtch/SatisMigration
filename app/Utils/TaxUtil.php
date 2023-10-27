<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Collection;
use App\Models\TaxGroup;
use App\Models\TaxRate;
use App\Models\Transaction;

class TaxUtil extends Util
{
    /**
     * Updates tax amount of a tax group
     */
    public function updateGroupTaxAmount(int $group_tax_id): void
    {
        $amount = 0;
        $tax_rate = TaxRate::where('id', $group_tax_id)->with(['sub_taxes'])->first();
        foreach ($tax_rate->sub_taxes as $sub_tax) {
            $amount += $sub_tax->amount;
        }
        $tax_rate->amount = $amount;
        $tax_rate->save();
    }

    /**
     * Get tax groups for a business
     *
     * @param  string  $type = sell|purchase
     */
    public function getTaxGroups(int $business_id, string $type = '', bool $with_percentages = false): Collection
    {

        if ($type) {
            $tax_groups = TaxGroup::where('business_id', $business_id)
                ->where('type', $type);

            if ($with_percentages) {
                $array_tax_group = [];

                foreach ($tax_groups->get() as $tg) {
                    $percent = 0;
                    foreach ($tg->tax_rates as $tr) {
                        $percent += $tr->percent;
                    }
                    $array_tax_group[] = [
                        'id' => $tg->id,
                        'name' => $tg->description,
                        'percent' => $percent,
                    ];
                }

                return $array_tax_group;

            } else {
                $tax_groups = $tax_groups
                    ->select('description as name', 'id')
                    ->get();
            }

        } else {
            $tax_groups = TaxGroup::where('business_id', $business_id);

            if ($with_percentages) {
                $array_tax_group = [];

                foreach ($tax_groups->get() as $tg) {
                    $percent = 0;
                    foreach ($tg->tax_rates as $tr) {
                        $percent += $tr->percent;
                    }
                    $array_tax_group[] = [
                        'id' => $tg->id,
                        'name' => $tg->description,
                        'percent' => $percent,
                    ];
                }

                return $array_tax_group;

            } else {
                $tax_groups = $tax_groups
                    ->select('description as name', 'id')
                    ->get();
            }
        }

        return $tax_groups;
    }

    /**
     * Get total percent from tax groups given
     *
     * @param  float  $amount
     */
    public function getTaxPercent(int $tax_group_id): float
    {
        if (is_null($tax_group_id)) {
            return null;
        }

        $tax_rates = TaxGroup::find($tax_group_id)->tax_rates;

        $percent = 0;
        if (! empty($tax_rates)) {
            foreach ($tax_rates as $tax_rate) {
                $percent += $tax_rate->percent;
            }
        }

        $percent = $percent / 100;

        return round($percent, 4);
    }

    /**
     * Get min amount from tax rate given.
     *
     * @param  float  $amount
     */
    public function getTaxMinAmount(int $tax_group_id): float
    {
        if (is_null($tax_group_id)) {
            return 0;
        }

        $tax_rates = TaxGroup::find($tax_group_id)->tax_rates;

        $min_amount = 0;

        if (! empty($tax_rates)) {
            foreach ($tax_rates as $tax_rate) {
                $min_amount = $tax_rate->min_amount ? $tax_rate->min_amount : 0;
            }
        }

        return $min_amount;
    }

    /**
     * Get max amount from tax rate given.
     *
     * @param  float  $amount
     */
    public function getTaxMaxAmount(int $tax_group_id): float
    {
        if (is_null($tax_group_id)) {
            return 0;
        }

        $tax_rates = TaxGroup::find($tax_group_id)->tax_rates;

        $max_amount = 0;

        if (! empty($tax_rates)) {
            foreach ($tax_rates as $tax_rate) {
                $max_amount = $tax_rate->max_amount ? $tax_rate->max_amount : 0;
            }
        }

        return $max_amount;
    }

    /**
     * Get price excluding taxes
     */
    public function getPriceExcTax(int $tax_group_id, float $amount): float
    {
        if (is_null($tax_group_id) || is_null($amount)) {
            exit('N/A');
        }

        $tax_rates = TaxGroup::find($tax_group_id)->tax_rates;

        $percent = 0;
        if (! empty($tax_rates)) {
            foreach ($tax_rates as $tax_rate) {
                $percent += $tax_rate->percent;
            }
        }

        $amount = $amount / (1 + ($percent / 100));

        return round($amount, 4);
    }

    /**
     * Get price including taxes
     */
    public function getPriceIncTax(int $tax_group_id, float $amount): float
    {
        if (is_null($tax_group_id) || is_null($amount)) {
            exit('N/A');
        }

        $tax_rates = TaxGroup::find($tax_group_id)->tax_rates;

        $percent = 0;
        if (! empty($tax_rates)) {
            foreach ($tax_rates as $tax_rate) {
                $percent += $tax_rate->percent;
            }
        }

        $amount = $amount + ($amount * ($percent / 100));

        return round($amount, 4);
    }

    /**
     * Get tax type from transaction
     *
     * @return int //**  -1 Withheld; 1 Perception; 0 exempt
     */
    public function getTaxType(int $transaction_id): int
    {
        $transaction = Transaction::find($transaction_id);

        $tax_type = -2;
        if (! empty($transaction->tax_id)) {
            $tax_group = TaxGroup::find($transaction->tax_id);

            foreach ($tax_group->tax_rates as $tr) {
                $tax_type = $tr->percent;
            }

            return $tax_type;

        } else {
            return $tax_type;
        }
    }

    /**
     * Get total amount taxes products from transaction
     */
    public function getTaxAmount(int $transaction_id, $type = 'sell', $discount_amount = 0): float
    {
        $trans_lines = Transaction::find($transaction_id);

        $tax_amount = 0;
        if (! empty($trans_lines)) {
            /** Sell transactions */
            if ($type == 'sell') {
                foreach ($trans_lines->sell_lines as $sl) {
                    $tax_amount += $sl->tax_amount;
                }

                if ($discount_amount > 0) {
                    $tax_percent = $this->getLinesTaxPercent($trans_lines->id);
                    $tax_amount = ($trans_lines->total_before_tax - $discount_amount) * $tax_percent;
                }

                return $tax_amount;
                /** Purchase transctions */
            } elseif ($type == 'purchase') {
                foreach ($trans_lines->purchase_lines as $pl) {
                    $tax_amount += $pl->tax_amount;
                }

                return $tax_amount;

            } elseif ($type == 'sell_return') {
                foreach ($trans_lines->sell_lines as $pl) {
                    $tax_amount += ($pl->tax_amount / $pl->quantity) * $pl->quantity_returned;
                }

                return $tax_amount;
            } else {
                return $tax_amount;
            }

        } else {
            return $tax_amount;
        }
    }

    /**
     * Get tax name
     *
     * @param  int  $transaction_id
     */
    public function getTaxName($tax_id, $type = 'tax_group'): string
    {
        $tax_name = '';

        if ($type == 'tax_group') {
            $tax_name = TaxGroup::find($tax_id)
                ->description;
        } elseif ($type == 'tax_rate') {
            $tax_name = TaxRate::find($tax_id)
                ->name;
        }

        return $tax_name;
    }

    /**
     * Get transaction tax details for purchase
     */
    public function getTaxDetailsTransaction(int $transaction_id): array
    {
        $transaction = Transaction::find($transaction_id);

        $tax_group = TaxGroup::find($transaction->tax_id);
        $details = [];

        if (! empty($tax_group)) {
            foreach ($tax_group->tax_rates as $tg) {
                $details[] = [
                    'name' => $this->getTaxName($tg->id, 'tax_rate'),
                    'amount' => $transaction->total_before_tax * ($tg->percent / 100),
                ];
            }
        }

        return $details;
    }

    /**
     * Get transaction line tax percent
     *
     * @param int @transction_id
     */
    public function getLinesTaxPercent($transaction_id): float
    {
        if (empty($transaction_id)) {
            return 0;
        }

        $transaction = Transaction::where('id', $transaction_id)
            ->with('sell_lines')
            ->first();
        $unit_price_inc_tax = 0;
        $unit_price_exc_tax = 0;
        $tax = 0;
        if (count($transaction->sell_lines) > 0) {
            foreach ($transaction->sell_lines as $tsl) {
                $unit_price_inc_tax += $tsl->unit_price;
                $unit_price_exc_tax += $tsl->unit_price_before_discount;
            }

            if ($unit_price_exc_tax != 0) {
                $tax = ($unit_price_inc_tax / $unit_price_exc_tax) - 1;
            } else {
                $tax = 0;
            }

        } else {
            $tax = 0;
        }

        return $tax;
    }

    public function getTaxes($tax_group_id)
    {
        $tax_rates = TaxGroup::find($tax_group_id);

        $percent = 0;
        if (! empty($tax_rates)) {
            foreach ($tax_rates->tax_rates as $tax_rate) {
                $percent += $tax_rate->percent;
            }
            $percent = $percent / 100;
        }

        return round($percent, 4);
    }

    /**
     * get the id of the tax_group of a sales line
     */
    public function getTaxPercentSellReturn(int $transaction_id): int
    {
        $tax = Transaction::join('transaction_sell_lines as tsl', 'tsl.transaction_id', 'transactions.id')
            ->where('transactions.id', $transaction_id)
            ->select(
                'tsl.tax_id'
            )
            ->first();

        return $tax->tax_id;
    }
}
