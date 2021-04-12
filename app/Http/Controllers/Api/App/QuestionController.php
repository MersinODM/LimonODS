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
use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends ApiController
{

    public function get($id) {
//        $question = DB::table('questions')
//            ->where('id', $id)
//            ->select("id", "type", "body", "context", "parent_id", "creator_id")
//            ->first();
//        $choices = DB::table('choices')
//            ->where('q_id', $id)
//            ->select("id", "content", "is_correct")
//            ->get();
//        $question->choices = $choices;

        $question = Question::with('choices')
            ->where("id", $id)
            ->first();
        return response()->json($question);
    }

    public function save(Request $request) {
        $validationResult = $this->apiValidator($request, [
            'type' => 'required',
            'body' => 'required',
            'level' => 'required|integer',
            'choices' => 'required|array|min:3|max:5',
            'choices.*.content' => 'required',
            'choices.*.is_correct' => 'required'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $choices = $request->input('choices');

        try {
            DB::beginTransaction();
            $question = new Question($request->all(["type", "body", "context","level"]));
            $question->creator_id = Auth::id();
            $question->save();

            foreach ($choices as $choice) {
                $choicesModel = new Choice($choice);
                $choicesModel->question_id = $question->id;
                $choicesModel->save();
            }
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Soru kaydı başarılı"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function update($id, Request $request) {
        $validationResult = $this->apiValidator($request, [
            'type' => 'required',
            'body' => 'required',
            'level' => 'required|integer',
            'choices' => 'required|array|min:3|max:5',
            'choices.*.id' => 'required|integer',
            'choices.*.content' => 'required',
            'choices.*.is_correct' => 'required'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        $choices = $request->input('choices');

        try {
            DB::beginTransaction();
            $question = Question::find($id);
            $question->fill($request->all(["body", "context", "level"]));
            $question->save();

            foreach ($choices as $choice) {
                $choicesModel = Choice::find($choice["id"]);
                $choicesModel->fill($choice);
                $choicesModel->save();
            }
            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Soru güncelleme başarılı"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }

    public function delete($id) {
        Question::destroy($id);
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
            ResponseKeys::MESSAGE => "Soru silme başarılı"
        ]);
    }
}