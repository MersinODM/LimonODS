<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('institutions_temp', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger("code")->nullable();
            $table->string("name");
            $table->string("province");
            $table->string("district");
            $table->string("type");
            $table->timestamps();
        });

        Schema::create('institutions_type', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger("code")->nullable();
            $table->string("name");
            $table->timestamps();
        });

        Schema::table('institutions', function (Blueprint $table) {
            $table->dropColumn("type");
            $table->unsignedInteger("type_id")->nullable()
                ->after('district_id')->comment("");

            $table->foreign("type_id")
                ->references("id")
                ->on("institutions_type");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions_temp');
    }
}
