<?php

	namespace CodeProject\Services;

	use CodeProject\Repositories\ProjectRepository;
	use CodeProject\Repositories\ProjectRepositoryEloquent;
	use CodeProject\Validators\ProjectValidator;
	use Prettus\Validator\Exceptions\ValidatorException;

	class ProjectService {
		/**
		 * @var ProjectRepository
		 */
		protected $repository;
		/**
		 * @var ProjectValidator
		 */
		private $validator;

		public function __construct(ProjectRepositoryEloquent $repository, ProjectValidator $validator) {
			$this->repository = $repository;
			$this->validator = $validator;
		}

		public function create(array $data) {
			try {
				$this->validator->with($data)->passesOrFail();
				return $this->repository->create($data);
			} catch (ValidatorException $e) {
				return [
					'error'   => TRUE,
					'message' => $e->getMessageBag()
				];
			}
		}

		public function update(array $data, $id) {
			try {
				$this->validator->with($data)->passesOrFail();
				return $this->repository->update($data, $id);
			} catch (ValidatorException $e) {
				return [
					'error'   => TRUE,
					'message' => $e->getMessageBag()
				];
			}
		}
	}