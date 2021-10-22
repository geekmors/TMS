<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;


class CreateTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Users::class);
           $table->date('date_worked');
           $table->string('entry');
           $table->timestamp('time_in')->nullable();
           $table->timestamp('time_out')->nullable();
           $table->decimal('total_hours', $precision=9, $scale=2);
           $table->decimal('regular_hours', $precision=9, $scale =2);
           $table->decimal('over_time', $precision=9, $scale=2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time');
    }
}
