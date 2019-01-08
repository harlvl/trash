<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\Log;
abstract class BaseRepository {
    /**
     * The Model instance.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Get Model by id.
     *
     * @param  int  $id
     * @return App\Models\Model
     */
    public function getByIdHard($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get Model by id.
     *
     * @param  int  $id
     * @return App\Models\Model
     */
    public function getById($id)
    {
        return $this->model->where('id',$id)->where('deleted',false)->first();
    }

    /**
     * Set a value to the id attribute.
     *
     * @param  int  $id
     * @return App\Models\Model
     */
    public function setId($id)
    {
        return $this->model->id = $id;
    }

    /**
     * Set a certain model to the model attribute.
     *
     * @param  App\Models\Model
     * @return void
     */
    public function setModel($model)
    {
        return $this->model = $model;
    }
  
    /**
     * Get the whole model.
     *
     * @return App\Models\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get all of records.
     *
     * @return Model array
     */
    public function getAll()
    {
        $list = $this->model->where('deleted',false)->get();
        return $list;
    }

    /**
     * Update a model by its id.
     * 
     * @param array $data 
     * @return App\Models\Model
     */
    public function update($data)
    {
        $this->model->update($data);
        $newModel = $this->getById($this->model->id);
        $this->setModel($newModel);
    }

    public function softDelete()
    {
        $data= ['deleted'=>true];
        $this->model->update($data);
        $this->setModel(null);   
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}