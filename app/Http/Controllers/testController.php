<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class testController extends Controller
{

    public function __construct() {
        $this -> middleware(['auth']) -> except(['loginError']);
    }
    //
    public function get(Request $request) {

        $data1['name'] = 'Kim';
        $data1['age'] = 25;
        $data2['test'] = 'test';
        $data2['testQ'] = 'Testq';
        $data['user'] = $data1;
        $data['test'] = $data2;
        return $data;
    }

    public function loginError(Request $request) {
        $data['error'] = '로그인 안 했어';
        return $data;
    }
}
