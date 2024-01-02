<?php

namespace App\Http\Controllers;

use App\Traits\AuthenticatedBusinessRequests;

/**
 * 事業所 認証後のコントローラー
 */
class AuthenticatedBusinessController extends Controller
{
    use AuthenticatedBusinessRequests;
}
