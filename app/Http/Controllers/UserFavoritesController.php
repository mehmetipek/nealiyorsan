<?php

namespace App\Http\Controllers;

use App\UserFavorites;
use Illuminate\Http\Request;
use Auth;

class UserFavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $favorites = UserFavorites::whereUserId(Auth::id())->with('auctions')->get()->toArray();

        return response()->json([
            'data' => $favorites,
            // 'status' => ($favorites[0]->count() > 0) ? 'success' : 'zero',
        ], 200);

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request_all = $request->all();
        $favorite = new UserFavorites();

        $checkFavorite = UserFavorites::whereUserId(Auth::id())
            ->whereRelatedId($request_all['related_id'])
            ->whereModel($request_all['model'])->get();

        if ($checkFavorite->count() == 0) {
            $favorite->related_id = $request_all['related_id'];
            $favorite->user_id = Auth::id();
            $favorite->model = $request_all['model'];
            $favorite->price = $request_all['price'];
            $favorite->currency = $request_all['currency'];

            $favorite->save();
        } else {
            UserFavorites::whereId($checkFavorite[0]['id'])->delete();
            $favorite = null;
        }
        return response()->json([
            'data' => $favorite,
            'status' => ($favorite != null) ? 'success' : 'deleted',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\UserFavorites $userFavorites
     * @return \Illuminate\Http\Response
     */
    public function show(UserFavorites $userFavorites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\UserFavorites $userFavorites
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFavorites $userFavorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\UserFavorites $userFavorites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserFavorites $userFavorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\UserFavorites $userFavoritesw
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $userFavorites)
    {
        $delete = UserFavorites::whereId($userFavorites['id'])->delete();
        return $delete;
    }
}
