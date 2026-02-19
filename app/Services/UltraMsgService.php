<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UltraMsgService
{
    protected $instanceId;
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        // استخراج instanceId من الرابط
        $fullUrl = config('services.ultramsg.url', 'https://api.ultramsg.com/instance81700/');

        // استخراج instanceId من الرابط
        preg_match('/instance(\d+)/', $fullUrl, $matches);
        $this->instanceId = $matches[1] ?? config('services.ultramsg.instance_id');

        $this->token = config('services.ultramsg.token');
        $this->baseUrl = 'https://api.ultramsg.com';

        Log::info('UltraMsg Config', [
            'instance_id' => $this->instanceId ? 'موجود' : 'غير موجود',
            'token' => $this->token ? 'موجود' : 'غير موجود',
            'base_url' => $this->baseUrl,
            'full_url' => $fullUrl
        ]);
    }

    /**
     * إرسال رسالة نصية عبر واتساب
     */
    public function sendMessage(string $to, string $message, array $options = [])
    {
        try {
            // التحقق من وجود الإعدادات
            if (!$this->instanceId || !$this->token) {
                Log::error('❌ UltraMsg: الإعدادات غير مكتملة', [
                    'instance_id' => $this->instanceId ? 'موجود' : 'مفقود',
                    'token' => $this->token ? 'موجود' : 'مفقود'
                ]);
                return false;
            }

            Log::info('🚀 محاولة إرسال رسالة UltraMsg', [
                'to' => $to,
                'message_length' => strlen($message),
                'timestamp' => now()->toDateTimeString()
            ]);

            // بناء URL صحيح
            $url = $this->baseUrl . '/instance' . $this->instanceId . '/messages/chat';

            Log::info('URL:', ['url' => $url]);

            $payload = array_merge([
                'token' => $this->token,
                'to' => $to,
                'body' => $message,
                'priority' => 10,
                'referenceId' => uniqid(),
            ], $options);

            Log::info('Payload prepared', [
                'to' => $to,
                'referenceId' => $payload['referenceId']
            ]);

            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->post($url, $payload);

            Log::info('📡 Response received', [
                'status' => $response->status(),
                'successful' => $response->successful() ? 'نعم' : 'لا',
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();

                Log::info('✅ UltraMsg: تم إرسال الرسالة بنجاح', [
                    'to' => $to,
                    'message_id' => $responseData['messageId'] ?? 'غير معروف',
                    'response' => $responseData
                ]);

                return $responseData;
            } else {
                Log::error('❌ UltraMsg: فشل في إرسال الرسالة', [
                    'to' => $to,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('❌ UltraMsg: استثناء في إرسال الرسالة', [
                'to' => $to,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * إرسال رسالة مع صورة
     */
 

    /**
     * إرسال ملف PDF
     */


    /**
     * تنسيق رقم الهاتف العراقي
     */
    public function formatPhoneNumber(string $phone, string $countryCode = '964')
    {
        // إزالة أي أحرف غير رقمية
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // إزالة الصفر الأول إذا وجد
        $phone = ltrim($phone, '0');

        // إزالة رمز البلد إذا كان موجوداً
        if (str_starts_with($phone, '964')) {
            $phone = substr($phone, 3);
        }

        // التأكد أن الرقم يبدأ بـ 7 (لأرقام العراق)
        if (!str_starts_with($phone, '7')) {
            Log::warning('رقم هاتف غير صالح للعراق', ['phone' => $phone]);
            return null;
        }

        // إضافة رمز البلد
        return $countryCode . $phone;
    }
}
