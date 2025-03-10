<script setup>
    import {ref} from 'vue';
    import GamemodeFilter from "./GamemodeFilter.vue";
    import VueTable from "./VueTab.vue";
    const props = defineProps([
        'apiUrl',
    ]);

    const gamemodeFilters = ref([]);


</script>

<template>
    <gamemode-filter 
        v-model="gamemodeFilters"
    >
    </gamemode-filter>
    <vue-table :endpoint="props.apiUrl" :columns="[
        { title: 'Type', field: 'gamemode', formatter: 'serverGamemode', headerSort: false, maxWidth: 70}, 
        { title: 'Server name', field: 'name', formatter: 'serverLink', width: '60%'}, 
        { title: 'Map name', field: 'variables-&gt;mapname', formatter: 'mapLink'},
        { title: 'Players', field: 'variables-&gt;numplayers', formatter: 'playerCell', maxWidth: 70},
      ]"
      id="serverList"></vue-table>
</template>