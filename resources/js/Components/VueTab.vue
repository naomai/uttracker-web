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

      tabulator.value.on("cellClick", function(e, cell){
        var clickTarget = null;
        const defaultLinkCell = cell.getElement().querySelector("a.cell_default_action");
        const defaultLinkRow = cell.getRow().getElement().querySelector("a.row_default_action");
        if(defaultLinkCell!==null){
          clickTarget = defaultLinkCell;
        }else if(defaultLinkRow!==null){
          clickTarget = defaultLinkRow;
        }

        if(clickTarget!==null){
          //clickTarget.click();
          e.preventDefault();
          window.location = clickTarget.href;
        }
      });

      //tabulator.value.setData();
      

        Tabulator.extendModule("format", "formatters",  {
            mapLink: function(cell){
                const row = cell.getRow().getData();
                const content = emel("a.cell_default_action[href=?]{?}", {
                  placeholders: [row.mapUrl,row.mapName]
                });
                return content;
            },
            serverLink: function(cell) {
                const row = cell.getRow().getData();
                const content = emel("a.row_default_action[href=?]{?}+div.serv_ip{?}", {
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