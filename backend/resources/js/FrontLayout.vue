<script setup>
import Navbar from "./Components/Navbar.vue";
import Footer from "./Components/Footer.vue";
</script>
<template>
  <div>
    <!-- navbar -->
    <Navbar />
    <!-- Contant Area -->
    <router-view></router-view>

    <!-- Footer -->
    <Footer />
  </div>
</template>
<script>
export default {};
</script>
<style>
</style>