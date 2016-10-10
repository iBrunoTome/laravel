<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ProjectNoteRepository;
	use CodeProject\Services\ProjectNoteService;
	use Illuminate\Auth\Access\Response;
	use Illuminate\Http\Request;

	class ProjectNoteController extends Controller {
		/**
		 * @var ProjectNoteRepository
		 */
		private $repository;
		/**
		 * @var ProjectNoteService
		 */
		private $service;

		/**
		 * ClientController constructor.
		 *
		 * @param ProjectNoteRepository $repository
		 * @param ProjectNoteService    $service
		 */
		public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service) {
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
		 * @param $noteId
		 *
		 * @return Response
		 */
		public function show($id, $noteId) {
			return $this->repository->findWhere([
				'project_id' => $id,
				'id'         => $noteId
			]);
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param $request
		 * @param $id
		 * @param $noteId
		 *
		 * @return Response
		 */
		public function update(Request $request, $id, $noteId) {
			return $this->service->update($request->all(), $noteId);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param $id
		 * @param $noteId
		 */
		public function destroy($id, $noteId) {
			$this->repository->delete($noteId);
		}
	}
