<template>
  <div class="container">
    <h2 class="text-center mt-4">Train Booking</h2>
    {{ bookTrain.schedule_id }}
  </div>
</template>
<script setup>
import { useBookingTrain } from "../stores/booking";

const bookTrain = useBookingTrain();
</script>
<script>
export default {
  data() {
    return {
      schedule: [],
    };
  },
  mounted() {
    if (this.bookTrain.schedule_id == null) {
      this.$router.push({
        name: "home",
      });
    }
  },
};
</script>
<style>
</style>