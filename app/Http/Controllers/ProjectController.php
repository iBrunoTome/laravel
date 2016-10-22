<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ProjectRepository;
	use CodeProject\Services\ProjectService;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Database\QueryException;
	use Illuminate\Http\Request;
	use LucaDegasperi\OAuth2Server\Facades\Authorizer;

	class ProjectController extends Controller {
		/**
		 * @var ProjectRepository
		 */
		private $repository;
		/**
		 * @var ProjectService
		 */
		private $service;

		/**
		 * ClientController constructor.
		 *
		 * @param ProjectRepository $repository
		 * @param ProjectService    $service
		 */
		public function __construct(ProjectRepository $repository, ProjectService $service) {
			$this->repository = $repository;
			$this->service = $service;
		}

		/**
		 * Display a listing of the resource.
		 */
		public function index() {
			return $this->repository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 *
		 * @return mixed
		 */
		public function store(Request $request) {
			return $this->service->create($request->all());
		}

		/**
		 * Display the specified resource.
		 *
		 * @param $id
		 *
		 * @return mixed
		 */
		public function show($id) {
			if ($this->checkProjectPermissions($id) == FALSE) {
				return ['error' => 'Acesso proibido'];
			}
			try {
				return $this->repository->find($id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Projeto não encontrado.'
				];
			}
		}

		private function checkProjectPermissions($projectId) {
			if ($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)) {
				return TRUE;
			}

			return FALSE;
		}

		private function checkProjectOwner($projectId) {
			$userId = Authorizer::getResourceOwnerId();

			return ($this->repository->isOwner($projectId, $userId));
		}

		private function checkProjectMember($memberId) {
			$userId = Authorizer::getResourceOwnerId();

			return ($this->repository->hasMember($memberId, $userId));
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 *
		 * @return array
		 */
		public function destroy($id) {
			if ($this->checkProjectPermissions($id) == FALSE) {
				return ['error' => 'Acesso proibido'];
			}
			try {
				$this->repository->delete($id);
				return [
					'error'   => FALSE,
					'message' => 'Projeto deletado com sucesso.'
				];
			} catch (QueryException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Projeto não pode ser apagado pois existe um ou mais notas vinculadas a ele.'
				];
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Projeto não encontrado.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar o projeto.'
				];
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param         $id
		 *
		 * @return array
		 */
		public function update(Request $request, $id) {
			if ($this->checkProjectPermissions($id) == FALSE) {
				return ['error' => 'Acesso proibido'];
			}
			try {
				return $this->service->update($request->all(), $id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Projeto não encontrado.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar o projeto.'
				];
			}
		}
	}
