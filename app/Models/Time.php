<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
	public $timestamps = false;
	protected $table = 'time';

	/**
	* виртуальная день
	* @return integer день
	*/
	public static function today(){
		return Time::where(['id'=>0])->first()->day;
	}
}
