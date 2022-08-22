<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pet_tags', function (Blueprint $table) {
            $table->foreignId('pet_id')->nullable()->constrained('pets')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('tag_id')->nullable()->constrained('tags')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pet_tags');
    }
}
