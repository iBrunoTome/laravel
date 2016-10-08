<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ClientRepository;
	use CodeProject\Services\ClientService;
	use Illuminate\Auth\Access\Response;
	use Illuminate\Http\Request;

	class ClientController extends Controller {
		/**
		 * @var ClientRepository
		 */
		private $repository;
		/**
		 * @var ClientService
		 */
		private $service;

		/**
		 * ClientController constructor.
		 *
		 * @param ClientRepository $repository
		 * @param ClientService    $service
		 */
		public function __construct(ClientRepository $repository, ClientService $service) {
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
		 * @param int $id
		 *
		 * @return mixed
		 */
		public function show($id) {
			return $this->repository->find($id);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 */
		public function destroy($id) {
			$this->repository->find($id)->delete();
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param Request $request
		 * @param int     $id
		 *
		 * @return Response
		 */
		public function update(Request $request, $id) {
			return $this->service->update($request->all(), $id);
		}
	}
