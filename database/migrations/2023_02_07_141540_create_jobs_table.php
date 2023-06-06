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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('level', ['Easy', 'Medium', 'Hard'])->default('Medium');
            $table->float('budget')->nullable();
            $table->string('address');
            $table->string('city');
            $table->enum('urgency', ['Very Urgent', 'Urgent', 'Not Urgent'])->default('Urgent');
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Group::class)->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'winner_id')->nullable();
            $table->enum('status', ['Done', 'In Progress', 'Bidding', 'Paid'])->default('Bidding');
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
        Schema::dropIfExists('jobs');
    }
};
