<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        try {
            \Log::info('Contact submission received', [
                'ip' => $request->ip(),
                'ua' => $request->userAgent(),
            ]);

            // Validate input
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

            // Verify captcha
            $hash = $request->input('captcha_hash');
            $answer = $request->input('captcha');

            if (!hash_equals($hash, md5((string) $answer))) {
                throw ValidationException::withMessages([
                    'captcha' => ['Incorrect answer. Please try again.'],
                ]);
            }

            // Store submission
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

            \Log::info('Contact submission saved', ['id' => $submission->id]);

            // Try to send email notification
            try {
                \Mail::to('sixer0.bk@gmail.com')->send(new \App\Mail\ContactNotification($submission));
            } catch (\Throwable $e) {
                \Log::warning('Email notification failed: ' . $e->getMessage());
            }

            return redirect()
                ->route('home')
                ->with('success', 'Thank you for your message! I will get back to you soon.');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the errors below.');

        } catch (\Throwable $e) {
            \Log::error('Contact submission error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
