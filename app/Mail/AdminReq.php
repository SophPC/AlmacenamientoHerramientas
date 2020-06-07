<?php

namespace App\Mail;

class AdminReq{

    public $user = array();
  
    function __construct($user) {
      $this->user = $user;
    }
}