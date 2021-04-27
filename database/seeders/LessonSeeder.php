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

namespace Database\Seeders;


use App\Models\Lesson;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonSeeder extends Seeder
{
    public function run()
    {
//        Lesson::truncate();
        $levels = [
            ["code" => "TUR", "name" => "Türkçe", "levels" => "4,5,6,7,8"],
            ["code" => "IMAT", "name" => "İlköğretim Matematik", "levels" => "4,5,6,7,8"],
            ["code" => "FB", "name" => "Fen Bilimleri", "levels" => "5,6,7,8"],
            ["code" => "ING", "name" => "İngilizce", "levels" => "4,5,6,7,8,9,10,11,12"],
            ["code" => "SB", "name" => "Sosyal Bilgiler", "levels" => "4,5,6,7,8"],
            ["code" => "HB", "name" => "Hayat Bilgisi", "levels" => "4"],
            ["code" => "DKAB", "name" => "Din Kültürü ve Ahlak Bilgisi", "levels" => "4,5,6,7,8,9,10,11,12"],
            ["code" => "ITA", "name" => "İnkılap Tarihi ve Atatürkçülük", "levels" => "8,12"],
            ["code" => "TDE", "name" => "Türk Dili ve Edebiyatı", "levels" => "9,10,11,12"],
            ["code" => "MAT", "name" => "Matematik", "levels" => "9,10,11,12"],
            ["code" => "FZK", "name" => "Fizik", "levels" => "9,10,11,12"],
            ["code" => "KMY", "name" => "Kimya", "levels" => "9,10,11,12"],
            ["code" => "BYL", "name" => "Biyoloji", "levels" => "9,10,11,12"],
            ["code" => "TAR", "name" => "Tarih", "levels" => "9,10,11,12"],
            ["code" => "COĞ", "name" => "Coğrafya", "levels" => "9,10,11,12"],
            ["code" => "İTA", "name" => "T.C. İnkılap Tarihi ve Atatürkçülük", "levels" => "8,12"],
            ["code" => "FEL", "name" => "Felsefe", "levels" => "9,10,11,12"]
        ];

        DB::table("lessons")
            ->insert($levels);
    }


}