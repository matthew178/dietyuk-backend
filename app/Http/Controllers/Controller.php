<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $req)
    {
        // $data['message'] = "contoh";
        // Mail::send('contoh', ['data'=> $data],
        //     function($message) use ($req)
        //     {
        //         $message->subject("Test");
        //         $message->from("hendrymatthew97@gmail.com","hendrymatthew97@gmail.com");
        //         $message->to("mhendry106@gmail.com");
        //     }
        // );
    }
}
