<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class StatusLaporanUpdated extends Notification
{
    use Queueable;

    protected $laporan;

    /**
     * Create a new notification instance.
     */
    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->laporan->aspirasi->status ?? 'menunggu';
        $statusText = ucfirst($status);

        return [
            'laporan_id' => $this->laporan->id,
            'keterangan' => 'Status laporan Anda "' . Str::limit($this->laporan->ket, 30) . '" telah diubah menjadi ' . $statusText . '.',
            'status' => $status
        ];
    }
}
