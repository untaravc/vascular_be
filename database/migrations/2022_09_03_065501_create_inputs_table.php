<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputs', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('project_id');
            $table->integer('institution_id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('type');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('order')->nullable();
            $table->integer('dependency_id')->nullable();
            $table->string('dependency_value')->nullable();
            $table->boolean('is_currency')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('blank_option')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inputs');
    }
}
