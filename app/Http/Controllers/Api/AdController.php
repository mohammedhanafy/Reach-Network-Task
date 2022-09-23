<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Ad;
use App\Models\User;
use App\Services\AdService;
use Illuminate\Http\Request;
use App\Http\Requests\AdRequest;
use App\Http\Resources\AdResource;
use App\Http\Controllers\Controller;

class AdController extends Controller
{

    /**
     * @var AdService
     */
    protected $adService;

    /**
     * Ad Service Constructor.
     *
     * @param AdService $adService
     */
    public function __construct(AdService $adService) {
        $this->adService = $adService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            return AdResource::collection($this->adService->getAllAds($request));
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdRequest $request)
    {
        try {
            $data = $request->only(['title', 'description', 'type', 'start_date', 'category_id', 'user_id', 'tags']);
            return new AdResource($this->adService->createAd($data));
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        try {
            return new AdResource($ad);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(AdRequest $request, Ad $ad)
    {
        try {
            $data = $request->only(['title', 'description', 'type', 'start_date', 'category_id', 'user_id', 'tags']);
            return new AdResource($this->adService->updateAd($ad, $data));      
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        try {
            $this->adService->deleteAd($ad);
            return response()->json(['success' => 'Ad deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }

    /**
     * show User Ads.
     *
     * @param User $user
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function showUserAds(User $user) {
        try {
            return AdResource::collection($this->adService->getUserAds($user));
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong', 'error_msg' => $e->getMessage()], 500);
        }
    }
}
