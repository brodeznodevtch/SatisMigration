<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;

class PurchaseSellMismatch extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request): Response
    {
        $output = ['success' => 0,
            'msg' => $this->getMessage(),
        ];

        if ($request->ajax()) {
            return $output;
        } else {
            throw new Exception($this->getMessage());
        }
    }
}
