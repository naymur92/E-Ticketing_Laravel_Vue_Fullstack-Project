require("./bootstrap");

import { createApp } from "vue";
import AddTrain from "./Components/AddTrain.vue";
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import VueSelect from "vue-select";

import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import "vue-select/dist/vue-select.css";

const app = createApp({});

app.component("vue-ctk-date-time-picker", VueCtkDateTimePicker);
app.component("add-train", AddTrain);
app.component("v-select", VueSelect);

app.mount("#app");
