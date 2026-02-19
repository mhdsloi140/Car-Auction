<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            // علاقات السيارات والبائع
            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // أسعار المزاد
            $table->decimal('starting_price', 10, 2)->nullable();
            $table->decimal('current_price', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
            $table->decimal('buy_now_price', 10, 2)->nullable();

            // تواريخ المزاد
            $table->timestamp('start_at')->nullable()->index();
            $table->timestamp('end_at')->nullable()->index();
            $table->timestamp('extended_until')->nullable()->index();
            $table->timestamp('closed_at')->nullable();

            // مدة المزاد وسلوك التمديد
            $table->integer('duration_hours')->default(24);
            $table->boolean('auto_extend')->default(true);
            $table->integer('extension_minutes')->default(5);

            // حالة المزاد
            $table->enum('status', [
                'pending',           // في انتظار موافقة المدير
                'approved',          // تمت الموافقة - جاهز للبدء
                'active',            // نشط - جاري المزايدة
                'closed',            // مغلق - انتهى الوقت بانتظار قرار المدير
                'pending_seller',    // بانتظار البائع - بعد موافقة المدير
                'completed',         // مكتمل - البائع وافق
                'rejected',          // مرفوض - من المدير أو البائع
                'cancelled'          // ملغي
            ])->default('pending')->index();

            // المستخدمون المرتبطون
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // إحصائيات سريعة
            $table->integer('views_count')->default(0);
            $table->integer('bids_count')->default(0);
            $table->integer('unique_bidders_count')->default(0);

            // إعدادات إضافية
            $table->boolean('is_featured')->default(false);
            $table->json('settings')->nullable();
            $table->text('rejection_reason')->nullable();

            // الطوابع الزمنية
            $table->timestamps();
            $table->softDeletes();

            // فهارس إضافية
            $table->index(['current_price']);
            $table->index(['status', 'end_at']);
            $table->index(['seller_id']);
            $table->index(['car_id']);
            $table->index(['winner_id']);
            $table->index(['is_featured']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
