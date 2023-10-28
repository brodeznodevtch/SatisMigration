<?php

namespace App\Http\Middleware;

use App\Models\Business;
use App\Utils\BusinessUtil;
use App\Utils\GlobalUtil;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetSessionData
{
    /**
     * All Utils instance.
     */
    protected $globalUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        GlobalUtil $globalUtil
    ) {

        $this->globalUtil = $globalUtil;
    }

    /**
     * Checks if session data is set or not for a user. If data is not set then set it.
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (! $request->session()->has('user')) {
            $business_util = new BusinessUtil;

            $user = Auth::user();
            $session_data = ['id' => $user->id,
                'surname' => $user->surname,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'business_id' => $user->business_id,
                'language' => $user->language,
                'user_ip' => $this->globalUtil->getUserIP(),
            ];
            $business = Business::findOrFail($user->business_id);

            $currency = $business->currency;
            $currency_data = ['id' => $currency->id,
                'code' => $currency->code,
                'symbol' => $currency->symbol,
                'thousand_separator' => $currency->thousand_separator,
                'decimal_separator' => $currency->decimal_separator,
            ];

            $request->session()->put('user', $session_data);
            $request->session()->put('business', $business);
            $request->session()->put('currency', $currency_data);

            //set current financial year to session
            $financial_year = $business_util->getCurrentFinancialYear($business->id);
            $request->session()->put('financial_year', $financial_year);
        }

        return $next($request);
    }
}
