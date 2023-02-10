require("./bootstrap");

import { createApp } from "vue";
import AddTrain from "./Components/AddTrain.vue";
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";

const app = createApp({});

app.component("VueCtkDateTimePicker", VueCtkDateTimePicker);
app.component("AddTrain", AddTrain);

app.mount("#app");
