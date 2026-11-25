<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function create()
    {
        $defaultEmail = auth()->check() ? auth()->user()->email : '';
        $defaultName = auth()->check() ? (auth()->user()->name_kanji ?? auth()->user()->name) : '';

        return view('contact.create', compact('defaultEmail', 'defaultName'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $adminAddress = config('mail.from.address') ?: 'admin@example.com';
        $body = "送信者名: {$validated['name']}\n"
              . "返信先メールアドレス: {$validated['email']}\n"
              . "件名: {$validated['subject']}\n\n"
              . "お問い合わせ内容:\n{$validated['message']}";

        try {
            Mail::raw($body, function ($mail) use ($adminAddress, $validated) {
                $mail->to($adminAddress)
                     ->replyTo($validated['email'], $validated['name'])
                     ->subject('[Cytech EC お問い合わせ] ' . $validated['subject']);
            });
        } catch (Throwable $e) {
            Log::info('お問い合わせメール（開発環境フォールバック記録）', [
                'to' => $adminAddress,
                'from' => $validated['email'],
                'name' => $validated['name'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'error' => $e->getMessage(),
            ]);
        }

        return redirect('/contact')->with('success', 'お問い合わせを送信しました！');
    }
}
