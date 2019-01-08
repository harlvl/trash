<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Http\Controllers\Controller;

use App\Http\Resources\GameResource;
use App\Http\Resources\GamesResource;

use App\Http\Resources\ExceptionResource;
use App\Http\Resources\NotFoundResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\ValidationResource;
use App\Http\Resources\ResponseResource;

use App\Repositories\GameRepository;

use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    protected $gameRepository;

    public function __construct(GameRepository $gameRepository){
        GameResource::withoutWrapping();
        $this->gameRepository = $gameRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $games = $this->gameRepository->getAll();
            $gamesResource =  new GamesResource($games);  
            $responseResource = new ResponseResource(null);
            $responseResource->title('List of games');  
            $responseResource->body($gamesResource);
            return $responseResource;
        }catch(\Exception $e){
            return (new ExceptionResource($e))->response()->setStatusCode(500);   
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $gameData)
    {
        try{
            $validator = \Validator::make($gameData->all(), 
                            ['title' => 'required',
                            'genre' => 'required',
                            'release_date' => 'required']);

            if ($validator->fails()) {
                return (new ValidationResource($validator))->response()->setStatusCode(422);
            }

            DB::beginTransaction();
            $game = $this->gameRepository->save($gameData->all());
            DB::commit();

            $gameResource =  new GameResource($game);
            $responseResource = new ResponseResource(null);
            $responseResource->title('Game stored successfully');       
            $responseResource->body($gameResource);       
            return $responseResource;
        }catch(\Exception $e){
            DB::rollback();   
            return (new ExceptionResource($e))->response()->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 42;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
