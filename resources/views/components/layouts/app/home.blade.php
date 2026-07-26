<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
</head>
<body class="bg-zinc-900">
    <x-home-navbar />
    {{ $slot }}

    <footer class="py-8 bg-zinc-800">
        <div class="container px-6 mx-auto">
            <div class="flex flex-col items-center sm:flex-row sm:justify-between">
                <p class="text-sm text-zinc-300">© Copyright 2025 <span class="font-bold">Oxydius</span>. All Rights Reserved.</p>
                <div class="flex mt-3 -mx-2 sm:mt-0">
                    <a href="https://discord.gg/42x5wJRucf" class="mx-2 text-sm text-zinc-300 hover:text-zinc-400" aria-label="discord">Discord</a>
                </div>
            </div>
        </div>
    </footer>
    <script>

        // --- Skrip Skin Viewer (Sekarang dipanggil oleh Alpine.js) ---
        function initSingleSkinViewer(canvas, gamertag, skinUrl) {
            // Cek jika skinview3d sudah di-load (dari app.js)
            if (typeof skinview3d === 'undefined') {
                console.error('SkinView3D not loaded.');
                return;
            }
            if (!canvas || !gamertag) return;
            if (canvas.skinViewer) return; // Sudah di-init, jangan ulangi

            const skinViewer = new skinview3d.SkinViewer({
                canvas: canvas,
                width: 200,  
                height: 256, 
            });

            skinViewer.fov = 70;
            skinViewer.zoom = 0.8;
            
            // Logika prioritas skin
            if (skinUrl) {
                skinViewer.loadSkin(skinUrl);
            } else {
                skinViewer.loadSkin(`https://minotar.net/skin/${gamertag}`);
            }
            
            const control = skinview3d.createOrbitControls(skinViewer);
            control.enableZoom = false;

            canvas.skinViewer = skinViewer; // Tandai sudah di-init
        }
        
    </script>
</body>
</html>