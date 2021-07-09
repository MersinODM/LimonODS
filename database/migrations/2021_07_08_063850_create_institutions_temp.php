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

        Schema::create('institution_temps', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger("code")->nullable();
            $table->string("name", 500);
            $table->string("province");
            $table->string("district");
            $table->string("type");
            $table->timestamps();
        });

        Schema::create('institution_types', function (Blueprint $table) {
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
                ->on("institution_types");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('institutions', function (Blueprint $table) {
            $table->dropForeign('institutions_type_id_foreign');
            $table->dropIndex('institutions_type_id_foreign');
            $table->dropColumn("type_id");
            $table->unsignedInteger("type")->nullable()
                ->after('district_id')->comment("");
        });
        Schema::dropIfExists('institution_temps');
        Schema::dropIfExists('institution_types');
    }
}
