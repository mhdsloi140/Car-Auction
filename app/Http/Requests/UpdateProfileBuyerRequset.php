<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileBuyerRequset extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                   'name' => ['nullable', 'string', 'min:3', 'max:256'],

            'email' => [
                'nullable',
                'email',
                'unique:users,email,' . $this->user()->id,
            ],

            'password' => ['nullable', 'min:8', 'confirmed'],

            'phone' => [
                'nullable',
                'unique:users,phone,' . $this->user()->id,
            ],
        ];
    }
        public function messages()
    {
        return [
            'name.min' => 'الاسم يجب أن يكون 3 أحرف على الأقل',
            'name.max' => 'الاسم طويل جدًا',

            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',

            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',

            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
        ];
    }

}
