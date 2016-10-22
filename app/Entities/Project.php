<?php

	namespace CodeProject\Entities;

	use Illuminate\Database\Eloquent\Model;
	use Prettus\Repository\Contracts\Transformable;
	use Prettus\Repository\Traits\TransformableTrait;

	/**
	 * @property integer   id
	 * @property integer   client_id
	 * @property integer   owner_id
	 * @property string    name
	 * @property string    description
	 * @property integer   progress
	 * @property integer   status
	 * @property \DateTime due_date
	 */
	class Project extends Model implements Transformable {
		use TransformableTrait;
		protected $fillable = [
			'owner_id',
			'client_id',
			'name',
			'description',
			'progress',
			'status',
			'due_date'
		];

		public function notes() {
			return $this->hasMany(ProjectNote::class);
		}

		public function members() {
			return $this->belongsToMany(User::class, 'project_members', 'project_id', 'member_id');
		}
	}
