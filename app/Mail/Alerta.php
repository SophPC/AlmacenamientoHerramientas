<?php

namespace App\Mail;

class Alerta{

    public $alerta = array();
  
    function __construct($alerta) {
      $this->alerta = $alerta;
    }
}