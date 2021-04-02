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

const Constants = {
  CURRENT_USER: 'current_user',
  ACCESS_TOKEN: 'access_token',
  PERMISSIONS: 'permissions',
  ROLES: 'roles',
  EXPIRES_IN: 'expires_in',
  GENERAL_INFO: 'general_info'
}

const ResponseCodes = {
  CODE_SUCCESS: 1000,
  CODE_UNAUTHORIZED: 1001,
  CODE_NOT_FOUND: 1002,
  CODE_INFO: 1003,
  CODE_WARNING: 1004,
  CODE_ERROR: 1005
}

const MessengerConstants = {
  errorMessage: 'Üzgünüz, bir hata ile karşılaştık lütfen sistem yöneticinize başvurunuz!'
}

const MessageKeys = {
  MESSAGE: 'message',
  CODE: 'code'
}


// const Permissions = Object.freeze({
//   CREATE_PROJECT: 'create_project',
//   EDIT_PROJECT: 'edit_project',
//   DELETE_PROJECT: 'delete_project',
//   LIST_PROJECTS: 'list_projects'
// })

export {
  MessengerConstants,
  ResponseCodes,
  MessageKeys,
  // Permissions
  Constants
}
