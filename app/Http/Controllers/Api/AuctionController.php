<?php

namespace App\Http\Controllers\Api;

use App\Auction;
use App\AuctionComplaint;
use App\FileOrganizer;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Auth;

class AuctionController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $published = Auction::published(Auth::id());
        $unpublished = Auction::unpublished(Auth::id());
        $wait_republished = Auction::waitRepublished(Auth::id());
        $wait_published = Auction::waitPublished(Auth::id());

        if ($request_all != null) {
            if (isset($request_all['direction'])) {
                $published->whereDirection($request_all['direction']);
                $unpublished->whereDirection($request_all['direction']);
                $wait_republished->whereDirection($request_all['direction']);
                $wait_published->whereDirection($request_all['direction']);
            }
        }
        $auctions = [
            'published' => $published->get(),
            'unpublished' => $unpublished->get(),
            'wait_published' => $wait_published->get(),
            'wait_republished' => $wait_republished->get()
        ];

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auctions,
            'count' => $auctions['published']->count() + $auctions['unpublished']->count(),
            'status' => 'success',
            'message' => ''
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createRequest(Request $request)
    {
        /**
         * @TODO: Validate eklenecek
         * İlan türü gelmeli,
         * Kategori eklenecke
         */
        $auction_count = Auction::whereUserId(Auth::id())->count();

        if (env('AUCTION_LIMIT') <= $auction_count) {
            return response()->json([
                'user_id' => Auth::id(),
                'data' => ['id' => 0],
                'status' => 'over_limit',
                'message' => 'İlan limitiniz dolmuşutur'
            ], 200);
        }

        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $checkDraft = Auction::whereUserId(Auth::id())
            ->whereCategoryId($request_all['category_id'])
            ->whereStatus(0)
            ->whereIsDraft(1)
            ->whereDirection(Helpers::direction($request_all['direction']))
            ->get();

        if ($checkDraft->count() == 0) {
            $auction = Auction::create([
                'user_id' => Auth::id(),
                'category_id' => $request_all['category_id'],
                'direction' => Helpers::direction($request_all['direction']),
                'title' => 'Yeni ilan'
            ]);
        } else {
            $auction = $checkDraft[0];
        }
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auction,
            'count' => $auction->count(),
            'status' => ($auction->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request_all = $request->all();
        $auction = Auction::find($request_all['id']);
        if ($auction->user_id == Auth::id()) {
            $auction->title = $request_all['title'];
            $auction->description = $request_all['description'];
            $auction->price = $request_all['price'];
            $auction->min_price = $request_all['min_price'];
            $auction->max_price = $request_all['max_price'];
            $auction->currency = $request_all['currency'];
            $auction->is_draft = $request_all['is_draft'];
            /**
             * @TODO: category_properties ile ilgili ayrıca çalışma yapılacak.
             */
            if (isset($request_all['category_properties'])) {
                $auction->category_properties = $request_all['category_properties'];
            }

            $auction->save();
            /**
             * @todo kontroller sağlanacak
             */
            //sağlanacak kontrollere göre kontroller sağlanacak
            $cache_key = 'auction.' . $auction['id'];

            if (Helpers::cacheHas($cache_key)) {
                Helpers::cacheDelete($cache_key);
            }
            Helpers::cacheForever($cache_key, [
                'user_id' => Auth::id(),
                'data' => $auction,
            ]);

        }
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auction,
            'count' => $auction->count(),
            'status' => ($auction->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function drafts()
    {
        /**
         * TODO: category üst kategorileri de eklenecek.
         */
        $drafts = Auction::whereUserId(Auth::id())
            ->with(['category'])
            ->whereStatus(0)
            ->whereIsDraft(1)
            ->get();

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $drafts,
            'count' => $drafts->count(),
            'status' => ($drafts->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function last($limit = 30)
    {
        if ($limit > 30) {
            $limit = 30;
        } else {
            $limit = ceil($limit / 2);
        }

        if (Helpers::cacheHas('auction.last')) {
            $data = Helpers::cacheGet('auction.last');
        } else {

            $auction_last_selling = Auction::whereStatus(1)->whereIsDraft(0)->whereDirection(0)->take($limit)->get();
            $auction_last_buying = Auction::whereStatus(1)->whereIsDraft(0)->whereDirection(1)->take($limit)->get();
            $data = ['selling' => $auction_last_selling, 'buying' => $auction_last_buying];

            Helpers::cachePut('auction.last', $data);
        }

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $data,
            'count' => $data['selling']->count() + $data['buying']->count(),
            'status' => 'success',
            'message' => ''
        ], 200);
    }

    public function view($id, $full = '')
    {
        $cache_key = 'auction.' . $id;

        if (Helpers::cacheHas($cache_key)) {
            $auction = Helpers::cacheGet($cache_key);
            $auction = $auction['data'];
        } else {
            $auction = Auction::whereId($id)->with('images')->first();
            Helpers::cacheForever($cache_key, $auction);
        }
        if ($auction->user_id == Auth::id()) {
            /**
             * @TODO: bu kontrol sonra eklenecek.
             */
        }

        if ($full == 'full') {

            if (Helpers::cacheHas($cache_key . '.full')) {

                $auction['category'] = Helpers::cacheGet($cache_key . '.full');
            } else {
                $category = new CategoryController();
                $auction['category'] = json_decode($category->view($auction->category_id, true), true);
                $auction['user'] = User::whereId($auction->user_id)->with('profile')->first()->toArray();

                Helpers::cacheForever($cache_key . '.full', $auction);
            }
            $category = new CategoryController();
            $auction['category'] = json_decode($category->view($auction->category_id, true), true);
        }
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auction,
            'count' => 1,
            'status' => 'success',
            'message' => ''
        ], 200);
    }

    public function setProfilePicture($auction_id, $file_id)
    {
        $file = FileOrganizer::find($file_id);
        $auction = Auction::whereId($auction_id)->whereUserId(Auth::id())->first();
        if ($auction) {
            $auction->profile_picture = $file->file_name;
            $auction->save();

            return response()->json([
                'user_id' => Auth::id(),
                'data' => $auction,
                'count' => 1,
                'status' => 'success',
                'message' => ''
            ], 200);
        } else {
            return response()->json([
                'user_id' => Auth::id(),
                'data' => null,
                'count' => 0,
                'status' => 'error',
                'message' => 'İlan no yanlış.'
            ], 404);
        }

    }

    public function complaint(Request $request)
    {
        $request_all = $request->all();
        $complaint = new AuctionComplaint();

        $checkComplaint = AuctionComplaint::whereUserId(Auth::id())
            ->whereAuctionId($request_all['auction_id'])->get();


        if ($checkComplaint->count() == 0) {
            $complaint->auction_id = $request_all['auction_id'];
            $complaint->user_id = Auth::id();
            $complaint->complaint = $request_all['complaint'];

            $complaint->save();
        } else {
            $complaint = $checkComplaint[0];
        }
        return response()->json([
            'data' => $complaint,
            'status' => ($complaint->count() > 0) ? 'success' : 'zero',
        ], 200);
    }


    public function user_auctions(Request $request)
    {
        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $auctions = Auction::whereUserId($request_all['id'])->whereIsDraft(0)->whereStatus(1)->with(['images']);

        if ($request_all != null) {
            if (isset($request_all['direction'])) {
                $auctions->whereDirection($request_all['direction']);
            }
        }

        $auctions = $auctions->get();

        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auctions,
            'count' => $auctions->count(),
            'status' => ($auctions->count() > 0) ? 'success' : 'zero',
            'message' => ''
        ], 200);
    }

    public function statusChange(Request $request)
    {
        if ($request->isJson()) {
            $request_all = json_decode($request->getContent(), true);
        } else {
            $request_all = $request->all();
        }

        $auction = Auction::find($request_all['auction_id']);

        if ($auction->user_id == Auth::id()) {
            $auction->status = $request_all['status'];

            $auction->save();

            $cache_key = 'auction.' . $auction['id'];

            Helpers::cacheUpdate(Auth::id(), $auction, $cache_key);
        }
        return response()->json([
            'user_id' => Auth::id(),
            'data' => $auction,
            'count' => $auction->count(),
            'status' => ($auction->count() > 0) ? 'success' : 'zero',
            'message' => $request_all['auction_id'] . ' Numaralı ilan ile ilgili işlem gerçekleşti'
        ], 200);
    }
}
