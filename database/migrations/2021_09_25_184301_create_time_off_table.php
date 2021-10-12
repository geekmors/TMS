<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;
use App\Models\TimeOffDesc;

class CreateTimeOffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_off', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Users::class);
            $table->foreignIdFor(TimeOffDesc::class);
            $table->date('date_from');
            $table->date('date_to');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_off');
    }
}
