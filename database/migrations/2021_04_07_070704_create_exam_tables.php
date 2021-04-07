<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Şehirler
        Schema::create('provinces', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary(); //Plaka kodu
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();
        });

        //İlçeler
        Schema::create('districts', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true)->primary();
            $table->unsignedTinyInteger('province_id');
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();

            $table->foreign("province_id")
                ->references("id")
                ->on("provinces");
        });

        //Kurumlar
        Schema::create('institutions', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->unsignedInteger('type')->nullable(); //10: İl MEM,11: İlçe MEM, 12:Okul
            $table->string('name', 500);
            $table->string('phone', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('e_mail', 100)->nullable();
            $table->timestamps();
        });

        //Buna katılımcılar demek daha uygun olabilirdi belki ama neyse
        Schema::create('students', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('inst_id');
            $table->string('full_name', 500);
            $table->unsignedTinyInteger('level');
            $table->string('branch', 200)->nullable();
            $table->unsignedTinyInteger('no');
            $table->timestamps();

            $table->foreign("inst_id")
                ->references("id")
                ->on("institutions");
        });

        //Kurum gruplama tablosu
        Schema::create('groups', function (Blueprint $table) {
           $table->id()->startingValue(1000);
           $table->unsignedInteger("owner_id")->nullable(); //Gruplamayı yapan ödm ya da kurumun kurum kodu
           $table->string('code')->nullable();
           $table->string('title')->nullable();
           $table->timestamps();

           $table->foreign("owner_id")
                ->references("id")
                ->on("institutions");
        });

        //Kurum gruplama birleştime tablosu
        Schema::create('institution_group_infos', function (Blueprint $table) {
           $table->unsignedBigInteger("group_id")->primary();
           $table->unsignedInteger("inst_id")->primary();
           $table->timestamps();

            $table->foreign("group_id")
                ->references("id")
                ->on("groups");

            $table->foreign("inst_id")
                ->references("id")
                ->on("institutions");
        });

        //Dersler
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();
            $table->softDeletes();
        });

        //Kazanım/Konu/Ünite daha doğrusu tüm müfredat
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("lesson_id");
            $table->unsignedInteger("parent_id");
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->tinyInteger('level');
            $table->tinyInteger('type');
            $table->string('content', 6000);
            $table->timestamps();
            $table->softDeletes();

            //foreign key tanımlamaları yapılıyor
            $table->foreign("lesson_id")
                ->references("id")
                ->on("lessons");

            $table->foreign("parent_id")
                ->references("id")
                ->on("curriculums");
        });

        //Sınav türleri
        Schema::create('exam_types', function (Blueprint $table) {
            $table->id()->startingValue(100);
            $table->string('code', 50)->nullable();
            $table->string('name', 500);
            $table->timestamps();
        });

        //Sınavlar
        Schema::create('exams', function (Blueprint $table) {
           $table->unsignedBigInteger("id");
           $table->unsignedInteger("type_id")->nullable();
           $table->unsignedInteger("creator_id")->nullable();
           $table->string('code', 50)->nullable();
           $table->string('title', 1000);
           $table->dateTime('start_date');
           $table->dateTime('end_date');
           $table->string('description', 10000);
           $table->timestamps();
           $table->softDeletes();
        });

        //Kurum sınav birleştirme tablosu
        Schema::create('institution_exam_infos', function (Blueprint $table) {
            $table->unsignedBigInteger("exam_id")->primary();
            $table->unsignedInteger("inst_id")->primary();
            $table->timestamps();

            $table->foreign("exam_id")
                ->references("id")
                ->on("exams");

            $table->foreign("inst_id")
                ->references("id")
                ->on("institutions");
        });

        //Sınav ders birleştirme tablosu
        Schema::create('exam_lesson_infos', function (Blueprint $table) {
           $table->unsignedBigInteger("exam_id")->primary();
           $table->unsignedBigInteger("lesson_id")->primary();
           $table->tinyInteger("count");
           $table->timestamps();
        });

        //Sorular tablosu
        Schema::create('questions', function (Blueprint $table) {
           $table->id()->startingValue(10000);
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->unsignedInteger("creator_id");
            $table->unsignedInteger("lesson_id");
            $table->tinyInteger("type");
            $table->string('context', 6000)->nullable();
            $table->string('body', 6000);
            $table->string('description', 6000)->nullable(); //Bu alan ihtimal dahilinmde konuldu
            $table->timestamps();

            $table->foreign("parent_id")
                ->references("id")
                ->on("questions");

        });


        Schema::create('choices', function (Blueprint $table) {
            $table->id()->startingValue(10000);
            $table->unsignedBigInteger("question_id");
            $table->string('content', 6000);
            $table->boolean('is_correct');
            $table->timestamps();
        });

        //Kazanım soru birleştirme tablosu
        Schema::create('curriculum_question_infos', function (Blueprint $table) {
           $table->unsignedBigInteger("curriculum_id")->primary();
           $table->unsignedBigInteger("question_id")->primary();
           $table->timestamps();

            $table->foreign("curriculum_id")
                ->references("id")
                ->on("curriculums");

            $table->foreign("question_id")
                ->references("id")
                ->on("questions");
        });

        //Bu tabloiçin her hangi bir ilişki eklenmeyecek yazılımsal kontrol edilecek
        Schema::create("student_answers", function (Blueprint $table) {
           $table->unsignedBigInteger("student_id")->primary();
           $table->unsignedBigInteger("choice_id")->nullable()->primary();
           $table->unsignedBigInteger("exam_id")->primary();
           $table->unsignedBigInteger("question_id")->primary();
           $table->unsignedBigInteger("short_answer")->primary();
           $table->unsignedBigInteger("answer")->primary();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_tables');
    }
}
