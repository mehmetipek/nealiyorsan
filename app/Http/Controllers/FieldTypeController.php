<?php

namespace App\Http\Controllers;

use App\Category;
use App\FieldType;
use App\FieldTypeProperties;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FieldTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = FieldType::paginate(15);

        return view('admin.field.index', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::defaultOrder()->get()->toTree();
        return view('admin.field.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_all = $request->all();
        $type = $request_all['type'];

        if ($type == 'select') {
            if (isset($request_all['static_values'])) {
                $request_all['static_values'] = Helpers::stringToArray($request_all['static_values']);
            }
        } else if ($type == 'checkbox') {
            if (isset($request_all['checkbox_values'])) {
                $checkbox_values = Helpers::stringToArray($request_all['checkbox_values']);

            }
        }

        $field_type = FieldType::create($request_all);

        if ($type == 'checkbox') {
            if (isset($checkbox_values)) {
                foreach ($checkbox_values AS $key => $val) {
                    $checkbox_values[$key] = [
                        'field_type_id' => $field_type->id,
                        'value' => $val,
                        'slug' => Str::slug($val, '-'),
                    ];
                }
                FieldTypeProperties::insert($checkbox_values);
            }

        }

        return redirect()->route('admin.field.index')->with(['status' => 'Yeni tip eklendi']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\FieldType $fieldType
     * @return \Illuminate\Http\Response
     */
    public function show(FieldType $fieldType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\FieldType $fieldType
     * @return \Illuminate\Http\Response
     */
    public function edit(FieldType $fieldType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\FieldType $fieldType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FieldType $fieldType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\FieldType $fieldType
     * @return \Illuminate\Http\Response
     */
    public function destroy(FieldType $fieldType)
    {
        //
    }
}
