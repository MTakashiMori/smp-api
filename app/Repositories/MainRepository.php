<?php

namespace App\Repositories;

use App\Models\MainModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->relationship = $relationship;
    }


    /**
     * @return Collection
     */
    public function index($request = null)
    {
        $data = $this->model->with($this->relationship ?: []);

        if($request)
        {
            $data->whereModelLike($request);
        }

        return $data->get();
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

    /**
     * @param $sql
     * @return array
     */
    public function runRawSql($sql)
    {
        return DB::select($sql);
    }

}
