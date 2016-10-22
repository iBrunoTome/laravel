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
			return $this->repository->all();
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
			try {
				$userId = Authorizer::getResourceOwnerId();

				if ($this->repository->isOwner($id, $userId) == FALSE) {
					return ['success' => FALSE];
				}
				return $this->repository->find($id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Projeto não encontrado.'
				];
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 *
		 * @return array
		 */
		public function destroy($id) {
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
