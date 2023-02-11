<?php

namespace App\Http\Controllers;

use App\SearchLog;
use Illuminate\Http\Request;

class SearchLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchlogs = SearchLog::whereStatus(0)->paginate(15);
        return view('admin.search.index', compact('searchlogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.search.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SearchLog  $searchLog
     * @return \Illuminate\Http\Response
     */
    public function show(SearchLog $searchLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SearchLog  $searchLog
     * @return \Illuminate\Http\Response
     */
    public function edit(SearchLog $searchLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SearchLog  $searchLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SearchLog $searchLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SearchLog  $searchLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(SearchLog $searchLog)
    {
        //
    }
}
