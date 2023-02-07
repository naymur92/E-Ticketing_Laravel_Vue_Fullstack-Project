import Vue from "vue";

require("./bootstrap");

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

Vue.component("add-train", require("./components/AddTrain").default);

const app = new Vue({
    el: "#app",
});
