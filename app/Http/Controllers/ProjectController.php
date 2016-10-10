<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ProjectRepository;
	use CodeProject\Services\ProjectService;
	use Illuminate\Auth\Access\Response;
	use Illuminate\Http\Request;

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
			return $this->repository->find($id);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 */
		public function destroy($id) {
			$this->repository->delete($id);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param $request
		 * @param $id
		 *
		 * @return Response
		 */
		public function update(Request $request, $id) {
			return $this->service->update($request->all(), $id);
		}
	}
