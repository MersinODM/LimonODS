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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends ApiController
{
    public function save(Request $request) {

        $validationResult = $this->apiValidator($request, [
            "image" => "required|mimes:png,jpg,jpeg|max:1024"
        ]);

        if ($validationResult) {
            return response()->json($validationResult, 422);
        }

        if ($request->hasFile("image")) {
            $file = $request->file('image');
            $name =  Auth::id()."-". date('YmdHis').'-'.uniqid('', true).".".$file->extension();
            $path = $file->storeAs('public/images', $name);
            return response()->json([
                ResponseKeys::CODE => ResponseCodes::CODE_SUCCESS,
                ResponseKeys::MESSAGE => "Dosya kaydınız başarıyla yapılmıştır.",
                "url" => route("getImage")."?fileName=".$name
            ]);
        }
        return response()->json([
            ResponseKeys::CODE => ResponseCodes::CODE_WARNING,
            ResponseKeys::MESSAGE => "Kaydedilecek dosya bulunamadı!",
            "error" => [
                "message" => "Kaydedilecek dosya bulunamadı!"
            ]
        ]);
    }
}