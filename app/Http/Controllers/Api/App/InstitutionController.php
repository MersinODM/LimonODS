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
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstitutionController extends ApiController
{
    public function get($id){
        $institutions=Institution::find($id);
        $institutions->first();
        return response()->json($institutions);

    }
    public function save(Request $request){
        $validationResult = $this->apiValidator($request, [
            'id'=>'required|integer',
            'district_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'e_mail' => 'required'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try{
            DB::BeginTransaction();

            $institutions=new Institution($request->all(["id","parent_id","district_id","type","name","phone","address","e_mail"]));
            $institutions->save();

            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Kurum kaydı başarılı"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }
    public function update($id, Request $request) {
        $validationResult = $this->apiValidator($request, [
            'id'=>'required|integer',
            'district_id' => 'required',
            'type' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'e_mail' => 'required'
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        try{
            DB::BeginTransaction();

            $institutions=Institution::find($id);
            $institutions->fill($request->all(["id","parent_id","district_id","type","name","phone","address","e_mail"]));
            $institutions->save();

            DB::commit();
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Kurum kaydı güncellendi"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiException($e);
        }
    }
    public function delete($id) {
        Institution::destroy($id);
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
            ResponseKeys::MESSAGE => "Kurum silme başarılı"
        ]);
    }
}