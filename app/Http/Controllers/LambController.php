<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Lambs;
use App\Models\Time;
use App\Http\Requests;
use Log;
use DB;
class LambController extends Controller
{

	public function initialize(){
		$dbh = new \PDO('mysql:host='.\Config::get('database.connections.mysql.host').';dbname='.\Config::get('database.connections.mysql.database'), \Config::get('database.connections.mysql.username'), \Config::get('database.connections.mysql.password'));
		$stmt=$dbh->prepare("DELETE FROM `lambs`"); $stmt->execute();
		$stmt=$dbh->prepare("ALTER TABLE `lambs` AUTO_INCREMENT = 1"); $stmt->execute();
		$stmt = $dbh->prepare("INSERT INTO `lambs` (`id`, `birth_day`, `death_day`, `corral_id`) 
			VALUES(1, 1, 0, 0),(2, 1, 0, 2),(3, 1, 0, 1),
			(4, 1, 0, 3),(5, 1, 0, 0),(6, 1, 0, 0),
			(7, 1, 0, 2),(8, 1, 0, 1),(9, 1, 0, 2),
			(10, 1, 0, 0);");
		$stmt->execute();
		$stmt=$dbh->prepare("DELETE FROM `time`"); $stmt->execute();
		$stmt = $dbh->prepare("INSERT INTO `time` (`id`, `day`) VALUES(0, 0);");
		$data = $stmt->execute();
		return response()->json($data);
	}
	
	/**
	* (вытаскиваем из базы через api всех живых овечек)
	*/
	public function index(){
		$data = Lambs::where_alive([])->get();
		return response()->json(['lambs'=>$data, 'time'=>Time::today()]);
	}

	/**
	* (1 день длится 10 секунд.
	* каждый день в одном из загонов где больше 1 овечки появляется ещё одна овечка каждый.
	* 10 день одну любую овечку забирают(сами знаете куда))
	*/
	public function nextday(){
		$time = Time::where(['id'=>0])->first();
		$time->day++;
		if ($time->save()) {
			$added_corral = Lambs::addOne();
		}
		if ($time->day%2 === 0) {
			$droped_corral = Lambs::dropOne();
		}
		if (isset($droped_corral) && $added_corral != $droped_corral) {
			$corrals[$droped_corral] = Lambs::where_alive(['corral_id'=>$droped_corral])->get();
		}
		$corrals[$added_corral] = Lambs::where_alive(['corral_id'=>$added_corral])->get();
		$data = array('lambs'=>$corrals, 'success'=>1);
		return response()->json($data);
	}

	public function create(){
		return response()->json(array('success' => 0));
	}

	/**
	* (если в загоне осталась одна овечка то берём загон где больше всего овечек и пересаживаем одну из них к одинокой овечке)
	*/
	public function update(){
		$postdata = file_get_contents("php://input");
		$post = json_decode($postdata);
		if(isset($post->lamb_id) && isset($post->to)){
			$lamb = Lambs::where_alive(['id'=>(int)$post->lamb_id])->first();
			// 
			if ($lamb->corral_id == $post->to) {
				return response()->json(['success'=>0]);
			}else{
				$old_corral = $lamb->corral_id;
				$lamb->corral_id = $post->to;
				$lamb->save();
				$corrals[$old_corral] = Lambs::where_alive(['corral_id'=>$old_corral])->get();
			}
			if ($lamb->save()) {
				Lambs::log('1 овечка переселилась', ['lamb_id'=>$lamb->id, 'from_corral'=>$old_corral, 'to_corral'=>$lamb->corral_id, 'day'=>Time::today()]);
				$corrals[$post->to] = Lambs::where_alive(['corral_id'=>$post->to])->get();
				return response()->json(['success' => 1,'lambs'=> $corrals]);
			}
		}
		return response()->json(['success'=>0]);
	}

	/**
	* (Удалить если загон не обнулится если убрать овечку).
	*/
	public function destroy($id){
		$success = 0;
		$lamb = Lambs::where_alive(['id'=>$id])->first();
		$corral_count = Lambs::where_alive(['corral_id'=>$lamb->corral_id])->count();
		if ($corral_count<2) {
			$success=0;
		}else{
			$lamb->kill();
			$success=1;
		}
		$lambs = Lambs::where_alive(['corral_id'=>$lamb->corral_id])->get();
		return response()->json(['success'=>$success,'lambs'=>[$lamb->corral_id=>$lambs]]);
	}
}
