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


use App\Traits\SelfReferencing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes, SelfReferencing;

    protected $fillable=[
        "type",
        "context",
        "body",
        "parent_id",
        "creator_id",
        "lesson_id",
        'level',
        'difficulty',
        'description'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "creator_id");
    }


    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, "lesson_id");
    }

    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class, 'curriculum_question_infos')->withTimestamps();
    }

    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'exam_question_infos')->withTimestamps();
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function choicesForApi() {
        return $this->hasMany(Choice::class)->select("id", "content", "is_correct");
    }
}