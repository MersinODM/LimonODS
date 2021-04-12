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


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'list-question', 'display_name' => "Soruları listeleyebilme"]);
        Permission::create(['name' => 'create-question', 'display_name' => "Soru oluşturabilme"]);
        Permission::create(['name' => 'update-question', 'display_name' => "Soru güncelleyebilme"]);
        Permission::create(['name' => 'delete-question', 'display_name' => "Soru silebilme"]);
        Permission::create(['name' => 'evaluate-question', 'display_name' => "Soru değerlendirebilme"]);
        Permission::create(['name' => 'approve-question', 'display_name' => "Soru onaylayabilme"]);

        Permission::create(['name' => 'list-exam', 'display_name' => "Sınavları listeleyebilme"]);
        Permission::create(['name' => 'create-exam', 'display_name' => "Sınav oluşturabilme"]);
        Permission::create(['name' => 'update-exam', 'display_name' => "Sınav güncelleyebilme"]);
        Permission::create(['name' => 'delete-exam', 'display_name' => "Sınav silebilme"]);


        Permission::create(['name' => 'level-*', 'display_name' => "Tüm seviyelerde çalışabilme"]);
        Permission::create(['name' => 'level-4', 'display_name' => "4. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-5', 'display_name' => "5. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-6', 'display_name' => "6. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-7', 'display_name' => "7. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-8', 'display_name' => "8. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-9', 'display_name' => "9. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-10', 'display_name' => "10. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-11', 'display_name' => "11. sınıf seviyesinde çalışabilme"]);
        Permission::create(['name' => 'level-12', 'display_name' => "12. sınıf seviyesinde çalışabilme"]);

        // create roles and assign created permissions

        // this can be done as separate statements
        Role::create(['name' => 'teacher', 'display_name' => 'Öğretmen']);
        Role::create(['name' => 'eval-commissioner', 'display_name' => 'Komisyon']);
        Role::create(['name' => 'inst-comanager', 'display_name' => 'Kurum Yönetici Yardımcısı']);
        Role::create(['name' => 'inst-manager', 'display_name' => 'Kurum Yöneticisi']);
        Role::create(['name' => 'branch-manager', 'display_name' => 'Şube Müdürü']);
        Role::create(['name' => 'district-edu-manager', 'display_name' => 'İlçe Milli Eğitim Müdürü']);
        Role::create(['name' => 'province-edu-comanager', 'display_name' => 'İl Milli Eğitim Müdür Yardımcısı']);
        Role::create(['name' => 'province-edu-manager', 'display_name' => 'İl Milli Eğitim Müdürü']);
        Role::create(['name' => 'assessment-and-eval-expert', 'display_name' => 'Ölçme Değerlendirme Uzmanı']);
        Role::create(['name' => 'admin', 'display_name' => 'Sistem Yöneticisi'])
            ->givePermissionTo(Permission::all());

    }
}