<template>
  <div>
    <form @submit.prevent="addStation">
      <div class="card-body">
        <div class="form-group my-2">
          <label for="_name"><strong>Station Name:</strong></label>
          <input
            type="text"
            v-model="name"
            id="_name"
            placeholder="Enter station name"
            class="form-control"
          />

          <ul v-if="errors.name" class="alert alert-warning my-2">
            <li v-for="(err, index) in errors.name" :key="index">
              {{ err }}
            </li>
          </ul>
        </div>
        <div class="form-group my-2">
          <label for="_addr"><strong>Station Address:</strong></label>
          <input
            type="text"
            v-model="address"
            id="_addr"
            placeholder="Enter station address"
            class="form-control"
          />

          <ul v-if="errors.address" class="alert alert-warning my-2">
            <li v-for="(err, index) in errors.address" :key="index">
              {{ err }}
            </li>
          </ul>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group my-2">
              <label for="_lat"><strong>Latitude:</strong></label>
              <input
                type="number"
                v-model="lat"
                id="_lat"
                step="any"
                placeholder="Enter lattitude"
                class="form-control"
              />
              <ul v-if="errors.lat" class="alert alert-warning my-2">
                <li v-for="(err, index) in errors.lat" :key="index">
                  {{ err }}
                </li>
              </ul>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group my-2">
              <label for="_lon"><strong>Longitude:</strong></label>
              <input
                type="number"
                v-model="lon"
                id="_lon"
                step="any"
                placeholder="Enter longitude"
                class="form-control"
              />
              <ul v-if="errors.lon" class="alert alert-warning my-2">
                <li v-for="(err, index) in errors.lon" :key="index">
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
          value="Add Station"
          class="btn btn-outline-primary"
        />
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "AddStation",
  data() {
    return {
      name: "",
      address: "",
      lat: "",
      lon: "",
      errors: {},
    };
  },
  mounted() {
    // this.$router.push("/stations");
  },
  methods: {
    addStation() {
      // console.log(this.lat);
      axios
        .post("/stations", {
          name: this.name,
          address: this.address,
          lat: this.lat,
          lon: this.lon,
        })
        .then((res) => {
          // console.log("Station Created");
          if (res.data.success) {
            // console.log(res.data.msg);
            window.location.href = "/stations";
          }
          // console.log(res.data.code);
        })
        .catch((err) => {
          // console.log(err.response.data);
          this.errors = err.response.data.errors;
        });
    },
  },
};
</script>
