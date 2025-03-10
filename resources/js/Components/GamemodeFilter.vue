<script setup>
    import {ref} from 'vue';
    const props = defineProps([
    ]);

    const model = defineModel({default: []});


    var gameTypes = [
        {name: "DM", desc: "Deathmatch",},
        {name: "CTF", desc: "Capture the flag",},
        {name: "TDM", desc: "Team deathmatch",},
        {name: "Insta", desc: "InstaGib",},
        {name: "Combo", desc: "Combo InstaGib",},
        {name: "BT", desc: "BunnyTrack",},
        {name: "MH", desc: "MonsterHunt",},
        {name: "SGI", desc: "Siege",},
        {name: "PUG", desc: "Pick Up Game",},
        {name: "AS", desc: "Assault",},
        {name: "LMS", desc: "Last Man Standing",},
        {name: "DOM", desc: "Domination",},
        {name: "FN", desc: "Funnel",},
        {name: "Coop", desc: "Co-op",},
        {name: "TH", desc: "Thievery",},
        {name: "JB", desc: "Jailbreak",},
        {name: "SH", desc: "Scavenger Hunt",},
        {name: "SCR", desc: "Soccer Tournament",},
        {name: "ALLWP", desc: "All Weapons",},
        {name: "NW3", desc: "NaliWeapons III",},
        {name: "Grapple", desc: "Grapple",},
        {name: "Sniper", desc: "Sniper",},
        {name: "RA", desc: "Rocket Arena",},
        {name: "DEMO", desc: "UT Demo",},
        {name: "TO", desc: "~Tactical Ops",},
        {name: "ONS", desc: "~Onslaught",},
        {name: "SV", desc: "~Survival",},
        {name: "MutDJ", desc: ":Double Jump",},
        {name: "MutMV", desc: ":Map Vote",},
        {name: "MutRL", desc: ":Relics",},
        {name: "MutSCTF", desc: ":SmartCTF",},
        {name: "MutCP", desc: ":Checkpoints",},
    ];

    const gameTypesFiltered = ref(gameTypes.filter(
        (mode)=>mode.desc[0]!="~" && mode.desc[0]!=":"
    ));
</script>

<template>
    <div id='serverlist_gamemode_filter'>
        <button v-for="(mode) in gameTypesFiltered" class="filter_mode" :class="{selected: model.includes(mode.name)}" @click="model=[mode.name]">
            <img :src="'assets/bitmaps/gm-' + mode.name.toLowerCase() + '.png'" :alt="mode.name"/>
        </button>
    </div>
</template>