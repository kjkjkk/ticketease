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
        Schema::create('ticket_assigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                ->constrained('tickets')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('technician_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->dateTime('date_assigned')->useCurrent();
            $table->boolean('if_priority')->default(0);

            $table->foreignId('assigned_by')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('service_rendered')->nullable();
            $table->string('issue_found')->nullable();
            $table->string('service_status')->nullable();
            $table->boolean('if_scheduled')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticke_assigns');
    }
};
