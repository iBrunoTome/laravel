<?php

	namespace CodeProject\Repositories;

	use CodeProject\Entities\Project;
	use CodeProject\Validators\ProjectValidator;
	use Prettus\Repository\Criteria\RequestCriteria;
	use Prettus\Repository\Eloquent\BaseRepository;

	/**
	 * Class ProjectRepositoryEloquent
	 * @package namespace CodeProject\Repositories;
	 */
	class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository {
		/**
		 * Specify Model class name
		 *
		 * @return string
		 */
		public function model() {
			return Project::class;
		}

		/**
		 * Boot up the repository, pushing criteria
		 */
		public function boot() {
			$this->pushCriteria(app(RequestCriteria::class));
		}
	}
