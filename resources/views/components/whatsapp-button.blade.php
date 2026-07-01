@php
    $currentRoute = request()->route()->getName() ?? '';
    $isGuest = !auth()->check();
    $isPasien = auth()->check() && auth()->user()->role === 'pasien';
    
    // Tampilkan tombol hanya di halaman welcome dan untuk pasien
    $showButton = $isGuest || $isPasien;
    
    if ($showButton):
        $waText = $isPasien 
            ? 'Halo Admin, saya ' . auth()->user()->name . ' ingin bertanya terkait layanan klinik.'
            : 'Halo Admin, saya ingin bertanya terkait layanan klinik.';
@endphp

<a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waText) }}" 
   target="_blank"
   class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-16 h-16 bg-green-500 hover:bg-green-600 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 hover:shadow-green-500/50 group">
    <svg class="w-8 h-8 text-white group-hover:scale-110 transition-transform duration-300" fill="currentColor" viewBox="0 0 24 24">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.812 11.812 0 0012.05 0C5.495 0 .162 5.333.162 11.889c0 2.099.547 4.142 1.588 5.94L0 24l6.308-1.654a11.882 11.882 0 005.74 1.448h.004c6.552 0 11.886-5.333 11.886-11.889 0-3.148-1.23-6.094-3.427-8.308z"/>
    </svg>
    <span class="absolute -top-10 right-0 bg-slate-800 text-white text-xs px-3 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap shadow-lg">
        Hubungi Admin
    </span>
</a>

@endif