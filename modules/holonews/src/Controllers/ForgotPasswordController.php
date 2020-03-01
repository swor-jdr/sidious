<?php
namespace Modules\Holonews\Controllers;

use Modules\Holonews\Models\Author;
use Throwable;
use Illuminate\Support\Str;
use Modules\Holonews\Mail\ResetPasswordEmail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Show the reset-password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetRequestForm()
    {
        return view('holonews::request-password-reset');
    }

    /**
     * Send password reset email.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail()
    {
        validator(request()->all(), [
            'email' => 'required|email',
        ])->validate();

        if ($author = Author::whereEmail(request('email'))->first()) {
            cache(['password.reset.'.$author->id => $token = Str::random()],
                now()->addMinutes(30)
            );

            Mail::to($author->email)->send(new ResetPasswordEmail(
                encrypt($author->id.'|'.$token)
            ));
        }

        return redirect()->route('holonews.password.forgot')->with('sent', true);
    }

    /**
     * Show the new password to the user.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function showNewPassword($token)
    {
        try {
            $token = decrypt($token);

            [$authorId, $token] = explode('|', $token);

            $author = Author::findOrFail($authorId);
        } catch (Throwable $e) {
            return redirect()->route('holonews.password.forgot')->with('invalidResetToken', true);
        }

        if (cache('password.reset.'.$authorId) != $token) {
            return redirect()->route('holonews.password.forgot')->with('invalidResetToken', true);
        }

        cache()->forget('password.reset.'.$authorId);

        $author->password = \Hash::make($password = Str::random());

        $author->save();

        return view('holonews::reset-password', [
            'password' => $password,
        ]);
    }
}
