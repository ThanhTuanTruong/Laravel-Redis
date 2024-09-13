<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index()
    {
        Redis::set('user:1:first_name', 'Shaun');
        Redis::set('user:2:first_name', 'Hugh');
        Redis::set('user:3:first_name', 'Toby');

        for ($i = 1; $i <= 3; $i++) {
            echo Redis::get('user:' . $i . ':first_name') . '<br>';
        }
    }
}
