<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public function users()
    {
    	return $this->belongsToMany('App\User', 'users_permissions');
    }

    public function views()
    {
    	return $this->belongsToMany('App\View', 'views_permissions');
    }

    public function getTableColumns()
    {
    	return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
