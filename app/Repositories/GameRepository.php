<?php
namespace App\Repositories;
use App\Models\Game;
use App\Http\Helpers\DateFormat;
	
class GameRepository extends BaseRepository
{
    public function __construct(Game $game=null)
    {
        $this->model = $game;
    }

    public function save($dataArray)
    {
        $dataArray['deleted'] =false;
        return $this->model = $this->model->create($dataArray);
    }
}