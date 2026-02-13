<?php

use App\Models\Car;
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
            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('seller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('starting_price', 10, 2);
            $table->decimal('buy_now_price', 10, 2)->nullable();

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'active',
                'closed',
                'completed'
            ])->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('winner_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
                    $table->decimal('final_price', 10, 2)->nullable();

            $table->timestamps();
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
