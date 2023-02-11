<?php

namespace App\Http\Controllers;

use App\Auction;
use App\FileOrganizer;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Arr;
use phpDocumentor\Reflection\File;

class FileOrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($auction_id)
    {
        $files = FileOrganizer::ofAuction($auction_id)->get();

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $files,
            'count' => $files->count(),
            'status' => ($files->count() > 0) ? 'success' : 'zero',
            'message' => ''
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $request_all['related_model'] = $request_all['type'];
        $request_all['user_id'] = Auth::id();

        if (Arr::has($request_all, 'auction_id')) {
            $request_all['related_id'] = $request_all['auction_id'];
        }

        unset($request_all['auction_id']);

        $auction = $auction_owner = Auction::whereUserId(Auth::id())->whereId($request_all['related_id'])->first(); // isimden karışıklık olmasın diye iki isim verdim.

        if ($auction_owner->count() == 0) {
            return response()->json([
                'user_id' => Auth::id(),
                'data' => null,
                'count' => 0,
                'status' => 'error',
                'message' => 'Bu ilan kullanıcıya ait değil'
            ], 404);
        }

        if ($auction['profile_picture'] == null) {
            $auction->profile_picture = $request_all['file_name'];
            $auction->save();
        }

        $request_all['title'] = $auction_owner->title;

        $auction_file_count = FileOrganizer::whereRelatedId($request_all['related_id'])->count();
        if (env('FILE_LIMIT') != $auction_file_count) {
            $new_file = FileOrganizer::create($request_all);
        }


        return redirect()->route('api.file.list', ['auction_id' => $request_all['related_id']]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\FileOrganizer $fileOrganizer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($file_id)
    {
        $file = FileOrganizer::find($file_id);

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $file,
            'count' => 1,
            'status' => 'success',
            'message' => null
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\FileOrganizer $fileOrganizer
     * @return \Illuminate\Http\Response
     */
    public function edit(FileOrganizer $fileOrganizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\FileOrganizer $fileOrganizer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, FileOrganizer $fileOrganizer)
    {
        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }
        $fileOrg = FileOrganizer::whereUserId(Auth::id())->whereId($request_all['file_id'])->first();

        if ($fileOrg == null) {
            return response()->json([
                'user_id' => Auth::id(),
                'data' => null,
                'count' => 0,
                'status' => 'error',
                'message' => 'İlan Bulunamadı'
            ], 404);
        }

        $fileOrg->title = $request_all['title'];
        $fileOrg->file_name = $request_all['file_name'];
        $fileOrg->save();

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $fileOrg,
            'count' => 1,
            'status' => 'success',
            'message' => ''
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\FileOrganizer $fileOrganizer
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $file_id)
    {
        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }
        if ($request_all == null) {
            $request_all['file_id'] = $file_id;
        }

        $file = FileOrganizer::whereId($request_all['file_id'])->whereUserId(Auth::id())->first();
        if ($file) {
            $file->delete();
        } else {
            return response()->json([
                'user_id' => Auth::id(),
                'data' => null,
                'count' => 0,
                'status' => 'error',
                'message' => 'Dosya Bulunamadı'
            ], 404);
        }

        return response()->json([
            'user_id' => Auth::id(),
            'data' => null,
            'count' => 0,
            'status' => 'success',
            'message' => 'Başarılı şekilde silindi'
        ], 200);
    }


}
