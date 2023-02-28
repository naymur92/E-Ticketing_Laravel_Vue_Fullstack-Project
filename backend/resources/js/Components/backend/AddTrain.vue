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
                ></v-select>
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
                  id="_journey_date"
                  v-model="journey_date"
                  :disabled-weekly="off_day"
                />
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
                  id="_journey_time"
                  v-model="journey_time"
                />
              </div>
            </div>

            <!-- Error lists -->
            <ul v-if="errors.name" class="alert alert-warning my-2">
              <li v-for="(err, index) in errors.name" :key="index">
                {{ err }}
              </li>
            </ul>

            <ul v-if="errors.journey_date" class="alert alert-warning my-2">
              <li v-for="(err, index) in errors.journey_date" :key="index">
                {{ err }}
              </li>
            </ul>

            <ul v-if="errors.journey_time" class="alert alert-warning my-2">
              <li v-for="(err, index) in errors.journey_time" :key="index">
                {{ err }}
              </li>
            </ul>
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
                  no-button-now
                  only-date
                  label="Select Start Date"
                  formatted="YYYY-MM-DD"
                  input-size="lg"
                  no-label="true"
                  id="_start_date"
                  v-model="start_date"
                />

                <ul v-if="errors.start_date" class="alert alert-warning my-2">
                  <li v-for="(err, index) in errors.start_date" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_end_date"><strong>End Date:</strong></label>
                <VueCtkDateTimePicker
                  no-button-now
                  only-date
                  label="Select End Date"
                  formatted="YYYY-MM-DD"
                  input-size="lg"
                  no-label="true"
                  id="_end_date"
                  v-model="end_date"
                />

                <ul v-if="errors.end_date" class="alert alert-warning my-2">
                  <li v-for="(err, index) in errors.end_date" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Bogi info -->
        <fieldset>
          <legend><strong>Bogi Info</strong></legend>
          <div class="row">
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_bogi_type"
                  ><strong>Select Bogi Type:</strong></label
                >
                <v-select
                  id="_bogi_type"
                  v-model="bogi_type_id"
                  :options="bogi_types"
                ></v-select>
                <ul v-if="errors.start_date" class="alert alert-warning my-2">
                  <li v-for="(err, index) in errors.start_date" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group my-2">
                <label for="_bogi_name"><strong>Bogi Name:</strong></label>
                <input
                  type="text"
                  v-model="bogi_name"
                  placeholder="Enter Bogi Name"
                  class="form-control"
                />

                <ul v-if="errors.bogi_name" class="alert alert-warning my-2">
                  <li v-for="(err, index) in errors.bogi_name" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </div>
            </div>
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
      route_id: null,
      root_trains: [],
      bogi_types: [],
      bogi_type_id: null,
      bogi_name: "",
      loading: true,
      errors: {},
      start_date: "",
      end_date: "",
    };
  },
  mounted() {
    axios.get("/root-trains").then((res) => {
      this.root_trains = res.data;
      this.loading = false;
    });

    axios.get("/bogi-types-list").then((res) => {
      this.bogi_types = res.data;
    });
  },
  methods: {
    addTrain() {
      axios
        .post("/trains", {
          name: this.name,
          journey_date: this.journey_date,
          journey_time: this.journey_time,
          route_id: this.route_id.code,
          off_day: this.off_day[0],
          start_date: this.start_date,
          end_date: this.end_date,
          bogi_type_id: this.bogi_type_id.code,
          bogi_name: this.bogi_name,
        })
        .then((res) => {
          console.log(res.data);
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
    getTrainInfo() {
      axios.get("/root-train/" + this.route_id.code).then((res) => {
        // console.log(res.data);
        this.name = res.data.train_name;
        this.off_day = [res.data.off_day];
      });
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
</style>
