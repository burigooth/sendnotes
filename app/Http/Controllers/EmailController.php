<?php

namespace App\Http\Controllers;

use App\Mail\NoteEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(User $user)
    {
        $toEmail = 'mateusburigo69@gmail.com';
        $message = "This is a test email";
        $subject = "Test Email";
        $name = $user->name;

        Mail::to($toEmail)->send(new NoteEmail($message, $subject, $name));

    }
}
