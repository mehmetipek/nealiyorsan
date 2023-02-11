<?php

namespace App\Http\Controllers;

use App\FrequentlyAskedQuestions;
use App\Helpers\Helpers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\Console\Helper\Helper;

class FrequentlyAskedQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function categories()
    {
        if (Helpers::cacheHas('question_categories')) {
            $question = Helpers::cacheGet('question_categories');
        } else {
            $question['categories'] = FrequentlyAskedQuestions::distinct()->get(['question_category']);
            Helpers::cacheForever('question_categories', $question);
        }
        return response()->json($question);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = json_decode($this->categories()->getContent(), true)['categories'];

        return view('admin.question.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $request_all = $request->all();
        if (isset($request_all['new_category'])) {
            $request_all['question_category'] = $request_all['new_category'];
            unset($request_all['new_category']);
        } else {
            unset($request_all['new_category']);
        }

        $question = new FrequentlyAskedQuestions();

        $question->question = $request_all['question'];
        $question->answer = $request_all['answer'];
        $question->question_category = $request_all['question_category'];

        if ($question->save()) {
            if (Helpers::cacheHas('question_categories')) {
                Helpers::cacheDelete('question_categories');
                $question['categories'] = FrequentlyAskedQuestions::distinct()->get(['question_category']);
                Helpers::cacheForever('question_categories', $question);

            }
            return view('admin.success');
        } else {
            return view('admin.failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($category_id)
    {
        if (Helpers::cacheHas($category_id)) {
            $question = Helpers::cacheGet($category_id);
        } else {
            $question['data'] = FrequentlyAskedQuestions::whereQuestionCategory($category_id)->get();
            Helpers::cacheForever($category_id, $question);
        }
        return response()->json($question);
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
