<script setup>
  import {TabulatorFull as Tabulator} from 'tabulator-tables'; //import Tabulator library
  import { ref, onMounted, useTemplateRef } from 'vue'
  import emel  from 'emel'

  const props = defineProps([
    "endpoint", 
    "columns", 
    "rows",
    "partial",
  ]);

  const tableNode = useTemplateRef("table");
  const tabulator = ref(null); //variable to hold your table
  const tableData = ref([]); //data for table to display

  onMounted(() => {
      let options = {
        ajaxURL: props.endpoint,
        reactiveData: true, //enable data reactivity
        columns: props.columns, //define table columns
        layout:"fitColumns",

        pagination:true, //enable pagination
        paginationSize: props.rows,
        paginationInitialPage: 1,
        
      }

      if(props.partial) {
        options.sortMode = "remote";
        options.paginationMode = "remote";
      } else {
        options.ajaxResponse = (url, params, response) => 
          response.data;
        
        options.paginationSize = 30;
      }


      tabulator.value = new Tabulator(tableNode.value, options);

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
          serverLink: (cell)=> {
              const row = cell.getData();
              const content = emel("a.row_default_action[href=?]{?}+div.serv_ip{?}", {
                placeholders: [row.serverUrl, row.name, row.addressGame]
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