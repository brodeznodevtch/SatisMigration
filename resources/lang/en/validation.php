<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
        'code'                  => 'code',
        'type'                  => 'typw',
        'parent'                => 'parent account',
        'name'                  => 'name',
        'username'              => 'user',
        'email'                 => 'email',
        'first_name'            => 'name',
        'last_name'             => 'last name',
        'password'              => 'password',
        'password_confirmation' => 'password confirm',
        'city'                  => 'city',
        'country'               => 'country',
        'address'               => 'address',
        'phone'                 => 'phone',
        'mobile'                => 'cell phone',
        'age'                   => 'age',
        'sex'                   => 'sex',
        'gender'                => 'gender',
        'year'                  => 'year',
        'month'                 => 'month',
        'day'                   => 'day',
        'hour'                  => 'hour',
        'minute'                => 'minute',
        'second'                => 'second',
        'title'                 => 'title',
        'content'               => 'content',
        'body'                  => 'body',
        'description'           => 'description',
        'excerpt'               => 'excerpt',
        'date'                  => 'date',
        'time'                  => 'time',
        'subject'               => 'subject',
        'message'               => 'message',

        
        
        'period_id'             => 'period',
        'number'                => 'number',
        'debe'                  => 'debit',
        'total_debe'            => 'total debit',
        'total_haber'           => 'total credit',
        'haber'                 => 'credit',
        'type_entrie_id'        => 'entrie type',
        'business_location_id'  => 'location',
        'location'              => 'Location',
        'description2'          => 'description',
        'debe2'                 => 'debit',
        'haber2'                => 'credit',
        'total_debe2'           => 'total debit',
        'total_haber2'          => 'total credit',
        'number2'               => 'number',
        'date2'                 => 'date',
        'country_id'            => 'country',
        'zone_id'               => 'zone',
        'state_id'              => 'state',
        'ename'                 => 'name',
        'correlative'           => 'correlative',
        'claim_type'            => 'claim type',
        'status_claim_id'       => 'status',
        'description'           => 'description',
        'claim_date'            => 'claim date',
        'suggested_closing_date'=> 'suggested closing date',

        'amount_request_business'   => 'amount required',
        'amount_request_natural'    => 'amount required',

        'name_reference'            => "name reference",
        'phone_reference'           => "phone reference",
        'amount_reference'          => "amoun reference",
        'date_reference'            => "date cancelled reference",

        'name_relationship'         => "name relationship",
        'relation_relationship'     => "relation relationship",
        'phone_relationship'        => "phone relationship",
        'address_relationship'      => "address relationship",

        'business_name'             => 'business name',
        'trade_name'                => 'trade name',
        'nrc'                       => 'NRC',
        'nit_business'              => 'NIT',
        'business_type'             => 'business type',
        'address'                   => 'address',
        'category_business'         => 'category',
        'phone_business'            => 'phone',
        'fax_business'              => 'fax',
        'legal_representative'      => 'legal representative',
        'dui_legal_representative'  => 'DUI legal representative',
        'purchasing_agent'          => 'purchasing agent',
        'phone_purchasing_agent'    => 'phone purchasing agent',
        'fax_purchasing_agent'      => 'fax purchasing agent',
        'email_purchasing_agent'    => 'email purchasing agent',
        'payment_manager'           => 'payment manager',
        'phone_payment_manager'     => 'phone payment manager',
        'email_payment_manager'     => 'email payment manager',
        'term_business'             => 'term',
        'warranty_business'         => 'warranty',
        'name_natural'              => 'name',
        'dui_natural'               => 'DUI',
        'age'                       => 'age',
        'birthday'                  => 'birthday',
        'phone_natural'             => 'phone',
        'category_natural'          => 'category',
        'nit_natural'               => 'NIT',
        'address_natural'           => 'address',
        'term_natural'              => 'term',
        'warranty_natural'          => 'warranty',
        'telphone'                  => 'phone',
        'dni'                       => 'DUI',
        'business_type_id'          => 'business type',
        'customer_portfolio_id'     => 'customer portfolio',
        'customer_group_id'         => 'customer group',
        'city_id'                   => 'city',
        'txt-name-type'             => 'name',
        'txt-resolution-time-type'  => 'resolution time',
        'txt-ename-type'            => 'name',
        'txt-eresolution-time-type' => 'resolution time',

        'customer_id'               => 'Customer',
        'employee_id'               => 'Vendedor',
        'document_type_id'          => 'Document type',
        'quote_date'                => 'Date',
        'quote_ref_no'              => 'Order number',
        'customer_name'             => 'Customer name',
        'contact_name'              => 'Contact name',
        'email'                     => 'Email',
        'mobile'                    => 'Mobile',
        'address'                   => 'Address',
        'payment_condition'         => 'Payment conditions',
        'tax_detail'                => 'Tax detail',
        'validity'                  => 'Validity',
        'delivery_time'             => 'Delivery time',
        'note'                      => 'Notes',
        'legend'                    => 'Legend',
        'terms_conditions'          => 'Terms & conditions',
        'discount_type'             => 'Discount type',
        'total_before_tax'          => 'Total before tax',
        'tax_amount'                => 'Total tax',
        'total_final'               => 'Total final',
        'catalogue_file'            => 'catalogue',
        'value'                     => 'name',
        'status'                    => 'status',
        'birthdate'                 => 'birthdate',
        'nationality_id'            => 'nationality',
        'civil_status_id'           => 'civil status',
        'check_payment'             => 'check payment',
        'extra_hours'               => 'extra hours',
        'foreign_tax'               => 'foreign tax',
        'profession_id'             => 'profession or ocuppation',
        'date_admission'            => 'date admission',
        'salary'                    => 'salary',
        'fee'                       => 'fee',
        'department_id'             => 'department',
        'position_id'               => 'position',
        'afp_id'                    => 'AFP',
        'type_id'                   => 'type',
        'bank_id'                   => 'bank',
        'bank_account'              => 'bank account',
        'tax_number'                => 'tax number',
        'afp_number'                => 'afp number',
        'social_security_number'    => 'social security number',
        'reg_number'    => 'NRC',
        'tax_number'    => 'NIT',
        'business_line' => 'business line',
        'user_id' => 'user who authorize the personnel action',
        'new_salary' => 'new salary',
        'description' => 'description',
        'department_id' => 'department',
        'position1_id' => 'position',
        'start_date' => 'start date',
        'end_date' => 'end date',
        'effective_date' => 'effective date'
    ),
'custom-messages' => [
    'quantity_not_available' => 'Only :qty :unit available',
    'this_field_is_required' => 'This field is required'
],

];