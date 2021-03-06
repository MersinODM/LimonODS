<?php
/*
 *     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
 *
 *     Licensed under the Apache License, Version 2.0 (the "License");
 *     you may not use this file except in compliance with the License.
 *     You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *     Unless required by applicable law or agreed to in writing, software
 *     distributed under the License is distributed on an "AS IS" BASIS,
 *     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *     See the License for the specific language governing permissions and
 *     limitations under the License.
 *
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "type_id",
        "creator_id",
        "title",
        "level",
        "code",
        "start_date",
        "end_date",
        "description"
    ];

    public function questions() {
        return $this->belongsToMany(Question::class, 'exam_question_infos');
    }

    public function lessons() {
        return $this->belongsToMany(Lesson::class, 'exam_lesson_infos')
            ->withPivot('count');
    }

    public function institutions () {
        return $this->belongsToMany(Institution::class, 'exam_institution_infos');

    }

}