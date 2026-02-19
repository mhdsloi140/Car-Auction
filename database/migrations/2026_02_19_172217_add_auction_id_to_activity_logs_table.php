<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('auction_id')->nullable()->after('user_id');
            // إذا أردت إضافة foreign key
            $table->foreign('auction_id')->references('id')->on('auctions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['auction_id']);
            $table->dropColumn('auction_id');
        });
    }
};
