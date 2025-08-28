<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            if (!Schema::hasColumn('feedbacks', 'developer_response')) {
                $table->text('developer_response')->nullable()->after('rating');
            }

            if (!Schema::hasColumn('feedbacks', 'status')) {
                $table->enum('status', ['Not Started', 'In Progress', 'Fixed'])
                      ->default('Not Started')
                      ->after('developer_response');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            if (Schema::hasColumn('feedbacks', 'developer_response')) {
                $table->dropColumn('developer_response');
            }

            if (Schema::hasColumn('feedbacks', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
