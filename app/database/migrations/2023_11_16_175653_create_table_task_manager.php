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
            $table->foreignId('user_id')->constrained()->onDelete("CASCADE");
            $table->integer('parent_id')->unsigned()->default(0);
            $table->smallInteger('status')->unsigned()->default(0);
            $table->smallInteger('priority')->unsigned()->default(0);
            $table->string('title');
            $table->text('description');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            //indexes
            $table->fullText(['title', 'description']);
            $table->index('priority');
            $table->index('status');
            $table->index('created_at');
            $table->index('completed_at');
         
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_task_manager');
    }
};
