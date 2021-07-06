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

import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/auth/Login'
import MasterView from '../views/layouts/MasterView'
import Start from '../views/home/Start'
import UnderConstruction from '../../commons/views/utils/UnderConstruction'
import NotFound from '../../commons/views/utils/NotFound'
import ShowExam from '../views/exams/ShowExam'
import StudentExams from '../views/exams/StudentExams'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/exam/login',
      name: 'login',
      component: Login
    },
    {
      path: '/exam',
      component: MasterView,
      children: [
        {
          path: '',
          name: 'start',
          component: Start
        },
        {
          path: 'show-exam',
          name: 'showExam',
          component: ShowExam
        },
        {
          path: 'student-exam',
          name: 'studentExam',
          component: StudentExams
        },
        {
          path: 'under-construction',
          name: 'underConstruction',
          component: UnderConstruction
        }
      ]
    },
    { path: '/:pathMatch(.*)*', name: 'not-found', component: NotFound }
  ]
})

const checkAuth = (to, next) => {
  if (to.name === 'login' || to.name === 'forgotMyPassword') {
    next()
  } else {
    // TODO burada login kontrlolü yapılsın
    next()
  }
}

// TODO Burada role denetimi yapılacak
router.beforeEach((to, from, next) => checkAuth(to, next))

export default router
