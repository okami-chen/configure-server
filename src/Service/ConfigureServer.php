<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\ConfigureServer\Service;

use OkamiChen\ConfigureServer\Entity\ConfigureNode;

/**
 * Description of ConfigureServer
 * @date 2018-8-7 15:46:24
 * @author dehua
 */
class ConfigureServer {
    
    
    static $cacheKey    = 'configure:server';


    /**
     * 
     * @return array
     */
    public static function all(){
        
        $data   = [];
        
        $rows   = ConfigureNode::get(['skey','svalue']);
        
        if(!count($rows)){
            return $data;
        }
        
        $items  = $rows->toArray();
        $cache = cache()->remember(self::$cacheKey, 5 , function() use($items){
            $data   = [];
            foreach ($items as $key => $row) {
                $json   = json_decode($row['svalue'], true);
                if(!$json){
                    $json   = $row['svalue'];
                }
                data_set($data, $row['skey'], $json);
            }
            return $data;
        });
        return $cache;
    }
    
    static public function clear(){
        cache()->forget(self::$cacheKey);
    }
}
