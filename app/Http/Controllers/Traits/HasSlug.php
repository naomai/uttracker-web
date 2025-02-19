<?php

namespace App\Http\Controllers\Traits;

trait HasSlug {
    protected static function getSlug($sx){
        $s=strtolower($sx);
        $s=str_replace(
            array('$',  /*"!",*/"@","{}v{}","(.)(.)", "(.y.)",  ")-(",")v(","|<","()","'//","'/","|_|","|_","/-]","|-|"),
            array("s" , /*"i",*/"a","m",    " boobs "," boobs ","h"  ,"m"  ,"k" ,"o" ,"w",  "y" ,"u"  ,"l" ,"a"  ,"h"),
        $s);
        $res=substr(str_replace(" ","-",trim(preg_replace("/[^a-z0-9]+/"," ",$s))),0,30);
        if(strlen($res)<2){
            $res=str_replace(
                array('$',       '#',     '!','.....',       '.',  '+',     '~',      '}:',   '|',             '"',    "&",    "%",        "*"),
                array(' dollar ',' hash ','a',' lots of dots ','dot',' plus ',' tilde ',' cow ',' vertical bar ',"quote"," and "," percent "," star "),
            $sx);
            return substr(str_replace(" ","-",trim(preg_replace("/[^a-z0-9]+/"," ",$res))),0,30);
        }
        return $res;
    }
} 
