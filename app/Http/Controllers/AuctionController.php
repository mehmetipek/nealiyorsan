<?php

namespace App\Http\Controllers;

use App\Auction;
use App\AuctionLog;
use App\Helpers\Helpers;
use App\Http\Controllers\Api\CategoryController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auctions = Auction::whereStatus(false)->whereIsDraft(false)->paginate(15);

        return view('admin.auction.index', compact('auctions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Auction $aucton
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auction = Auction::whereId($id)->with('images')->first()->toArray();
        $category = new CategoryController();
        $auction['category'] = json_decode($category->view($auction['category_id'], true), true);
        $auction['user'] = User::whereId($auction['user_id'])->with('profile')->first()->toArray();

        $auction['logs'] = AuctionLog::whereAuctionId($auction['id'])->orderBy('id', 'DESC')->with(['user'])->get()->toArray();

        Carbon::setLocale('tr');
        return view('admin.auction.edit', compact('auction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Auction $aucton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $aucton)
    {
        $request_all = $request->all(['status', 'auction_id', 'status_message']);

        $aucton = Auction::find($request_all['auction_id']);
        $aucton->status = $request_all['status'];
        $aucton->save();

        if ($request_all['status'] == 1) {
            $message = "İlan Yayınlandı";
        } else if ($request_all['status'] == 2) {
            $message = "Ilan Geri Çevrildi";
        }

        if (is_null($request_all['status_message'])) {
            $request_all['status_message'] = '';
        }

        $log_data = [
            'auction_id' => $aucton->id,
            'user_id' => Auth::id(),
            'status' => $request_all['status'],
            'status_message' => $request_all['status_message']
        ];

        AuctionLog::create($log_data);

            return redirect()->back()->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Auction $aucton
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $aucton)
    {
        //
    }
}
