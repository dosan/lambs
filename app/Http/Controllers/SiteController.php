<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SiteController extends Controller
{

	public function index(){
		return Response::json(Lambs::get());
	}
	public function create(){
		return Response::json(array('success' => true));
	}
	public function update(){
		return Response::json(array('success' => true));
	}
}
