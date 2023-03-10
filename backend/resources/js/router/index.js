import Home from "../pages/Home.vue";
import SearchResult from "../pages/SearchResult.vue";
import Booking from '../pages/Booking.vue'
import ContactUs from "../pages/ContactUs.vue";

import { createRouter, createWebHistory } from "vue-router";

const routes = [
  { path: "/", name: 'home', component: Home },
  {
    path: "/search-result",
    name: "searchresult",
    component: SearchResult,
  },
  { path: "/book", component: Booking },
  { path: "/contact-us", component: ContactUs },
  // { path: "/:pathMatch(.*)*", redirect: { name: 'home' } }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass: "active"
});

export default router;
