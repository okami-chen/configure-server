<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OkamiChen\ConfigureServer\Entity;


use Illuminate\Database\Eloquent\Model;

/**
 * Description of ConfigureGroup
 * @date 2018-8-7 10:15:14
 * @author dehua
 */
class ConfigureNode extends Model {


    protected $table = 'configure_node';
    
    public function group(){
        return $this->belongsTo(ConfigureGroup::class, 'group_id');
    }
}
