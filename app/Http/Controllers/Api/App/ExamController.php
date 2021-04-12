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
use App\Http\Controllers\Utils\ResponseCodes;
use App\Http\Controllers\Utils\ResponseKeys;
use App\Models\Exam;
use App\Models\ExamInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends ApiController
{

    public function get($id){
        $exam=Exam::with('lessons')
            ->where("id",$id)
            ->first();
        return response()->json($exam);
    }

    public function save(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'level' => 'required|integer',
            'type_id' => 'required|integer',
            'description' => 'required',
            'lessons' => 'required|array|min:1',
            'lessons.*.count' => 'required|integer|min:1',
            'lessons.*.id' => 'required|integer'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $lessons = $request->input('lessons');

        try {
            DB::beginTransaction();
            $exam = new Exam($request->all(["title", "start_date", "end_date","level","type_id","description"]));
            $exam->creator_id = Auth::id();
            $exam->save();

            foreach ($lessons as $lesson) {
                $lessonModel = new ExamInfo();
                $lessonModel->exam_id = $exam["id"];
                $lessonModel->lesson_id = $lesson["id"];
                $lessonModel->count = $lesson["count"];
                $lessonModel->save();
            }
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Sınav kaydı başarılı"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function update($id, Request $request) {
        $validationResult = $this->apiValidator($request, [
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'level' => 'required|integer',
            'type_id' => 'required|integer',
            'description' => 'required',
            'lessons' => 'required|array|min:1',
            'lessons.*.count' => 'required|integer|min:1',
            'lessons.*.lesson_id' => 'required|integer'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $lessons = $request->input('lessons');

        try {
            DB::beginTransaction();
            $exam=Exam::find($id);
            $exam->fill($request->all(["title", "start_date", "end_date", "level", "type_id", "description"]));
            $exam->save();

            $exam_id=$id;

            $lessons_delete = ExamInfo::where('exam_id',$exam_id);
            $lessons_delete->delete();

            foreach ($lessons as $lesson) {
                $lessonModel = new ExamInfo();
                $lessonModel->exam_id = $id;
                $lessonModel->lesson_id = $lesson["lesson_id"];
                $lessonModel->count = $lesson["count"];
                $lessonModel->save();
            }

            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Sınav kaydı güncellendi"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function delete($id) {
        try {
            DB::beginTransaction();
            Exam::destroy($id);
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