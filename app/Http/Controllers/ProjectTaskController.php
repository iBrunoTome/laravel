<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ProjectTaskRepository;
	use CodeProject\Services\ProjectTaskService;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	class ProjectTaskController extends Controller {
		/**
		 * @var ProjectTaskRepository
		 */
		private $repository;
		/**
		 * @var ProjectTaskService
		 */
		private $service;

		/**
		 * ClientController constructor.
		 *
		 * @param ProjectTaskRepository $repository
		 * @param ProjectTaskService    $service
		 */
		public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service) {
			$this->repository = $repository;
			$this->service = $service;
		}

		/**
		 * Display a listing of the resource.
		 *
		 * @param $id
		 *
		 * @return mixed
		 */
		public function index($id) {
			return $this->repository->findWhere(['project_id' => $id]);
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
		 * @param $TaskId
		 *
		 * @return array
		 */
		public function show($id, $TaskId) {
			try {
				return $this->repository->findWhere([
					'project_id' => $id,
					'id'         => $TaskId
				]);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Task não encontrada.'
				];
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param $request
		 * @param $id
		 * @param $taskId
		 *
		 * @return array
		 */
		public function update(Request $request, $id, $taskId) {
			try {
				return $this->service->update($request->all(), $id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Task não encontrada.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar a task.'
				];
			}
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @param $taskId
		 *
		 * @return array
		 */
		public function destroy($id, $taskId) {
			try {
				$this->repository->delete($id);
				return [
					'error'   => FALSE,
					'message' => 'Task deletada com sucesso.'
				];
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Task não encontrada.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar a task.'
				];
			}
		}
	}
