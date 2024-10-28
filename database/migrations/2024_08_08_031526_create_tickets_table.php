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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_number')->unique();

            $table->foreignId('requestor_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');


            $table->foreignId('ticket_nature_id')
                ->constrained('ticket_natures')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('district_id')
                ->constrained('districts')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('department');

            $table->foreignId('device_id')
                ->constrained('devices')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('brand')->default('NA');
            $table->string('model')->default('NA');
            $table->string('property_no')->default('NA');
            $table->string('serial_no')->default('NA');
            $table->string('details');

            $table->foreignId('status_id')
                ->default(1)
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
        Schema::dropIfExists('tickets');
    }
};
