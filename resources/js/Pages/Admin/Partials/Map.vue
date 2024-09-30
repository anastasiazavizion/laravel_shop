<script setup>
import {GoogleMap, InfoWindow, Marker, MarkerCluster} from "vue3-google-map";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";

const store = useStore();

onMounted(async () => {
    await store.dispatch('map/getCoordinates');

})
function calculateCenter(coordinates) {
    if (coordinates.length === 0) {
        return {lat: 0, lng: 0};
    }
    let sumLat = 0;
    let sumLng = 0;
    for (const coordinate of coordinates) {
        sumLat += coordinate.lat;
        sumLng += coordinate.lng;
    }
    const avgLat = sumLat / coordinates.length;
    const avgLng = sumLng / coordinates.length;
    return {lat: avgLat, lng: avgLng};
}

let currentInfoWindow = null;
function openInfoWindow(i) {
    if (currentInfoWindow !== null) {
        currentInfoWindow.value = false;
    }
    currentInfoWindow = infoWindows.value[i];
    currentInfoWindow.value = true;
}

const apiKey = import.meta.env.VITE_GOOGLE_API_KEY;

const coordinates = computed(() => {
    return store.getters['map/coordinates'];
})

const center = computed(() => {
    return calculateCenter(coordinates.value)
});

const infoWindows = computed(() => {
    return coordinates.value.map(() => ref(false));
});
</script>

<template>
    <GoogleMap
        :api-key="apiKey"
        style="width: 100%; height: 600px"
        :center="center"
        :zoom="3"
    >
        <MarkerCluster>
            <Marker
                v-for="(coordinate, i) in coordinates"
                :key="i"
                :options="{ position: coordinate }"
                @click="openInfoWindow(i)"
            >
                <InfoWindow v-model="infoWindows[i].value">
                    <div class="info-window">
                        <div>Address</div>
                        <div>{{ coordinate.order.address }}</div>

                        <div>City</div>
                        <div>{{ coordinate.order.city }}</div>

                        <div>Name</div>
                        <div>{{ coordinate.order.name }}</div>

                        <div>Lastname</div>
                        <div>{{ coordinate.order.lastname }}</div>

                        <div>Phone</div>
                        <div>{{ coordinate.order.phone }}</div>

                        <div>Email</div>
                        <div>{{ coordinate.order.email }}</div>

                        <div>Total</div>
                        <div>{{ coordinate.order.total }}</div>

                    </div>
                </InfoWindow>
            </Marker>
        </MarkerCluster>
    </GoogleMap>
</template>
