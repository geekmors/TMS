<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;
use App\Models\TypographySize;
use App\Models\TimeFormat;

class CreateUserSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->id();
           $table->foreignIdFor(Users::class);
            $table->foreignIdFor(TypographySize::class);
            $table->boolean('dark_theme');
            $table->string('avatar');
            $table->string('avatar_original');
            $table->boolean('is_enabled');
            $table->foreignIdFor(TimeFormat::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_setting');
    }
}
