<script setup>
  import {TabulatorFull as Tabulator} from 'tabulator-tables'; //import Tabulator library
  import { ref, defineProps, onMounted, useTemplateRef } from 'vue'

  const props = defineProps(["endpoint", "columns", "rows"]);

  const tableNode = useTemplateRef("table");
  const tabulator = ref(null); //variable to hold your table
  const tableData = ref([]); //data for table to display

  onMounted(() => {
      //instantiate Tabulator when element is mounted
      tabulator.value = new Tabulator(tableNode.value, {
        ajaxURL: props.endpoint,
        reactiveData: true, //enable data reactivity
        columns: props.columns, //define table columns
        layout:"fitColumns",

        sortMode:"remote", 

        pagination:true, //enable pagination
        paginationMode:"remote",
        paginationSize: props.rows,
        paginationInitialPage: 1,
        
      });
      //tabulator.value.setData();
      

        Tabulator.extendModule("format", "formatters",  {
            mapLink: function(cell){
                const row = cell.getRow().getData();
                const mapName = row.mapName;
                const url = row.mapUrl;
                const content = '<a href=\''+url+'\'>'+mapName+'</a>';
                return content;
            },
            serverLink: function(cell){
                const row = cell.getRow().getData();
                const serverName = row.name;
                const url = row.serverUrl;
                const content = '<a href=\''+url+'\'>'+serverName+'</a>';
                return content;
            },
            playerCell: function(cell){
                const row = cell.getRow().getData();
                const playersOnline = row.playersOnline;
                const playersMax = row.playersMax;
                const hasFakePlayers = row.hasFakePlayers;
                const content = `<span class='numplayers'>${playersOnline}</span> / <span class='maxplayers'>${playersMax}</span>`;
                return content;
            },
        });


    }
  );
</script>

<template>
  <div ref="table"></div>
</template>