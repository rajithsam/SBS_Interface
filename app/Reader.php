<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    protected $table = 'Reader';
    protected $connection = 'sqlsrv_BioStar';    

    public function __construct(array $attributes = [])
    {
            //$this->table = "TB_Event_Log";
        parent::__construct($attributes);
    }

}