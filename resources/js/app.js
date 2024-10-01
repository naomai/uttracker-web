import "./bootstrap";
import { createApp } from "vue";
import VueTab from "./Components/VueTab.vue";


const app = createApp({});

app.component("vue-table", VueTab);

app.mount("#ut_tracker_app");