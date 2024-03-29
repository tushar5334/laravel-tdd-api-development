<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            //$table->unsignedBigInteger('todo_list_id');
            $table->mediumText('description')->nullable();
            $table->foreignId('todo_list_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('lable_id')->nullable()->constrained();
            $table->string('status')->default(Task::TASK_NOT_STARTED);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
