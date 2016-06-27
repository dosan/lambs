<?php

use Illuminate\Database\Seeder;

class LambsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$corral = collect([0,1,2,3]);

		DB::table('lambs')->insert([
			'birth_day' => 1,
			'death_day' =>null,
			'corral_id'=>$corral->random(),
		]);
	}
}
