<?php

	use Illuminate\Database\Seeder;

	class DatabaseSeeder extends Seeder {
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run() {
			\CodeProject\Client::truncate();
			factory(\CodeProject\Client::class, 10)->create();
		}
	}
