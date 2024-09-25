<script setup>
import Navbar from "@/Layouts/Navbar.vue";
import Footer from "@/Layouts/Footer.vue";
</script>
<template>
    <div>
        <div class="min-h-screen flex flex-col">
           <Navbar/>
            <main class="container default-component flex-grow">
                <router-view></router-view>
            </main>
            <Footer/>
        </div>
    </div>
</template>
