<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LevelUp') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="font-family:'Inter',sans-serif;background:#0A0E2A;min-height:100vh;">

    {{-- Background effects using LevelUp Brand Color Palette --}}
    <div style="position:fixed;inset:0;pointer-events:none;z-index:0;">
        {{-- Primary Blue Ambient Glow --}}
        <div style="position:absolute;top:-250px;left:50%;transform:translateX(-50%);width:900px;height:900px;border-radius:50%;background:radial-gradient(circle,rgba(30, 69, 251,0.22) 0%,transparent 70%);"></div>
        {{-- Accent Lime Ambient Glow (Bottom Right) --}}
        <div style="position:absolute;bottom:-150px;right:-150px;width:550px;height:550px;border-radius:50%;background:radial-gradient(circle,rgba(205, 242, 43,0.08) 0%,transparent 70%);"></div>
        {{-- Accent Lime Ambient Glow (Top Left) --}}
        <div style="position:absolute;top:-100px;left:-100px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(205, 242, 43,0.04) 0%,transparent 70%);"></div>
        {{-- Brand Grid Pattern --}}
        <div style="position:absolute;inset:0;background-image:linear-gradient(rgba(30, 69, 251,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(30, 69, 251,0.03) 1px,transparent 1px);background-size:60px 60px;"></div>
    </div>

    <div style="position:relative;z-index:1;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 1rem;">
        {{-- Logo --}}
        <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;margin-bottom:2.5rem;">
            <div style="width: 48px; height: 48px; border-radius: 50%; background: #ffffff; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(30, 69, 251, 0.15); overflow: visible;">
                <img src="{{ asset('images/logo.png') }}" alt="LevelUp Logo" style="height:32px;width:auto;object-fit:contain;">
            </div>
            <span style="font-size:1.4rem;font-weight:800;background:#F8FAFC;-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">LevelUp</span>
        </a>

        {{-- Card styled with modern branding border & shadow --}}
        <div style="width:100%;max-width:440px;background:#FFFFFF;backdrop-filter:blur(24px);border: 1px solid rgba(30, 69, 251, 0.12);border-radius:24px;padding:2.5rem;box-shadow:0 24px 80px rgba(0,0,0,0.5), 0 0 40px rgba(30, 69, 251, 0.05);">
            {{ $slot }}
        </div>

        {{-- Back link --}}
        <a href="/" style="margin-top:1.5rem;font-size:.8rem;color:#94A3B8;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#CDF22B'" onmouseout="this.style.color='#94A3B8'">
            ← Kembali ke Beranda
        </a>
    </div>
</body>
</html>
