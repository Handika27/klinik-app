<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Announcement;

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
        // Bagikan data global ke semua view
        View::composer('*', function ($view) {
            // Status buka/tutup klinik berdasarkan jam operasional
            $currentTime = now();
            $currentHour = $currentTime->hour;
            $currentDay = $currentTime->dayOfWeek; // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
            
            // Contoh jam operasional: Senin-Sabtu 08:00-20:00, Minggu tutup
            $isOpen = false;
            $operationalMessage = '';
            
            if ($currentDay >= 1 && $currentDay <= 6) {
                if ($currentHour >= 8 && $currentHour < 20) {
                    $isOpen = true;
                    $operationalMessage = 'Buka (08:00 - 20:00 WIB)';
                } else {
                    $operationalMessage = 'Tutup - Buka besok pukul 08:00 WIB';
                }
            } else {
                $operationalMessage = 'Tutup - Buka Senin pukul 08:00 WIB';
            }
            
            // Pengumuman aktif
            $activeAnnouncements = Announcement::where('is_active', true)
                ->orderBy('tanggal_rilis', 'desc')
                ->get();
                
            // Nomor WhatsApp CS
            $waNumber = '628123456789';
            
            $view->with([
                'clinicIsOpen' => $isOpen,
                'clinicOperationalMessage' => $operationalMessage,
                'activeAnnouncements' => $activeAnnouncements,
                'waNumber' => $waNumber,
            ]);
        });
    }
}
