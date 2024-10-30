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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_task_id')->nullable()->constrained('tasks');
            $table->foreignId('workflow_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
