<?php

	namespace CodeProject\Entities;

	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;

	/**
	 * @property mixed id
	 * @property mixed name
	 */
	class User extends Authenticatable {
		use Notifiable;
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'name',
			'email',
			'password',
		];
		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = [
			'password',
			'remember_token',
		];

		public function projects() {
			return $this->belongsToMany(Project::class, 'project_members', 'member_id', 'project_id');
		}
	}
