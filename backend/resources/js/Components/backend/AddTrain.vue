<template>
  <div>
    <form v-if="!loading" @submit.prevent="addTrain" method="post">
      <div class="card-body">
        <!-- Train info -->
        <fieldset>
          <legend><strong>Train Info</strong></legend>
          <div class="row">
            <div class="col-4">
              <div class="form-group my-2">
                <label for="_route_id"><strong>Train Name:</strong></label>
                <v-select
                  id="_route_id"
                  v-model="route_id"
                  :options="root_trains"
                  @update:modelValue="getTrainInfo()"
                  :class="[errors.name ? 'is-invalid' : '']"
                ></v-select>

                <span
                  v-for="(err, index) in errors.name"
                  :key="index"
                  class="invalid-feedback"
                  role="alert"
                >
                  <strong>{{ err }}</strong>
                </span>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group my-2">
                <label for="_journey_date"><strong>Train Date:</strong></label>
                <VueCtkDateTimePicker
                  only-date
                  no-button-now
                  format="YYYY-MM-DD"
                  formatted="YYYY-MM-DD"
                  label="Select Train Date"
                  input-size="lg"
                  no-label="true"
                  :min-date="current_date"
                  id="_journey_date"
                  v-model="journey_date"
                  :disabled-weekly="off_day"
                />

                <span
                  v-for="(err, index) in errors.journey_date"
                  :key="index"
                  class="invalid-feedback"
                  role="alert"
                >
                  <strong>{{ err }}</strong>
                </span>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group my-2">
                <label for="_journey_time"><strong>Train Time:</strong></label>
                <VueCtkDateTimePicker
                  only-time
                  no-button-now
                  format="HH:mm"
                  formatted="hh:mm a"
                  label="Select Train Time"
                  input-size="lg"
                  no-label="true"
                  :min-date="current_date"
                  id="_journey_time"
                  v-model="journey_time"
                />

                <span
                  v-for="(err, index) in errors.journey_time"
                  :key="index"
                  class="invalid-feedback"
                  role="alert"
                >
                  <strong>{{ err }}</strong>
                </span>
              </div>
            </div>

            <!-- Error lists -->
          </div>
        </fieldset>

        <!-- multiple add -->
        <fieldset>
          <legend><strong>Multiple Add</strong></legend>
          <div class="row">
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_start_date"><strong>Start Date:</strong></label>
                <VueCtkDateTimePicker
                  only-date
                  no-button-now
                  format="YYYY-MM-DD"
                  formatted="YYYY-MM-DD"
                  label="Select Start Date"
                  input-size="lg"
                  :min-date="current_date"
                  no-label="true"
                  id="_start_date"
                  v-model="start_date"
                />
              </div>
            </div>
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_end_date"><strong>End Date:</strong></label>
                <VueCtkDateTimePicker
                  only-date
                  no-button-now
                  format="YYYY-MM-DD"
                  formatted="YYYY-MM-DD"
                  label="Select End Date"
                  input-size="lg"
                  no-label="true"
                  id="_end_date"
                  v-model="end_date"
                />
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Bogi info -->
        <fieldset>
          <legend><strong>Bogi Info</strong></legend>
          <div class="row" v-for="(bogi, index) in bogis" :key="index">
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_bogi_type"
                  ><strong>Select Bogi Type:</strong></label
                >
                <v-select
                  id="_bogi_type"
                  v-model="bogi.bogi_type_id"
                  :options="bogi_types"
                ></v-select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_bogi_name"><strong>Bogi Name:</strong></label>
                <input
                  type="text"
                  v-model="bogi.bogi_name"
                  placeholder="Enter Bogi Name"
                  class="form-control"
                />
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" @click="addField()" class="btn btn-success">
              Add More Bogi
            </button>
          </div>
        </fieldset>
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
import axios from "axios";
export default {
  name: "AddTrain",
  data() {
    return {
      name: "",
      journey_date: "",
      journey_time: "",
      off_day: [],
      route_id: "",
      root_trains: [],
      bogi_types: [],
      bogis: [
        {
          bogi_type_id: "",
          bogi_name: "",
        },
      ],
      loading: true,
      errors: {},
      start_date: "",
      end_date: "",
      current_date: "",
    };
  },
  mounted() {
    axios.get("/admin/root-trains").then((res) => {
      this.root_trains = res.data;
      this.loading = false;
    });

    axios.get("/admin/bogi-types-list").then((res) => {
      this.bogi_types = res.data;
    });

    this.getNow();
  },
  methods: {
    addTrain() {
      // clear form error
      document
        .getElementById("_journey_date-wrapper")
        .classList.remove("is-invalid");
      document
        .getElementById("_journey_time-wrapper")
        .classList.remove("is-invalid");

      axios
        .post("/admin/trains", {
          name: this.name,
          journey_date: this.journey_date,
          journey_time: this.journey_time,
          route_id: this.route_id.code,
          off_day: this.off_day[0],
          start_date: this.start_date,
          end_date: this.end_date,
          bogis: this.bogis,
        })
        .then((res) => {
          // console.log(res.data);
          if (res.data.success) {
            // console.log(res.data.msg);
            window.location.href = "/admin/trains";
          } else {
            alert(res.data.msg);
          }
        })
        .catch((err) => {
          // console.log(err.response.data.errors);
          this.errors = err.response.data.errors;

          // set errors in input fields
          if (this.errors.journey_date) {
            document
              .getElementById("_journey_date-wrapper")
              .classList.add("is-invalid");
          }
          if (this.errors.journey_time) {
            document
              .getElementById("_journey_time-wrapper")
              .classList.add("is-invalid");
          }
        });
    },
    getTrainInfo() {
      axios.get("/admin/root-train/" + this.route_id.code).then((res) => {
        // console.log(res.data);
        this.name = res.data.train_name;
        this.off_day = [res.data.off_day];
      });
    },
    addField() {
      this.bogis.push({
        bogi_type_id: "",
        bogi_name: "",
      });
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
fieldset {
  border: 1px solid #858796;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}
fieldset legend {
  width: fit-content;
}

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
