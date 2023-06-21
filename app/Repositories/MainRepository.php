<?php

namespace App\Repositories;

use App\Models\MainModel;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class MainRepository
{

    /**
     * @var MainModel
     */
    private $model;

    /**
     * @param MainModel $model
     */
    public function __construct(MainModel $model)
    {
        $this->model = $model;
    }


    /**
     * @return Collection
     */
    public function index()
    {
        return $this->model->all();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->model::create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->model::find($id);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->model::find($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
       return $this->model->delete($id);
    }

}
