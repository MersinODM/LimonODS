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


class QuestionStatus
{
    public const WAITING_FOR_ACTION = 900; // İşeleme alınmamış
    public const IN_ELECTION = 901; // değerledirme aşamasında
    public const NOT_MUST_ASKED = 902;          // SORULMAMALI
    public const NEED_REVISION = 903;           // Revizyon gerekir
    public const REVISION_COMPLETED = 904; // değerledirme aşamasında
    public const APPROVED = 905;          // Onaylanmış soru
    public const DELETE_REQUESTED = 906; //905;          // Onaylanmış soru
}