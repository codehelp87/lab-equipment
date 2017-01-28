<?php

namespace LabEquipment\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use LabEquipment\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function getEmail(Request $request)
    {
    $this->validate($request, ['email' => 'required|email']);

    $response = $this->sendResetLinkEmail($request, function($m)
    {
        $m->subject($this->getEmailSubject());
        $m->from('admin@chemdepartment.com', 'Chemistry Department');
    });

    switch ($response)
    {
        case Password::RESET_LINK_SENT:
            return[
                'error'=>'false',
                'msg'=>'A password link has been sent to your email address'
            ];

        case Password::INVALID_USER:
            return[
                'error'=>'true',
                'msg'=>"We can't find a user with that email address"
            ];
    }
}
}
