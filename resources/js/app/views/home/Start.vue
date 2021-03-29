<template>
  <page>
    <template #header>
      <h4>Giriş <span class="text-bold text-blue">(Aktif Stoklar)</span></h4>
    </template>
    <template #content>
      <div class="row">
        <div class="col-md-3">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5>Arama</h5>
                </div>
                <div class="card-body">
                  <strong>Müşteri Adına Göre</strong>
                  <div class="input-group mb-3">
                    <input
                      v-model="inputSearchCustomerByFullName"
                      type="text"
                      class="form-control"
                    >
                    <span class="input-group-append">
                      <button
                        type="submit"
                        class="btn btn-primary"
                        @click="searchCustomerByFullName"
                      >Ara</button>
                    </span>
                  </div>
                  <strong>Stok Numarasına Göre Müşteri</strong>
                  <div class="input-group mb-3">
                    <input
                      v-model="inputSearchCustomerByInventoryCode"
                      type="text"
                      class="form-control"
                    >
                    <span class="input-group-append">
                      <button
                        type="submit"
                        class="btn btn-success"
                        @click="searchCustomerByInventoryCode"
                      >Ara</button>
                    </span>
                  </div>
                  <strong>Stok Numarasına Göre Stok</strong>
                  <div class="input-group mb-3">
                    <input
                      v-model="inputSearchInventoryByInventoryCode"
                      type="text"
                      class="form-control"
                    >
                    <span class="input-group-append">
                      <button
                        type="submit"
                        class="btn btn-danger"
                        @click="searchInventoryByInventoryCode"
                      >Ara</button>
                    </span>
                  </div>
                  <strong>Telefon Numarasına Göre</strong>
                  <div class="input-group mb-3">
                    <input
                      v-model="inputSearchCustomerByPhone"
                      type="text"
                      class="form-control"
                    >
                    <span class="input-group-append">
                      <button
                        type="submit"
                        class="btn btn-warning"
                        @click="searchCustomerByPhone"
                      >Ara</button>
                    </span>
                  </div>
                  <strong>TC'ye göre</strong>
                  <div class="input-group mb-3">
                    <input
                      v-model="inputSearchCustomerByIdentity"
                      type="text"
                      class="form-control"
                    >
                    <span class="input-group-append">
                      <button
                        type="submit"
                        class="btn btn-dark"
                        @click="searchCustomerByIdentity"
                      >Ara</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h5>{{ tableHeader }}</h5>
            </div>
            <div
              class="card-body table-responsive p-0"
              style="height: 430px;"
            >
              <table
                v-if="!isCustomerSearch"
                class="table table-head-fixed table-sm text-nowrap"
              >
                <thead>
                  <tr>
                    <th>GİRİŞ</th>
                    <th>KOD</th>
                    <th>AD SOYAD</th>
                    <th class="text-center">
                      TELEFON
                    </th>
                    <th class="text-center">
                      ADRES
                    </th>
                    <th class="text-center">
                      TC
                    </th>
                    <th>ÜRÜN</th>
                    <th>KİLO</th>
                    <th>ODA</th>
                    <th>RAF</th>
                    <th>GETİREN</th>
                    <th>PLANLANAN ÇIKIŞ</th>
                    <th>AKSİYON</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="inventory in inventories"
                    :key="inventory.id"
                  >
                    <td v-date-format>
                      {{ inventory.entry_date }}
                    </td>
                    <td>{{ inventory.code }}</td>
                    <td>{{ inventory.customer }}</td>
                    <td>{{ inventory.phone }}</td>
                    <td>{{ inventory.address }}</td>
                    <td>{{ inventory.identity_no }}</td>
                    <td>{{ inventory.product }} <span class="text-success text-bold">{{ inventory.description }}</span></td>
                    <td>
                      <span
                        v-amount-format
                        class="badge badge-warning"
                      >{{ inventory.amount }}</span>
                    </td>
                    <td>{{ inventory.room }}</td>
                    <td>{{ inventory.rack }}</td>
                    <td>{{ inventory.contact }}</td>
                    <td
                      v-date-format
                      class="text-center"
                    >
                      {{ inventory.expiration_date }}
                    </td>
                    <td>
                      <div class="btn-group">
                        <button
                          class="btn btn-xs btn-primary"
                          @click="showInventory(inventory.id)"
                        >
                          GÖSTER
                        </button>
                        <button
                          class="btn btn-xs btn-danger"
                          @click="drop(inventory.id)"
                        >
                          DÜŞÜR
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table
                v-else
                class="table table-head-fixed table-sm text-nowrap"
              >
                <thead>
                  <tr>
                    <th>AD SOYAD</th>
                    <th>TELEFON</th>
                    <th>ADRES</th>
                    <th>TC</th>
                    <th>AKSİYON</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="customer in customers"
                    :key="customer.id"
                  >
                    <td>{{ customer.full_name }}</td>
                    <td>{{ customer.phone }}</td>
                    <td>{{ customer.address }}</td>
                    <td>{{ customer.identity_no }}</td>
                    <td>
                      <div class="btn-group">
                        <button
                          class="btn btn-xs btn-success"
                          @click="newInventory(customer)"
                        >
                          YENİ STOK
                        </button>
                        <button
                          class="btn btn-xs btn-primary"
                          @click="showCustomer(customer)"
                        >
                          GÖSTER
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </template>
  </page>
</template>

<script>
import Page from '../../../commons/components/Page'
import { inject, ref } from 'vue'
import { getLastInventories } from '../../compositions/InventoryQuery'
import InventoryQueryService from '../../services/InventoryService'
import { useRouter } from 'vue-router'
import useDropOrBackInventory from '../../compositions/useDropOrBackInventory'
import CustomerService from '../../services/CustomerService'

export default {
  name: 'Start',
  components: { Page },
  setup (props) {
    const store = inject('customerStore')
    const router = useRouter()
    const { dropInventory } = useDropOrBackInventory(() => {})
    const tableHeader = ref('Son Yapılan Stok Kayıtları')

    const inventories = ref([])
    const customers = ref([])

    const inputSearchCustomerByFullName = ref('')
    const inputSearchCustomerByInventoryCode = ref('')
    const inputSearchInventoryByInventoryCode = ref('')
    const inputSearchCustomerByPhone = ref('')
    const inputSearchCustomerByIdentity = ref('')

    const isCustomerSearch = ref(false)

    async function getLastRecords () {
      inventories.value = await getLastInventories(15)
    }

    async function getLastCustomerRecords () {
      customers.value = await CustomerService.getLastRecords(20)
    }

    const drop = async (id) => {
      await dropInventory(id)
    }

    const showInventory = async (id) => {
      await router.push({ name: 'showInventory', params: { inventoryId: id } })
    }

    const showCustomer = async (customer) => {
      store.actions.setCustomer({ id: customer.id, name: customer.full_name, identity: customer.identity_no, phone: customer.phone, address: customer.address })
      await router.push({ name: 'showCustomer', params: { customerId: customer.id } })
    }

    const newInventory = async (customer) => {
      store.actions.setCustomer({ id: customer.id, name: customer.full_name, identity: customer.identity_no, phone: customer.phone, address: customer.address })
      await router.push({ name: 'newInventory', params: { customerId: customer.id } })
    }

    // Bu saçma yapı müşteri istediği için yazıldı
    const searchCustomerByFullName = async () => {
      isCustomerSearch.value = true
      if (inputSearchCustomerByFullName.value.length <= 0) {
        await getLastCustomerRecords()
        tableHeader.value = 'Son Yapılan Müşteri Kayıtları'
      } else {
        const searchOpts = { full_name: inputSearchCustomerByFullName.value }
        customers.value = await CustomerService.findBy(searchOpts)
        tableHeader.value = 'Arama sonuçları'
      }
    }

    const searchCustomerByPhone = async () => {
      isCustomerSearch.value = true
      if (inputSearchCustomerByPhone.value.length <= 0) {
        await getLastCustomerRecords()
        tableHeader.value = 'Son Yapılan Müşteri Kayıtları'
      } else {
        const searchOpts = { phone: inputSearchCustomerByPhone.value }
        customers.value = await CustomerService.findBy(searchOpts)
        tableHeader.value = 'Arama sonuçları'
      }
    }

    const searchCustomerByInventoryCode = async () => {
      isCustomerSearch.value = true
      if (inputSearchCustomerByInventoryCode.value.length <= 0) {
        await getLastCustomerRecords()
        tableHeader.value = 'Son Yapılan Müşteri Kayıtları'
      } else {
        const searchOpts = { inventory_code: inputSearchCustomerByInventoryCode.value }
        customers.value = await CustomerService.findBy(searchOpts)
        tableHeader.value = 'Arama sonuçları'
      }
    }

    const searchCustomerByIdentity = async () => {
      isCustomerSearch.value = true
      if (inputSearchCustomerByIdentity.value.length <= 0) {
        await getLastCustomerRecords()
        tableHeader.value = 'Son Yapılan Müşteri Kayıtları'
      } else {
        const searchOpts = { identity_no: inputSearchCustomerByIdentity.value }
        customers.value = await CustomerService.findBy(searchOpts)
        tableHeader.value = 'Arama sonuçları'
      }
    }

    const searchInventoryByInventoryCode = async () => {
      isCustomerSearch.value = false
      if (inputSearchInventoryByInventoryCode.value.length <= 0) {
        await getLastRecords()
        tableHeader.value = 'Son Yapılan Stok Kayıtları'
      } else {
        const searchOpts = { code: inputSearchInventoryByInventoryCode.value }
        inventories.value = await InventoryQueryService.findBy(searchOpts)
        tableHeader.value = 'Arama sonuçları'
      }
    }

    getLastRecords()
    return {
      inputSearchCustomerByFullName,
      searchCustomerByFullName,
      inputSearchCustomerByIdentity,
      searchCustomerByIdentity,
      inputSearchCustomerByInventoryCode,
      searchCustomerByInventoryCode,
      inputSearchInventoryByInventoryCode,
      searchInventoryByInventoryCode,
      inputSearchCustomerByPhone,
      searchCustomerByPhone,
      isCustomerSearch,
      customers,
      inventories,
      tableHeader,
      drop,
      showInventory,
      showCustomer,
      newInventory
    }
  }
}
</script>

<style >

</style>
