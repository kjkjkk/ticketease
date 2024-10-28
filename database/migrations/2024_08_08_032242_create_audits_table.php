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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained('tickets')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('activity');

            $table->foreignId('previous_status_id')
                ->constrained('statuses')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('new_status_id')
                ->constrained('statuses')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
