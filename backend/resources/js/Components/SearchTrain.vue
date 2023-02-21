<template>
  <form @submit.prevent="searchTrain()">
    <div class="row my-2">
      <div class="col-6">
        <div class="form-group">
          <label for="_from"><strong>From</strong></label>
          <v-select id="_from" v-model="from" :options="stations"></v-select>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label for="_to"><strong>To</strong></label>
          <v-select id="_to" v-model="to" :options="stations"></v-select>
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
            auto-close="true"
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
</template>
<script>
export default {
  data() {
    return {
      loading: true,
      stations: [],
      from: "",
      to: "",
      doj: "",
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
    searchTrain() {
      axios
        .post("/check", {
          from: this.from.code,
          to: this.to.code,
          doj: this.doj,
        })
        .then((res) => {
          console.log(res.data);
        });
      // alert(this.from);
    },
  },
};
</script>
<style>
</style>