<?php

namespace App\Http\Controllers;

use App\Models\PostUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    //

    public function index() {
        $postUser = PostUser::select('post_id', DB::raw('count(*) cnt')) -> groupBy('post_id')
            -> orderBy('cnt','desc') -> take(6) -> get();

//        $postUser = PostUser::selectRaw('post_id','count(*) cnt') -> groupBy('post_id') -> orderByDesc('cnt') -> take(6) -> get();

        return view('chart.index', compact('postUser'));
    }
}
