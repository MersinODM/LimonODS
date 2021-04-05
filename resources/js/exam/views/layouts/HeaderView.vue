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
  <nav class="main-header navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
      <router-link
          class="navbar-brand"
          :to="{ name: 'start' }"
      >
        <img
            :src="logo"
            alt="Limon ÖDS"
            class="brand-image"
            style="opacity: .8"
        >
      </router-link>
      <button
          class="navbar-toggler order-1 collapsed"
          type="button"
          data-toggle="collapse"
          data-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
          id="navbarCollapse"
          class="collapse navbar-collapse order-3"
      >
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link
                class="nav-link"
                :to="{name: 'start'}"
            >
              SINAVLAR
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a
                id="ddsReport"
                href="#"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="true"
                class="nav-link dropdown-toggle"
            ><i class="mdi mdi-account-group" /> KARNELER</a>
            <ul
                aria-labelledby="dropdownSubMenu1"
                class="dropdown-menu border-0 shadow"
            >
              <li>
                <router-link
                    href="#"
                    class="dropdown-item"
                    :to="{name: 'underConstruction'}"
                >
                  Karne Listesi
                </router-link>
              </li>
<!--              <li class="dropdown-divider" />-->
<!--              <li>-->
<!--                <router-link-->
<!--                    class="dropdown-item"-->
<!--                    :to="{name: 'newCustomer'}"-->
<!--                >-->
<!--                  -->
<!--                </router-link>-->
<!--              </li>-->
            </ul>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto order-1 order-md-3">
          <li class="nav-item">
            <a
                class="nav-link"
                role="button"
            >
              <i class="mdi mdi-logout" /></a>
          </li>
        </ul>
      </div>
    </div>
    <!--    <div class="container">-->
    <!--      <ul class="navbar-nav">-->
    <!--        <li class="nav-item">-->
    <!--          <a-->
    <!--              class="nav-link"-->
    <!--              data-widget="pushmenu"-->
    <!--              href="#"-->
    <!--              role="button"-->
    <!--          ><i class="fas fa-bars"/>-->
    <!--          </a>-->
    <!--        </li>-->
    <!--      </ul>-->
    <!--              <ul class="navbar-nav ml-auto">-->
    <!--                <li class="nav-item">-->
    <!--                  <a-->
    <!--                      class="nav-link"-->
    <!--                      role="button"-->
    <!--                      @click="logout"-->
    <!--                  >-->
    <!--                    <i class="mdi mdi-logout"/></a>-->
    <!--                </li>-->
    <!--              </ul>-->
    <!--    </div>-->
  </nav>
</template>

<script>
import logo from '../../../../images/svg/logo.svg'


export default {
  name: 'NHeader',
  data: () => ({
    logo: logo,
    user: null,
    name: ''
  }),
  mounted () {
    $('[data-widget="pushmenu"]').PushMenu()
  },
  // methods: {
  //   ...mapActions('app', ['logout'])
  // }
}
</script>

<style lang="sass">

</style>
