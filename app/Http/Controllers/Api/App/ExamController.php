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
use Illuminate\Http\Request;

class ExamController extends ApiController
{
    public function save(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'level' => 'required|integer',
            'type_id' => 'required|integer',
            'description' => 'required',
            'lessons' => 'required|array|min:1',
            'lessons.*.question_count' => 'required|integer|min:1',
            'lessons.*.id' => 'required|integer',
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
    }

    public function update($id, Request $request) {

    }

    public function delete(Request $request) {

    }
}