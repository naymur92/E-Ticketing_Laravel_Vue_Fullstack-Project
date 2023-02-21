<template>
  <div>
    <form v-if="!loading" @submit.prevent="addTrain" method="post">
      <div class="card-body">
        <div class="form-group my-2">
          <label for="_name"><strong>Train Name:</strong></label>
          <input
            type="text"
            v-model="name"
            id="_name"
            placeholder="Enter train name"
            class="form-control"
          />

          <ul v-if="errors.name" class="alert alert-warning my-2">
            <li v-for="(err, index) in errors.name" :key="index">
              {{ err }}
            </li>
          </ul>
        </div>

        <div class="form-group my-2">
          <label for="_home_station"><strong>Home Station:</strong></label>

          <v-select
            id="_home_station"
            v-model="home_station_id"
            :options="stations"
          ></v-select>

          <ul v-if="errors.home_station_id" class="alert alert-warning my-2">
            <li v-for="(err, index) in errors.home_station_id" :key="index">
              {{ err }}
            </li>
          </ul>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group my-2">
              <label for="_date"><strong>Train Date:</strong></label>
              <VueCtkDateTimePicker
                only-date
                no-button-now
                format="YYYY-MM-DD"
                formatted="YYYY-MM-DD"
                input-size="lg"
                label="Select Date"
                auto-close="true"
                id="_date"
                v-model="date"
              />

              <ul v-if="errors.date" class="alert alert-warning my-2">
                <li v-for="(err, index) in errors.date" :key="index">
                  {{ err }}
                </li>
              </ul>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group my-2">
              <label for="_start_time"><strong>Start Time:</strong></label>
              <VueCtkDateTimePicker
                only-time
                no-button-now
                format="HH:mm"
                formatted="hh:mm a"
                input-size="lg"
                label="Select Time"
                id="_start_time"
                v-model="start_time"
              />
              <ul v-if="errors.start_time" class="alert alert-warning my-2">
                <li v-for="(err, index) in errors.start_time" :key="index">
                  {{ err }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <input
          type="submit"
          value="Add Train"
          class="btn btn-outline-primary"
        />
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "AddTrain",
  data() {
    return {
      name: "",
      date: "",
      home_station_id: "",
      start_time: "",
      stations: [],
      loading: true,
      errors: {},
    };
  },
  mounted() {
    axios.get("/list-stations").then((res) => {
      this.stations = res.data;
      this.loading = false;
    });
  },
  methods: {
    addTrain() {
      // console.log(this.home_station_id.code);
      axios
        .post("/trains", {
          name: this.name,
          date: this.date,
          home_station_id: this.home_station_id.code,
          start_time: this.start_time,
        })
        .then((res) => {
          if (res.data.success) {
            console.log(res.data.msg);
            window.location.href = "/trains";
          }
        })
        .catch((err) => {
          // console.log(err.response.data.errors);
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
