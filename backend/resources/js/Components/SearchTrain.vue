<template>
  <div>
    <form @submit.prevent="searchTrain">
      <div class="row my-2">
        <div class="col-6">
          <div class="form-group">
            <label for="_from"><strong>From</strong></label>
            <v-select
              id="_from"
              v-model="from"
              :options="from_stations"
              @update:modelValue="getToStations()"
              :class="[errors.from ? 'is-invalid' : '']"
            ></v-select>

            <span
              v-for="(err, index) in errors.from"
              :key="index"
              class="invalid-feedback"
              role="alert"
            >
              <strong>{{ err }}</strong>
            </span>
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
            <label for="_to"><strong>To</strong></label>
            <v-select
              id="_to"
              v-model="to"
              :options="to_stations"
              :class="[errors.to ? 'is-invalid' : '']"
            ></v-select>

            <span
              v-for="(err, index) in errors.to"
              :key="index"
              class="invalid-feedback"
              role="alert"
            >
              <strong>{{ err }}</strong>
            </span>
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

            <span
              v-for="(err, index) in errors.doj"
              :key="index"
              class="invalid-feedback"
              role="alert"
            >
              <strong>{{ err }}</strong>
            </span>
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
      from: { code: null },
      to: { code: null },
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
      // clear form error
      document.getElementById("_doj-wrapper").classList.remove("is-invalid");

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
        })
        .catch((err) => {
          // console.log(err.response.data.errors);
          this.errors = err.response.data.errors;

          // set errors in input fields
          if (this.errors.doj) {
            document.getElementById("_doj-wrapper").classList.add("is-invalid");
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
.is-invalid,
.was-validated .form-control:invalid {
  border: 1px solid;
  border-radius: 5px;
  border-color: #e74a3b;
  padding-right: calc(1.5em + 0.75rem);
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23e74a3b' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23e74a3b' stroke='none'/%3e%3c/svg%3e");
  background-repeat: no-repeat;
  background-position: right calc(0.375em + 0.1875rem) center;
  background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
</style>