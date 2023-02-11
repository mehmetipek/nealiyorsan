<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use http\Env\Response;
use Illuminate\Http\Request;
use Auth;
use App\City;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $user = User::whereId($request->user()->id)->with('profile')->first();
        if (isset($request_all['full_name'])) {
            $user->name = $request_all['full_name'];
        }
        if (isset($request_all['username'])) {
            $user->username = $request_all['username'];
        }



        if ($user->profile == null) {
            $profile = UserProfile::create([
                'user_id' => $user->id,
                'city_id' => $request_all['city_id'],
                'phone' => $request_all['phone'],
                'address_1' => $request_all['address_1'],
                'address_2' => $request_all['address_2'],
                'government_id' => $request_all['government_id'],
                'confirmation_1' => false,
                'confirmation_2' => false,

            ]);
        } else {
            $user->profile->phone = $request_all['phone'];
            $user->profile->address_1 = $request_all['address_1'];
            $user->profile->address_2 = $request_all['address_2'];
            $user->profile->government_id = $request_all['government_id'];
            $user->profile->confirmation_1 = false;
            $user->profile->confirmation_2 = false;
            $user->profile->city_id = $request_all['city_id'];
            $user->push();
        }
        $user->save();
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $user,
            'count' => $user->count(),
            'status' => ($user->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = User::whereId($request['id'])->first();
        /**
         * @todo unsetler modele eklenecek
         */
        unset($user['email']);
        unset($user['phone']);
        unset($user['created_at']);
        unset($user['updated_at']);
        unset($user['deleted_at']);

        return response()->json([
            'data' => $user,
            'count' => $user->count(),
            'status' => ($user->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
