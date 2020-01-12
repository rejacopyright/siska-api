<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class test_c extends Controller
{
  function test(){
    return auth::guard('admin')->user();
  }
}
