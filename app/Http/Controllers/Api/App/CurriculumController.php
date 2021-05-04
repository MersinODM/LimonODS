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
use App\Models\Curriculum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurriculumController extends ApiController
{

    public function getById($id)
    {
        $query = Curriculum::find($id);
        return response()->json($query);
    }

    public function findBy(Request $request): JsonResponse
    {
        if($request->has('questionId') && !is_null($request->query('questionId'))) {
            $id = $request->query('questionId');
            $model = Curriculum::whereHas('questions',  static function (Builder $query) use ($id) {
                $query->where('id', $id);
            })->get();
            return response()->json($model);
        }

        $param = $request->query("param");
        $level = $request->query("level");
        if (!is_null($param)) {
            $query = Curriculum::where("content", "like", "%" . $param . "%");
            if (!is_null($level)) {
                $query->where("level", $level);
            }
            $result = $query->get();
            return response()->json($result);
        }
        return response()->json([], 200);
    }

}