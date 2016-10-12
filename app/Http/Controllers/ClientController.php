<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Repositories\ClientRepository;
	use CodeProject\Services\ClientService;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Database\QueryException;
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
		 * @param $id
		 *
		 * @return mixed
		 */
		public function show($id) {
			try {
				return $this->repository->find($id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Cliente não encontrado.'
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
			} catch (QueryException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Cliente não pode ser apagado pois existe um ou mais projetos vinculados a ele.'
				];
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Cliente não encontrado.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar o cliente.'
				];
			}
		}

		/**
		 * Update the specified resource in storage.
		 *
		 * @param $request
		 * @param $id
		 *
		 * @return array
		 */
		public function update(Request $request, $id) {
			try {
				return $this->service->update($request->all(), $id);
			} catch (ModelNotFoundException $e) {
				return [
					'error'   => TRUE,
					'message' => 'Cliente não encontrado.'
				];
			} catch (\Exception $e) {
				return [
					'error'   => TRUE,
					'message' => 'Ocorreu algum erro ao editar o cliente.'
				];
			}
		}
	}
