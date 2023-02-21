require("./bootstrap");

import { createApp } from "vue";

// Backend imports
import AddTrain from "./Components/backend/AddTrain.vue";
import AddStation from "./Components/backend/AddStation.vue";

// Tools imports
import VueCtkDateTimePicker from "vue-ctk-date-time-picker";
import VueSelect from "vue-select";
import "vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css";
import "vue-select/dist/vue-select.css";

// Frontend imports
import FrontLayout from "./FrontLayout.vue";

import router from "./router";

const app = createApp({});

app.component("add-train", AddTrain);
app.component("add-station", AddStation);
app.component("VueCtkDateTimePicker", VueCtkDateTimePicker);
app.component("v-select", VueSelect);
app.component("front-layout", FrontLayout);
app.use(router);

app.mount("#app");
