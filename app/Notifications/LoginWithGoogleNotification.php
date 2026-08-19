<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginWithGoogleNotification extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('[Travel Agent] Notifikasi Keamanan: Akun Berhasil Login')
            ->greeting('Yth. ' . $notifiable->name . ',')
            ->line('Kami menginformasikan bahwa akun Travel Agent Anda baru saja berhasil masuk (login) menggunakan metode autentikasi Akun Google.')
            ->line('Detail Aktivitas:')
            ->line('• Waktu Akses: ' . now()->timezone('Asia/Jakarta')->format('d F Y, H:i') . ' WIB')
            ->line('• Metode: Google Single Sign-On (SSO)')
            ->action('Akses Dashboard Anda', route('account.dashboard'))
            ->line('Apabila Anda tidak merasa melakukan aktivitas masuk ini, segera lakukan pengamanan pada akun Google Anda atau hubungi Tim Layanan Pelanggan Travel Agent.')
            ->salutation('Hormat kami,' . "\n" . 'Tim Keamanan Travel Agent');
    }
}