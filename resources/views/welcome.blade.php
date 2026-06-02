<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LevelUp — Platform kontribusi sosial digital premium yang menghubungkan mahasiswa berbakat dengan UMKM Indonesia.">
    <title>LevelUp — Platform Kontribusi Sosial Digital</title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* ── Core Design Tokens (Landing Redesign) ── */
        :root {
            --primary-blue: #1E45FB;
            --accent-lime: #CDF22B;
            --bg-white: #FFFFFF;
            --text-dark: #0F172A;
            --text-muted: #475569;
            --border-light: rgba(30, 69, 251, 0.08);
            --shadow-subtle: 0 10px 30px -10px rgba(30, 69, 251, 0.04), 0 1px 3px rgba(30, 69, 251, 0.02);
            --shadow-premium: 0 20px 40px -15px rgba(30, 69, 251, 0.08), 0 1px 10px rgba(30, 69, 251, 0.03);
            --shadow-glow: 0 0 30px rgba(30, 69, 251, 0.15);
            --shadow-glow-lime: 0 0 30px rgba(205, 242, 43, 0.4);
            --font-head: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        /* ── Base Reset & Scroll behavior ── */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }
        body {
            background-color: var(--bg-white);
            color: var(--text-dark);
            font-family: var(--font-body);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── Grid/Abstract Decorative Backdrops ── */
        .decor-grid-bg {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(30, 69, 251, 0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(30, 69, 251, 0.02) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            z-index: 1;
        }
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }
        .glow-orb-blue {
            background: radial-gradient(circle, rgba(30, 69, 251, 0.15) 0%, transparent 70%);
        }
        .glow-orb-lime {
            background: radial-gradient(circle, rgba(205, 242, 43, 0.12) 0%, transparent 70%);
        }

        /* ── Modern Premium Typography ── */
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-head);
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--text-dark);
        }
        .headline-massive {
            font-size: clamp(2.5rem, 6.5vw, 4.75rem);
            line-height: 1.05;
            letter-spacing: -0.04em;
            font-weight: 900;
        }
        .headline-section {
            font-size: clamp(2rem, 4vw, 2.75rem);
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.03em;
        }
        .gradient-text-blue {
            background: linear-gradient(135deg, var(--primary-blue) 30%, #4f46e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Premium Buttons ── */
        .btn-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: var(--font-head);
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.875rem 2rem;
            border-radius: 9999px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }
        .btn-premium:active {
            transform: scale(0.97);
        }
        .btn-lime {
            background-color: var(--accent-lime);
            color: var(--text-dark);
        }
        .btn-lime:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow-lime), 0 8px 20px rgba(205, 242, 43, 0.2);
            filter: brightness(1.03);
        }
        .btn-outline-blue {
            background-color: transparent;
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .btn-outline-blue:hover {
            background-color: var(--primary-blue);
            color: var(--bg-white);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 69, 251, 0.15);
        }
        .btn-sm {
            padding: 0.5rem 1.25rem;
            font-size: 0.85rem;
        }
        .btn-lg {
            padding: 1rem 2.25rem;
            font-size: 1.05rem;
        }

        /* ── Glassmorphic & Floating Badges ── */
        .badge-premium {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(30, 69, 251, 0.04);
            border: 1px solid rgba(30, 69, 251, 0.08);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--primary-blue);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }
        .badge-premium-lime {
            background: rgba(205, 242, 43, 0.15);
            border: 1px solid rgba(205, 242, 43, 0.4);
            color: var(--text-dark);
        }
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            animation: pulse-glow-blue 2s infinite;
        }
        .pulse-dot-lime {
            background-color: var(--primary-blue);
            animation: pulse-glow-lime 2s infinite;
        }

        /* ── Glassmorphic Nav ── */
        .landing-nav-redesign {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 32px);
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(30, 69, 251, 0.06);
            border-radius: 9999px;
            padding: 0 1.5rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 40px -10px rgba(30, 69, 251, 0.06);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .landing-nav-redesign.scrolled {
            top: 8px;
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(30, 69, 251, 0.1);
            box-shadow: 0 12px 50px -10px rgba(30, 69, 251, 0.12);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-family: var(--font-head);
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-dark);
            transition: transform 0.2s;
        }
        .nav-logo:hover {
            transform: scale(1.02);
        }
        .nav-logo-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            color: var(--bg-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 900;
            box-shadow: 0 4px 12px rgba(30, 69, 251, 0.2);
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link-item {
            font-family: var(--font-head);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            padding: 8px 16px;
            border-radius: 999px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .nav-link-item:hover {
            color: var(--primary-blue);
            background: rgba(30, 69, 251, 0.04);
        }
        .nav-auth-buttons {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-nav-login {
            font-family: var(--font-head);
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-dark);
            text-decoration: none;
            padding: 8px 18px;
            transition: color 0.2s;
        }
        .btn-nav-login:hover {
            color: var(--primary-blue);
        }

        /* Mobile Hamburger Icon */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            width: 32px;
            height: 32px;
            position: relative;
            z-index: 1100;
        }
        .mobile-menu-toggle span {
            display: block;
            width: 20px;
            height: 2px;
            background-color: var(--text-dark);
            margin: 4px auto;
            transition: all 0.3s ease;
        }

        /* Mobile Drawer */
        .nav-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background-color: var(--bg-white);
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
            z-index: 999;
            padding: 80px 24px 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: right 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nav-drawer.open {
            right: 0;
        }
        .nav-drawer .nav-link-item {
            font-size: 1.1rem;
            padding: 10px 16px;
            width: 100%;
            box-sizing: border-box;
        }
        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.3);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .drawer-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        /* ── Hero Section Layout ── */
        .hero-section {
            padding: 180px 1.5rem 100px;
            position: relative;
            background: var(--bg-white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .hero-text-content {
            text-align: left;
        }
        .hero-desc {
            font-size: 1.15rem;
            color: var(--text-muted);
            max-width: 540px;
            margin: 1.5rem 0 2.5rem;
            line-height: 1.7;
        }
        .hero-cta-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3.5rem;
        }

        /* Floating Interactive Dashboard Widgets in Hero (Awwwards 3D vibe) */
        .hero-visual-wrapper {
            position: relative;
            width: 100%;
            max-width: 480px;
            height: 520px;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1000px;
            margin: 0 auto;
        }
        .visual-glass-canvas {
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 16px;
            border: 2px dashed rgba(30, 69, 251, 0.15);
        }
        .floating-widget {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(30, 69, 251, 0.1);
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: var(--shadow-premium);
            transition: all 0.3s;
            z-index: 10;
        }
        .floating-widget:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(30, 69, 251, 0.2);
            box-shadow: var(--shadow-glow);
        }
        
        /* Widget A: Active Mission completed Feed */
        .widget-mission-completed {
            top: 10px;
            left: 0px;
            width: 270px;
            animation: float-slow 6s ease-in-out infinite;
        }
        .widget-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .widget-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--primary-blue);
            letter-spacing: 0.05em;
        }
        .widget-badge {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            background: rgba(205, 242, 43, 0.2);
            color: var(--text-dark);
        }
        .widget-mission-body {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .widget-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            color: var(--bg-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
        }
        .widget-mission-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .widget-mission-sub {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Widget B: Portfolio Stat Radial */
        .widget-portfolio-stat {
            bottom: 20px;
            right: 10px;
            width: 240px;
            animation: float-mid 8s ease-in-out infinite;
        }
        .widget-stat-value {
            font-family: var(--font-head);
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-blue);
            line-height: 1;
            margin-top: 4px;
        }
        .widget-graph {
            height: 36px;
            display: flex;
            align-items: flex-end;
            gap: 4px;
            margin-top: 1rem;
        }
        .widget-bar {
            flex: 1;
            background: rgba(30, 69, 251, 0.1);
            border-radius: 4px;
            transition: all 0.3s;
        }
        .widget-bar.active {
            background: var(--primary-blue);
        }

        /* Widget C: Floating Badge Display */
        .widget-badge-reward {
            top: 130px;
            right: 0px;
            width: 185px;
            text-align: center;
            animation: float-fast 5s ease-in-out infinite;
            border-left: 4px solid var(--accent-lime);
        }
        .badge-icon-glow {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-blue), #4f46e5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 0.75rem;
            box-shadow: 0 4px 12px rgba(30, 69, 251, 0.3);
        }

        /* Floating animation keyframes */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @keyframes float-mid {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px) rotate(1deg); }
        }
        @keyframes float-fast {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes pulse-glow-blue {
            0%, 100% { box-shadow: 0 0 0 0 rgba(30, 69, 251, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(30, 69, 251, 0); }
        }
        @keyframes pulse-glow-lime {
            0%, 100% { box-shadow: 0 0 0 0 rgba(205, 242, 43, 0.6); }
            50% { box-shadow: 0 0 0 10px rgba(205, 242, 43, 0); }
        }

        /* ── Hero Stats Row ── */
        .hero-stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            background: #F8FAFC;
            border: 1px solid rgba(30, 69, 251, 0.05);
            border-radius: 24px;
            padding: 1.5rem 2rem;
            margin-top: 1.5rem;
        }
        .stat-card-redesign {
            text-align: center;
        }
        .stat-val-premium {
            font-family: var(--font-head);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-blue);
            line-height: 1;
            margin-bottom: 0.25rem;
        }
        .stat-lbl-premium {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ── Services Section ── */
        .services-section {
            padding: 120px 1.5rem;
            background: var(--bg-white);
            position: relative;
        }
        .section-header-wrap {
            max-width: 800px;
            margin: 0 auto 5rem;
            text-align: center;
        }
        .section-subtitle {
            font-family: var(--font-head);
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .services-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        .service-card-redesign {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 2.5rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
        }
        .service-card-redesign:hover {
            transform: translateY(-8px);
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-premium), 0 0 30px rgba(30, 69, 251, 0.05);
        }
        .service-card-redesign::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background-color: var(--primary-blue);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .service-card-redesign:hover::before {
            opacity: 1;
        }
        .service-card-redesign:hover .icon-box-premium {
            background-color: var(--accent-lime);
            color: var(--text-dark);
            transform: scale(1.05);
        }
        .icon-box-premium {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background-color: rgba(30, 69, 251, 0.05);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .service-card-redesign h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }
        .service-card-redesign p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }


        .bento-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 240px;
            gap: 2rem;
        }
        
        .bento-card {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 2.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-subtle);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .bento-card:hover {
            transform: scale(1.01) translateY(-4px);
            border-color: rgba(30, 69, 251, 0.15);
            box-shadow: var(--shadow-premium);
        }

        .bento-col-2 {
            grid-column: span 2;
        }
        .bento-row-2 {
            grid-row: span 2;
            height: auto;
        }
        .bento-card-header {
            max-width: 80%;
            margin-bottom: 1rem;
        }
        .bento-tag {
            display: inline-block;
            padding: 4px 10px;
            background: rgba(30, 69, 251, 0.05);
            color: var(--primary-blue);
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }
        .bento-card h3 {
            font-size: 1.35rem;
            margin-bottom: 0.5rem;
            line-height: 1.25;
        }
        .bento-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Interactive Bento Elements */
        /* UI A: Digital Mission Explorer list inside bento */
        .bento-mission-explorer {
            background: #F8FAFC;
            border-radius: 16px;
            padding: 1rem;
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 8px;
            border: 1px solid rgba(30, 69, 251, 0.04);
        }
        .bento-mission-item {
            background: var(--bg-white);
            border: 1px solid rgba(30, 69, 251, 0.06);
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
            cursor: pointer;
        }
        .bento-mission-item:hover {
            transform: translateX(4px);
            border-color: var(--primary-blue);
        }
        .bento-m-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .bento-m-difficulty {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
        }
        .diff-easy { background: rgba(34, 197, 94, 0.1); color: rgb(34, 197, 94); }
        .diff-medium { background: rgba(205, 242, 43, 0.25); color: var(--text-dark); }
        .diff-hard { background: rgba(239, 68, 68, 0.1); color: rgb(239, 68, 68); }

        /* UI B: Floating Achievement badging display */
        .bento-badge-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 1.5rem;
        }
        .bento-badge-item {
            background: #F8FAFC;
            border: 1px solid rgba(30, 69, 251, 0.04);
            border-radius: 16px;
            padding: 1rem 0.5rem;
            text-align: center;
            transition: all 0.3s;
        }
        .bento-badge-item:hover {
            background: var(--bg-white);
            border-color: var(--primary-blue);
            transform: scale(1.05);
        }
        .bento-badge-icon {
            font-size: 1.75rem;
            margin-bottom: 0.25rem;
        }
        .bento-badge-name {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* UI C: Timeline tracker */
        .bento-timeline {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            padding-left: 20px;
        }
        .bento-timeline::before {
            content: '';
            position: absolute;
            left: 5px; top: 8px; bottom: 8px;
            width: 2px;
            background: rgba(30, 69, 251, 0.08);
        }
        .bento-timeline-step {
            position: relative;
        }
        .bento-timeline-step::before {
            content: '';
            position: absolute;
            left: -20px; top: 4px;
            width: 12px; height: 12px;
            border-radius: 50%;
            background: var(--primary-blue);
            border: 2px solid var(--bg-white);
            box-shadow: 0 0 0 2px rgba(30, 69, 251, 0.15);
        }
        .bento-timeline-step.active::before {
            background: var(--accent-lime);
            box-shadow: 0 0 0 2px rgba(205, 242, 43, 0.3);
        }
        .bento-step-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .bento-step-desc {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        /* UI D: Premium Student Profile mock card */
        .bento-student-card {
            background: #F8FAFC;
            border: 1px solid rgba(30, 69, 251, 0.05);
            border-radius: 20px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 1.5rem;
        }
        .bento-std-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), #4f46e5);
            color: var(--bg-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
        }
        .bento-std-info h4 {
            font-size: 0.95rem;
            font-weight: 800;
        }
        .bento-std-info p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .bento-std-pill {
            display: inline-flex;
            padding: 2px 8px;
            border-radius: 99px;
            background: rgba(30, 69, 251, 0.08);
            color: var(--primary-blue);
            font-size: 0.68rem;
            font-weight: 700;
            margin-top: 4px;
        }

        /* ── Users Split / Roles Section ── */
        .roles-section {
            padding: 120px 1.5rem;
            background: var(--bg-white);
            position: relative;
        }
        .roles-container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
        }
        .role-show-card {
            background: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 28px;
            padding: 3rem;
            box-shadow: var(--shadow-subtle);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .role-show-card:hover {
            transform: translateY(-6px);
            border-color: rgba(30, 69, 251, 0.12);
            box-shadow: var(--shadow-premium);
        }
        .role-icon-lg {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        .role-show-card h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
        }
        .role-list {
            list-style: none;
            margin: 1.5rem 0 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .role-list li {
            font-size: 0.95rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .role-list-icon {
            color: var(--primary-blue);
            font-weight: 800;
        }

        /* ── Testimonials Section (Glassmorphism slider elements) ── */
        .testimonials-section {
            padding: 120px 1.5rem;
            background: #FAFAFA;
            position: relative;
        }
        .testimonials-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        .testimonial-card-premium {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-light);
            border-radius: 24px;
            padding: 2.25rem;
            box-shadow: var(--shadow-subtle);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .testimonial-card-premium:hover {
            transform: translateY(-4px);
            border-color: var(--primary-blue);
            box-shadow: var(--shadow-premium);
        }
        .testimonial-stars {
            color: #fbbf24;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .testimonial-quote {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            font-style: italic;
            margin-bottom: 1.5rem;
        }
        .testimonial-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .t-user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            color: var(--bg-white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(30, 69, 251, 0.1);
        }
        .t-user-name {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--text-dark);
        }
        .t-user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* ── Action Box Banner Section (CTA) ── */
        .action-banner-section {
            display: none;
            padding: 100px 1.5rem;
            background: var(--bg-white);
        }
        .cta-banner-card {
            max-width: 1100px;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--primary-blue) 0%, #1738cc 100%);
            border-radius: 36px;
            padding: 5rem 3rem;
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: 0 25px 60px -15px rgba(30, 69, 251, 0.35);
        }
        .cta-banner-card::before {
            content: '';
            position: absolute;
            top: -200px; left: -200px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(205, 242, 43, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }
        .cta-banner-card::after {
            content: '';
            position: absolute;
            bottom: -200px; right: -200px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .cta-glow-dot {
            position: absolute;
            width: 15px; height: 15px;
            border-radius: 50%;
            background-color: var(--accent-lime);
            animation: pulse-glow-lime 3s infinite;
        }
        .cta-banner-icon {
            width: 72px;
            height: 72px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            margin: 0 auto 2rem;
            color: var(--accent-lime);
            position: relative;
            z-index: 5;
        }
        .cta-banner-card h2 {
            font-size: clamp(2rem, 5vw, 3rem);
            color: var(--bg-white);
            margin-bottom: 1rem;
            position: relative;
            z-index: 5;
        }
        .cta-banner-card p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            max-width: 550px;
            margin: 0 auto 2.5rem;
            position: relative;
            z-index: 5;
        }
        .cta-banner-card .btn-premium {
            position: relative;
            z-index: 5;
            padding: 1.1rem 2.75rem;
            font-size: 1.1rem;
        }

        /* ── Redesigned Premium Footer ── */
        .site-footer-redesign {
            background-color: #FAFAFA;
            border-top: 1px solid var(--border-light);
            padding: 6rem 1.5rem 3rem;
            position: relative;
        }
        .footer-grid-premium {
            max-width: 1200px;
            margin: 0 auto 4rem;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 4rem;
        }
        .footer-brand h4 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            max-width: 260px;
        }
        .footer-socials {
            display: flex;
            gap: 12px;
        }
        .social-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--bg-white);
            border: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s;
        }
        .social-circle:hover {
            color: var(--primary-blue);
            background-color: rgba(30, 69, 251, 0.05);
            transform: scale(1.08);
            border-color: var(--primary-blue);
        }
        .footer-col h5 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-dark);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }
        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .footer-col ul a {
            font-size: 0.9rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s;
        }
        .footer-col ul a:hover {
            color: var(--primary-blue);
            padding-left: 4px;
        }
        .footer-divider-premium {
            height: 1px;
            background-color: var(--border-light);
            max-width: 1200px;
            margin: 0 auto 2rem;
        }
        .footer-bottom-premium {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-copy {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .footer-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px;
            background-color: var(--bg-white);
            border: 1px solid var(--border-light);
            border-radius: 99px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-muted);
        }
        .green-pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #22c55e;
            animation: pulse-green 2s infinite;
        }
        @keyframes pulse-green {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            50% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
        }

        /* ── Responsive Styling ── */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }
            .hero-text-content {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .hero-cta-group {
                justify-content: center;
            }
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: minmax(220px, auto);
            }
            .bento-col-2 {
                grid-column: span 2;
            }
            .bento-row-2 {
                grid-row: span 1;
            }
            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .landing-nav-redesign {
                padding: 0 0.5rem;
                height: 56px;
                border-radius: 16px;
                gap: 4px;
            }
            .nav-logo span {
                display: none;
            }
            .nav-links {
                display: flex !important;
                gap: 4px !important;
            }
            .nav-link-item {
                font-size: 0.72rem !important;
                padding: 4px 8px !important;
                white-space: nowrap;
            }
            .nav-auth-buttons {
                display: flex !important;
                gap: 4px !important;
            }
            .btn-nav-login {
                font-size: 0.72rem !important;
                padding: 4px 8px !important;
            }
            .btn-premium.btn-sm {
                font-size: 0.72rem !important;
                padding: 6px 10px !important;
                white-space: nowrap;
            }
            .mobile-menu-toggle {
                display: none !important;
            }
            .hero-section {
                padding-top: 140px;
            }
            .hero-visual-wrapper {
                height: 380px;
            }
            .visual-glass-canvas {
                width: 280px;
                height: 280px;
            }
            .floating-widget {
                padding: 0.8rem;
            }
            .widget-mission-completed {
                width: 220px;
                left: 10px;
                top: 0;
            }
            .widget-portfolio-stat {
                width: 200px;
                right: 10px;
                bottom: 10px;
            }
            .widget-badge-reward {
                width: 140px;
                right: 20px;
                top: 90px;
            }
            .hero-stats-row {
                grid-template-columns: repeat(2, 1fr);
                padding: 1.5rem;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            .bento-grid {
                grid-template-columns: 1fr;
            }
            .bento-col-2 {
                grid-column: span 1;
            }
            .roles-container {
                grid-template-columns: 1fr;
            }
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            .footer-grid-premium {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-stats-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            .cta-banner-card {
                padding: 3rem 1.5rem;
            }
            .footer-grid-premium {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Redesigned High-fidelity Navigation Bar -->
    <nav class="landing-nav-redesign" id="landing-nav">
        <a href="/" class="nav-logo">
            <img src="{{ asset('images/logo.png') }}" alt="LevelUp Logo" style="height:32px;width:auto;object-fit:contain;">
            <span>LevelUp</span>
        </a>
        
        <div class="nav-links">
            <a href="#features" class="nav-link-item">Fitur</a>
            <a href="#how-it-works" class="nav-link-item">Cara Kerja</a>
            <a href="/leaderboard" class="nav-link-item">Leaderboard</a>
        </div>
        
        <div class="nav-auth-buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-premium btn-lime btn-sm">Masuk Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav-login">Masuk</a>
                <a href="{{ route('register') }}" class="btn-premium btn-lime btn-sm">Daftar Gratis</a>
            @endauth
        </div>
    </nav>

    <!-- ── Hero Section Redesign ── -->
    <section class="hero-section">
        <div class="decor-grid-bg"></div>
        <div class="glow-orb glow-orb-blue" style="top: -100px; left: 10%; width: 600px; height: 600px;"></div>
        <div class="glow-orb glow-orb-lime" style="bottom: 100px; right: 5%; width: 500px; height: 500px;"></div>
        
        <div class="hero-container">
            <!-- Hero Left Side Text Context -->
            <div class="hero-text-content">
                <div class="badge-premium">
                    <span class="pulse-dot"></span>
                    Platform Kontribusi Sosial Digital #1 Indonesia
                </div>
                
                <h1 class="headline-massive">
                    Bangun Portfolio Nyata, <br>
                    <span class="gradient-text-blue">Bantu UMKM Go Digital</span>
                </h1>
                
                <p class="hero-desc">
                    Hubungkan kompetensi digital perkuliahanmu dengan tantangan riil UMKM Indonesia. Selesaikan mission terkurasi, kumpulkan lencana prestasi, dan bentuk portofolio profesional tangguh.
                </p>
                
                <div class="hero-cta-group">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-premium btn-lime btn-lg">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-premium btn-lime btn-lg">
                            ⚡ Mulai Sekarang — Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn-premium btn-outline-blue btn-lg">
                            Masuk Akun →
                        </a>
                    @endauth
                </div>

                <!-- Responsive Stats Row embedded in Hero bottom -->
                <div class="hero-stats-row">
                    @php $stats = [
                        ['value' => \App\Models\User::where('role','mahasiswa')->count().'+'  , 'label' => 'Mahasiswa'],
                        ['value' => \App\Models\User::where('role','umkm')->count().'+'       , 'label' => 'Mitra UMKM'],
                        ['value' => \App\Models\Mission::count().'+'                          , 'label' => 'Mission Berjalan'],
                        ['value' => \App\Models\Badge::count()                                , 'label' => 'Lencana Reward'],
                    ]; @endphp
                    @foreach($stats as $s)
                    <div class="stat-card-redesign">
                        <div class="stat-val-premium">{{ $s['value'] }}</div>
                        <div class="stat-lbl-premium">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Hero Right Side: Floating Interactive 3D Mock-dashboard -->
            <div class="hero-visual-wrapper">
                <div class="visual-glass-canvas"></div>
                
                <!-- Widget A: Mission success notification -->
                <div class="floating-widget widget-mission-completed">
                    <div class="widget-header">
                        <span class="widget-title">Mission Sukses</span>
                        <span class="widget-badge">+120 Poin</span>
                    </div>
                    <div class="widget-mission-body">
                        <div class="widget-avatar">🎓</div>
                        <div>
                            <div class="widget-mission-title">Landing Page Redesign</div>
                            <div class="widget-mission-sub">Oleh Mahasiswa LevelUp</div>
                        </div>
                    </div>
                </div>

                <!-- Widget B: Floating Badge Reward Award -->
                <div class="floating-widget widget-badge-reward">
                    <div class="badge-icon-glow">🏆</div>
                    <div class="widget-mission-title" style="margin-top: 4px;">Social Hero</div>
                    <div class="widget-mission-sub">Lencana Kontribusi</div>
                </div>

                <!-- Widget C: Dynamic Graph Data Widget -->
                <div class="floating-widget widget-portfolio-stat">
                    <div class="widget-header">
                        <span class="widget-title" style="color: var(--text-muted);">Kontribusi Bulanan</span>
                        <span class="pulse-dot" style="background-color: #22c55e;"></span>
                    </div>
                    <div class="widget-stat-value">84% Naik</div>
                    <div class="widget-graph">
                        <div class="widget-bar" style="height: 40%"></div>
                        <div class="widget-bar" style="height: 60%"></div>
                        <div class="widget-bar" style="height: 50%"></div>
                        <div class="widget-bar" style="height: 75%"></div>
                        <div class="widget-bar active" style="height: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Services / Feature Section Redesign ── -->
    <section id="features" class="services-section">
        <div class="section-header-wrap">
            <div class="section-subtitle">
                <span class="pulse-dot"></span>
                Kenapa LevelUp
            </div>
            <h2 class="headline-section">Platform Ekosistem Berkembang Terintegrasi</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Sistem modern yang dirancang untuk mendukung sinergi mahasiswa kreatif dan digitalisasi UMKM Indonesia secara komprehensif.</p>
        </div>

        <div class="services-grid">
            @php $features = [
                ['icon'=>'🎯','title'=>'Mission Terstruktur','desc'=>'UMKM mempublikasikan tantangan digital, mahasiswa mengajukan diri dan mengeksekusinya dalam ekosistem terkelola.'],
                ['icon'=>'🛡️','title'=>'Moderasi Pengawas','desc'=>'Setiap pengajuan divalidasi langsung oleh tim administrator untuk memastikan tingkat kesulitan dan keamanan terjamin.'],
                ['icon'=>'💼','title'=>'Portofolio Instan','desc'=>'Kompilasi portfolio profesional terbuat otomatis secara online lengkap dengan ulasan kepuasan dari UMKM mitra.'],
                ['icon'=>'⭐','title'=>'Lencana & Leveling','desc'=>'Dapatkan akumulasi poin keahlian nyata serta klaim ragam emblem prestasi bergengsi atas kontribusi sosial digitalmu.'],
                ['icon'=>'📊','title'=>'Monitor Progress','desc'=>'Pantau alur pengerjaan secara berkala melalui tracker status transparan, fitur diskusi tim, dan revisi praktis.'],
                ['icon'=>'🏆','title'=>'Papan Peringkat','desc'=>'Dapatkan sorotan prestasi pada leaderboard nasional sebagai apresiasi atas kontribusi sosial digital terbaik.'],
            ]; @endphp
            @foreach($features as $f)
            <div class="service-card-redesign">
                <div class="icon-box-premium">{{ $f['icon'] }}</div>
                <h3>{{ $f['title'] }}</h3>
                <p>{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ── How It Works Section ── -->
    <section id="how-it-works" class="services-section" style="background-color: #FAFAFA; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
        <div class="section-header-wrap">
            <div class="section-subtitle">
                <span class="pulse-dot"></span>
                Alur Kontribusi
            </div>
            <h2 class="headline-section">Cara Kerja Platform</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Ikuti langkah taktis berikut untuk memulai kolaborasi transformatif sosial digital.</p>
        </div>

        <!-- 4-step modern flow grid -->
        <div class="services-grid" style="grid-template-columns: repeat(4, 1fr); max-width: 1100px;">
            @php $steps = [
                ['num'=>'01','icon'=>'📝','title'=>'Buat Tantangan','desc'=>'Mitra UMKM mempublikasikan proposal mission bantuan digital terperinci.'],
                ['num'=>'02','icon'=>'🔍','title'=>'Verifikasi Admin','desc'=>'Pihak administrator memvalidasi dan mematok level kompleksitas mission.'],
                ['num'=>'03','icon'=>'🎓','title'=>'Kerjakan Mission','desc'=>'Mahasiswa terpilih merancang solusi digital dengan pendampingan.'],
                ['num'=>'04','icon'=>'🏆','title'=>'Raih Reward','desc'=>'Setelah serah terima sukses, mahasiswa mendapatkan portofolio, badge, dan poin.'],
            ]; @endphp
            @foreach($steps as $i => $s)
            <div class="service-card-redesign" style="text-align: center; padding: 2rem;">
                <div style="font-family: var(--font-head); font-weight: 900; font-size: 2.75rem; color: rgba(30, 69, 251, 0.15); margin-bottom: 0.5rem; line-height: 1;">{{ $s['num'] }}</div>
                <div style="font-size: 1.5rem; margin-bottom: 0.75rem;">{{ $s['icon'] }}</div>
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">{{ $s['title'] }}</h3>
                <p style="font-size: 0.85rem; line-height: 1.5;">{{ $s['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ── Roles Split Section ── -->
    <section class="roles-section">
        <div class="section-header-wrap">
            <div class="section-subtitle">
                <span class="pulse-dot"></span>
                Daftar Akun
            </div>
            <h2 class="headline-section">Sinergi Dua Aktor Utama</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Pilih peran kontribusimu dan mulai kolaborasi berdaya dorong tinggi.</p>
        </div>

        <div class="roles-container">
            <!-- Card Mahasiswa -->
            <div class="role-show-card">
                <div>
                    <div class="role-icon-lg">🎓</div>
                    <h3>Untuk Mahasiswa</h3>
                    <ul class="role-list">
                        <li><span class="role-list-icon">✓</span> Terapkan ilmu perkuliahan ke kasus nyata</li>
                        <li><span class="role-list-icon">✓</span> Bangun portofolio digital terverifikasi</li>
                        <li><span class="role-list-icon">✓</span> Kumpulkan lencana & tingkatkan peringkat</li>
                        <li><span class="role-list-icon">✓</span> Dapatkan poin kontribusi sosial kampus</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="btn-premium btn-lime btn-lg" style="width: 100%;">Gabung Sebagai Mahasiswa</a>
            </div>

            <!-- Card UMKM -->
            <div class="role-show-card" style="border-color: rgba(30, 69, 251, 0.1);">
                <div>
                    <div class="role-icon-lg">🏪</div>
                    <h3>Untuk Mitra UMKM</h3>
                    <ul class="role-list">
                        <li><span class="role-list-icon">✓</span> Solusi digitalisasi bisnis berkualitas</li>
                        <li><span class="role-list-icon">✓</span> Pendampingan pembuatan web, sosmed & logo</li>
                        <li><span class="role-list-icon">✓</span> Akses mahasiswa unggul berkompetensi</li>
                        <li><span class="role-list-icon">✓</span> Tanpa dipungut biaya operasional</li>
                    </ul>
                </div>
                <a href="{{ route('register') }}" class="btn-premium btn-outline-blue btn-lg" style="width: 100%;">Gabung Sebagai Mitra UMKM</a>
            </div>
        </div>
    </section>

    <!-- ── Testimonials Section Redesign ── -->
    <section class="testimonials-section">
        <div class="section-header-wrap">
            <div class="section-subtitle">
                <span class="pulse-dot"></span>
                Ulasan Komunitas
            </div>
            <h2 class="headline-section">Apa Kata Mereka Tentang LevelUp</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem;">Sinergi transformatif terbukti memberikan dampak riil bagi mahasiswa maupun pelaku UMKM.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card-premium">
                <div>
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Lewat LevelUp, saya berhasil membuat landing page profesional pertama saya untuk membantu UMKM kerajinan rotan lokal. Ini jadi portofolio andalan saya saat melamar magang!"</p>
                </div>
                <div class="testimonial-user">
                    <div class="t-user-avatar">AD</div>
                    <div>
                        <div class="t-user-name">Adi Darmawan</div>
                        <div class="t-user-role">Mahasiswa Informatika, ITB</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card-premium">
                <div>
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Kami terbantu sekali dalam pembuatan materi konten sosial media mingguan. Warung kami sekarang terlihat modern dan penjualan go-digital naik signifikan!"</p>
                </div>
                <div class="testimonial-user">
                    <div class="t-user-avatar">SR</div>
                    <div>
                        <div class="t-user-name">Siti Rahma</div>
                        <div class="t-user-role">Owner Dapur Nusantara (Mitra UMKM)</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card-premium">
                <div>
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-quote">"Sistem moderasi dan penilaian yang transparan membuat saya merasa aman. Selain portofolio, lencana reward yang didapatkan memotivasi saya terus kontribusi."</p>
                </div>
                <div class="testimonial-user">
                    <div class="t-user-avatar">FR</div>
                    <div>
                        <div class="t-user-name">Fajar Ramadan</div>
                        <div class="t-user-role">Mahasiswa Sistem Informasi, UI</div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- ── Premium Redesigned Footer ── -->
    <footer class="site-footer-redesign">
        <div class="footer-grid-premium">
            <div class="footer-brand">
                <h4>
                    <img src="{{ asset('images/logo.png') }}" alt="LevelUp Logo" style="height:28px;width:auto;object-fit:contain;">
                    <span>LevelUp</span>
                </h4>
                <p>Platform sosial kontribusi digital mahasiswa yang bersinergi memberdayakan kemandirian teknologi UMKM Indonesia.</p>
                
                <div class="footer-socials">
                    <a href="#" class="social-circle" aria-label="Facebook">FB</a>
                    <a href="#" class="social-circle" aria-label="Twitter">TW</a>
                    <a href="#" class="social-circle" aria-label="Instagram">IG</a>
                    <a href="#" class="social-circle" aria-label="LinkedIn">LN</a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Platform</h5>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#how-it-works">Cara Kerja</a></li>
                    <li><a href="#features">Fitur Utama</a></li>
                    <li><a href="/leaderboard">Leaderboard</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Bergabung</h5>
                <ul>
                    <li><a href="{{ route('register') }}">Registrasi Mahasiswa</a></li>
                    <li><a href="{{ route('register') }}">Registrasi Mitra UMKM</a></li>
                    <li><a href="{{ route('login') }}">Masuk Ke Dashboard</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Syarat & Ketentuan</h5>
                <ul>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat Layanan</a></li>
                    <li><a href="#">FAQ Bantuan</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-divider-premium"></div>

        <div class="footer-bottom-premium">
            <div class="footer-copy">
                &copy; {{ date('Y') }} LevelUp. Hak Cipta Dilindungi Undang-Undang.
            </div>
            
            <div class="footer-status">
                <span class="green-pulse-dot"></span>
                <span>Semua sistem berjalan normal</span>
            </div>
        </div>
    </footer>

    <!-- Native Smooth Scroll, Scroll Color Swap & Responsive Menu Drawer Script -->
    <script>
        // Transparent to solid header color swap on scroll
        const navBarElement = document.getElementById('landing-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                navBarElement.classList.add('scrolled');
            } else {
                navBarElement.classList.remove('scrolled');
            }
        });


    </script>
</body>
</html>
