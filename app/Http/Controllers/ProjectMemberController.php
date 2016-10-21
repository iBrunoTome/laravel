<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ProjectMemberRepository;
	use CodeProject\Services\ProjectMemberService;

	class ProjectMemberController extends Controller {
		/**
		 * @var ProjectMemberRepository
		 */
		private $repository;
		/**
		 * @var ProjectMemberService
		 */
		private $service;

		/**
		 * ClientController constructor.
		 *
		 * @param ProjectMemberRepository $repository
		 * @param ProjectMemberService    $service
		 */
		public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service) {
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
	}
