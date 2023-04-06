require("./bootstrap");

import { createApp } from "vue";

// Backend imports
import AddStation from "./Components/backend/AddStation.vue";
import AddRoute from "./Components/backend/AddRoute.vue";
import AddTrain from "./Components/backend/AddTrain.vue";
import AddSchedule from "./Components/backend/AddSchedule.vue";

// Tools imports
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import VueSelect from "vue-select";
import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import "vue-select/dist/vue-select.css";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// Frontend imports
import FrontLayout from "./FrontLayout.vue";

import { createPinia } from "pinia";
import router from "./router";

const app = createApp({});
const pinia = createPinia();

app.component("add-station", AddStation);
app.component("add-route", AddRoute);
app.component("add-train", AddTrain);
app.component("add-schedule", AddSchedule);
app.component("VueCtkDateTimePicker", VueCtkDateTimePicker);
app.component("v-select", VueSelect);
app.component("front-layout", FrontLayout);
app.use(router);
app.use(pinia);
app.use(VueSweetalert2);

app.mount("#app");
