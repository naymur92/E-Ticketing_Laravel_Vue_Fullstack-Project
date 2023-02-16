require("./bootstrap");

import { createApp } from "vue";
import AddTrain from "./Components/AddTrain.vue";
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import VueSelect from "vue-select";
import FrontLayout from "./FrontLayout.vue";

import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import "vue-select/dist/vue-select.css";
import router from "./router";

const app = createApp({});

app.component("vue-ctk-date-time-picker", VueCtkDateTimePicker);
app.component("add-train", AddTrain);
app.component("v-select", VueSelect);
app.component("front-layout", FrontLayout).default;
app.use(router);

app.mount("#app");
