<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="{{ asset('img/favicon.png') }}" sizes="any">
<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<!-- Meta Standar -->
<meta name="description" content="{{ $description ?? 'Bergabunglah dengan Oxydius, komunitas server Minecraft terdedikasi untuk player yang serius dan kreatif. Bangun, bertahan, dan taklukkan bersama kami.' }}">
<meta name="keywords" content="Minecraft, Server Minecraft, Komunitas Minecraft, Clan Minecraft, Oxydius, Survival, Creative, Indonesia">
<meta name="author" content="Oxydius Team">
<meta name="theme-color" content="#10b981"> {{-- Warna Address Bar di Mobile (Hijau Emerald) --}}

{{-- 2. Open Graph (Facebook, WhatsApp, Discord, LinkedIn) --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $title ?? 'Oxydius - ProwNetwork Clan' }}">
<meta property="og:description" content="{{ $description ?? 'Bergabunglah dengan Oxydius, komunitas server Minecraft terdedikasi untuk player yang serius dan kreatif.' }}">
{{-- Gambar Preview saat share link (Ganti URL ini dengan URL logo/banner asli Anda) --}}
<!-- <meta property="og:image" content="{{ $image ?? 'https://source.unsplash.com/1200x630/?minecraft,landscape' }}"> -->
<meta property="og:site_name" content="Oxydius">
<meta property="og:locale" content="id_ID">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance