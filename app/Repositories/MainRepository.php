<?php

namespace App\Repositories;

use App\Models\MainModel;
use Illuminate\Database\Eloquent\Collection;

class MainRepository
{

    /**
     * @var MainModel
     */
    protected MainModel $model;

    protected $relationship;

    /**
     * @param MainModel $model
     */
    public function __construct(MainModel $model, $relationship = [])
    {
        $this->model = $model;
        $this->relationship = [];
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
