<template>
  <div>
    <!-- navbar -->
    <Navbar :auth="auth" />
    <!-- Contant Area -->
    <router-view :auth="auth"></router-view>

    <!-- Footer -->
    <Footer />
  </div>
</template>
<script>
import Navbar from "./Components/Navbar.vue";
import Footer from "./Components/Footer.vue";

export default {
  components: {
    Navbar,
    Footer,
  },
  props: ["auth"],
};
</script>
<style>
</style>