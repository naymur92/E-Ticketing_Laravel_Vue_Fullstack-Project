<template>
  <div>
    <form v-if="!loading" @submit.prevent="addSchedule()" method="post">
      <div class="card-body">
        <!-- Train info -->
        <fieldset>
          <legend><strong>Train Info</strong></legend>
          <div class="row">
            <div class="col-12">
              <div class="form-group my-2">
                <label for="_train_id"><strong>Train:</strong></label>
                <v-select
                  id="_train_id"
                  v-model="train_id"
                  :options="trains"
                  @update:modelValue="getTrainRoutes()"
                ></v-select>

                <ul v-if="errors.train_id" class="text-danger my-2">
                  <li v-for="(err, index) in errors.train_id" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </fieldset>

        <!-- Schedule info -->
        <fieldset>
          <legend><strong>Schedule Info</strong></legend>

          <div
            v-for="(schedule, index) in schedules"
            :key="index"
            class="mt-5 shadow p-3 rounded"
          >
            <h2
              v-if="schedule.dest_stations[0].to_station_id != null"
              class="bg-success p-3 text-center text-white rounded"
            >
              Base Station {{ index + 1 }} ({{
                schedule.base_station.from_station_name
              }})
            </h2>
            <!-- base station info -->
            <div class="row">
              <div class="col-6">
                <div class="form-group my-2">
                  <label for="_base_station"
                    ><strong>Base Station:</strong></label
                  >
                  <input
                    type="text"
                    id="_base_station"
                    :value="schedule.base_station.from_station_name"
                    class="form-control"
                    disabled
                  />
                </div>
              </div>
              <div class="col-6">
                <div class="form-group my-2">
                  <label for="_left_at"><strong>Left At:</strong></label>
                  <input
                    type="text"
                    id="_left_at"
                    class="form-control"
                    :value="schedule.base_station.left_station_at"
                    disabled
                  />
                </div>
              </div>
            </div>

            <!-- next stations info -->
            <div v-if="schedule.dest_stations[0].to_station_id != null">
              <div
                class="my-4 shadow p-2"
                v-for="item in schedule.dest_stations"
                :key="item.to_station_id"
              >
                <!-- Next station info -->
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label><strong>Next Station</strong></label>
                      <input
                        type="text"
                        class="form-control"
                        :value="
                          schedule.base_station.from_station_name +
                          '->' +
                          item.to_station_name
                        "
                        disabled
                      />
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label><strong>Reach At</strong></label>
                      <input
                        type="text"
                        class="form-control"
                        :value="item.reach_at"
                        disabled
                      />
                    </div>
                  </div>
                </div>

                <!-- pricing details -->
                <div class="row">
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>Shovon Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.shovon_price"
                        :disabled="!bogi_types.includes('shovon')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>S-Chair Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.s_chair_price"
                        :disabled="!bogi_types.includes('s_chair')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>F-Chair Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.f_chair_price"
                        :disabled="!bogi_types.includes('f_chair')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>F-Seat Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.f_seat_price"
                        :disabled="!bogi_types.includes('f_seat')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>F-Berth Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.f_berth_price"
                        :disabled="!bogi_types.includes('f_berth')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>Snigdha Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.snigdha_price"
                        :disabled="!bogi_types.includes('snigdha')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>AC-S Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.ac_s_price"
                        :disabled="!bogi_types.includes('ac_s')"
                      />
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>AC-B Price</strong></label>
                      <input
                        type="number"
                        class="form-control"
                        v-model="item.ac_b_price"
                        :disabled="!bogi_types.includes('ac_b')"
                      />
                    </div>
                  </div>
                </div>

                <!-- Seat range details -->
                <div class="alert alert-info mt-4">
                  <strong>Set Seat Ranges</strong>
                </div>
                <div
                  class="row"
                  v-for="(seat_range, i) in item.seat_ranges"
                  :key="i"
                >
                  <div class="col-6">
                    <div class="form-group">
                      <label><strong>Select Bogi</strong></label>
                      <v-select
                        v-model="item.seat_ranges[i].bogi_name"
                        :options="bogis_seats.bogis"
                      ></v-select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>Seat Start</strong></label>
                      <v-select
                        v-model="item.seat_ranges[i].seat_start"
                        :options="bogis_seats.seats[i]"
                      ></v-select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label><strong>Seat End</strong></label>
                      <v-select
                        v-model="item.seat_ranges[i].seat_end"
                        :options="bogis_seats.seats[i]"
                      ></v-select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </fieldset>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <input
          type="submit"
          value="Add Schedule"
          class="btn btn-outline-primary"
        />
      </div>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      loading: true,
      errors: [],
      trains: [],
      train_id: null,
      schedules: [
        {
          base_station: {
            from_station_id: null,
            from_station_name: "",
            left_station_at: "",
          },
          dest_stations: [
            {
              to_station_id: null,
              to_station_name: "",
              reach_at: "",
              ac_b_price: null,
              ac_s_price: null,
              snigdha_price: null,
              f_berth_price: null,
              f_seat_price: null,
              f_chair_price: null,
              s_chair_price: null,
              shovon_price: null,
              seat_ranges: [
                {
                  bogi_id: null,
                  bogi_name: null,
                  seat_start: null,
                  seat_end: null,
                },
              ],
            },
          ],
        },
      ],
      bogi_types: [],
      bogis_seats: [],
    };
  },
  mounted() {
    axios.get("/admin/trains-for-schedules").then((res) => {
      this.trains = res.data;
      this.loading = false;
    });
  },
  methods: {
    getTrainRoutes() {
      if (this.train_id != null) {
        axios.get("/admin/route-list/" + this.train_id.code).then((res) => {
          this.schedules = res.data.schedules;
          this.bogi_types = res.data.bogi_types;
          this.bogis_seats = res.data.bogis_seats;

          // console.log(res.data.schedules);
        });
      } else {
        this.route_lists = [];
      }
    },
    addSchedule() {
      // console.log(this.dest_stations);
      axios
        .post("/admin/schedules", {
          train_id: this.train_id.code,
          schedules: this.schedules,
        })
        .then((res) => {
          if (res.data.success) {
            // console.log(res.data.msg);
            window.location.href = "/admin/schedules";
            // alert(res.data.msg);
          } else {
            alert(res.data.msg);
          }
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