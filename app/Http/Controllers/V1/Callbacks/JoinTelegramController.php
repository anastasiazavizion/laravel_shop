<?php

namespace App\Http\Controllers\V1\Callbacks;

use App\Http\Controllers\Controller;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;

class JoinTelegramController extends Controller
{
    public function __invoke(TelegramLoginAuth $telegramLoginAuth, Request $request)
    {
        $data = $telegramLoginAuth->validate($request);
        if($data){
            auth()->user()->update(['telegram_id' => $data->getId()]);
        }
        return redirect()->back();
    }
}
