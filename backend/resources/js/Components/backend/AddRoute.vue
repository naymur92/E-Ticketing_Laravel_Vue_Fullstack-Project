<script setup>
import axios from "axios";
</script>
<template>
  <form @submit.prevent="addRoute()">
    <div class="card-body">
      <!-- Train Name section -->
      <div class="form-group">
        <label for="_route_name"><strong>Select Root Train:</strong></label>
        <v-select
          id="_route_name"
          v-model="route_id"
          :options="train_lists"
        ></v-select>
      </div>

      <div class="row mb-3">
        <div class="col-2"><strong>Station SL.</strong></div>
        <div class="col-5"><strong>Station Name</strong></div>
        <div class="col-5"><strong>Time From Previous Station</strong></div>
      </div>

      <div class="row my-2" v-for="route in routes" :key="route.sl_no">
        <div class="col-2">Station {{ route.sl_no }}</div>
        <div class="col-5">
          <v-select v-model="route.station_id" :options="stations"></v-select>
        </div>
        <div class="col-5">
          <VueCtkDateTimePicker
            only-time
            no-button-now
            format="HH:mm"
            formatted="HH:mm"
            input-size="lg"
            no-label="true"
            disabled-hours="['12','13','14','15','16','17','18','19','20','21','22','23']"
            label="Select Time"
            v-model="route.time_from_prev_station"
          />
        </div>
      </div>
      <div class="d-flex justify-content-end mt-2">
        <button
          type="button"
          @click="addField()"
          class="btn btn-outline-primary"
        >
          Add New Field
        </button>
      </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
      <input
        type="submit"
        value="SUBMIT"
        class="btn btn-success"
        :disabled="route_id == null"
      />
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      sl_no: 1,
      stations: [],
      train_lists: [],
      route_id: null,
      routes: [{ sl_no: 1, station_id: null, time_from_prev_station: "" }],
    };
  },
  methods: {
    addField() {
      this.routes.push({
        sl_no: ++this.sl_no,
        station_id: null,
        time_from_prev_station: "",
      });
    },
    addRoute() {
      axios
        .post("/admin/routes", {
          route_id: this.route_id,
          routes: this.routes,
        })
        .then((res) => {
          if (res.data.success) {
            window.location.href = "/admin/routes";
          }
        });
    },
  },
  mounted() {
    axios.get("/admin/root-stations").then((res) => {
      this.stations = res.data.stations;
      this.train_lists = res.data.train_lists;
    });
  },
};
</script>
<style>
</style>