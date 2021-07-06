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

namespace App\Http\Controllers\Api\Exam;


use App\Http\Controllers\ApiController;
use App\Models\Student;
use App\Models\MultiChoiceAnswer;
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends ApiController
{
    public function get($id){
        $student=Student::find($id)
            ->first();
        return response()->json($student);
    }

    public function save(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'student_id' => 'required',
            'choice_id' => 'required',
            'exam_id' => 'required',
            'question_id' => 'required|integer'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try {
            DB::beginTransaction();
            $answer = new MultiChoiceAnswer($request->all(["student_id", "choice_id", "exam_id","question_id"]));
            $answer->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Cevap ekleme başarılı."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function update(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'student_id' => 'required',
            'choice_id' => 'required',
            'exam_id' => 'required',
            'question_id' => 'required|integer'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }
        try {
            DB::beginTransaction();
            $answer=MultiChoiceAnswer::find($request->all(["student_id", "exam_id","question_id"]));
            $answer = $answer -> fill($request->all(["student_id", "choice_id", "exam_id","question_id"]));
            $answer->save();
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Cevap güncelleme başarılı."
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            MultiChoiceAnswer::destroy($id);
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Sınav silme başarılı"
            ]);
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }
}