<?php
/**
 * SignalController.php
 * Created by @anonymoussc on 6/5/2017 6:31 AM.
 */

namespace App\Components\Signal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class SignalController extends Controller
{
    public function index()
    {
        return view('signal::index');
    }
}
