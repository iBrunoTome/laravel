<?php

	namespace CodeProject\Http\Controllers;

	use CodeProject\Models\Client;
	use Illuminate\Auth\Access\Response;
	use Illuminate\Http\Request;

	class ClientController extends Controller {
		/**
		 * Display a listing of the resource.
		 *
		 * @return static[]
		 */
		public function index() {
			return Client::all();
		}

		/**
		 * Store a newly created resource in storage.
		 *
		 * @param Request $request
		 *
		 * @return Client
		 */
		public function store(Request $request) {
			return Client::create($request->all());
		}

		/**
		 * Display the specified resource.
		 *
		 * @param int $id
		 *
		 * @return Response
		 */
		public function show($id) {
			return Client::find($id);
		}

		/**
		 * Remove the specified resource from storage.
		 *
		 * @param int $id
		 *
		 * @return Response
		 */
		public function destroy($id) {
			Client::find($id)->delete();
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
			$client = Client::find($id);
			return $client->fill($request->all(), $id);
		}
	}
