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

namespace App\Http\Controllers\Api\App;


use App\Http\Controllers\ApiController;
use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuestionQueryController extends ApiController
{
    public function getTable(Request $request): JsonResponse
    {
        $query = Question::with('creator', 'lesson');
        if ( $request->has('year') && !is_null($request->input('year'))) {
            $query->whereRaw("YEAR(questions.created_at) = ".$request->input('year'));
        }
        if ($request->has('status') && !is_null($request->input('status'))) {
            $query->where('questions.status', '=', $request->input('status'));
        }
        if ($request->has('lesson_id') && !is_null($request->input('lesson_id'))) {
            $query->where('questions.lesson_id', '=', $request->input('lesson_id'));
        }

        if ($request->has('level') && !is_null($request->input('level'))) {
            $query->where('questions.level', '=', $request->input('level'));
        }

//        if ($request->has('search') && !is_null($request->input('search')['value'])) {
//            $query->orWhereHas('curriculums', function (Builder $qury) use ($request) {
//                $searchParam = $request->input('search')['value'];
//                $qury->whereRaw("content like ?",  ["%{$searchParam}%"]);
//            });
//        }

        // Kullanılan sınav sayısı
        $query->withCount('exams');
        // Kazanım sayısı
        $query->withCount('curriculums');

        return Datatables::eloquent($query)
            ->filterColumn('curriculum', function ($query, $keyword)  {
                $query->whereHas('curriculums', function (Builder $qery) use ($keyword) {
                        $qery->whereRaw("content like ?",  ["%{$keyword}%"]);
                    });
            })
            ->make(true);
//        return response()->json($query->get());
    }
}

