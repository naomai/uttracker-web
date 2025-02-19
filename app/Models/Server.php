<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Server extends Model {
    use HasFactory;

    protected $hidden = ['variables'];

    protected function variables(): Attribute {
        return Attribute::make(
            get: fn (string $json) => json_decode($json),
            set: fn (object $obj) => json_encode($obj),
        );
    }

    public function playerStats() : HasMany {
        return $this->hasMany(PlayerStat::class);
    }

    public function getGamemodeInfo() {
        $mode = "";
        $style = "";

        $rules = $this->variables;
        // CTF-BT-Abcd => ['CTF','BT',"Abc']
        $mapNameSplit = explode("-", $rules->mapname, 3);
        if(count($mapNameSplit)>=2) {
            [$mapNamePrefix,$mapNameContinued] = $mapNameSplit;
        }else{
            $mapNamePrefix = $rules->mapname;
            $mapNameContinued = "";
        }

        $hostName = isset($rules->hostname) ? $rules->hostname : "";
        $gameType = strtolower($rules->gametype);
        $mutatorList = isset($rules->mutators) ? $rules->mutators : "";
        
        if(($mapNamePrefix=="CTF" && $mapNameContinued=="BT") || $mapNamePrefix=="BT") {
            $mode="BT";
        }else{
            switch($gameType){
                case "deathmatchplus": 
                case "idm": 
                    $mode="DM"; 
                    break;
                case "teamgameplus": 
                case "itdm": 
                    $mode="TDM"; 
                    break;
                case "ctfgame": 
                case "ictf": 
                case "sactf": 
                    $mode="CTF"; 
                    break;
                case "domination": 
                case "idom": 
                    $mode="DOM"; 
                    break;
                case "lastmanstanding": 
                    $mode="LMS"; 
                    break;
                case "thieverydeathmatchplus": 
                    $mode="TH"; 
                    break;
                case "monsterhunt": 
                    $mode="MH"; 
                    break;
                case "jailbreak": 
                    $mode="JB"; 
                    break;
                case "soccermatch": 
                    $mode="SCR"; 
                    break;
                case "shgame": 
                    $mode="SH"; 
                    break;
                case "coop game":
                case "coopgame2":
                case "tvcoop": 
                case "infcoopunrealgame": 
                    $mode="Coop"; 
                    break;
                case "siegegi": 
                    $mode="SGI"; 
                    break;
                default: 
                    if($mapNameContinued!="") {
                        $mode=$mapNamePrefix;
                    }else{
                        $mode=$rules->gametype;
                    }
                break;
            }
        }

        if(stripos($hostName, "sniper")!==false
            || $gameType=="sactf"
        ) {
            $style="Sniper";
        }
        if(stripos($hostName, "funnel")!==false) { // not robust, but good enough
            $style="FN";
        }
        if(stripos($hostName, "pug")!==false) {
            $style="PUG";
        }

        if(stripos($mutatorList, "combogib")!==false
            || stripos($hostName, "combogib")!==false
            || stripos($hostName, "comboinstagib")!==false
        ) {
            $style="Combo";
        }
        if($mode!="BT" 
            && (stripos($mutatorList, "zeroping accugib")!==false
            || stripos($hostName, "insta")!==false
            || $gameType=="idm"
            || $gameType=="ictf"
            || $gameType=="idom"
            || $gameType=="itdm")
        ) {
            $style="Insta";
        }

        
        return (object)['mode'=>$mode, 'style'=>$style];
    }

    public function getServerTags() {
        $rules = $this->variables;
        $tags = array();

        $mutatorList = isset($rules->mutators) ? $rules->mutators : "";
        $hostName = isset($rules->hostname) ? $rules->hostname : "";
        
        if(stripos($mutatorList, "nali weapons 3")!==false
            || stripos($hostName, "nw3")!==false
            || stripos($hostName, "nali weapons 3")!==false
            || stripos($hostName, "naliweaponsiii")!==false
        ) {
            $tags[]="NW3";
        }
        elseif(stripos($hostName, "all weapons")!==false
            || stripos($hostName, "allweapons")!==false
            || stripos($mutatorList, "all weapons")!==false
            || stripos($mutatorList, "allweapons")!==false
        ) {
            $tags[]="ALLWP";
        }
        if(stripos($mutatorList, "grapple")!==false
            || stripos($mutatorList, "grapplinghook")!==false
            || stripos($hostName, "grapple")!==false
        ) {
            $tags[]="Grapple";
        }
        if(stripos($mutatorList, "map-vote")!==false) {
            $tags[]="MutMV";
        }
        if(stripos($mutatorList, "smartctf")!==false) {
            $tags[]="MutSCTF";
        }
        if(stripos($mutatorList, "doublejumput")!==false
            || stripos($mutatorList, "[r]^sdj")!==false
        ) {
            $tags[]="MutDJ";
        }
        if(stripos($mutatorList, "relic: ")!==false) {
            $tags[]="MutRL";
        }
        if(stripos($mutatorList, "btcheckpoints")!==false) {
            $tags[]="MutCP";
        }
        if(isset($rules->gamever) && $rules->gamever>250 && $rules->gamever<=348) {
            $tags[]="DEMO";
        }
        return array_unique($tags);
    }
}
