import "./bootstrap";
import { createApp } from "vue";
import VueTab from "./Components/VueTab.vue";
import GamemodeFilter from "./Components/GamemodeFilter.vue";
import ServerBrowser from "./Components/ServerBrowser.vue";


const app = createApp({
    components: {
        "vue-table": VueTab,
        "gamemode-filter": GamemodeFilter,
        "server-browser": ServerBrowser,
    }
});

app.mount("#ut_tracker_app");