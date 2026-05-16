<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ContactController extends \App\Http\Controllers\AppBaseController
{
    public function submit(Request $request)
    {
        try {
            Log::info('Contact submission received', [
                'ip' => $request->ip(),
                'ua' => $request->userAgent(),
            ]);
            $validated = $request->validate([
                'company' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:50',
                'email' => 'required|email:rfc|max:255',
                'message' => 'required|string|max:5000',
                'privacy' => 'required|accepted',
                'captcha' => 'required|integer',
                'captcha_hash' => 'required|string',
            ]);
            $answer  = (int) $request->input('captcha');
            $session = Session::get('captcha_answer');
            if ($session === null || $answer !== (int) $session) {
                ValidationException::withMessages([
                    'captcha' => ['Incorrect answer. Please try again.'],
                ]);
            }
            Session::forget('captcha_answer');

            $submission = ContactSubmission::create([
                'company' => $validated['company'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'message' => $validated['message'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent() ?? '',
                'user_agent_short' => Str::limit($request->userAgent(), 100),
                'status' => 'new',
            ]);
            Log::info('Contact submission saved', ['id' => $submission->id]);
            try {
                Mail::to('sixer0.bk@gmail.com')->send(new \App\Mail\ContactNotification($submission));
            } catch (\Throwable $e) {
                Log::warning('Email notification failed: ' . $e->getMessage());
            }
            return redirect()->route('home')
                ->with('success', 'Thank you for your message!');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Please fix the errors below.');
        } catch (\Throwable $e) {
            Log::error('Contact submission error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong.');
        }
    }
    public function captcha()
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $answer = $a + $b;
        Session::put('captcha_answer', $answer);
        return response()->json([
            'question' => "$a + $b",
            'hash'     => md5((string) $answer),
        ]);
    }
}
