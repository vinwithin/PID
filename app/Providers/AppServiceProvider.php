<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email Anda - Pro-Ide')
                ->greeting('Halo, ' . $notifiable->name . ' 👋')
                ->line('Terima kasih telah mendaftar di *Pro-Ide*!')
                ->line('Untuk mengaktifkan akun Anda, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini.')
                ->action('Verifikasi Sekarang', $url)
                ->line('Jika Anda tidak membuat akun, Anda bisa mengabaikan email ini.')
                ->salutation('Salam hangat, Admin Pro-Ide 💡');
        });
    }
}
