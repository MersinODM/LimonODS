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

        Schema::disableForeignKeyConstraints();
        //Şehirler
        Schema::create('provinces', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary(); //Plaka kodu
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->timestamps();
        });

        //İlçeler
        Schema::create('districts', function (Blueprint $table) {
            $table->unsignedTinyInteger('id', true);
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
            $table->unsignedInteger('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('district_id')->nullable();
            $table->unsignedInteger('type')->nullable(); //10: İl MEM,11: İlçe MEM, 12:Okul
            $table->string('name', 500);
            $table->string('phone', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('e_mail', 100)->nullable();
            $table->timestamps();

            $table->primary("id");

            $table->foreign("parent_id")
                ->references("id")
                ->on("institutions");

            $table->foreign("district_id")
                ->references("id")
                ->on("districts");
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
           $table->unsignedBigInteger("group_id");
           $table->unsignedInteger("inst_id");
           $table->timestamps();

          $table->primary(['group_id', 'inst_id']);

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
            $table->unsignedBigInteger("lesson_id");
            $table->unsignedBigInteger("parent_id");
            $table->string('code', 50)->nullable();
            $table->string('name', 1000);
            $table->tinyInteger('level');
            $table->tinyInteger('type');
            $table->string('content', 4000);
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
           $table->id()->startingValue(1000);
           $table->unsignedBigInteger("type_id")->nullable();
           $table->unsignedBigInteger("creator_id")->nullable();
           $table->string('code', 50)->nullable();
           $table->string('title', 1000);
           $table->dateTime('start_date');
           $table->dateTime('end_date');
           $table->string('description', 4000);
           $table->timestamps();
           $table->softDeletes();

            $table->foreign("type_id")
                ->references("id")
                ->on("exam_types");
        });

        //Kurum sınav birleştirme tablosu
        Schema::create('institution_exam_infos', function (Blueprint $table) {
            $table->unsignedBigInteger("exam_id");
            $table->unsignedInteger("inst_id");
            $table->timestamps();

            $table->primary(['exam_id', 'inst_id']);


            $table->foreign("exam_id")
                ->references("id")
                ->on("exams");

            $table->foreign("inst_id")
                ->references("id")
                ->on("institutions");
        });

        //Sınav ders birleştirme tablosu
        Schema::create('exam_lesson_infos', function (Blueprint $table) {
           $table->unsignedBigInteger("exam_id");
           $table->unsignedBigInteger("lesson_id");
           $table->tinyInteger("count");
           $table->timestamps();
           $table->primary(['exam_id', 'lesson_id']);

            $table->foreign("exam_id")
                ->references("id")
                ->on("exams");

            $table->foreign("lesson_id")
                ->references("id")
                ->on("lessons");
        });

        //Sorular tablosu
        Schema::create('questions', function (Blueprint $table) {
           $table->id()->startingValue(10000);
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->unsignedInteger("creator_id");
            $table->unsignedInteger("lesson_id");
            $table->tinyInteger("type");
            $table->string('context', 4000)->nullable();
            $table->string('body', 4000);
            $table->string('description', 4000)->nullable(); //Bu alan ihtimal dahilinmde konuldu
            $table->timestamps();

            $table->foreign("parent_id")
                ->references("id")
                ->on("questions");

        });


        Schema::create('choices', function (Blueprint $table) {
            $table->id()->startingValue(10000);
            $table->unsignedBigInteger("question_id");
            $table->string('content', 4000);
            $table->boolean('is_correct');
            $table->timestamps();

            $table->foreign("question_id")
                ->references("id")
                ->on("questions");
        });

        //Kazanım soru birleştirme tablosu
        Schema::create('curriculum_question_infos', function (Blueprint $table) {
           $table->unsignedBigInteger("curriculum_id");
           $table->unsignedBigInteger("question_id");
           $table->timestamps();
           $table->primary(['curriculum_id', 'question_id']);


            $table->foreign("curriculum_id")
                ->references("id")
                ->on("curriculums");

            $table->foreign("question_id")
                ->references("id")
                ->on("questions");
        });

        //Bu tabloiçin her hangi bir ilişki eklenmeyecek yazılımsal kontrol edilecek
        Schema::create("multi_choice_answers", function (Blueprint $table) {
           $table->unsignedBigInteger("student_id");
           $table->unsignedBigInteger("choice_id")->nullable();
           $table->unsignedBigInteger("exam_id");
           $table->unsignedBigInteger("question_id");
           $table->primary(['student_id', 'question_id', 'choice_id', 'exam_id']);
        });

        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_answers');
        Schema::dropIfExists('curriculum_question_infos');
        Schema::dropIfExists('choices');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('exam_lesson_infos');
        Schema::dropIfExists('institution_exam_infos');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('exam_types');
        Schema::dropIfExists('curriculums');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('institution_group_infos');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('students');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
    }
}
