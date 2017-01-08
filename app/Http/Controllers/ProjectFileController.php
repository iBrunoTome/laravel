<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Symfony\Component\HttpFoundation\Request;

class ProjectFileController extends Controller
{
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
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->repository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        $this->service->createFile($data);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Acesso proibido'];
        }
        try {
            return $this->repository->find($id);
        } catch (ModelNotFoundException $e) {
            return [
                'error'   => true,
                'message' => 'Projeto não encontrado.'
            ];
        }
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)) {
            return true;
        }

        return false;
    }

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return ($this->repository->isOwner($projectId, $userId));
    }

    private function checkProjectMember($memberId)
    {
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
    public function destroy($id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Acesso proibido'];
        }
        try {
            $this->repository->delete($id);
            return [
                'error'   => false,
                'message' => 'Projeto deletado com sucesso.'
            ];
        } catch (QueryException $e) {
            return [
                'error'   => true,
                'message' => 'Projeto não pode ser apagado pois existe um ou mais notas vinculadas a ele.'
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'error'   => true,
                'message' => 'Projeto não encontrado.'
            ];
        } catch (\Exception $e) {
            return [
                'error'   => true,
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
    public function update(Request $request, $id)
    {
        if ($this->checkProjectPermissions($id) == false) {
            return ['error' => 'Acesso proibido'];
        }
        try {
            return $this->service->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return [
                'error'   => true,
                'message' => 'Projeto não encontrado.'
            ];
        } catch (\Exception $e) {
            return [
                'error'   => true,
                'message' => 'Ocorreu algum erro ao editar o projeto.'
            ];
        }
    }
}
