<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatHookController extends AppBaseController
{
    /**
     * Handle the incoming chat webhook from Openclaw.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request)
    {
        Log::info('Nailla Chat Webhook Received:', [
            'ip' => $request->ip(),
            'payload' => $request->all(),
        ]);

        return response()->json(['status' => 'ok'], 200);
    }
}
