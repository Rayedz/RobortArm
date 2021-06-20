<?php

use App\Models\ArmEngine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arm_engines', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->integer('value')->default(0);
            $table->boolean('isOn')->default(false);
            $table->timestamps();
        });

        ArmEngine::create(['name' => '1']);
        ArmEngine::create(['name' => '2']);
        ArmEngine::create(['name' => '3']);
        ArmEngine::create(['name' => '4']);
        ArmEngine::create(['name' => '5']);
        ArmEngine::create(['name' => '6']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arm_engines');
    }
}
