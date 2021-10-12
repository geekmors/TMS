<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
        
            $table->string('google_id');
            $table->string('email')->unique();
           /* $table->foreignId('roleId');
            $table->foreign('roleId')->references('id')->on('roles'); */
            $table->foreignIdFor(Role::class);
            $table->timestamp('timestamp_created')->nullable();
            $table->rememberToken();
            $table->date('timestamp_lastlogin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
