<?php

namespace App\X;

class Detect
{
    
    public static function clear(){
        session()->forget('detect_refs');
    } 

    public static function refs(){
        return session('detect_refs',[]);
    }
    public static function add($key,$value){
        $data = static::refs();
        $data[$key] = $value;
        session()->put('detect_refs',$data);
    }
}
