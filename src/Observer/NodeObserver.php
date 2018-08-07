<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\ConfigureServer\Observer;

use Illuminate\Database\Eloquent\Model;
use OkamiChen\ConfigureServer\Service\IdCreate;
use OkamiChen\ConfigureServer\Event\ConfigChanged;

/**
 * Description of NodeObserver
 * @date 2018-8-7 14:21:25
 * @author dehua
 */
class NodeObserver {
    
    /**
     * 
     * @param string $value
     * @return json
     */
    protected function format($value){
        $option = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        return json_encode($value, $option);
    }

    /**
     * 
     * @param Model $model
     * @return Model
     */
    public function saving(Model $model){
        
        $model->version_id  = IdCreate::onlyId();
        
        return $model;
    }
    
    /**
     * 
     * @param Model $model
     * @return Model
     */
    public function saved(Model $model){
        
        $change = [
            'from'   => array_only($model->getOriginal(), array_keys($model->getDirty())),
            'to'   => array_only($model->toArray(), array_keys($model->getDirty())),
        ];

        event(new ConfigChanged($model->id, $change));
        
        return $model;
    }
}
