<template>
  <div class="container">
    <h2 class="text-center mt-4">Train Booking</h2>
    <div class="card mt-4">
      <div class="card-header bg-info">
        <h3 class="text-center">{{ train.name }}</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="card shadow m-0 p-0">
              <div class="card-header">
                <ul class="bogi-list">
                  <li
                    v-for="bogi in bogis"
                    :key="bogi.id"
                    :class="activeBogi == bogi.id ? 'active' : ''"
                  >
                    <span @click="getSeats(bogi.id)">
                      {{ bogi.bogi_name }}
                    </span>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <ul class="seat-list">
                  <li v-for="seat in seats" :key="seat.id">
                    {{ seat.seat_name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6"></div>
        </div>
      </div>
      <div class="card-footer">
        <router-link to="/" class="btn btn-warning float-end"
          >Search Again</router-link
        >
      </div>
    </div>
  </div>
</template>
<script setup>
import { useBookingTrain } from "../stores/booking";

const bookTrain = useBookingTrain();
</script>
<script>
import axios from "axios";
export default {
  props: ["auth"],
  data() {
    return {
      train: [],
      bogis: [],
      activeBogi: null,
      seats: [],
      seat_ranges: [],
    };
  },
  beforeMount() {
    this.bookTrain.schedule_id = 31;
    // check auth
    if (this.auth.length == 0) {
      alert("Please login first!");
      window.location.href = "/login";
      return;
    }

    // check user
    if (this.auth.is_admin == "admin") {
      alert("Please login as a user");

      this.$router.push({
        name: "home",
      });
      return;
    }
  },
  mounted() {
    if (this.bookTrain.schedule_id == null) {
      this.$router.push({
        name: "home",
      });
      return;
    }
    // get booking info
    this.getBookingDetails();
  },
  methods: {
    async getBookingDetails() {
      await axios
        .get("/get-booking-details/" + this.bookTrain.schedule_id)
        .then((res) => {
          this.train = res.data[0].train;
          this.bogis = res.data[0].train.bogis;
          // console.log(this.bogis[0].id);
        });
      // get first seats of first bogi
      this.activeBogi = this.bogis[0].id;
      await this.getSeats(this.activeBogi);
    },
    getSeats(bogi_id) {
      this.activeBogi = bogi_id;
      axios.get("/get-seats/" + bogi_id).then((res) => {
        this.seats = res.data;
        // console.log(res.data);
      });
    },
  },
};
</script>
<style>
ul.bogi-list,
ul.seat-list {
  display: flex;
  flex-wrap: wrap;
  list-style-type: none;
  padding: 0;
  margin: 0;
}
.bogi-list li {
  cursor: pointer;
  background: #ddd;
  width: 50px;
  height: 35px;
  border-radius: 5px;
  margin-left: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: 0.3s all;
}
.bogi-list li.active {
  background: #0d6efd;
  color: white;
}
.bogi-list li:first-child {
  margin-left: 0;
}
.bogi-list li:hover {
  background: #8f8d8d;
}

.seat-list li {
  cursor: pointer;
  background: #ddd;
  width: 50px;
  border-radius: 5px;
  margin: 10px;
  text-align: center;
  padding: 5px 0px;
  transition: 0.3s all;
}
</style>