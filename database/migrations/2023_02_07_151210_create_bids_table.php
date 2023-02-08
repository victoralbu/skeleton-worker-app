<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->float('money');
            $table->text('few_words')->nullable();
            $table->enum('status', ['Won', 'In Progress', 'Lost'])->default('In Progress');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Job::class);
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
        Schema::dropIfExists('bids');
    }
};
