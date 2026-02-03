<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'exists' => 'الحقل المحدد :attribute غير موجود.',
    'integer' => 'يجب أن يكون :attribute عدداً صحيحاً.',
    'numeric' => 'يجب أن يكون :attribute رقماً.',
    'min' => [
        'numeric' => 'يجب أن يكون :attribute على الأقل :min.',
        'string' => 'يجب أن يحتوي :attribute على الأقل على :min حروف.',
    ],
    'max' => [
        'numeric' => 'يجب ألا يزيد :attribute عن :max.',
        'string' => 'يجب ألا يزيد :attribute عن :max حروف.',
    ],
    'between' => [
        'numeric' => 'يجب أن يكون :attribute بين :min و :max.',
        'string' => 'يجب أن يحتوي :attribute بين :min و :max حروف.',
    ],
    'image' => 'يجب أن يكون :attribute صورة.',
    'gt' => 'يجب أن يكون :attribute أكبر من :value.',
    'in' => 'الحقل :attribute غير صالح.',
];
