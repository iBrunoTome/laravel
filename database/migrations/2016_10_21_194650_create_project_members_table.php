<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	class CreateProjectMembersTable extends Migration {
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up() {
			Schema::create('project_members', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('project_id', FALSE, TRUE);
				$table->foreign('project_id')->references('id')->on('projects');
				$table->integer('member_id', FALSE, TRUE);
				$table->foreign('member_id')->references('id')->on('users');
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down() {
			Schema::drop('project_members');
		}
	}
