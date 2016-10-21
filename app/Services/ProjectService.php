<?php

	namespace CodeProject\Services;

	use CodeProject\Repositories\ProjectRepository;
	use CodeProject\Validators\ProjectValidator;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Prettus\Validator\Exceptions\ValidatorException;

	class ProjectService {
		/**
		 * @var ProjectRepository
		 */
		private $repository;
		/**
		 * @var ProjectValidator
		 */
		private $validator;

		/**
		 * @param ProjectRepository $repository
		 * @param ProjectValidator  $validator
		 */
		public function __construct(ProjectRepository $repository, ProjectValidator $validator) {
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

		public function showMembers($id) {
			try {
				return $this->repository->with(['members'])->find($id);
			} catch (ModelNotFoundException $ex) {
				return [
					'error'   => TRUE,
					'message' => 'ID não encontrado.'
				];
			}
		}

		/**
		 * Add a member
		 *
		 * @param $id
		 * @param $memberId
		 *
		 * @return array|mixed
		 */
		public function addMember($id, $memberId) {
			try {
				$this->repository->find($id)->members()->attach($memberId);
				return [
					'error'   => FALSE,
					'message' => 'Membro adicionado com sucesso.'
				];
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'ID não encontrado.'
				];
			}
		}

		/**
		 * Remove a member
		 *
		 * @param $id
		 * @param $memberId
		 *
		 * @return array|\Illuminate\Http\JsonResponse
		 */
		public function removeMember($id, $memberId) {
			try {
				$this->repository->with(['members'])->find($id)->detach($memberId);
				return response()->json([
					'error'   => FALSE,
					'message' => [
						'removeMember' => "Membro de ID {$memberId} removido."
					]
				]);
			} catch (ModelNotFoundException $ex) {
				return [
					'error'   => TRUE,
					'message' => 'ID não encontrado.'
				];
			}
		}

		/**
		 * Check if is member
		 *
		 * @param $id
		 * @param $memberId
		 *
		 * @return array
		 */
		public function isMember($id, $memberId) {
			try {
				$member = $this->repository->find($id)->members()->find($memberId);
				if (!$member) {
					return [
						'error'   => TRUE,
						'message' => [
							'isMember' => "Membro de ID {$memberId} não é um membro desse projeto"
						]
					];
				}
				return [
					'error'   => FALSE,
					'message' => [
						'isMember' => "{$member->name} é um membro desse projeto"
					]
				];
			} catch (ModelNotFoundException $ex) {
				return [
					'error'   => TRUE,
					'message' => 'ID não encontrado.'
				];
			}
		}
	}