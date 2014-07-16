<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profile
 *
 * @author tonyprr
 */
class Profile extends Eloquent {

    protected $table = 'profile';
    
    public function user()
    {
        return $this->belongsTo('User');
    }

}
