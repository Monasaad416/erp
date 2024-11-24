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

    'name_ar_required' => 'الاسم باللغة العربية مطلوب',
    'name_en_required' => 'الاسم باللغة الانجليزية مطلوب',
    'name_ar_string' => 'الاسم باللغة العربية يجب ان يتكون من احرف',
    'name_en_string' =>  'الاسم باللغة الإنجليزية يجب ان يتكون من احرف',
    'name_ar_max' => 'الاسم باللغة العربية يجب  الا يتعدي 255  حرف',
    'name_en_max' =>  'الاسم باللغة الإنجليزية يجب  الا يتعدي 255  حرف',
    'name_en_max_50' =>  'الاسم باللغة الإنجليزية يجب  الا يتعدي 50  حرف',
    'name_ar_max_50' =>  'الاسم باللغة العربية يجب  الا يتعدي 50  حرف',
    'name_ar_unique' =>  'الاسم باللغة العربية بالفعل مسجل بقاعدة البيانات',
    'name_en_unique' =>  'الاسم باللغة الإنجليزية بالفعل مسجل بقاعدة البيانات',

    'name_required' => 'الاسم   مطلوب',
    'name_string' => 'الاسم يجب ان يتكون من احرف',
    'name_max' => 'الاسم يجب الا يتعدي 255  حرف',


    'address_ar_required' => 'العنوان باللغة العربية مطلوب',
    'address_ar_string' => 'العنوان باللغة العربية يجب ان يتكون من احرف',
    'address_en_string' => 'العنوان باللغة الانجليزية يجب ان يتكون من احرف',
    'gln_required'=> 'رقم الموقع العالمي مطلوب',
    'gln_string'=> 'ادخل صيغة صحيحة لرقم الموقع العالمي',
    'gln_length'=> 'رقم الموقع العالمي يجب ان يتكون من 13 خانة',
    'tax_num_length'=> 'الرقم الضريبي يجب ان يتكون من 15 خانة',

    'email_email'=> 'ادخل صيغة صحيحة للبريد الالكتروني ',
    'email_unique'=> 'البريد الالكتروني الذي تم ادخالة بالفعل مسجل بقاعدة البيانات',
    'email_max'=> 'البريد الالكتروني يجب الا يتعدي 100حرف ',
    'phone_string'=> 'ادخل صيغة صحيحة للهاتف ',

    'branch_num_required'=> 'رقم الفرع مطلوب',
    'branch_num_numeric'=> 'ادخل رقم صحيح للفرع',


    'description_ar_required' => 'الوصف باللغة العربية مطلوب',
    'description_en_required' => 'الوصف باللغة الانجليزية مطلوب',
    'description_ar_string' => 'الوصف باللغة العربية يجب ان يتكون من احرف',
    'description_en_string' =>  'الوصف باللغة الإنجليزية يجب ان يتكون من احرف',
    'short_description_ar_string' => 'الوصف القصير باللغة العربية يجب ان يتكون من احرف',
    'short_description_en_string' =>  'الوصف القصير باللغة الإنجليزية يجب ان يتكون من احرف',


    'unit_id_required' => 'وحدة القياس مطلوبة',
    'parent_id_exists' => 'التصنيف الذي تم اختيارة غير موجود بقاعدة البيانات',
    'unit_id_exists' => 'وحدة القياس التي تم اختيارها غير موجود بقاعدة البيانات',
    'serial_num_required' => 'الرقم التسلسلي مطلوب',
    'serial_num_unique'=>'الرقم التسلسلي الذي تم ادخالة بالفعل مسجل في قاعدة البيانات',
    'gtin_required' => 'الرقم الدولي التجاري للمنتج مطلوب  ',
    'gtin_length' => 'عدد الخانات للرقم الدولي التجاري للمنتج يجب ان يكون واحد من 8و12و13و14',
     'gtin_nuique' =>'الرقم الدولي التجاري للمنتج الذي تم ادخالة بالفعل مسجل في قاعدة البيانات',



    'purchase_price_required_if' => 'سعر الشراء للمنتج مطلوب في حالة عدم ادخال سعر الجملة شامل الضريبة ',
    'purchase_price_numeric' => 'سعر الشراء للمنتج يجب ان يكون رقم',
    'wholesale_inc_vat_required_if' => ' السعر الجملة شامل الضريبة للمنتج مطلوب في حالة عدم ادخال سعر الشراء    ',
    'wholesale_inc_vat_numeric' => 'سعر الشراء للمنتج يجب ان يكون رقم',
    'purchase_price_min' => 'اقل سعر للشراء = 0 ',



    'discount_percentage_numeric' => 'نسبة الخصم  للمنتج يجب ان يكون رقم',
    'discount_value_numeric' => 'مبلغ الخصم  للمنتج يجب ان يكون رقم',

    'sale_price_required' => 'سعر البيع للمنتج مطلوب',
    'sale_price_nimeric' => 'سعر البيع للمنتج يجب ان يكون رقم',
    'sale_price_min' => 'اقل سعر للبيع = 0 ',


    'discount_price_nimeric' => 'سعر الخصم للمنتج يجب ان يكون رقم',
    'discount_price_min' => 'اقل سعر للخصم = 0 ',

    'manufactured_date_required' => 'تاريخ التصنيع مطلوب',
    'manufactured_date_date' => 'ادخل صيغة صحيحة لتاريخ التصنيع',

    'expiry_date_required' => 'تاريخ الصلاحية مطلوب',
    'expiry_date_date' => 'ادخل صيغة صحيحة لتاريخ الصلاحية',

    'import_date_required' => 'تاريخ دخول المخزن مطلوب',
    'import_date_date' => 'ادخل صيغة صحيحة لتاريخ دخول المخزن',

    'batch_num_required' => 'رقم التشغيلة مطلوب',
    'payment_type_required' =>'نوع الدفع مطلوب',
    'status_required' =>'تحديد الحالة مطلوب',


    'inventory_balance_required' => 'رصيد المخزن مطلوب',
    'inventory_balance_numeric' => 'رصيد المخزن يجب ان يكون رقم',

    'initial_balance_required' => 'رصيد المخزن الافتتاحي مطلوب',
    'initial_balance_numeric' => 'رصيد المخزن الافتتاحي يجب ان يكون رقم',

    'alert_main_branch_required' => 'كمية التنبية علي النواقص بالمركز الرئيسي مطلوبة',
    'alert_main_branch_numeric' =>  'كمية التنبية علي النواقص بالمركز الرئيسي يجب أن تكون رقم',

    'alert_branch_required' =>  'كمية التنبية علي النواقص  بالفرع مطلوبة',
    'alert_branch_numeric' =>  'كمية التنبية علي النواقص  بالفرع يجب ان تكون رقم',

    'product_code_required' => 'كود المنتج مطلوب',
    'product_code_string' => 'كود المنتج يقبل حروف وارقام ',
    'product_code_max' => 'كود المنتج يجب الا يزيد عن 50 خانة ',
    'product_code_unique' =>'كود المنتج الذي تم إدخالة بالفعل مسجل بقاعدة البيانات',
    'product_code_exists' => 'الكود الذي تم ادخالة غير موجود بقاعدة البيانات',

    'qty_required' => 'كمية المنتج مطلوبة',
    'qty_numeric' => 'كمية المنتج  يجب أن تكون رقم ',

    'taxes_required' =>'قيمة الضريبة مطلوبة',


    'account_num_required' => 'رقم الحساب مطلوب     ',
    'account_num_numeric' =>  'رقم الحساب يجب ان يتكون من ارقام ',
    'account_num_min' => 'رقم الحساب يجب الايقل عن 0',
    'account_num_unique' => 'رقم الحساب الذي تم ادخالة بالفعل مسجل بقاعدة البيانات   ',

    'start_balance_required' => 'الرصيد الابتدائي مطلوب',
    'start_balance_numeric' => 'الرصيد الابتدائي يجب ان يكون رقم',
    'start_balance_min' => 'الرصيد الابتدائي  يجب الايقل عن 0',

    'current_balance_required' => 'الرصيد الحالي مطلوب',
    'current_balance_numeric' =>'الرصيد الحالي يجب ان يكون رقم',
    'current_balance_min' => 'الرصيد الحالي  يجب الايقل عن 0',

    'balance_state_required' =>'حالة الحساب مطلوبة',
     'balance_state_in' =>'حالة الحساب لابد ان تكون واحدة من دائن-مدين-متزن في بداية المدة',

    'account_type_id_required' => 'نوع الحساب مطلوب',
    'account_type_id_exists' => 'نوع الحساب الذي تم ادخالة غير موجود بقاعدة البيانات',

    'branch_id_required' => 'الفرع مطلوب',
    'branch_id_exists' => 'الفرع الذي تم ادخالة غير موجود بقاعدة البيانات',

    'parent_id_required' => 'الحساب الرئيسي مطلوب',
    'parent_account_id_exists' => 'الحساب الرئيسي الذي تم ادخالة غير موحود بقاعدة البيانات',

    'supplier_id_required' => 'إختر المورد',
    'payment_type_in' => 'إختر نوع الدفع',
    'supp_inv_date_time_required' =>'تاريخ وتوقيت الفاتورة مطلوب',


    'img_image' => 'الملف المرفوع يجب ان يكون صورة',
    'img_mimes' => 'صيغة الصورة يجب أن تكون واحدة من jpeg, jpg, png, svg, gif, jfif',

    'price_numeric' => 'السعر يجب ان يكون رقم',
    'discount_price_numeric' => 'سعر الخصم يجب ان يكون رقم',
    'shipping_price_numeric' => 'سعر الشحن يجب ان يكون رقم',
    'duration_numeric' => 'مدة الخدمة  يجب ان يكون رقم',
    'price_required' => ' السعر مطلوب',

    'notes_string' => 'الملاحظات يجب ان تكون نص',
    'payment_method_id_numeric' =>'لم يتم إختيار طريقة الدفع بصورة صحيحة ',
    'status_numeric' =>'لم يتم إختيار حالو الطلب بصورة صحيحة ',
    'order_price_numeric' =>'السعر يجدب ان يكون رقم',
    'total_price_numeric' =>'إجمالي السعر يجب ان يكون رقم',
    'coach_id_numeric' =>'لم يتم إختيار المستشار بصورة صحيحة ',
    'client_id_numeric'  =>'لم يتم إختيار العميل بصورة صحيحة ',

    'title_ar_required' => 'العنوان باللغة العربية مطلوب',
    'title_en_required' => 'العنوان باللغة الانجليزية مطلوب',
    'title_ar_string' => 'العنوان باللغة العربية يجب ان يتكون من احرف',
    'title_en_string' =>  'العنوان باللغة الإنجليزية يجب ان يتكون من احرف',
    'title_ar_max' => 'العنوان باللغة العربية يجب  الا يتعدي 255  حرف',
    'title_en_max' =>  'العنوان باللغة الإنجليزية يجب  الا يتعدي 255  حرف',

    'body_ar_required' => 'تفاصيل المقال باللغة العربية مطلوب',
    'body_en_required' => 'تفاصيل المقال باللغة الانجليزية مطلوب',
    'body_ar_string' => 'تفاصيل المقال باللغة العربية يجب ان يتكون من احرف',
    'body_en_string' =>  'تفاصيل المقال باللغة الإنجليزية يجب ان يتكون من احرف',

    'details_ar_required' => 'تفاصيل الصفحة باللغة العربية مطلوبة',
    'details_en_required' => 'تفاصيل الصفحة باللغة الانجليزية مطلوبة',
    'details_ar_string' => 'تفاصيل الصفحة باللغة العربية يجب ان يتكون من احرف',
    'details_en_string' =>  'تفاصيل الصفحة باللغة الإنجليزية يجب ان يتكون من احرف',

    'seo_title_string' => 'العنوان الخاص بمحركات البحث  باللغة العربية يجب ان يتكون من احرف',
    'seo_meta_description_string' =>  'الوصف التعريفي الخاص بمحركات البحث  باللغة الإنجليزية يجب ان يتكون من احرف',

    'seo_title_required' =>  'العنوان الخاص بمحركات البحث  باللغة العربية مطلوب',
    'seo_meta_description_required' => 'الوصف التعريفي الخاص بمحركات البحث  باللغة الإنجليزية مطلوب',

    'page_id_required' => 'الصفحة الديناميكية مطلوبة',
    'page_id_exists' =>'الصفحة الديناميكة غير المدخلة موجودة بقاعدة البيانات',
    'menu_item_id_required' => 'بند القائمة الرئيسي مطلوب',
    'menu_item_id_exists' =>'بند القائمة الرئيسي المدخل غير موجود بقاعدة البيانات',

    'order_required'=> 'ترتيب القسم بالموقع مطلوب',
    'order_numeric'=> 'ترتيب القسم بالموقع يجب أن يكون رقم',

    'button_en_string' => 'نص الزر باللغة الإنجليزية يجب أن يتكون من أحرف',
    'button_ar_string' => 'نص الزر باللغة العربية يجب أن يتكون من أحرف',





    'email_required' => 'البريد الإلكتروني مطلوب',
    'email_string' => 'صيغة البريد الإلكتروني غير صالحة',


    'phone_required' => 'الهاتف مطلوب',
    'phone_max' => 'الهاتف يجب الا يتعدي 255  حرف',

    'type_required' =>'نوع الوردية مطلوب',
    'type.in' => 'نوع الوردية الذي تم اخيارة غير متواجد بقاعدة البيانات',

    'start_required' => 'بداية توقيت الوردية مطلوب',
    'start_numeric' => 'بداية توقيت الوردية يجب ان سكون رقم',

    'end_required' => 'نهاية توقيت الوردية مطلوب',
    'end_numeric' => 'نهاية توقيت الوردية يجب ان سكون رقم',

    'total_hours_required' => 'عدد ساعات الوردية مطلوب',
    'total_hours_numeric' => 'عدد ساعات  الوردية يجب ان سكون رقم',

    'start_shift_cash_balance_required'=> 'رصيد الكاش بداية الوردية مطلوب ',
    'start_shift_cash_balance_numeric'=> ' رصيد الكاش بداية الوردية يجب ان يكون رقم',
     'end_shift_cash_balance_required'=> 'رصيدالكاش نهاية الوردية مطلوب ',
     'end_shift_cash_balance_numeric'=> ' رصيدالكاش نهاية الوردية يجب ان يكون رقم',
    'end_shift_bank_balance_required'=> 'الرصيد المحول للبنك نهاية الوردية مطلوب ',
     'end_shift_bank_balance_numeric'=> ' الرصيد المحول للبنك نهاية الوردية يجب ان يكون رقم',
     'amount_delivered_required'=>' المبلغ المسلم بنهاية الوردية مطلوب ',
     'amount_delivered_numeric'=> ' المبلغ المسلم بنهاية الوردية يجا ان يكزن  رقم ',
     'amount_status_value_required'=>' مبلغ العجز او الزيادة او الاتزان مطلوب ',
     'amount_status_value_numeric'=> ' مبلغ العجز او الزيادة او الاتزان يجب ان يكون رقم ',
     'start_shift_date_time_required'=> ' تاريخ وتوقيت بداية الوردية السابقة ',
     'end_shift_date_time_required'=> ' تاريخ وتوقيت نهاية الوردية السابقة ',
     'delivered_shift_id_in'=> 'نوع الوردية الذي تم اخيارة غير موجود بقاعدة البيانات',
     'delivered_shift_id_required'=> ' نوع الوردية المسلمة مطلوب ',
     'delivered_to_shift_id_required'=> ' نوع الوردية المستلمة مطلوب',
     'delivered_to_shift_id_in'=> 'نوع الوردية الذي تم اخيارة غير موجود بقاعدة البيانات',
     'amount_status_required'=> 'تحديد حالة الاتزان او العجز او الفائض مطلوبة',
     'delivered_to_required' =>'اسم مستلم الوردية',

    'commission_rate_numeric' =>  'نسبة العمولة يجب أن تكون رقم',
    'commission_rate_min' =>  'اقل نسبة للعمولة  %00 ',
    'commission_rate_max' =>  'أقصي نسبة للعمولة %100',




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
    'confirmed' => 'تأكيد كلمة السر غير متطابق مع كلمة السر',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute field must be a valid date.',
    'date_equals' => 'The :attribute field must be a date equal to :date.',
    'date_format' => 'The :attribute field must match the format :format.',
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
    'string' => 'The :attribute field must be a string.',
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
