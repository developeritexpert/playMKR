<?php
namespace App\Services;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Repositories\PasswordResetRepository;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class PasswordResetService
{
    protected $repository;

    public function __construct(PasswordResetRepository $repository)
    {
        $this->repository = $repository;
    }


    public function sendResetEmail(array $data)
    {
        $email = $data['email'];

        $token = Str::random(60);
        $hashedToken = Hash::make($token);

        $this->repository->createOrUpdate([
            'email' => $email,
            'token' => $hashedToken
        ]);

        $resetUrl = "https://yourfrontend.com/reset-password?token={$token}&email={$email}";

        Log::info('Sending Reset Password Mail from service');
        
        // Mail::to($email)->send(new ResetPasswordMail($resetUrl));
        Mail::to($email)->queue(new ResetPasswordMail($resetUrl));
    }


    public function resetPassword(array $data)
    {
        $email = $data['email'];
        $token = $data['token'];
        $newPassword = $data['password'];

        $record = $this->repository->findByEmail($email);

        if (!$record || !Hash::check($token, $record->token)) {
            throw new Exception('Invalid token.');
        }

        if (Carbon::parse($record->created_at)->addHour()->isPast()) {
            throw new Exception('Token expired.');
        }

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($newPassword);
        $user->save();

        $this->repository->deleteByEmail($email);
    }

}