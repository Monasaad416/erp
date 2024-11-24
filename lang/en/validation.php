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
    'language_required' => 'You must choose at least one language',
    'price_numeric' => 'The :attribute field must be a number.',
    'discount_price_numeric' => 'The :attribute field must be a number.',
    'shipping_price_numeric' => 'The :attribute field must be a number.',
    'duration_numeric' => 'The :attribute field must be a number.',
    'name_ar_required' => 'Arabic unit name field is required.',
    'name_en_required' => 'Arabic unit name  field is required.',
    'name_ar_string' => 'Arabic unit name field must be a string.',
    'name_en_string' => 'English unit name  must be a string.',
    'name_ar_max' => 'Arabic unit name  must not exceed 255 character',
    'name_en_max' => 'English unit name  must not exceed 255 character',
    'name_ar_max_50' => 'The :attribute field must not exceed 50 character',
    'name_en_max_50' => 'The :attribute field must not exceed 50 character',
    'name_ar_unique' =>  'Arabic unit name already exists in database',
    'name_en_unique' =>  'English unit name already exists in database',

    'name_required' => 'Name  field is required.',
    'name_string' => 'Name field must be a string.',
    'name_max' => 'Name  must not exceed 255 character',

    'gln_required'=> 'GLN required',
    'gln_string'=> 'Invalid GLN',
    'gln_length'=> 'GLN must be 13 digit',
    'tax_num_length'=> 'GLN must be 15 digit',

    'description_ar_required' => 'The :attribute field is required.',
    'description_en_required' => 'The :attribute field is required.',
    'description_ar_string' => 'The :attribute field must be a string.',
    'description_en_string' => 'The :attribute field must be a string.',

    'short_description_ar_string' => 'The :attribute field must be a string.',
    'short_description_en_string' => 'The :attribute field must be a string.',

    'title_ar_required' => 'The :attribute field is required.',
    'title_en_required' => 'The :attribute field is required.',
    'title_ar_string' => 'The :attribute field must be a string.',
    'title_en_string' => 'The :attribute field must be a string.',
    'title_ar_max' => 'The :attribute field must not exceed 255 character',
    'title_en_max' => 'The :attribute field must not exceed 255 character',

    'body_ar_required' => 'The :attribute field is required.',
    'body_en_required' => 'The :attribute field is required.',
    'body_ar_string' => 'The :attribute field must be a string.',
    'body_en_string' => 'The :attribute field must be a string.',

    'details_ar_required' => 'The :attribute field is required.',
    'details_en_required' => 'The :attribute field is required.',
    'details_ar_string' => 'The :attribute field must be a string.',
    'details_en_string' => 'The :attribute field must be a string.',

    'parent_id_required' => 'Category required',
    'parent_id_exists' => 'Selected category does not exist in database',
    'supplier_id_required' => 'Select Supplier ',
    'payment_type_in' => 'Select Payment Type ',
    'supp_inv_date_time_required' =>'Supplier invoice date and time required',


    'branch_id_required' => 'Branch required',
    'branch_id_exists' => 'Selected branch does not exist in database',

    'unit_id_exists' => 'Selected Measurment Unit does not exist in database',
    'unit_id_required' => 'Measurment unit required',
    'img_image' => 'You must upload an image',
    'img_mimes' => 'Image extension mut be one of these extensions jpeg, jpg, png, svg, gif, jfif',
    'serial_num_required' => 'Serial number required',
    'serial_num_unique'=>'This serial number already exists in database',

    'gtin_required' => 'GTIN required',
    'gtin_length' => 'GTIN valid number of digits only 8,12,13,14 ',
    'gtin_nuique' =>'Entered GTIN already exists in database',

    'qty_required' => 'Item quantity required',
    'qty_numeric' => 'Item quantity must be number',

    'taxes_required' =>'Taxes value required',

    'purchase_price_required' => 'Purchase price required',
    'purchase_price_numeric' => 'Purchase price must be number',
    'purchase_price_min' => 'Purchase price minimum value = 0 ',
    'discount_percentage_numeric' => 'Discount prcentage must be numeric',
    'discount_value_numeric' =>  'Discount value must be numeric',

    'sale_price_required' => 'Sale price required',
    'sale_price_nimeric' => 'Sale price must be number',
    'sale_price_min' => 'Sale price minimum value = 0 ',

    'payment_type_required' =>'Payment type required',
    'status_required' =>'Status required ',


    'discount_price_nimeric' => 'Discount price must be number',
    'discount_price_min' => 'Discount price minimum value = 0 ',

    'manufactured_date_required' => 'Manufacturd date required',
    'manufactured_date_date' => 'Enter valid manufacturd date',

    'expiry_date_required' => 'Expiry date required',
    'expiry_date_date' => 'Enter valid expiry date',

    'import_date_required' => 'Import date required',
    'import_date_date' => 'Enter valid import date',

    'batch_num_required' => 'Patch number required',


    'inventory_balance_required' => 'Inventory balance required',
    'inventory_balance_numeric' => 'Inventory balancre must be valid number',

    'initial_balance_required' => 'Initial inventory balance required',
    'initial_balance_numeric' => 'Initial inventory balancre must be valid number',

    
    'alert_main_branch_required' => 'Inventory balance required',
    'alert_main_branch_numeric' => 'Inventory balancre must be valid number',

    'alert_branch_required' => 'Initial inventory balance required',
    'alert_branch_numeric' => 'Initial inventory balancre must be valid number',

    'product_code_required' => 'Product code required',
    'product_code_string' => 'Product code accept both numbers and letters',
    'product_code_max' => 'Product code must no be greater than 50 digits',
    'product_code_unique' =>'The entered product code already exist in database ',
    'product_code_exists' => 'The entered product code doese not exist in database ',


    'account_num_required' => 'Account number required    ',
    'account_num_numeric' =>  'aAccount number must be number',
    'account_num_min' => 'Account number must not be less than  0',

    'start_shift_cash_balance_required' => 'Cash balance at shift start required',
    'start_shift_cash_balance_numeric' => 'Cash balance at shift start must be number',
    'start_shift_cash_balance_min' => 'Cash balance at shift start must be greater than 0',

    'end_shift_cash_balance_required' => 'Cash balance at shift end required',
    'end_shift_cash_balance_numeric' => 'Cash balance at shift end must be number',
    'end_shift_cash_balance_min' => 'Cash balance at shift end must be greater than 0',

    'end_shift_bank_balance_required' => 'Bank balance at shift end required',
    'end_shift_bank_balance_numeric' => 'Bank balance at shift end must be number',
    'end_shift_bank_balance_min' => 'Bank balance at shift end must be greater than 0',

    'current_balance_required' => 'Current balance required',
    'current_balance_numeric' =>'Current balance must be number',
    'current_balance_min' => 'Current_balance_min',

    'balance_state_required' =>'Balance state required',
    'balance_state_in' =>'Blance state must be one of debit,credit,balanced at beginning',

    'account_type_id_required' => 'Account type required',
    'account_type_id_exists' => 'Selected account type dosnot exist in database',

    'parent_account_id_exists' => 'Selected Parent account  doesnot exists in database',



    'order_required'=> 'The :attribute field is required.',
    'order_numeric'=> 'The :attribute field must be a number.',

    'button_en_string' =>'The :attribute field must be a string.',
    'button_ar_string' =>'The :attribute field must be a string.',



    'type_required' =>'shift type required',
    'type.in' => 'shift type does not exist in databse',

    'start.required' => 'shift start time required',
    'start.numeric' => 'invalid shift start time',

    'end.required' => 'shift end time required',
    'end.numeric' => 'invalid shift end time',

  
    'commission_rate_numeric' =>  'commission rate must be number',
    'commission_rate_min' =>  ' min commission rate is 0%',
    'commission_rate_max' =>  ' max commission rate is 100%',




    'email_max' => 'The :attribute field must not exceed 100 character',
    'email_unique' => 'This email already exists in database',
    'phone1_string' => 'The :attribute field must be a string.',
    'phone1_max' => 'The :attribute field must not exceed 255 character',
    'phone2_string' => 'The :attribute field must be a string.',
    'phone2_max' => 'The :attribute field must not exceed 255 character',
    'address_string' => 'The :attribute field must be a string.',
    'address_max' => 'The :attribute field must not exceed 255 character',
    'about_string' => 'The :attribute field must be a string.',

    'notes_string' => 'The :attribute field must be a string.',
    'payment_method_id_numeric' =>'The :attribute field must be a number.',
    'status_numeric' =>'The :attribute field must be a number.',
    'order_price_numeric' =>'The :attribute field must be a number.',

    'total_price_numeric' =>'The :attribute field must be a number.',

    'page_id_required' => 'The :attribute field is required.',
    'page_id_exists' => 'The selected :attribute is invalid.',
    'menu_item_id_required' => 'The :attribute field is required.',
    'menu_item_id_exists' => 'The selected :attribute is invalid.',

    'coach_id_numeric' =>'The :attribute field must be a number.',
    'client_id_numeric'  =>'The :attribute field must be a number.',

    'date_format' => 'The :attribute field must match the format :format.',
    'day_required' => 'Day Is Required.',
    'from_required' => 'Time To Start Work Is Required',
    'to_required' => 'Time To End Work Is Required',

    'facebook_url' => 'The :attribute field must be a valid URL.',
    'instagram_url' => 'The :attribute field must be a valid URL.',
    'twitter_url' => 'The :attribute field must be a valid URL.',
    'linkedin_url' => 'The :attribute field must be a valid URL.',

    'accepted' => 'The :attribute field must be accepted.',
    'accepted_if' => 'The :attribute field must be accepted when :other is :value.',
    'active_url' => 'The :attribute field must be a valid URL.',
    'after' => 'The :attribute field must be a date after :date.',
    'after_or_equal' => 'The :attribute field must be a date after or equal to :date.',
    'alpha' => 'The :attribute field must only contain letters.',
    'alpha_dash' => 'The :attribute field must only contain letters, numbers, dashes, and underscores.',
    'alpha_num' => 'The :attribute field must only contain letters and numbers.',
    'array' => 'The :attribute field must be an array.',
    'ascii' => 'The :attribute field must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute field must be a date before :date.',
    'before_or_equal' => 'The :attribute field must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute field must have between :min and :max items.',
        'file' => 'The :attribute field must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute field must be between :min and :max.',
        'string' => 'The :attribute field must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute field confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'decimal' => 'The :attribute field must have :decimal decimal places.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'The :attribute field and :other must be different.',
    'digits' => 'The :attribute field must be :digits digits.',
    'digits_between' => 'The :attribute field must be between :min and :max digits.',
    'dimensions' => 'The :attribute field has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute field must not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute field must not start with one of the following: :values.',
    'email' => 'The :attribute field must be a valid email address.',
    'ends_with' => 'The :attribute field must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute field must not have more than :max items.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute field must not be greater than :max.',
        'string' => 'The :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute field must have at least :min items.',
        'file' => 'The :attribute field must be at least :min kilobytes.',
        'numeric' => 'The :attribute field must be at least :min.',
        'string' => 'The :attribute field must be at least :min characters.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',

    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',

    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'array' => 'The :attribute field must contain :size items.',
        'file' => 'The :attribute field must be :size kilobytes.',
        'numeric' => 'The :attribute field must be :size.',
        'string' => 'The :attribute field must be :size characters.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',

    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
