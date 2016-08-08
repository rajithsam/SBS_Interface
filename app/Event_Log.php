<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event_Log extends Model
{
    protected $table = 'Event_Log';
    protected $connection = 'sqlsrv_BioStar';    

    public function __construct(array $attributes = [])
    {
            //$this->table = "TB_Event_Log";
        parent::__construct($attributes);
    }

	public function user()
    {
    	return $this->belongsTo('App\Employee', 'nUserID');
    }

}
