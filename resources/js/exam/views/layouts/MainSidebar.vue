
<!--
  -     Copyright 2021 Mersin İl Milli Eğitim Müdürlüğü Ölçme Değerlendirme Merkezi
  -
  -     Licensed under the Apache License, Version 2.0 (the "License");
  -     you may not use this file except in compliance with the License.
  -     You may obtain a copy of the License at
  -
  -       http://www.apache.org/licenses/LICENSE-2.0
  -
  -     Unless required by applicable law or agreed to in writing, software
  -     distributed under the License is distributed on an "AS IS" BASIS,
  -     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  -     See the License for the specific language governing permissions and
  -     limitations under the License.
  -
  -->

<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a
      href="#"
      class="brand-link"
    >
      <img
        alt="Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: .8"
      >
      <span class="brand-text font-weight-light">Test</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center">
        <div class="info">
          <a
            href="#"
            class="d-block"
            @click.prevent
          >Test</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar nav-child-indent flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="true"
        >
          <!-- Optionally, you can add icons to the links -->
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Ana Sayfa
                <i class="right mdi mdi-angle-left" />
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-question" />
              <p>Soru İşlemleri
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-multiple" />
                  <p>Soruları Listele</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-book-plus" />
                  <p>Soru Oluştur</p>
                </router-link>
              </li>
              <li
                class="nav-item"
              >
                <router-link
                  :to="{name: 'underConstruction' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-test-tube" />
                  <p></p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-delete-restore" />
                  <p>Proje Silme İstekleri</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-account-settings" />
              <p>Kullanıcı Modülü
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <!-- Add a Font Awesome icon -->
                  <i class="mdi mdi-account-group" />
                  <p>Kullanıcıları Listele</p>
                </router-link>
              </li>
              <li
                class="nav-item"
              >
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-table-row-remove" />
                  <p>Pasif Kull. Listele</p>
                </router-link>
              </li>
              <li
                class="nav-item"
              >
                <router-link
                  v-can="'test'"
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <i class="mdi mdi-account-edit" />
                  <p>Bilgilerimi Güncelle</p>
                </router-link>
              </li>
            </ul>
          </li>
          <li
            class="nav-item has-treeview"
          >
            <a
              href="#"
              class="nav-link"
            >
              <i class="mdi mdi-cogs" />
              <p>Uygulama Modülü
                <i class="right fas fa-angle-left" />
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link
                  :to="{name: '' }"
                  class="nav-link"
                >
                  <!-- Add a Font Awesome icon -->
                  <i class="mdi mdi-settings-box" />
                  <p>Uygulama Ayarları</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>

// import img from '../../../images/Logo.png'
// import { mapGetters } from 'vuex'

export default {
  name: 'NMainSidebar',
  data: () => ({
    // userImg: img
  }),
  mounted () {
    $('body').Layout('fixLayoutHeight')
    $('ul').Treeview('init')
  }
}
</script>

<style>

</style>
