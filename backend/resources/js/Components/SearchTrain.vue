<template>
  <div>
    <form @submit.prevent="searchTrain()">
      <div class="row my-2">
        <div class="col-6">
          <div class="form-group">
            <label for="_from"><strong>From</strong></label>
            <v-select
              id="_from"
              v-model="from"
              :options="from_stations"
              @update:modelValue="getToStations()"
            ></v-select>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="_to"><strong>To</strong></label>
            <v-select id="_to" v-model="to" :options="to_stations"></v-select>
          </div>
        </div>
      </div>
      <div class="row my-2">
        <div class="col-6">
          <div class="form-group">
            <label for="_doj"><strong>Date of Journey</strong></label>
            <VueCtkDateTimePicker
              only-date
              no-button-now
              format="YYYY-MM-DD"
              formatted="YYYY-MM-DD"
              input-size="lg"
              label="Select Date"
              no-label="true"
              auto-close="true"
              :min-date="current_date"
              id="_doj"
              v-model="doj"
            />
          </div>
        </div>
      </div>
      <input
        type="submit"
        value="Search Train"
        class="btn btn-success form-control"
      />
    </form>

    <!-- search result -->
    <div class="card mt-5" v-if="search">
      <div v-if="searchStore.searchResult.length == 0" class="p-2">
        <h3>No Result Found</h3>
      </div>
    </div>
  </div>
</template>
<script setup>
import { useSearchStore } from "../stores/search";

const searchStore = useSearchStore();
</script>
<script>
import axios from "axios";
export default {
  data() {
    return {
      loading: true,
      from_stations: [],
      to_stations: [],
      from: null,
      to: null,
      doj: "",
      errors: {},
      current_date: "",
      search: false,
    };
  },
  mounted() {
    axios.get("/from-stations").then((res) => {
      this.from_stations = res.data;
      this.loading = false;
    });

    this.getNow();
  },
  methods: {
    searchTrain() {
      axios
        .post("/search-train", {
          from: this.from.code,
          to: this.to.code,
          doj: this.doj,
        })
        .then((res) => {
          // console.log(res.data);
          this.searchStore.searchResult = res.data;
          this.search = true;

          if (res.data.length > 0) {
            this.$router.push({
              name: "searchresult",
            });
          }
        });
      // alert(this.from);
    },
    getToStations() {
      if (this.from.code != null) {
        axios.get("/to-stations/" + this.from.code).then((res) => {
          this.to_stations = res.data;
          // console.log(res.data);
        });
      }
    },
    // get date
    getNow: function () {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      // const time =
      //   today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      // const dateTime = date + " " + time;
      this.current_date = date;
    },
  },
};
</script>
<style>
</style>