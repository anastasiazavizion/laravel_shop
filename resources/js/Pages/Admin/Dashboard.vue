<script setup>
import {computed, nextTick, onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import loadTelegramWidget from "@/hooks/telegramWidget.js";
import OrdersAmountByProducts from "@/Pages/Admin/Partials/OrdersAmountByProducts.vue";
import OrdersAmountByCities from "@/Pages/Admin/Partials/OrdersAmountByCities.vue";
import OrdersAmountByStatuses from "@/Pages/Admin/Partials/OrdersAmountByStatuses.vue";
import OrdersAmountByCategories from "@/Pages/Admin/Partials/OrdersAmountByCategories.vue";
import {Tab, TabGroup, TabList, TabPanel, TabPanels} from "@headlessui/vue";
const store = useStore();

const user = ref(null);
const allOrdersAmount = ref(null);
const allProductsAmount = ref(null);
const allUsersAmount = ref(null);
const ordersTotal = ref(0);

onMounted(async () => {
    await store.dispatch('user/getUser');
    user.value = await computed(()=>{
        return store.getters['user/user'];
    })

    await nextTick();
    loadTelegramWidget();

    await store.dispatch('order/allOrdersAmount');
    allOrdersAmount.value = await computed(()=>{
        return store.getters['order/allOrdersAmount'];
    })

    await store.dispatch('product_admin/allProductsAmount');
    allProductsAmount.value = await computed(()=>{
        return store.getters['product_admin/allProductsAmount'];
    })

    await store.dispatch('admin_users/allUsersAmount');
    allUsersAmount.value = await computed(()=>{
        return store.getters['admin_users/allUsersAmount'];
    })

    await store.dispatch('admin_charts/ordersTotal');
    ordersTotal.value = await computed(()=>{
        return store.getters['admin_charts/ordersTotal'];
    })

})

const tabs = ref([
    {name:'Statistic', active:true},
    {name:'Map', active: false},
]);

const activePaymentType = ref()

function setActiveTab(tab){
    activePaymentType.value = tab.name;
}

</script>

<template>
    <Header>Admin panel</Header>
    <div v-if="is('admin') && (user && !user.telegram_id)" id="telegram-widget-container"></div>

    <TabGroup>
        <TabList class="text-center grid grid-cols-2 mt-8 gap-8">
            <Tab  class="tab"
                  @click="setActiveTab(tab)"
                  :class="[activePaymentType === tab.name ? 'active-tab' : '']"
                 :key="tab.name"
                 v-for="tab in tabs">
                 {{ tab.name }}
            </Tab>
        </TabList>

        <TabPanels class="mt-4 min-h-40 sm:min-h-80">
            <div>
                <TabPanel  :key="tab.name"
                           v-for="tab in tabs">

                    <div v-if="tab.name === 'Statistic'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                            <div class="adminCard">
                                <div class="text-base absolute left-5 top-5 font-normal">Orders</div>
                                <span>{{allOrdersAmount}}</span>
                            </div>

                            <div class="adminCard">
                                <div class="text-base absolute left-5 top-5 font-normal">Products</div>
                                <span>{{allProductsAmount}}</span>
                            </div>

                            <div class="adminCard">
                                <div class="text-base absolute left-5 top-5 font-normal">Users</div>
                                <span>{{allUsersAmount}}</span>
                            </div>

                            <div class="adminCard">
                                <div class="text-base absolute left-5 top-5 font-normal">Paid Orders Income</div>
                                <span>{{ordersTotal}}$</span>
                            </div>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                            <div>
                                <OrdersAmountByProducts/>
                            </div>

                            <div>
                                <OrdersAmountByCities/>
                            </div>

                            <div>
                                <OrdersAmountByStatuses/>
                            </div>

                            <div>
                                <OrdersAmountByCategories/>
                            </div>

                        </div>
                    </div>

                    <div v-if="tab.name === 'Map'">

                        Map
                    </div>

                </TabPanel>
            </div>

        </TabPanels>
    </TabGroup>





</template>
