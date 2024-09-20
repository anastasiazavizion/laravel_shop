<script setup>
import Navbar from "@/Layouts/Navbar.vue";
</script>
<template>
    <div>
        <div class="min-h-screen">
           <Navbar/>
            <main class="container mx-auto p-4 max-w-7xl">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
