<?php

namespace App\Utils;

use App\AccountingEntrie;
use App\AccountingEntriesDetail;
use App\BankCheckbook;
use App\BankTransaction;
use App\BusinessLocation;
use App\LawDiscount;
use App\RrhhIncomeDiscount;
use App\TypeBankTransaction;
use Carbon\Carbon;
use DB;

class PayrollUtil extends Util
{

    public function calculateIsss($total_income, $business_id, $isr_id)
    {
        $lawDiscounts = LawDiscount::join('institution_laws as institution_law', 'institution_law.id', '=', 'law_discounts.institution_law_id')
            ->join('payment_periods as payment_period', 'payment_period.id', '=', 'law_discounts.payment_period_id')
            ->select('law_discounts.id as id', 'law_discounts.*', 'payment_period.id as payment_period_id', 'institution_law.name as institution_law')
            ->where('payment_period.id', $isr_id)
            ->where('law_discounts.business_id', $business_id)
            ->where('law_discounts.deleted_at', null)
            ->get();

        $isss = 0;
        foreach ($lawDiscounts as $lawDiscount) {
            if (mb_strtolower($lawDiscount->institution_law) == mb_strtolower('ISSS')) {
                if ($lawDiscount->payment_period_id == $isr_id) {
                    if ($total_income >= $lawDiscount->until) {
                        $isss = $lawDiscount->until * $lawDiscount->employee_percentage / 100;
                    } else {
                        $isss = $total_income * $lawDiscount->employee_percentage / 100;
                    }
                }
            }
        }

        return $isss;
    }

    public function calculateAfp($total_income, $business_id, $isr_id)
    {
        $afp = 0;

        $lawDiscounts = LawDiscount::join('institution_laws as institution_law', 'institution_law.id', '=', 'law_discounts.institution_law_id')
            ->join('payment_periods as payment_period', 'payment_period.id', '=', 'law_discounts.payment_period_id')
            ->select('law_discounts.id as id', 'law_discounts.*', 'payment_period.id as payment_period_id', 'institution_law.name as institution_law')
            ->where('payment_period.id', $isr_id)
            ->where('law_discounts.business_id', $business_id)
            ->where('law_discounts.deleted_at', null)
            ->get();

        foreach ($lawDiscounts as $lawDiscount) {
            if (mb_strtolower($lawDiscount->institution_law) == mb_strtolower('AFP Confia') || mb_strtolower($lawDiscount->institution_law) == mb_strtolower('AFP Crecer')) {
                if ($lawDiscount->payment_period_id == $isr_id) {
                    $afp = $total_income * $lawDiscount->employee_percentage / 100;
                }
            }
        }

        return $afp;
    }


    public function calculateRent($total_income, $business_id, $isr_id, $isss, $afp)
    {
        $lawDiscountsRenta = LawDiscount::join('institution_laws as institution_law', 'institution_law.id', '=', 'law_discounts.institution_law_id')
            ->join('payment_periods as payment_period', 'payment_period.id', '=', 'law_discounts.payment_period_id')
            ->select('law_discounts.id as id', 'law_discounts.*', 'institution_law.name as institution_law', 'payment_period.name as payment_period')
            ->where('institution_law.name', 'Renta')
            ->where('payment_period.id', $isr_id)
            ->where('law_discounts.business_id', $business_id)
            ->where('law_discounts.deleted_at', null)
            ->get();

        $rent = 0;
        for ($i = 0; $i < count($lawDiscountsRenta); $i++) {
            $value = $total_income - $isss - $afp;

            if ($value <= $lawDiscountsRenta[0]->until) {
                $rent = 0;
            } else {
                if ($value <= $lawDiscountsRenta[1]->until) {
                    $rent = bcdiv((($value - $lawDiscountsRenta[1]->base) * ($lawDiscountsRenta[1]->employee_percentage / 100)) + $lawDiscountsRenta[1]->fixed_fee, 1, 2);
                } else {
                    if ($value <= $lawDiscountsRenta[2]->until) {
                        $rent = bcdiv((($value - $lawDiscountsRenta[2]->base) * ($lawDiscountsRenta[2]->employee_percentage / 100)) + $lawDiscountsRenta[2]->fixed_fee, 1, 2);
                    } else {
                        if ($value <= $lawDiscountsRenta[3]->until) {
                            $rent = bcdiv((($value - $lawDiscountsRenta[3]->base) * ($lawDiscountsRenta[3]->employee_percentage / 100)) + $lawDiscountsRenta[3]->fixed_fee, 1, 2);
                        }
                    }
                }
            }
        }

        return $rent;
    }

    public function createAccountingEntrie($location_id, $location_name, $business_id, $payroll, $typeEntrie, $period_id, $mdate, $ydate)
    {
        $accountingEntrie = AccountingEntrie::where('business_location_id', $location_id)
            ->where('business_id', $business_id)
            ->orderby('id', 'ASC')
            ->first();

        $short_name_month = ($mdate < 10) ? '0' . $mdate : $mdate;
        $short_name_cont = str_pad($accountingEntrie->correlative + 1, 5, "0", STR_PAD_LEFT);
        $short_name_full = $typeEntrie->short_name . '-' . $ydate . $short_name_month . '-' . $short_name_cont;

        $entrie = new AccountingEntrie;
        $entrie->date = Carbon::now();
        $entrie->number = $accountingEntrie->correlative + 1;
        $entrie->correlative = $accountingEntrie->correlative + 1;
        $entrie->business_id = $business_id;
        $entrie->accounting_period_id = $period_id;
        $entrie->description = $payroll->payrollType->name . ' - ' .$location_name.' ' . $payroll->start_date . ' al ' . $payroll->end_date;
        $entrie->type_entrie_id = $typeEntrie->id;
        $entrie->business_location_id = $location_id;
        $entrie->short_name = $short_name_full;
        $entrie->status = 1;
        $entrie->save();

        return $entrie;
    }

    public function createIncomeDiscount($value, $payroll, $type_name, $employee_id)
    {
        $income = RrhhIncomeDiscount::create([
            'total_value' => $value,
            'quota' => 1,
            'quota_value' => $value,
            'quotas_applied' => 1,
            'balance_to_date' => 0,
            'start_date' => $payroll->start_date,
            'end_date' => $payroll->end_date,
            'payment_period_id' => 2,
            'rrhh_type_income_discount_id' => $type_name,
            'employee_id' => $employee_id
        ]);

        return $income;
    }

    public function createAccountingEntriesDetail($entrie_id, $account, $value, $concept, $type)
    {
        $detalle = new AccountingEntriesDetail;
        $detalle->entrie_id = $entrie_id;
        $detalle->account_id = $account;
        if ($type == 1) { //ingreso
            $detalle->debit = $value;
            $detalle->credit = 0;
        } else {
            $detalle->debit = 0;
            $detalle->credit = $value;
        }
        $detalle->description = $concept;
        $detalle->save();

        return $detalle;
    }

    public function createBankTransaction($entrie_id, $amount, $payroll, $payrollPayment, $business_id)
    {
        $checkbook = BankCheckbook::where('id', $payrollPayment->bank_checkbook_id)->first();
        if ($checkbook != null) {
            $checkbook_initial = $checkbook->initial_correlative;
            $checkbook_final = $checkbook->final_correlative;
        } else {
            $checkbook_initial = 0;
            $checkbook_final = 0;
        }

        if($payrollPayment->payment->value == 'Transferencia bancaria'){
            $type_bank = TypeBankTransaction::where('name', 'Transferencias bancarias salida')->where('type_entrie_id', 2)->first(); //Egreso
        }else{
            $type_bank = TypeBankTransaction::where('name', 'Cheques')->where('type_entrie_id', 2)->first(); //Egreso
        }

        $transaction = new BankTransaction;
        $transaction->bank_account_id = $payrollPayment->bank_account_id; //Cuenta principal de bancos
        $transaction->accounting_entrie_id = $entrie_id; //Ya creada AccountingEntrie
        $transaction->type_bank_transaction_id = $type_bank->id;  //Si es cheque o transferencia
        $transaction->bank_checkbook_id = $payrollPayment->bank_checkbook_id; //Cuenta de la chequeraaaaaaa
        $transaction->business_id = $business_id;
        if($type_bank->enable_checkbook == 0) {
            $transaction->reference = $payrollPayment->reference; //Referencia
        }
        $transaction->date = Carbon::now();
        $transaction->amount = $amount;
        $transaction->description = 'Planilla de salarios y retenciones de '.$payroll->start_date.' - '.$payroll->end_date;
        //$transaction->headline = $request->input('txt-payment-to');

        if ($payrollPayment->check_number != null) {
            $transaction->check_number = $payrollPayment->check_number; //Numero de cheque
            $actual_correlative = $checkbook->actual_correlative;
            $checkbook->actual_correlative = $actual_correlative + 1;
            $checkbook->save();

            if ($transaction->check_number == $checkbook->final_correlative) {
                $checkbook->status = 0;
                $checkbook->save();
            }
        }

        $transaction->save();
    }
}
