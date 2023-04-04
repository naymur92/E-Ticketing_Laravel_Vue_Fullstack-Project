<template>
  <div>
    <form @submit.prevent="searchTrain">
      <div class="row my-2">
        <div class="col-6">
          <div class="form-group">
            <label for="_from"><strong>From</strong></label>
            <v-select
              id="_from"
              :options="from_stations"
              :class="[errors.from ? 'is-invalid' : '']"
              v-model="from_st"
              @update:modelValue="getToStations"
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
              :options="to_stations"
              :class="[errors.to ? 'is-invalid' : '']"
              v-model="to_st"
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

<script>
import axios from "axios";
import { useSearchStore } from "../stores/searchTrain";

export default {
  setup() {
    const searchStore = useSearchStore();
    return { searchStore };
  },
  data() {
    return {
      loading: true,
      from_stations: [],
      to_stations: [],
      from_st: { code: null },
      to_st: { code: null },
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
      // console.log(res.data);
    });

    this.getNow();
  },
  methods: {
    searchTrain() {
      // clear form error
      document.getElementById("_doj-wrapper").classList.remove("is-invalid");

      axios
        .post("/search-train", {
          from: this.from_st.code,
          to: this.to_st.code,
          doj: this.doj,
        })
        .then((res) => {
          // console.log(res.data);
          this.searchStore.setSearchResult(res.data);
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
      // console.log(this.from_st);
      if (this.from_st != null) {
        axios.get("/to-stations/" + this.from_st.code).then((res) => {
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
