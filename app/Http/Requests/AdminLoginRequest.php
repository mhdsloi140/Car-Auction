<?php

namespace App\Http\Requests;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
class AdminLoginRequest extends FormRequest
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
            'phone' => ['required', 'string', 'exists:users,phone'],
            'password' => ['required', 'string'],
        ];
    }
    public function afterValidation()
    {
        $data = $this->validated();
        $user = User::where('phone', $data['phone'])->first();
        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'البيانات المقدمة غير صحيحة.',
            ]);
        }
        return $data;
    }
    public function messages(): array
    {
        return
            [
                'phone.required' => 'رقم الهاتف مطلوب',
                'phone.string' => 'رقم الهاتف غير صحيح',
                'phone.exists' => 'هذا الرقم غير مسجل',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.string' => 'كلمة المرور يجب أن تكون نصية',
            ];
    }
}
