<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeagueRequest;
use App\Http\Requests\UpdateLeagueRequest;
use App\Http\Resources\LeagueResource;
use App\Http\Services\LeagueService;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function __construct(public readonly LeagueService $leagueService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leagues = $this->leagueService->getAll();
        return LeagueResource::collection($leagues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeagueRequest $request)
    {
        $data = $request->validated();
        try {
            $league = $this->leagueService->create($data);

            return new LeagueResource($league);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(League $league)
    {
        return new LeagueResource($league->load('teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeagueRequest $request, League $league)
    {
        $data = $request->validated();
        $this->leagueService->update($data, $league);

        return new LeagueResource($league->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(League $league)
    {
        $league->delete();
        return response()->json([
            'message' => 'Successfully deleted league',
        ]);
    }

    public function activate(League $league)
    {
        $this->leagueService->activate($league);
        return response()->json([
            'message' => 'Successfully activated league',
        ]);
    }

    public function deactivate(League $league)
    {
        $this->leagueService->deactivate($league);
        return response()->json([
            'message' => 'Successfully deactivated league',
        ]);
    }

    public function active()
    {
        $leagues = $this->leagueService->activeLeagues();

        return LeagueResource::collection($leagues);
    }

}
