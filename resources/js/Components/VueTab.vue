<script setup>
  import {TabulatorFull as Tabulator} from 'tabulator-tables'; //import Tabulator library
  import { ref, defineProps, onMounted, useTemplateRef } from 'vue'
  import emel  from 'emel'

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
                const content = emel("a[href=?]{?}", {
                  placeholders: [row.mapUrl,row.mapName]
                });
                return content;
            },
            serverLink: function(cell) {
                const row = cell.getRow().getData();
                const content = emel("a[href=?]{?}+div.serv_ip{?}", {
                  placeholders: [row.serverUrl, row.name, row.address_game]
                });
                return content;
            },
            playerCell: function(cell){
                const row = cell.getRow().getData();
                const content = emel("span.serv_players_online{?}+{ / }+span.serv_players_max{?}", {
                  placeholders: [row.playersOnline, row.playersMax]
                });
                const hasFakePlayers = row.hasFakePlayers;
                return content;
            },
        });


    }
  );
</script>

<template>
  <div ref="table"></div>
</template>