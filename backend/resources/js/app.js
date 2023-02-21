require("./bootstrap");

import { createApp } from "vue";
import AddTrain from "./Components/AddTrain.vue";
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import VueSelect from "vue-select";
import FrontLayout from "./FrontLayout.vue";

import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import "vue-select/dist/vue-select.css";
import router from "./router";

window.renderSomething = function() {};

const app = createApp({});

app.component("VueCtkDateTimePicker", VueCtkDateTimePicker);
app.component("add-train", AddTrain);
app.component("v-select", VueSelect);
app.component("front-layout", FrontLayout);
app.use(router);

app.mount("#app");
