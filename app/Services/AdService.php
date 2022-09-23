<?php

namespace App\Services;

use Exception;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Http\Request;

class AdService
{
    /**
     * Get all Ads.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAds(Request $request) {
        try {
            $ads = Ad::with('category', 'user', 'tags');
            if($request->has('category')) {
                $ads->where('category_id', $request->category);
            }
            if($request->has('tag')) {
                $tag = $request->tag;
                $ads->whereHas('tags', function($query) use($tag) {
                    $query->where('tag_id', $tag);
                });
            }
            return $ads->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Create Ad.
     *
     * @param array $record
     *
     * @return App\Models\Ad
     */
    public function createAd($record)
    {
        try {
            $ad = Ad::create($record);
            $ad->tags()->sync($record['tags']);
            return $ad;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Delete Ad.
     *
     * @param Ad $Ad
     * @param $record
     *
     * @return App\Models\Ad
     */
    public function updateAd(Ad $ad, $record)
    {
        try {
            $ad->update($record);
            $ad->tags()->sync($record['tags']);
            return $ad;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        
    }

    /**
     * Delete Ad.
     *
     * @param Ad $Ad
     *
     * @return void
     */
    public function deleteAd(Ad $ad)
    {
        try {
            $ad->delete();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get User Ads.
     *
     * @param User $user
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserAds(User $user) {
        try {
            return $user->ads()->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
