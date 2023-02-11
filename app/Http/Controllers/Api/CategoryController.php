<?php

namespace App\Http\Controllers\Api;

use App\Auction;
use App\Category;
use App\FieldTypeProperties;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{
    public function index($parent_id = null)
    {

        if ($parent_id != null) {
            $categories = Category::where('parent_id',$parent_id)->withDepth()->whereStatus(true)->get()->toTree();
        } else {
            $categories = Category::withDepth()->having('depth', '=', 0)->orHaving('depth', '=', 1)->whereStatus(true)->get()->toTree();

        }
        return response()->json([
            'user_id' => null,
            'data' => $categories,
            'count' => $categories->count(),
            'status' => ($categories->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    public function getSubCategory($parent_id)
    {
        /**
         * @TODO: Cache Eklenecek
         */
        $categories = Category::whereParentId($parent_id)->withDepth()->get();

        return response()->json([
            'user_id' => null,
            'data' => $categories,
            'count' => $categories->count(),
            'status' => ($categories->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    public function view($category_id, $json = false)
    {
        /**
         * @TODO: Cache Eklenecek
         */

        if(is_int($category_id)) {
            $category = Category::whereId($category_id)->with('ancestors')->with('descendants')->first();
        } else {
            $category = Category::whereSlug($category_id)->with('ancestors')->with('descendants')->first();
        }

        $category_temp_data = ['properties' => [], 'category' => [], 'ancestors' => [], 'auctions' => []];

        foreach ($category->ancestors AS $key => $ancestor) {
            $ancestor_category = Category::whereId($ancestor->id)->with('field_types')->first();
            $category_temp_data['ancestors'][$key] = ['name' => $ancestor_category->name, 'slug' => $ancestor_category->slug, 'id' => $ancestor_category->id];
            if (!is_null($ancestor_category->field_types)) {
                foreach ($ancestor_category->field_types AS $field_type) {
                    if ($field_type->type == 'checkbox') {
                        $field_values = FieldTypeProperties::whereFieldTypeId($field_type->id)->whereStatus(true)->get();
                        $field_type->related = $field_values;
                    }
                    $category_temp_data['properties'][$field_type->slug] = $field_type;
                }
                //$category_temp_data['properties'][$key] = $ancestor_category->field_types;
            }
        }

        $category_temp_data['category'] = $category->toArray();
        Arr::forget($category_temp_data['category'], ['ancestors', '_lft', '_rgt', 'parent_id']);
        $category_temp_data['category']['fields'] = $category_temp_data['properties'];
        $category_temp_data['category']['ancestors'] = $category_temp_data['ancestors'];
        $category = $category_temp_data['category'];
        unset($category_temp_data);

        if(count($category['descendants']) > 0) {
            $descendants_ids = data_get($category['descendants'], '*.id');
            $descendants_auctions = Auction::whereStatus(1)->whereIsDraft(0)->whereIn('id',$descendants_ids)->paginate(15);
            $category['auctions'] = $descendants_auctions;
        }

        /**
         * Descendants kullanılmadığı için şimdilik unset
         */
        unset($category['descendants']);

        if ($json == false) {
            return response()->json([
                'user_id' => null,
                'data' => $category,
                'count' => count($category),
                'status' => (count($category) > 0) ? 'success' : 'zero',
                'message' => ''
            ], 200);
        } else {
            return json_encode($category);
        }

    }
}
