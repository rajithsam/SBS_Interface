<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectedUser extends Model
{
    protected $table = 'USER';
    protected $connection = 'sqlsrv_BioStar';    
    protected $casts = [
        'bPassword2' => 'binary',
     ];

    public function __construct(array $attributes = [])
    {
            //$this->table = "TB_Event_Log";
        parent::__construct($attributes);
    }

	public function user()
    {
    	return $this->belongsTo('App\Employee', 'nUserID', 'nUserID');
    }

}
