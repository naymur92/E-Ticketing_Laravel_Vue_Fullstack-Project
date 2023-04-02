<template>
  <div class="container search-result">
    <div class="card-header mt-4">
      <h2 class="text-center">Search Result</h2>
    </div>
    <div
      class="card shadow my-5"
      v-for="result in searchStore.searchResult"
      :key="result.train_id"
    >
      <div class="card-header d-flex justify-content-between">
        <h5>{{ result.train_name }}</h5>
        <span>{{ result.from }} - {{ result.to }}</span>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-4">
            <p><strong>Left At</strong></p>
            <p>{{ result.left_at }}</p>
          </div>
          <div class="col-4 text-center">
            <p><strong>Reach At</strong></p>
            <p>{{ result.reach_at }}</p>
          </div>
          <div class="col-4" style="text-align: right">
            <p><strong>Total Time</strong></p>
            <p>{{ result.total_time }}</p>
          </div>
        </div>
        <hr />

        <div class="row align-items-center justify-content-between">
          <div class="col-6">
            <h5>Seats Available</h5>
            <table class="table table-responsive table-striped table-hover">
              <tr>
                <th>Seat Type</th>
                <th>Total Seats</th>
              </tr>
              <tr v-for="(item, key) in result.seats" :key="item">
                <td>{{ key }}</td>
                <td>{{ item }}</td>
              </tr>
            </table>
          </div>
          <div class="col-2" style="text-align: right">
            <router-link
              to="/book"
              @click="setScheduleId(result.id)"
              class="btn btn-warning"
              >Book Now</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { useSearchStore } from "../stores/search";
import { useBookingTrain } from "../stores/booking";

const searchStore = useSearchStore();
const bookTrain = useBookingTrain();
</script>
<script>
export default {
  data() {
    return {};
  },
  methods: {
    setScheduleId(id) {
      this.bookTrain.schedule_id = id;
    },
  },
  mounted() {
    if (this.searchStore.searchResult.length == 0) {
      this.$router.push({
        name: "home",
      });
    }
  },
};
</script>
<style>
.search-result {
  min-height: 600px;
}
</style>