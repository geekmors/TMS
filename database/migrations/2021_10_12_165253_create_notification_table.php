<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Users::class,'from')->nullable();
            $table->foreignIdFor(Users::class,'to');
            $table->boolean('seen');
            $table->string('message', 100);
            $table->timestamp('created_timestamp')->nullable();
            $table->dateTime('viewed_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification');
    }
}
