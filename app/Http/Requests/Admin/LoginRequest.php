<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'user' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'max:255'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = trim($this->string('user')->toString());
        $password = $this->string('password')->toString();
        $admin = Admin::query()->whereKey($user)->first();

        if (! $admin || ! $this->passwordMatches($password, (string) $admin->getAuthPassword())) {
            RateLimiter::hit($this->throttleKey(), 60);

            throw ValidationException::withMessages([
                'user' => 'ユーザー名またはパスワードが正しくありません。',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Auth::guard('admin')->login($admin);
    }

    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'user' => "ログイン試行回数が多すぎます。{$seconds}秒後に再試行してください。",
        ]);
    }

    private function passwordMatches(string $plainPassword, string $storedPassword): bool
    {
        $passwordInfo = password_get_info($storedPassword);

        if (($passwordInfo['algoName'] ?? 'unknown') !== 'unknown') {
            return password_verify($plainPassword, $storedPassword);
        }

        // Compatibility with the current legacy admin table. Replace this
        // branch after the pass column is expanded and all passwords are hashed.
        return hash_equals($storedPassword, $plainPassword);
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('user')).'|'.$this->ip());
    }
}
