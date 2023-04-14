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
                    class="shadow"
                    :class="activeBogi == bogi.id ? 'active' : ''"
                    @click="getSeats(bogi.id)"
                  >
                    {{ bogi.bogi_name }}
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <ul class="seat-list">
                  <li
                    class="rounded shadow"
                    v-for="seat in seats"
                    :key="seat.id"
                    :class="setClassNamesToSeats(seat)"
                    @click="bookSeat($event, seat)"
                  >
                    {{ seat.seat_name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div
              class="card shadow m-0 p-0 mt-2"
              v-if="selected_seats.length != 0"
            >
              <div class="card-header">
                <h4 class="text-center">Selected Seats</h4>
              </div>
              <div class="card-body">
                <span
                  class="badge bg-primary"
                  style="margin-right: 3px"
                  v-for="(item, i) in selected_seats"
                  :key="i"
                  >{{ item }}</span
                >
              </div>
            </div>
            <div class="card shadow m-0 p-0">
              <div class="card-header">
                <h4 class="text-center">Train Information</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th>From</th>
                    <td>{{ train_details.from }}</td>
                  </tr>
                  <tr>
                    <th>To</th>
                    <td>{{ train_details.to }}</td>
                  </tr>
                  <tr>
                    <th>Left At</th>
                    <td>{{ train_details.left_at }}</td>
                  </tr>
                  <tr>
                    <th>Reach At</th>
                    <td>{{ train_details.reach_at }}</td>
                  </tr>
                  <tr>
                    <th>Total Time</th>
                    <td>{{ train_details.total_time }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="card shadow m-0 p-0 mt-2">
              <div class="card-header">
                <h4 class="text-center">Available Seats</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <tr v-for="(av_seats, key) in available_seats" :key="key">
                    <th>{{ key }}</th>
                    <td>{{ av_seats }}</td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="card shadow m-0 p-0 mt-2">
              <div class="card-header">
                <h4 class="text-center">Price List</h4>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <tr v-for="(item, index) in price_details" :key="index">
                    <th>{{ item[0] }}</th>
                    <td>{{ item[1] }}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-between">
        <router-link to="/" class="btn btn-warning">Search Again</router-link>
        <button
          @click="confirmBooking"
          class="btn btn-success"
          :disabled="selected_seats.length == 0"
        >
          Confirm Booking
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { useBookingTrain } from "../stores/booking";

import axios from "axios";
export default {
  setup() {
    const bookTrain = useBookingTrain();
    return { bookTrain };
  },
  props: ["auth"],
  data() {
    return {
      train: [],
      bogis: [],
      activeBogi: null,
      seats: [],
      seat_ranges: [],
      train_details: [],
      price_details: [],
      available_seats: [],
      selected_seats: [],
    };
  },
  beforeMount() {
    // this.bookTrain.schedule_id = 31;
    // check auth
    if (this.auth.length == 0) {
      this.$swal({ icon: "error", text: "Please login first!" });
      window.location.href = "/login";
      return;
    }

    // check user
    if (this.auth.is_admin == "admin") {
      this.$swal({ icon: "error", text: "Please login as a user" });

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

    // get train details
    this.getTrainDetails();
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
    async getTrainDetails() {
      await axios
        .get("/get-train-details-for-booking/" + this.bookTrain.schedule_id)
        .then((res) => {
          this.seat_ranges = res.data[0].seat_ranges;
          this.train_details = res.data[0].train_details;
          this.available_seats = res.data[0].available_seats;

          // filter prices greater than zero
          let price_list = Object.keys(res.data[0].price_details).map((key) => [
            key,
            res.data[0].price_details[key],
          ]);

          for (let i = 0; i < price_list.length; i++) {
            if (price_list[i][1] > 0) {
              this.price_details.push(price_list[i]);
            }
          }
        });
    },
    setClassNamesToSeats(seat) {
      let bogi_name = seat.seat_name.split("-")[0];
      let seat_sl = Number(seat.seat_name.split("-")[1]);

      // check selected seat
      if (this.selected_seats.includes(seat.seat_name)) {
        return "selected";
      }

      // set unavailable class
      if (
        seat_sl < Number(this.seat_ranges[bogi_name].start_seat) ||
        seat_sl > Number(this.seat_ranges[bogi_name].end_seat)
      ) {
        return "unavailable";
      } else {
        // set available or booked class
        if (seat.booked == 0) {
          return "available";
        } else {
          return "booked";
        }
      }
    },
    async bookSeat($event, seat) {
      // book seat
      if ($event.target.classList.contains("available")) {
        // check maximum seats and send error
        if (this.selected_seats.length == 4) {
          this.$swal({ icon: "error", text: "Maximum seat selection is 4!" });
          return;
        }

        await axios.post("/book-seat/" + seat.id).then((res) => {
          this.selected_seats.push(seat.seat_name);

          $event.target.classList.remove("available");
          $event.target.classList.add("selected");
        });

        return;
      }

      // remove from booking
      if ($event.target.classList.contains("selected")) {
        await axios.post("/book-seat/" + seat.id).then((res) => {
          this.selected_seats = this.selected_seats.filter(
            (seat_name) => seat_name != seat.seat_name
          );

          $event.target.classList.remove("selected");
          $event.target.classList.add("available");
        });

        return;
      }
    },
    async confirmBooking() {
      this.$swal({ icon: "error", text: "The project is under development!" });
    },
  },
};
</script>
<style>
ul.bogi-list {
  display: flex;
  flex-wrap: wrap;
  list-style-type: none;
  padding: 0;
  margin: 0;
}
.bogi-list li {
  cursor: pointer;
  background: #e6faff;
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
  background: #92fbff;
  color: black;
}

.seat-list {
  list-style-type: none;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 10px 5px;
  padding: 10px;
  margin: 0;
  font-size: 0.65em;
  font-weight: 600 !important;
  text-align: center;
  position: relative;
}

.seat-list li:nth-child(5n + 2) {
  margin-right: 40px !important;
}

.seat-list li {
  width: calc(20% - 13px);
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.seat-list li.unavailable {
  background: #ddd;
  cursor: not-allowed;
  color: red;
  box-shadow: none !important;
}
.seat-list li.available {
  background: #92e3f7;
  cursor: pointer;
}
.seat-list li.selected {
  background: #033fc2;
  color: white;
  cursor: pointer;
}
.seat-list li.booked {
  background: #f792a3;
  cursor: not-allowed;
  box-shadow: none !important;
}
</style>