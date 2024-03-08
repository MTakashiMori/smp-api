<?php

namespace App\Services;

use App\Repositories\MainRepository;
use Illuminate\Database\Eloquent\Collection;

class MainService
{

    protected MainRepository $repository;

    /**
     * @param MainRepository $repository
     */
    public function __construct(MainRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Collection
     */
    public function index($id)
    {
        return $this->repository->index($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->repository->store($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->repository->show($id);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->repository->show($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }


}
