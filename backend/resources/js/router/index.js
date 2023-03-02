import Home from "../pages/Home.vue";
import SearchResult from "../pages/SearchResult.vue";
import ContactUs from "../pages/ContactUs.vue";

import { createRouter, createWebHistory } from "vue-router";

const routes = [
    { path: "/", component: Home },
    {
        path: "/search-result",
        name: "searchresult",
        component: SearchResult,
        props: true
    },
    { path: "/contact-us", component: ContactUs }
    // { path: "*", redirect: "/" }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: "active"
});

export default router;
