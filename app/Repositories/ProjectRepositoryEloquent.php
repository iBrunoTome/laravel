<?php

	namespace CodeProject\Repositories;

	use CodeProject\Entities\Project;
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

		public function isOwner($projectId, $userId) {
			if (count($this->findWhere([
				'id'       => $projectId,
				'owner_id' => $userId
			]))) {
				return TRUE;
			}

			return FALSE;
		}

		public function hasMember($projectId, $memberId) {
			$project = $this->find($projectId);

			foreach ($project->members as $member) {
				if ($member->id == $memberId) {
					return TRUE;
				}
			}

			return FALSE;
		}
	}
