<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ClientRepository;
	use Illuminate\Http\Request;

	class ClientController extends Controller {
		/**
		 * @var ClientRepository
		 */
		private $repository;

		public function __construct(ClientRepository $repository) {
			$this->repository = $repository;
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
			return $this->repository->create($request->all());
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
		 */
		public function update(Request $request, $id) {
			$client = $this->repository->find($id);
			return $client->fill($request->all(), $id);
		}
	}
