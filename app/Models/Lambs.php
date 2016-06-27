<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use Log;
class Lambs extends Model
{
	protected $table = 'lambs';
	public $timestamps = false;

	/**
	* Найти всех живых овечек
	* @param array $expression Условия
	* @return $query object
	*/
	public static function where_alive($expression){
		return self::where(array_merge($expression, ['death_day'=>0]));
	}
	/**
	* каждый день в одном из загонов где больше 1 овечки появляется ещё одна овечка
	* @return int or boolean false;
	*/
	public static function addOne(){
		return self::addIn(self::randCorral());
	}

	/**
	* каждый 10 день одну любую овечку забирают.
	*/
	public static function dropOne(){
		return self::dropIn(self::randCorral());
	}

	/**
	* добавить новую овечку)
	* @param $corral_id  integer Номер загона
	* return boolean;
	*/
	public static function addIn($corral_id){
		$lamb = new self;
		$lamb->corral_id = $corral_id;
		$lamb->birth_day = Time::today();
		if ($lamb->save()) {
			Lambs::log('1 овечка родилась в загоне '.$corral_id, ['lamb_id'=>$lamb->id,'corral_id'=>$corral_id,'day'=>Time::today()]);
			return $lamb->corral_id;
		}
		return false;
	}
	/**
	* Зарубить любую овечку в загоне
	* @return int or boolean coral номер загона.
	*/
	public static function dropIn($corral){
		$query = self::where_alive(['corral_id'=>$corral]);
		if ($query->count() > 1) {
			$lamb = $query->first();
			$lamb->kill();
			return $lamb->corral_id;
		}
		return false;
	}

	/**
	* Зарубить овечку(Те которые день смерти больше 0 мертвые овечки).
	* @return boolean result 
	*/
	public function kill(){
		$this->death_day = Time::today();
		if ($this->save()){
			Lambs::log('1 овечка умерла в загоне ', ['lamb_id'=>$this->id, 'corral_id'=>$this->corral_id, 'day'=>Time::today()]);
			return true;
		}
		return false;
	}


	/**
	* Выбираем любуй загон для убийства
	*/
	public static function randCorral($exclude = array()){
		$corral_num = rand(0,3);
		if (in_array($corral_num, $exclude)) {
			return $self::randCorral();
		}
		$lambs_count = self::where_alive(['corral_id'=>$corral_num])->count();
		if ($lambs_count > 1){
			return $corral_num;
		}else{
			return self::randCorral(array_merge($exclude, $corral_num));
		}
	}

	public static function log($message, $params){
		$logFile = 'lambs.log';
		Log::useDailyFiles(storage_path().'/logs/'.$logFile);
		Log::info($message, $params);
	}
}
