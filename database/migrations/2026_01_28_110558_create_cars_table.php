<?php

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('model_id')
                ->constrained('car_models')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            $table->year('year');
            $table->string('city');
            $table->integer('mileage');
            $table->string('plate_number')->nullable();
            $table->text('description');
            $table->string('report_pdf');
            $table->text('specs');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
