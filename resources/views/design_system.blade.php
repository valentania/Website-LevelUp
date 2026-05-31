<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LevelUp Brand Design System Hub and Interactive Portal">
    <title>LevelUp — Design System Portal & Explorer</title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js CDN for robust interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Premium Dashboard layout */
        .ds-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
            background: #FFFFFF;
        }
        
        .ds-sidebar {
            background: #FAFAFA;
            border-right: 1px solid rgba(30, 69, 251, 0.08);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 10;
        }

        .ds-content {
            padding: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            overflow-x: hidden;
        }

        /* Nav links in explorer */
        .ds-nav-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            transition: all 0.2s;
            text-align: left;
        }

        .ds-nav-btn:hover {
            color: #1E45FB;
            background: rgba(30, 69, 251, 0.04);
        }

        .ds-nav-btn.active {
            color: #1E45FB;
            background: rgba(30, 69, 251, 0.08);
        }

        /* Mock Screen container */
        .mock-screen {
            border: 1px solid rgba(30, 69, 251, 0.08);
            border-radius: 20px;
            background: #FFFFFF;
            box-shadow: 0 20px 40px -15px rgba(30, 69, 251, 0.06);
            overflow: hidden;
            transition: all 0.3s;
        }

        .mock-screen-header {
            background: #FAFAFA;
            border-bottom: 1px solid rgba(30, 69, 251, 0.06);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dot-red { width: 10px; height: 10px; border-radius: 50%; background: #EF4444; }
        .dot-yellow { width: 10px; height: 10px; border-radius: 50%; background: #F59E0B; }
        .dot-green { width: 10px; height: 10px; border-radius: 50%; background: #10B981; }

        .mock-screen-body {
            background: #FFFFFF;
            min-height: 550px;
            position: relative;
        }

        /* Component Demo Grid */
        .comp-card {
            border: 1px solid rgba(30, 69, 251, 0.08);
            border-radius: 16px;
            padding: 1.5rem;
            background: #FFFFFF;
            transition: all 0.3s;
        }

        .comp-card:hover {
            border-color: rgba(30, 69, 251, 0.15);
            box-shadow: 0 10px 25px -10px rgba(30, 69, 251, 0.04);
        }

        /* Scrollbar styling */
        .ds-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .ds-sidebar::-webkit-scrollbar-track {
            background: #FAFAFA;
        }
        .ds-sidebar::-webkit-scrollbar-thumb {
            background: rgba(30, 69, 251, 0.1);
            border-radius: 2px;
        }

        /* Neon Lime CTA badge glow */
        .lime-glow {
            box-shadow: 0 0 15px rgba(205, 242, 43, 0.4);
        }
        
        .blue-glow {
            box-shadow: 0 0 15px rgba(30, 69, 251, 0.2);
        }
    </style>
</head>
<body class="font-sans antialiased bg-white text-slate-900" x-data="{ 
    activeTab: 'tokens', // tokens, components, pages
    activeSubItem: 'color', // color, typography, grids etc. OR component index OR page index
    
    // Components state
    isModalOpen: false,
    selectedCategory: 'all',
    sortOrder: 'highest',
    
    // Page state variables
    activePageCategory: 'public',
    activePageIndex: 1,

    // Chat demo states
    chatInput: '',
    chatMessages: [
        { sender: 'client', text: 'Halo! Apakah portofolio desain UI/UX Anda bisa dikirimkan?', time: '14:20' },
        { sender: 'me', text: 'Tentu, ini link portofolio Figma saya. Semuanya menggunakan design system premium.', time: '14:22' },
        { sender: 'client', text: 'Keren sekali! Kami ingin mempekerjakan Anda untuk proyek redesign UMKM Kopi.', time: '14:23' }
    ],
    sendChatMessage() {
        if(this.chatInput.trim() !== '') {
            this.chatMessages.push({ sender: 'me', text: this.chatInput, time: 'Baru saja' });
            this.chatInput = '';
            setTimeout(() => {
                this.chatMessages.push({ sender: 'client', text: 'Terima kasih atas respons cepatnya! Mari lanjut ke milestone workspace.', time: 'Baru saja' });
            }, 1000);
        }
    },

    // Bidding quick state
    bidAmount: 1500000,
    hasApplied: false,

    // Project creation state
    newProjTitle: 'Desain Aplikasi E-Commerce UMKM Hijab',
    newProjBudget: 2500000,
    newProjDuration: '14 Hari',
    newProjDesc: 'Kami membutuhkan mahasiswa kreatif untuk merancang tampilan UI/UX aplikasi mobile store kami agar tampak modern dan premium.',
    
    // Admin moderation states
    users: [
        { name: 'Ahmad Satrio', role: 'Mahasiswa', status: 'Aktif', rating: 4.8 },
        { name: 'Kopi Kenangan Kampus', role: 'UMKM Client', status: 'Pending Verifikasi', rating: 4.5 },
        { name: 'Budi Santoso', role: 'Mahasiswa', status: 'Ditangguhkan', rating: 3.2 }
    ],
    suspendReason: '',
    selectedUserToSuspend: 'Budi Santoso',
    suspendUser() {
        alert('User ' + this.selectedUserToSuspend + ' telah berhasil ditangguhkan dengan alasan: ' + this.suspendReason);
        this.suspendReason = '';
    }
}">

<div class="ds-layout">
    
    <!-- Sidebar -->
    <aside class="ds-sidebar flex flex-col justify-between">
        <div class="p-6">
            <!-- Brand Logo -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-extrabold text-lg shadow-md">
                    L
                </div>
                <div>
                    <h1 class="font-extrabold tracking-tight text-lg text-slate-900 leading-tight">LevelUp</h1>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#1E45FB]">Design System Portal</span>
                </div>
            </div>

            <!-- Tab Selection -->
            <div class="flex flex-col gap-1 mb-8">
                <button @click="activeTab = 'tokens'; activeSubItem = 'color'" 
                        :class="activeTab === 'tokens' ? 'bg-[#1E45FB]/8 text-[#1E45FB]' : 'text-slate-600 hover:bg-slate-100'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition duration-200 text-left">
                    <i class="fa-solid fa-palette w-5"></i>
                    Brand & Tokens
                </button>
                <button @click="activeTab = 'components'; activeSubItem = 'buttons'" 
                        :class="activeTab === 'components' ? 'bg-[#1E45FB]/8 text-[#1E45FB]' : 'text-slate-600 hover:bg-slate-100'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition duration-200 text-left">
                    <i class="fa-solid fa-cubes w-5"></i>
                    Component Library (17)
                </button>
                <button @click="activeTab = 'pages'; activePageCategory = 'public'; activePageIndex = 1" 
                        :class="activeTab === 'pages' ? 'bg-[#1E45FB]/8 text-[#1E45FB]' : 'text-slate-600 hover:bg-slate-100'"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-sm transition duration-200 text-left">
                    <i class="fa-solid fa-laptop-code w-5"></i>
                    Interactive Pages (37)
                </button>
            </div>

            <!-- Contextual Sidebar Nav Elements -->
            
            <!-- Category Tokens -->
            <template x-if="activeTab === 'tokens'">
                <div>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block px-3 mb-3">Core Variables</span>
                    <nav class="flex flex-col gap-1">
                        <button @click="activeSubItem = 'color'" :class="activeSubItem === 'color' ? 'active' : ''" class="ds-nav-btn">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1E45FB]"></span> Brand Palette
                        </button>
                        <button @click="activeSubItem = 'typography'" :class="activeSubItem === 'typography' ? 'active' : ''" class="ds-nav-btn">
                            <i class="fa-solid fa-font text-xs"></i> Typography System
                        </button>
                        <button @click="activeSubItem = 'shadows'" :class="activeSubItem === 'shadows' ? 'active' : ''" class="ds-nav-btn">
                            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i> Shadows & Glass
                        </button>
                    </nav>
                </div>
            </template>

            <!-- Category Components -->
            <template x-if="activeTab === 'components'">
                <div>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block px-3 mb-3">UI Components</span>
                    <nav class="flex flex-col gap-1 overflow-y-auto max-h-[50vh] pr-1">
                        <button @click="activeSubItem = 'buttons'" :class="activeSubItem === 'buttons' ? 'active' : ''" class="ds-nav-btn">1. Buttons & Actions</button>
                        <button @click="activeSubItem = 'inputs'" :class="activeSubItem === 'inputs' ? 'active' : ''" class="ds-nav-btn">2. Modern Input Fields</button>
                        <button @click="activeSubItem = 'badges'" :class="activeSubItem === 'badges' ? 'active' : ''" class="ds-nav-btn">3. Custom Badges & Tags</button>
                        <button @click="activeSubItem = 'cards'" :class="activeSubItem === 'cards' ? 'active' : ''" class="ds-nav-btn">4. Glassmorphism Cards</button>
                        <button @click="activeSubItem = 'navigation'" :class="activeSubItem === 'navigation' ? 'active' : ''" class="ds-nav-btn">5. Responsive Navbars</button>
                        <button @click="activeSubItem = 'sidebars'" :class="activeSubItem === 'sidebars' ? 'active' : ''" class="ds-nav-btn">6. Collapsible Sidebars</button>
                        <button @click="activeSubItem = 'modals'" :class="activeSubItem === 'modals' ? 'active' : ''" class="ds-nav-btn">7. Interactive Modals</button>
                        <button @click="activeSubItem = 'dropdowns'" :class="activeSubItem === 'dropdowns' ? 'active' : ''" class="ds-nav-btn">8. Custom Dropdowns</button>
                        <button @click="activeSubItem = 'tables'" :class="activeSubItem === 'tables' ? 'active' : ''" class="ds-nav-btn">9. Data Tables Grid</button>
                        <button @click="activeSubItem = 'charts'" :class="activeSubItem === 'charts' ? 'active' : ''" class="ds-nav-btn">10. Inline SVG Charts</button>
                        <button @click="activeSubItem = 'empty'" :class="activeSubItem === 'empty' ? 'active' : ''" class="ds-nav-btn">11. Empty States Panel</button>
                        <button @click="activeSubItem = 'skeletons'" :class="activeSubItem === 'skeletons' ? 'active' : ''" class="ds-nav-btn">12. Loading Skeletons</button>
                        <button @click="activeSubItem = 'alerts'" :class="activeSubItem === 'alerts' ? 'active' : ''" class="ds-nav-btn">13. Toast Alert Banners</button>
                        <button @click="activeSubItem = 'chat'" :class="activeSubItem === 'chat' ? 'active' : ''" class="ds-nav-btn">14. Chat UI Bubbles</button>
                        <button @click="activeSubItem = 'progress'" :class="activeSubItem === 'progress' ? 'active' : ''" class="ds-nav-btn">15. Progress Milestones</button>
                        <button @click="activeSubItem = 'profile'" :class="activeSubItem === 'profile' ? 'active' : ''" class="ds-nav-btn">16. Floating Avatars</button>
                        <button @click="activeSubItem = 'stats'" :class="activeSubItem === 'stats' ? 'active' : ''" class="ds-nav-btn">17. Stats Grid Layout</button>
                    </nav>
                </div>
            </template>

            <!-- Category Pages -->
            <template x-if="activeTab === 'pages'">
                <div class="flex flex-col gap-6">
                    <div>
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block px-3 mb-2">Roles & Context</span>
                        <div class="flex flex-wrap gap-1 bg-slate-100 p-1.5 rounded-xl">
                            <button @click="activePageCategory = 'public'; activePageIndex = 1" :class="activePageCategory === 'public' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="flex-1 text-center py-1.5 text-[11px] font-bold rounded-lg transition duration-200">Public & Auth</button>
                            <button @click="activePageCategory = 'student'; activePageIndex = 1" :class="activePageCategory === 'student' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="flex-1 text-center py-1.5 text-[11px] font-bold rounded-lg transition duration-200">Student</button>
                            <button @click="activePageCategory = 'client'; activePageIndex = 1" :class="activePageCategory === 'client' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="flex-1 text-center py-1.5 text-[11px] font-bold rounded-lg transition duration-200">Client</button>
                            <button @click="activePageCategory = 'admin'; activePageIndex = 1" :class="activePageCategory === 'admin' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="flex-1 text-center py-1.5 text-[11px] font-bold rounded-lg transition duration-200">Admin</button>
                        </div>
                    </div>

                    <!-- Listed Pages depending on role -->
                    <div>
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block px-3 mb-3" x-text="activePageCategory.toUpperCase() + ' MOCKUPS'"></span>
                        <nav class="flex flex-col gap-1 overflow-y-auto max-h-[45vh] pr-1">
                            
                            <!-- Public Category -->
                            <template x-if="activePageCategory === 'public'">
                                <div class="flex flex-col gap-0.5">
                                    <button @click="activePageIndex = 1" :class="activePageIndex === 1 ? 'active' : ''" class="ds-nav-btn">1. Premium Landing Page</button>
                                    <button @click="activePageIndex = 2" :class="activePageIndex === 2 ? 'active' : ''" class="ds-nav-btn">2. Student Leaderboards</button>
                                    <button @click="activePageIndex = 3" :class="activePageIndex === 3 ? 'active' : ''" class="ds-nav-btn">3. Browse Project Directory</button>
                                    <button @click="activePageIndex = 4" :class="activePageIndex === 4 ? 'active' : ''" class="ds-nav-btn">4. Project Requirement View</button>
                                    <button @click="activePageIndex = 5" :class="activePageIndex === 5 ? 'active' : ''" class="ds-nav-btn">5. Public Freelancer Profile</button>
                                    <button @click="activePageIndex = 6" :class="activePageIndex === 6 ? 'active' : ''" class="ds-nav-btn">6. Public UMKM Profile</button>
                                    <button @click="activePageIndex = 7" :class="activePageIndex === 7 ? 'active' : ''" class="ds-nav-btn">7. Unified Brand Login</button>
                                    <button @click="activePageIndex = 8" :class="activePageIndex === 8 ? 'active' : ''" class="ds-nav-btn">8. Student Registration</button>
                                    <button @click="activePageIndex = 9" :class="activePageIndex === 9 ? 'active' : ''" class="ds-nav-btn">9. UMKM Client Registration</button>
                                    <button @click="activePageIndex = 10" :class="activePageIndex === 10 ? 'active' : ''" class="ds-nav-btn">10. Forgot Password Desk</button>
                                    <button @click="activePageIndex = 11" :class="activePageIndex === 11 ? 'active' : ''" class="ds-nav-btn">11. Email Verification Portal</button>
                                </div>
                            </template>

                            <!-- Student Category -->
                            <template x-if="activePageCategory === 'student'">
                                <div class="flex flex-col gap-0.5">
                                    <button @click="activePageIndex = 1" :class="activePageIndex === 1 ? 'active' : ''" class="ds-nav-btn">1. Freelancer Dashboard</button>
                                    <button @click="activePageIndex = 2" :class="activePageIndex === 2 ? 'active' : ''" class="ds-nav-btn">2. Wallet & Earnings Manager</button>
                                    <button @click="activePageIndex = 3" :class="activePageIndex === 3 ? 'active' : ''" class="ds-nav-btn">3. Applied Missions Tracker</button>
                                    <button @click="activePageIndex = 4" :class="activePageIndex === 4 ? 'active' : ''" class="ds-nav-btn">4. Add/Edit Portfolio Hub</button>
                                    <button @click="activePageIndex = 5" :class="activePageIndex === 5 ? 'active' : ''" class="ds-nav-btn">5. Interactive Project Workspace</button>
                                    <button @click="activePageIndex = 6" :class="activePageIndex === 6 ? 'active' : ''" class="ds-nav-btn">6. Deliverable Submission Desk</button>
                                    <button @click="activePageIndex = 7" :class="activePageIndex === 7 ? 'active' : ''" class="ds-nav-btn">7. Client Live Chat Console</button>
                                    <button @click="activePageIndex = 8" :class="activePageIndex === 8 ? 'active' : ''" class="ds-nav-btn">8. Edit Freelancer Profile</button>
                                    <button @click="activePageIndex = 9" :class="activePageIndex === 9 ? 'active' : ''" class="ds-nav-btn">9. Payout & Account Settings</button>
                                    <button @click="activePageIndex = 10" :class="activePageIndex === 10 ? 'active' : ''" class="ds-nav-btn">10. Platform Notifications List</button>
                                    <button @click="activePageIndex = 11" :class="activePageIndex === 11 ? 'active' : ''" class="ds-nav-btn">11. Interactive Rank Placement</button>
                                    <button @click="activePageIndex = 12" :class="activePageIndex === 12 ? 'active' : ''" class="ds-nav-btn">12. Matching Projects Drawer</button>
                                    <button @click="activePageIndex = 13" :class="activePageIndex === 13 ? 'active' : ''" class="ds-nav-btn">13. Detail Page & Quick Bid</button>
                                </div>
                            </template>

                            <!-- Client Category -->
                            <template x-if="activePageCategory === 'client'">
                                <div class="flex flex-col gap-0.5">
                                    <button @click="activePageIndex = 1" :class="activePageIndex === 1 ? 'active' : ''" class="ds-nav-btn">1. Client Dashboard Panel</button>
                                    <button @click="activePageIndex = 2" :class="activePageIndex === 2 ? 'active' : ''" class="ds-nav-btn">2. Interactive Post Project</button>
                                    <button @click="activePageIndex = 3" :class="activePageIndex === 3 ? 'active' : ''" class="ds-nav-btn">3. Manage Posted Missions</button>
                                    <button @click="activePageIndex = 4" :class="activePageIndex === 4 ? 'active' : ''" class="ds-nav-btn">4. Applicant Shortlist Board</button>
                                    <button @click="activePageIndex = 5" :class="activePageIndex === 5 ? 'active' : ''" class="ds-nav-btn">5. Review Applicant CV & Details</button>
                                    <button @click="activePageIndex = 6" :class="activePageIndex === 6 ? 'active' : ''" class="ds-nav-btn">6. Active Workspace Console</button>
                                    <button @click="activePageIndex = 7" :class="activePageIndex === 7 ? 'active' : ''" class="ds-nav-btn">7. Client Milestone Feedback</button>
                                    <button @click="activePageIndex = 8" :class="activePageIndex === 8 ? 'active' : ''" class="ds-nav-btn">8. Revision/Approval Manager</button>
                                    <button @click="activePageIndex = 9" :class="activePageIndex === 9 ? 'active' : ''" class="ds-nav-btn">9. Student Live Chat Center</button>
                                    <button @click="activePageIndex = 10" :class="activePageIndex === 10 ? 'active' : ''" class="ds-nav-btn">10. Billing, Invoices & Stripe</button>
                                    <button @click="activePageIndex = 11" :class="activePageIndex === 11 ? 'active' : ''" class="ds-nav-btn">11. Edit UMKM Brand Profile</button>
                                    <button @click="activePageIndex = 12" :class="activePageIndex === 12 ? 'active' : ''" class="ds-nav-btn">12. Client Platform Settings</button>
                                    <button @click="activePageIndex = 13" :class="activePageIndex === 13 ? 'active' : ''" class="ds-nav-btn">13. Interactive Support Hub</button>
                                </div>
                            </template>

                            <!-- Admin Category -->
                            <template x-if="activePageCategory === 'admin'">
                                <div class="flex flex-col gap-0.5">
                                    <button @click="activePageIndex = 1" :class="activePageIndex === 1 ? 'active' : ''" class="ds-nav-btn">1. Master Dashboard Panel</button>
                                    <button @click="activePageIndex = 2" :class="activePageIndex === 2 ? 'active' : ''" class="ds-nav-btn">2. User Verification Directory</button>
                                    <button @click="activePageIndex = 3" :class="activePageIndex === 3 ? 'active' : ''" class="ds-nav-btn">3. Mission Moderation Queue</button>
                                    <button @click="activePageIndex = 4" :class="activePageIndex === 4 ? 'active' : ''" class="ds-nav-btn">4. Suspend User Form Console</button>
                                    <button @click="activePageIndex = 5" :class="activePageIndex === 5 ? 'active' : ''" class="ds-nav-btn">5. Category & Tags Manager</button>
                                    <button @click="activePageIndex = 6" :class="activePageIndex === 6 ? 'active' : ''" class="ds-nav-btn">6. System Audit & Log Streams</button>
                                    <button @click="activePageIndex = 7" :class="activePageIndex === 7 ? 'active' : ''" class="ds-nav-btn">7. Student Payout Approvals</button>
                                </div>
                            </template>

                        </nav>
                    </div>
                </div>
            </template>

        </div>

        <!-- Sticky Footer -->
        <div class="p-6 border-t border-slate-200 bg-slate-50">
            <a href="/" class="flex items-center gap-2 text-xs font-bold text-[#1E45FB] hover:underline">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Landing Page
            </a>
            <div class="mt-2 text-[10px] text-slate-400 font-semibold uppercase tracking-wider">LevelUp Beta V2.0</div>
        </div>
    </aside>

    <!-- Main Workspace Content -->
    <main class="ds-content">
        
        <!-- SECTION 1: CORE TOKENS & BRAND STYLE -->
        <template x-if="activeTab === 'tokens'">
            <div>
                <!-- Header -->
                <div class="mb-8">
                    <span class="badge badge-blue mb-2">Design Tokens</span>
                    <h2 class="heading-lg text-slate-900">Brand Identity & Visual Foundations</h2>
                    <p class="text-slate-500 text-sm mt-1">Sistem visual terpusat yang membentuk representasi premium LevelUp.</p>
                </div>

                <!-- SUBSECTION: COLOR PALETTE -->
                <template x-if="activeSubItem === 'color'">
                    <div class="space-y-8 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Blue -->
                            <div class="comp-card flex flex-col justify-between h-48 border-l-4 border-l-[#1E45FB]">
                                <div>
                                    <div class="w-12 h-12 rounded-2xl bg-[#1E45FB] flex items-center justify-center text-white mb-4 blue-glow">
                                        <i class="fa-solid fa-fill-drip"></i>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900">Primary Blue</h3>
                                    <span class="text-xs text-slate-400 font-mono">#1E45FB</span>
                                </div>
                                <p class="text-xs text-[#1E45FB] font-bold">Tombol utama, heading highlights, borders aktif.</p>
                            </div>
                            <!-- Lime -->
                            <div class="comp-card flex flex-col justify-between h-48 border-l-4 border-l-[#CDF22B]">
                                <div>
                                    <div class="w-12 h-12 rounded-2xl bg-[#CDF22B] flex items-center justify-center text-slate-900 mb-4 lime-glow">
                                        <i class="fa-solid fa-bolt"></i>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900">Accent Lime Green</h3>
                                    <span class="text-xs text-slate-400 font-mono">#CDF22B</span>
                                </div>
                                <p class="text-xs text-slate-600 font-bold">Badge status, hover highlights, Call-To-Action (CTA).</p>
                            </div>
                            <!-- White -->
                            <div class="comp-card flex flex-col justify-between h-48 border-l-4 border-l-slate-200">
                                <div>
                                    <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-900 mb-4">
                                        <i class="fa-solid fa-window-maximize"></i>
                                    </div>
                                    <h3 class="font-bold text-base text-slate-900">Main Background</h3>
                                    <span class="text-xs text-slate-400 font-mono">#FFFFFF</span>
                                </div>
                                <p class="text-xs text-slate-500 font-bold">Latar belakang utama, container, workspace canvas.</p>
                            </div>
                        </div>

                        <!-- System rules card -->
                        <div class="glass-card p-6 bg-slate-50">
                            <h4 class="font-bold text-sm text-slate-900 mb-2"><i class="fa-solid fa-circle-info text-[#1E45FB] mr-2"></i>Aturan Penggunaan Warna</h4>
                            <ul class="text-xs text-slate-600 space-y-2 list-disc list-inside">
                                <li><strong>Dominasi Putih (#FFFFFF):</strong> Seluruh container dashboard, modal, dan background wajib didominasi warna putih murni untuk visual bright minimal yang premium.</li>
                                <li><strong>Aksen Utama Blue (#1E45FB):</strong> Digunakan sebagai brand signature. Tombol utama, navigasi aktif, and link penting menggunakan warna ini.</li>
                                <li><strong>Highlight Lime (#CDF22B):</strong> Menambah vibrancy dan energi startup. Diterapkan pada tombol CTA sekunder, tag difficulty, badge prestasi, and highlight interaktif.</li>
                            </ul>
                        </div>
                    </div>
                </template>

                <!-- SUBSECTION: TYPOGRAPHY -->
                <template x-if="activeSubItem === 'typography'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card space-y-6">
                            <div class="pb-6 border-b border-slate-100">
                                <span class="caption block mb-1">Heading XL</span>
                                <h1 class="heading-xl text-slate-900">LevelUp Platform Marketplace Freelance</h1>
                                <span class="text-xs text-slate-400 font-mono block mt-2">Plus Jakarta Sans - Extrabold, tracking-tight, 48px/60px</span>
                            </div>
                            <div class="pb-6 border-b border-slate-100">
                                <span class="caption block mb-1">Heading LG</span>
                                <h2 class="heading-lg text-slate-900">Premium Project Marketplace for University Students</h2>
                                <span class="text-xs text-slate-400 font-mono block mt-2">Plus Jakarta Sans - Bold, 32px/40px</span>
                            </div>
                            <div class="pb-6 border-b border-slate-100">
                                <span class="caption block mb-1">Body Text (Medium)</span>
                                <p class="body-md text-slate-600">LevelUp memfasilitasi kolaborasi erat antara inovasi mahasiswa berbakat dengan pertumbuhan digital UMKM Indonesia. Dapatkan pengalaman kerja riil di industri modern.</p>
                                <span class="text-xs text-slate-400 font-mono block mt-2">Inter - Medium, 16px/24px</span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- SUBSECTION: SHADOWS & GLASSMORPHISM -->
                <template x-if="activeSubItem === 'shadows'">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in">
                        <div class="glass-card p-8 flex flex-col justify-between min-h-[220px]">
                            <div>
                                <span class="badge badge-yellow mb-4">Premium Glass Card</span>
                                <h3 class="heading-sm text-slate-900">Subtle Border & Soft Ambient Glow</h3>
                                <p class="text-xs text-slate-500 mt-2">Menggunakan bayangan tipis terdistribusi warna biru dan border translucent 1px untuk kedalaman layout 3D.</p>
                            </div>
                            <span class="text-xs font-mono text-[#1E45FB] mt-4">class="glass-card"</span>
                        </div>
                        <div class="glass-light p-8 flex flex-col justify-between min-h-[220px]">
                            <div>
                                <span class="badge badge-blue mb-4">Glass Light Container</span>
                                <h3 class="heading-sm text-slate-900">Minimal Border Card</h3>
                                <p class="text-xs text-slate-500 mt-2">Container standard untuk item bento grid tanpa bayangan hover. Mengedepankan ruang putih bersih dan elegan.</p>
                            </div>
                            <span class="text-xs font-mono text-[#1E45FB] mt-4">class="glass-light"</span>
                        </div>
                    </div>
                </template>
            </div>
        </template>

        <!-- SECTION 2: COMPONENT PLAYGROUND -->
        <template x-if="activeTab === 'components'">
            <div>
                <!-- Header -->
                <div class="mb-8">
                    <span class="badge badge-yellow mb-2">Interactive Components</span>
                    <h2 class="heading-lg text-slate-900">Reusable Component Library</h2>
                    <p class="text-slate-500 text-sm mt-1">Koleksi 17 elemen UI atomik interaktif siap pakai yang terkonfigurasi global.</p>
                </div>

                <!-- Live Components Switcher View -->
                
                <!-- 1. Buttons -->
                <template x-if="activeSubItem === 'buttons'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card">
                            <h3 class="font-bold text-sm text-slate-400 mb-6 uppercase tracking-wider">Demonstrasi Tombol</h3>
                            <div class="flex flex-wrap gap-4 items-center">
                                <button class="btn btn-primary">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Primary Blue
                                </button>
                                <button class="btn btn-secondary lime-glow">
                                    <i class="fa-solid fa-rocket"></i>
                                    Accent Lime CTA
                                </button>
                                <button class="btn btn-ghost">
                                    Ghost Button
                                </button>
                                <button class="btn btn-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Danger Action
                                </button>
                            </div>
                        </div>
                        <div class="bg-slate-900 rounded-2xl p-6 font-mono text-xs text-lime-400 space-y-2">
                            <p class="text-slate-400">// Code Snippet Buttons</p>
                            <p>&lt;button class="btn btn-primary"&gt;Primary Button&lt;/button&gt;</p>
                            <p>&lt;button class="btn btn-secondary lime-glow"&gt;Accent Lime CTA&lt;/button&gt;</p>
                            <p>&lt;button class="btn btn-ghost"&gt;Ghost Outline&lt;/button&gt;</p>
                        </div>
                    </div>
                </template>

                <!-- 2. Inputs -->
                <template x-if="activeSubItem === 'inputs'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card space-y-6 max-w-lg">
                            <div>
                                <label class="input-label">Username / Panggilan</label>
                                <input type="text" placeholder="Masukkan username Anda..." class="input-field">
                                <span class="text-[10px] text-slate-400 mt-1 block">Username akan terlihat pada dashboard publik</span>
                            </div>
                            <div>
                                <label class="input-label">Project Budget (Rupiah)</label>
                                <input type="number" value="1500000" class="input-field">
                            </div>
                            <div>
                                <label class="input-label text-red-500">Email Address (Error State)</label>
                                <input type="email" value="budisantosolimit.com" class="input-field border-red-400 focus:border-red-500 focus:shadow-[0_0_0_3px_rgba(239,68,68,0.1)]">
                                <span class="text-xs text-red-500 font-semibold mt-1.5 block"><i class="fa-solid fa-circle-exclamation mr-1"></i>Format email tidak valid. Masukkan domain yang benar.</span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 3. Badges -->
                <template x-if="activeSubItem === 'badges'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card">
                            <h4 class="font-bold text-slate-400 text-xs mb-4 uppercase tracking-widest">Complexity Level Tags</h4>
                            <div class="flex gap-3 mb-8">
                                <span class="badge complexity-easy">Easy Task</span>
                                <span class="badge complexity-medium">Medium Project</span>
                                <span class="badge complexity-hard">Hard System</span>
                            </div>

                            <h4 class="font-bold text-slate-400 text-xs mb-4 uppercase tracking-widest">Application Status Flags</h4>
                            <div class="flex gap-3">
                                <span class="badge status-open">Status Open</span>
                                <span class="badge status-pending">Verification Pending</span>
                                <span class="badge status-in-progress">In Progress</span>
                                <span class="badge status-completed">Completed</span>
                                <span class="badge status-rejected">Rejected</span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 4. Cards -->
                <template x-if="activeSubItem === 'cards'">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in">
                        <div class="glass-card p-6 cursor-pointer">
                            <span class="badge complexity-medium mb-3">Project Design</span>
                            <h4 class="font-bold text-lg text-slate-900 leading-snug">Redesign Landing Page UMKM Madu Alami</h4>
                            <p class="text-xs text-slate-500 mt-2 mb-4">Bantu meningkatkan penjualan digital produk madu hutan lokal melalui konsep situs web modern berestetika premium.</p>
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-[#1E45FB]">Rp1.800.000</span>
                                <span class="text-slate-400 font-semibold">12 Pelamar</span>
                            </div>
                        </div>
                        <div class="glass-card p-6 bg-gradient-to-tr from-[#1E45FB]/5 to-transparent">
                            <div class="flex justify-between mb-4">
                                <div class="w-10 h-10 rounded-full bg-[#CDF22B] flex items-center justify-center text-slate-900 font-bold">
                                    <i class="fa-solid fa-trophy"></i>
                                </div>
                                <span class="badge badge-yellow">Weekly Reward</span>
                            </div>
                            <h4 class="font-bold text-lg text-slate-900">Juara Teratas Leaderboard</h4>
                            <p class="text-xs text-slate-500 mt-1">Dapatkan komisi bonus mingguan tambahan Rp500.000 dengan menjadi mahasiswa peringkat pertama mingguan.</p>
                        </div>
                    </div>
                </template>

                <!-- 5. Navbars -->
                <template x-if="activeSubItem === 'navigation'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="relative h-24 border border-dashed border-slate-200 rounded-2xl overflow-hidden bg-slate-50">
                            <div class="navbar w-[95%] max-w-full relative top-3 shadow-sm bg-white/90">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-extrabold text-sm">L</div>
                                    <span class="font-extrabold text-slate-900 text-sm">LevelUp</span>
                                </div>
                                <div class="flex gap-1">
                                    <span class="nav-link active text-xs">Home</span>
                                    <span class="nav-link text-xs">Leaderboard</span>
                                    <span class="nav-link text-xs">Proyek</span>
                                </div>
                                <button class="btn btn-primary btn-sm">Sign In</button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 6. Sidebars -->
                <template x-if="activeSubItem === 'sidebars'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="border border-slate-200 rounded-2xl p-4 max-w-xs bg-slate-50">
                            <div class="flex items-center gap-3 mb-6 px-3">
                                <div class="w-8 h-8 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-bold text-sm">L</div>
                                <h4 class="font-extrabold text-slate-900 text-sm">Dashboard Panel</h4>
                            </div>
                            <div class="space-y-1">
                                <a href="#" class="ds-nav-btn active"><i class="fa-solid fa-home"></i> Overview</a>
                                <a href="#" class="ds-nav-btn"><i class="fa-solid fa-wallet"></i> Keuangan</a>
                                <a href="#" class="ds-nav-btn"><i class="fa-solid fa-briefcase"></i> Proyek Saya</a>
                                <a href="#" class="ds-nav-btn"><i class="fa-solid fa-gear"></i> Pengaturan</a>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 7. Modals -->
                <template x-if="activeSubItem === 'modals'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card">
                            <button @click="isModalOpen = true" class="btn btn-primary">
                                <i class="fa-solid fa-up-right-from-square"></i>
                                Buka Contoh Modal
                            </button>
                        </div>

                        <!-- Modal Popup Demo -->
                        <div x-show="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in" x-cloak>
                            <div class="bg-white rounded-3xl p-6 max-w-md w-full shadow-2xl border border-slate-100" @click.away="isModalOpen = false">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-50 text-[#1E45FB] flex items-center justify-center text-lg">
                                        <i class="fa-solid fa-circle-question"></i>
                                    </div>
                                    <button @click="isModalOpen = false" class="text-slate-400 hover:text-slate-900 transition">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                                <h3 class="heading-sm text-slate-900">Konfirmasi Kirim Lamaran?</h3>
                                <p class="text-xs text-slate-500 mt-2">Anda akan mengajukan penawaran jasa untuk proyek <strong>UMKM Kopi Luwak Merdeka</strong> sebesar Rp1.500.000.</p>
                                <div class="flex gap-3 mt-6">
                                    <button @click="isModalOpen = false" class="btn btn-ghost flex-1 py-2 text-xs">Kembali</button>
                                    <button @click="isModalOpen = false; alert('Lamaran berhasil dikirim!')" class="btn btn-primary flex-1 py-2 text-xs">Kirim Lamaran</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 8. Dropdowns -->
                <template x-if="activeSubItem === 'dropdowns'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card flex gap-4 max-w-md">
                            <div class="flex-1">
                                <label class="input-label">Filter Kategori</label>
                                <select x-model="selectedCategory" class="input-field">
                                    <option value="all">Semua Kategori</option>
                                    <option value="uiux">Desain UI/UX</option>
                                    <option value="web">Pemrograman Web</option>
                                    <option value="branding">Branding & Logo</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="input-label">Urutan Budget</label>
                                <select x-model="sortOrder" class="input-field">
                                    <option value="highest">Budget Tertinggi</option>
                                    <option value="lowest">Budget Terendah</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 9. Tables -->
                <template x-if="activeSubItem === 'tables'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="glass-card p-4 overflow-x-auto">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <th>UMKM Client</th>
                                        <th>Budget</th>
                                        <th>Tanggal Batas</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="font-bold text-slate-900 text-xs">Website Profile Toko Roti</td>
                                        <td class="text-xs text-slate-500">Sari Roti Mandiri</td>
                                        <td class="font-bold text-[#1E45FB] text-xs">Rp2.000.000</td>
                                        <td class="text-xs text-slate-400">12 Juni 2026</td>
                                        <td>
                                            <span class="badge complexity-easy">Easy</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-bold text-slate-900 text-xs">UI/UX App Hijab Store</td>
                                        <td class="text-xs text-slate-500">Hijab Premium Store</td>
                                        <td class="font-bold text-[#1E45FB] text-xs">Rp3.500.000</td>
                                        <td class="text-xs text-slate-400">19 Juni 2026</td>
                                        <td>
                                            <span class="badge complexity-medium">Medium</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </template>

                <!-- 10. Charts -->
                <template x-if="activeSubItem === 'charts'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="glass-card p-6 max-w-lg">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">Tren Statistik Pendaftaran Mahasiswa</h4>
                                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider mt-0.5">Januari - Mei 2026</p>
                                </div>
                                <span class="badge badge-yellow">+45% Pekan Ini</span>
                            </div>
                            
                            <!-- Inline SVG Chart Demo -->
                            <div class="w-full h-40 relative flex items-end">
                                <svg class="w-full h-full" viewBox="0 0 100 30" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="blue-grad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#1E45FB" stop-opacity="0.25"/>
                                            <stop offset="100%" stop-color="#1E45FB" stop-opacity="0"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Filled path -->
                                    <path d="M0,30 L0,22 Q25,8 50,15 T100,5 L100,30 Z" fill="url(#blue-grad)"/>
                                    <!-- Stroke line -->
                                    <path d="M0,22 Q25,8 50,15 T100,5" fill="none" stroke="#1E45FB" stroke-width="1" stroke-linecap="round"/>
                                    <!-- Indicator dot -->
                                    <circle cx="100" cy="5" r="1.5" fill="#CDF22B" stroke="#1E45FB" stroke-width="0.75"/>
                                </svg>
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase mt-3">
                                <span>Jan</span>
                                <span>Feb</span>
                                <span>Mar</span>
                                <span>Apr</span>
                                <span>Mei</span>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 11. Empty States -->
                <template x-if="activeSubItem === 'empty'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="comp-card text-center py-12 max-w-md mx-auto">
                            <div class="empty-state-icon">
                                <i class="fa-solid fa-box-open text-[#1E45FB] text-2xl"></i>
                            </div>
                            <h4 class="empty-state-title">Belum Ada Proyek Aktif</h4>
                            <p class="empty-state-desc">Telusuri direktori pencarian proyek mahasiswa dan ajukan lamaran portofolio pertama Anda sekarang!</p>
                            <button class="btn btn-primary btn-sm">Temukan Proyek</button>
                        </div>
                    </div>
                </template>

                <!-- 12. Skeletons -->
                <template x-if="activeSubItem === 'skeletons'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="glass-card p-6 max-w-sm space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full skeleton"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="h-3 w-2/3 skeleton"></div>
                                    <div class="h-2 w-1/2 skeleton"></div>
                                </div>
                            </div>
                            <div class="h-16 w-full skeleton"></div>
                            <div class="flex justify-between">
                                <div class="h-3 w-1/4 skeleton"></div>
                                <div class="h-3 w-1/3 skeleton"></div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 13. Alerts -->
                <template x-if="activeSubItem === 'alerts'">
                    <div class="space-y-4 max-w-md animate-fade-in">
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex gap-3 text-xs">
                            <i class="fa-solid fa-circle-check text-base"></i>
                            <div>
                                <h5 class="font-bold">Dokumen Berhasil Diverifikasi</h5>
                                <p class="mt-0.5">Akun mahasiswa Anda kini telah berstatus terverifikasi oleh pihak admin.</p>
                            </div>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 flex gap-3 text-xs">
                            <i class="fa-solid fa-circle-exclamation text-base"></i>
                            <div>
                                <h5 class="font-bold">Lengkapi Data Portofolio</h5>
                                <p class="mt-0.5">Tingkatkan peluang diterima bekerja oleh UMKM klien hingga 75% dengan mengunggah sertifikat keahlian.</p>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 14. Chat -->
                <template x-if="activeSubItem === 'chat'">
                    <div class="space-y-6 max-w-md animate-fade-in">
                        <div class="glass-card overflow-hidden flex flex-col h-96">
                            <!-- Chat header -->
                            <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#1E45FB] flex items-center justify-center text-white text-xs font-bold">K</div>
                                <div>
                                    <h4 class="font-bold text-xs text-slate-900 leading-tight">Kedai Kopi Kampus</h4>
                                    <span class="text-[9px] text-emerald-500 font-bold block mt-0.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block mr-1"></span>Online</span>
                                </div>
                            </div>
                            <!-- Messages -->
                            <div class="flex-1 p-4 space-y-3 overflow-y-auto">
                                <div class="flex justify-start">
                                    <div class="bg-slate-100 text-slate-800 p-2.5 rounded-2xl rounded-tl-none text-xs max-w-[80%]">
                                        Halo! Desain logo UMKM kami apakah bisa diselesaikan dalam 5 hari kerja?
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <div class="bg-[#1E45FB] text-white p-2.5 rounded-2xl rounded-tr-none text-xs max-w-[80%]">
                                        Tentu bisa! Saya menggunakan layout UI premium.
                                    </div>
                                </div>
                            </div>
                            <!-- Input -->
                            <div class="p-3 border-t border-slate-100 flex gap-2">
                                <input type="text" placeholder="Tulis pesan..." class="input-field flex-1 py-1.5 text-xs">
                                <button class="btn btn-primary btn-sm px-4"><i class="fa-solid fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 15. Progress -->
                <template x-if="activeSubItem === 'progress'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="glass-card p-6 max-w-lg">
                            <h4 class="font-bold text-slate-900 text-sm mb-4">Milestone Progress Proyek</h4>
                            <div class="space-y-4">
                                <div class="flex justify-between text-xs font-bold text-slate-600">
                                    <span>Langkah 2 dari 4 (Pembuatan Tampilan UI/UX)</span>
                                    <span>50%</span>
                                </div>
                                <div class="progress-bar-track">
                                    <div class="progress-bar-fill" style="width: 50%"></div>
                                </div>
                                <div class="grid grid-cols-4 gap-2 pt-2 text-[10px] text-slate-400 font-semibold uppercase">
                                    <div class="text-[#1E45FB]"><i class="fa-solid fa-circle-check mr-1"></i>Brief</div>
                                    <div class="text-[#1E45FB]"><span class="pulse-dot inline-block mr-1"></span>UI/UX</div>
                                    <div>Coding</div>
                                    <div>Review</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 16. Profile -->
                <template x-if="activeSubItem === 'profile'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="glass-card overflow-hidden max-w-md">
                            <div class="profile-banner"></div>
                            <div class="relative px-6 pb-6 pt-16">
                                <div class="profile-avatar text-lg">AS</div>
                                <div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-bold text-lg text-slate-900">Ahmad Satrio</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">Mahasiswa Sistem Informasi - Universitas Indonesia</p>
                                        </div>
                                        <span class="badge complexity-medium">Rank 12</span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-4 leading-relaxed">Spesialisasi di bidang rancang bangun antarmuka web modern dengan fokus utama kecepatan performa dan kemudahan aksesibilitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- 17. Stats Grid -->
                <template x-if="activeSubItem === 'stats'">
                    <div class="space-y-6 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="stat-card">
                                <span class="stat-value">Rp4.250.000</span>
                                <h4 class="stat-label">Total Saldo Earnings</h4>
                            </div>
                            <div class="stat-card">
                                <span class="stat-value">14 Proyek</span>
                                <h4 class="stat-label">Kontribusi Selesai</h4>
                            </div>
                            <div class="stat-card">
                                <span class="stat-value">8.9 XP</span>
                                <h4 class="stat-label">Skor Kompetensi</h4>
                            </div>
                        </div>
                    </div>
                </template>

            </div>
        </template>

        <!-- SECTION 3: 37 INTERACTIVE PAGES MOCKUP BLUEPRINT -->
        <template x-if="activeTab === 'pages'">
            <div>
                <!-- Top Mockup Info Banner -->
                <div class="mb-6 flex justify-between items-start">
                    <div>
                        <span class="badge badge-yellow mb-2 text-xs" x-text="'Kategori: ' + activePageCategory.toUpperCase()"></span>
                        <h2 class="heading-lg text-slate-900" x-text="activePageIndex + '. Mockup Halaman Web'"></h2 >
                        <p class="text-slate-500 text-sm mt-1">Prototipe representatif beresolusi tinggi dengan skema warna yang terkonfigurasi konsisten.</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-ghost btn-sm" @click="if(activePageIndex > 1) activePageIndex--"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="btn btn-ghost btn-sm" @click="activePageIndex++"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <!-- Browser Outer Shell -->
                <div class="mock-screen">
                    <!-- Browser Header -->
                    <div class="mock-screen-header">
                        <div class="dot-red"></div>
                        <div class="dot-yellow"></div>
                        <div class="dot-green"></div>
                        <div class="bg-slate-100 text-slate-400 font-mono text-[10px] px-4 py-1.5 rounded-lg flex-1 text-center font-bold tracking-tight select-none">
                            levelup.ac.id/marketplace/<span x-text="activePageCategory"></span>/<span x-text="activePageIndex"></span>
                        </div>
                    </div>

                    <!-- Render Container body -->
                    <div class="mock-screen-body p-6 bg-slate-50">
                        
                        <!-- ==================== PUBLIC CATEGORY ==================== -->
                        <template x-if="activePageCategory === 'public'">
                            <div class="space-y-6">
                                
                                <!-- 1. Public Landing Page -->
                                <template x-if="activePageIndex === 1">
                                    <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm space-y-6 max-w-4xl mx-auto text-center">
                                        <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-black text-sm">L</div>
                                                <span class="font-extrabold text-slate-900 text-sm">LevelUp</span>
                                            </div>
                                            <div class="flex gap-4 text-xs font-bold text-slate-500">
                                                <span class="text-[#1E45FB]">Home</span>
                                                <span>Leaderboard</span>
                                                <span>Browsing Proyek</span>
                                            </div>
                                            <button class="btn btn-primary btn-sm py-1">Login</button>
                                        </div>
                                        <div class="py-12 max-w-xl mx-auto space-y-6">
                                            <span class="badge badge-yellow">LevelUp V2 Launch</span>
                                            <h1 class="heading-lg text-slate-900">Hubungkan Mahasiswa Kreatif dengan Pertumbuhan UMKM</h1>
                                            <p class="text-xs text-slate-500 leading-relaxed">Platform kontribusi sosial digital premium yang memfasilitasi mahasiswa bertalenta untuk berkarya secara nyata bagi digitalisasi UMKM Indonesia.</p>
                                            <div class="flex justify-center gap-4">
                                                <button class="btn btn-primary">Cari Proyek Jasa</button>
                                                <button class="btn btn-secondary lime-glow">Gabung Mitra UMKM</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 2. Leaderboard -->
                                <template x-if="activePageIndex === 2">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-2xl mx-auto">
                                        <div class="mb-6 flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Klasemen & Peringkat Mahasiswa</h3>
                                                <p class="text-[10px] text-slate-400">Diupdate setiap pekan berdasarkan skor kompetensi kontribusi.</p>
                                            </div>
                                            <span class="badge complexity-medium">Mei 2026</span>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between bg-gradient-to-r from-yellow-50 to-transparent">
                                                <div class="flex items-center gap-3">
                                                    <span class="font-black text-slate-900 text-sm">#1</span>
                                                    <div class="w-8 h-8 rounded-full bg-[#1E45FB] flex items-center justify-center text-white text-xs font-bold">AS</div>
                                                    <div>
                                                        <h4 class="font-bold text-xs text-slate-900">Ahmad Satrio</h4>
                                                        <span class="text-[9px] text-slate-400">Universitas Indonesia - 12 Proyek Selesai</span>
                                                    </div>
                                                </div>
                                                <span class="badge badge-yellow font-mono text-[10px]">1,280 XP</span>
                                            </div>
                                            <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <span class="font-black text-slate-400 text-sm">#2</span>
                                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 text-xs font-bold">R</div>
                                                    <div>
                                                        <h4 class="font-bold text-xs text-slate-900">Rania Maharani</h4>
                                                        <span class="text-[9px] text-slate-400">Institut Teknologi Bandung - 10 Proyek</span>
                                                    </div>
                                                </div>
                                                <span class="badge badge-blue font-mono text-[10px]">1,150 XP</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 3. Project Directory -->
                                <template x-if="activePageIndex === 3">
                                    <div class="space-y-4 max-w-3xl mx-auto">
                                        <div class="flex gap-3">
                                            <input type="text" placeholder="Cari proyek digitalisasi UMKM..." class="input-field flex-1 text-xs">
                                            <button class="btn btn-primary btn-sm px-6"><i class="fa-solid fa-search"></i></button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="glass-card p-5 bg-white">
                                                <span class="badge complexity-easy mb-2">Easy</span>
                                                <h4 class="font-bold text-xs text-slate-900">Desain Logo Toko Roti Sari Rasa</h4>
                                                <p class="text-[10px] text-slate-400 mt-1">Kami membutuhkan logo modern dengan filosofi kehangatan keluarga untuk brand kue kering kami.</p>
                                                <div class="mt-4 flex justify-between items-center text-xs">
                                                    <span class="font-bold text-[#1E45FB]">Rp1.200.000</span>
                                                    <button class="btn btn-ghost btn-sm py-0.5 px-3 text-[10px]">Detail</button>
                                                </div>
                                            </div>
                                            <div class="glass-card p-5 bg-white">
                                                <span class="badge complexity-medium mb-2">Medium</span>
                                                <h4 class="font-bold text-xs text-slate-900">Website Landing Page UMKM Madu Hutan</h4>
                                                <p class="text-[10px] text-slate-400 mt-1">Bantu kami membangun website promosi satu halaman untuk mengenalkan madu asli sumatera.</p>
                                                <div class="mt-4 flex justify-between items-center text-xs">
                                                    <span class="font-bold text-[#1E45FB]">Rp2.500.000</span>
                                                    <button class="btn btn-ghost btn-sm py-0.5 px-3 text-[10px]">Detail</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4. Project Requirement View -->
                                <template x-if="activePageIndex === 4">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-2xl mx-auto space-y-4">
                                        <div class="pb-4 border-b border-slate-100 flex justify-between items-start">
                                            <div>
                                                <span class="badge complexity-medium mb-2">Pemrograman Web</span>
                                                <h3 class="font-bold text-sm text-slate-900">E-Commerce Web Kopi Kenangan Lokal</h3>
                                                <p class="text-[10px] text-slate-400 mt-1">Diposting oleh UMKM Kopi Lokal pada 22 Mei 2026</p>
                                            </div>
                                            <span class="font-black text-[#1E45FB] text-sm">Rp3.500.000</span>
                                        </div>
                                        <div class="space-y-3">
                                            <h4 class="font-bold text-xs text-slate-900">Deskripsi & Kebutuhan Proyek:</h4>
                                            <p class="text-xs text-slate-500 leading-relaxed">UMKM Kopi Lokal membutuhkan mahasiswa untuk membuat sistem pemesanan kopi online terintegrasi pembayaran lokal (Gopay/OVO). Tampilan harus modern, bersih, and ramah akses seluler.</p>
                                            
                                            <h4 class="font-bold text-xs text-slate-900 mt-4">Kualifikasi Mahasiswa:</h4>
                                            <ul class="text-xs text-slate-500 list-disc list-inside space-y-1">
                                                <li>Memahami dasar Laravel & MySQL</li>
                                                <li>Memiliki portofolio desain UI bertema kuliner</li>
                                                <li>Komunikatif and siap revisi berkala</li>
                                            </ul>
                                        </div>
                                        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                                            <button class="btn btn-ghost btn-sm">Hubungi Klien</button>
                                            <button class="btn btn-primary btn-sm" @click="alert('Form Lamaran Terbuka!')">Ajukan Lamaran Portofolio</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 5. Public Freelancer Profile -->
                                <template x-if="activePageIndex === 5">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-lg mx-auto text-center space-y-4">
                                        <div class="w-16 h-16 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-extrabold text-xl mx-auto shadow-md">AS</div>
                                        <div>
                                            <h3 class="font-bold text-sm text-slate-900">Ahmad Satrio</h3>
                                            <span class="text-[9px] text-[#1E45FB] font-bold uppercase tracking-wider block mt-0.5">Top Rated Freelancer</span>
                                        </div>
                                        <p class="text-xs text-slate-500 leading-relaxed">Mahasiswa Semester 6 Ilmu Komputer UI. Berfokus pada perancangan web responsif dengan integrasi antarmuka yang bersih and modern.</p>
                                        <div class="grid grid-cols-3 gap-2 py-3 bg-slate-50 rounded-xl text-center">
                                            <div>
                                                <span class="font-bold text-slate-900 text-xs">12</span>
                                                <span class="text-[9px] text-slate-400 block">Proyek</span>
                                            </div>
                                            <div>
                                                <span class="font-bold text-slate-900 text-xs">4.9/5</span>
                                                <span class="text-[9px] text-slate-400 block">Rating</span>
                                            </div>
                                            <div>
                                                <span class="font-bold text-[#1E45FB] text-xs">1,280</span>
                                                <span class="text-[9px] text-slate-400 block">XP</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 6. Public UMKM Profile -->
                                <template x-if="activePageIndex === 6">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-lg mx-auto space-y-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 font-extrabold text-base">KK</div>
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Kedai Kopi Kenangan</h3>
                                                <span class="text-[9px] text-slate-400 block">Mitra UMKM Tingkat Utama sejak 2025</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-slate-500">Kedai kopi modern yang menyajikan cita rasa biji kopi nusantara terbaik dengan 5 cabang di area Jabodetabek.</p>
                                        <div class="p-3 bg-slate-50 rounded-xl flex justify-between items-center text-xs">
                                            <span class="text-slate-500">Misi Aktif Diposting:</span>
                                            <span class="font-bold text-[#1E45FB]">4 Proyek Terbuka</span>
                                        </div>
                                    </div>
                                </template>

                                <!-- 7. Unified Brand Login -->
                                <template x-if="activePageIndex === 7">
                                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-lg max-w-sm mx-auto space-y-6">
                                        <div class="text-center">
                                            <div class="w-10 h-10 rounded-full bg-[#1E45FB] flex items-center justify-center text-white font-extrabold mx-auto mb-3">L</div>
                                            <h3 class="font-bold text-sm text-slate-900">Masuk ke Akun LevelUp</h3>
                                            <p class="text-[10px] text-slate-400 mt-1">Gunakan alamat email akademik mahasiswa atau institusi UMKM Anda.</p>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Email Akademik / Mitra</label>
                                                <input type="email" placeholder="contoh@kampus.ac.id" class="input-field text-xs">
                                            </div>
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="input-label mb-0">Kata Sandi</label>
                                                    <a href="#" class="text-[9px] font-bold text-[#1E45FB]">Lupa Sandi?</a>
                                                </div>
                                                <input type="password" placeholder="••••••••" class="input-field text-xs">
                                            </div>
                                            <button class="btn btn-primary w-full py-2.5 text-xs font-bold">Masuk Sekarang</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 8. Student Registration -->
                                <template x-if="activePageIndex === 8">
                                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-lg max-w-sm mx-auto space-y-4">
                                        <div class="text-center">
                                            <span class="badge badge-blue">Mahasiswa Baru</span>
                                            <h3 class="font-bold text-sm text-slate-900 mt-2">Daftar Akun Mahasiswa</h3>
                                            <p class="text-[10px] text-slate-400 mt-1">Gabung marketplace freelance khusus mahasiswa Indonesia.</p>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Nama Lengkap Sesuai KTM</label>
                                                <input type="text" placeholder="Masukkan nama..." class="input-field text-xs">
                                            </div>
                                            <div>
                                                <label class="input-label">Email Universitas (.ac.id)</label>
                                                <input type="email" placeholder="mahasiswa@ui.ac.id" class="input-field text-xs">
                                            </div>
                                            <div class="flex gap-2">
                                                <input type="checkbox" class="rounded border-slate-300 text-[#1E45FB]">
                                                <span class="text-[9px] text-slate-500 leading-tight">Saya menyetujui ketentuan platform LevelUp</span>
                                            </div>
                                            <button class="btn btn-primary w-full py-2.5 text-xs">Daftar Akun</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 9. UMKM Registration -->
                                <template x-if="activePageIndex === 9">
                                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-lg max-w-sm mx-auto space-y-4">
                                        <div class="text-center">
                                            <span class="badge badge-yellow">Mitra UMKM Indonesia</span>
                                            <h3 class="font-bold text-sm text-slate-900 mt-2">Registrasi Klien UMKM</h3>
                                            <p class="text-[10px] text-slate-400 mt-1">Posting misi digitalisasi and temukan talenta muda terbaik.</p>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Nama Usaha / UMKM</label>
                                                <input type="text" placeholder="Kedai Kopi Kenangan" class="input-field text-xs">
                                            </div>
                                            <div>
                                                <label class="input-label">Nomor Izin Usaha / NIB (Opsional)</label>
                                                <input type="text" placeholder="12XXXXXXXXXX" class="input-field text-xs">
                                            </div>
                                            <button class="btn btn-secondary lime-glow w-full py-2.5 text-xs text-slate-950 font-bold">Daftarkan Klien</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 10. Forgot Password -->
                                <template x-if="activePageIndex === 10">
                                    <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-lg max-w-sm mx-auto space-y-6">
                                        <div class="text-center">
                                            <h3 class="font-bold text-sm text-slate-900">Atur Ulang Kata Sandi</h3>
                                            <p class="text-[10px] text-slate-400 mt-1">Kami akan mengirimkan link atur ulang sandi ke email terdaftar Anda.</p>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Alamat Email Terdaftar</label>
                                                <input type="email" placeholder="mahasiswa@ui.ac.id" class="input-field text-xs">
                                            </div>
                                            <button class="btn btn-primary w-full py-2.5 text-xs">Kirim Link Atur Ulang</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 11. Email Verification -->
                                <template x-if="activePageIndex === 11">
                                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-lg max-w-sm mx-auto text-center space-y-4">
                                        <div class="w-12 h-12 rounded-full bg-blue-50 text-[#1E45FB] flex items-center justify-center text-lg mx-auto">
                                            <i class="fa-solid fa-envelope-open-text"></i>
                                        </div>
                                        <h3 class="font-bold text-sm text-slate-900">Verifikasi Email Anda</h3>
                                        <p class="text-[10px] text-slate-500 leading-relaxed">Tolong klik tautan dalam email konfirmasi yang baru saja kami kirimkan ke email Anda agar bisa masuk ke dashboard.</p>
                                        <button class="btn btn-ghost w-full py-2 text-xs">Kirim Ulang Email Verifikasi</button>
                                    </div>
                                </template>

                            </div>
                        </template>

                        <!-- ==================== STUDENT CATEGORY ==================== -->
                        <template x-if="activePageCategory === 'student'">
                            <div class="space-y-6">
                                
                                <!-- 1. Student Dashboard Overview -->
                                <template x-if="activePageIndex === 1">
                                    <div class="space-y-6 max-w-3xl mx-auto">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Selamat Datang Kembali, Ahmad!</h3>
                                                <p class="text-[10px] text-slate-400">Berikut perkembangan misi digitalisasi yang sedang Anda tangani.</p>
                                            </div>
                                            <span class="badge complexity-medium"><span class="pulse-dot mr-1"></span>Aktif</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">Rp1.850.000</span>
                                                <span class="stat-label block text-[9px]">Saldo Aktif</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">4 Proyek</span>
                                                <span class="stat-label block text-[9px]">Berjalan</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">9.2 SCORE</span>
                                                <span class="stat-label block text-[9px]">Kompetensi</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 2. Wallet & Earnings -->
                                <template x-if="activePageIndex === 2">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-6">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Dompet Domestik & Earnings</h3>
                                                <p class="text-[10px] text-slate-400">Total akumulasi pencairan dana insentif digitalisasi.</p>
                                            </div>
                                            <button class="btn btn-secondary lime-glow btn-sm text-[10px] text-slate-900 font-bold" @click="alert('Pencairan dana diajukan ke admin!')">Tarik Saldo</button>
                                        </div>
                                        <div class="p-6 bg-slate-900 rounded-2xl text-center text-white">
                                            <span class="text-[9px] uppercase tracking-wider font-bold text-slate-400 block">Total Pendapatan Terkumpul</span>
                                            <span class="text-2xl font-black block mt-2 text-[#CDF22B]">Rp4.850.000</span>
                                        </div>
                                    </div>
                                </template>

                                <!-- 3. Applied Missions Tracker -->
                                <template x-if="activePageIndex === 3">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Riwayat Lamaran Misi Jasa</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center">
                                                <div>
                                                    <h4 class="font-bold text-xs text-slate-900">Website Toko Kopi Luwak</h4>
                                                    <span class="text-[9px] text-slate-400 block mt-0.5">Budget Penawaran: Rp1.500.000</span>
                                                </div>
                                                <span class="badge status-completed">Diterima</span>
                                            </div>
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center">
                                                <div>
                                                    <h4 class="font-bold text-xs text-slate-900">Desain Kemasan UMKM Madu</h4>
                                                    <span class="text-[9px] text-slate-400 block mt-0.5">Budget Penawaran: Rp800.000</span>
                                                </div>
                                                <span class="badge status-pending">Diproses</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4. Portfolio Builder -->
                                <template x-if="activePageIndex === 4">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                            <h3 class="font-bold text-sm text-slate-900">Manajemen Portofolio Karya</h3>
                                            <button class="btn btn-primary btn-sm text-[10px]" @click="alert('Silakan unggah gambar portofolio baru!')">Tambah Portofolio</button>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="portfolio-card p-3 bg-slate-50">
                                                <div class="h-24 bg-slate-200 rounded-lg mb-2"></div>
                                                <h4 class="font-bold text-xs text-slate-900">Website Sari Roti Lokal</h4>
                                                <span class="text-[9px] text-[#1E45FB] font-bold block mt-1">PHP / Laravel</span>
                                            </div>
                                            <div class="portfolio-card p-3 bg-slate-50">
                                                <div class="h-24 bg-slate-200 rounded-lg mb-2"></div>
                                                <h4 class="font-bold text-xs text-slate-900">Logo Design Madu Murni</h4>
                                                <span class="text-[9px] text-[#1E45FB] font-bold block mt-1">Branding / Adobe</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 5. Active Mission Workspace -->
                                <template x-if="activePageIndex === 5">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-2xl mx-auto space-y-4">
                                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Workspace: E-Commerce Kopi Kampus</h3>
                                                <span class="text-[9px] text-slate-400 block mt-0.5">Kolaborasi Bersama UMKM Kopi Kenangan</span>
                                            </div>
                                            <span class="badge complexity-medium">Tahap 2: Rancang Tampilan</span>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex justify-between text-xs font-bold text-slate-600">
                                                <span>Progress Milestone</span>
                                                <span>60%</span>
                                            </div>
                                            <div class="progress-bar-track">
                                                <div class="progress-bar-fill" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <div class="pt-4 flex justify-end gap-3">
                                            <button class="btn btn-ghost btn-sm" @click="activePageIndex = 7">Hubungi Klien</button>
                                            <button class="btn btn-primary btn-sm" @click="activePageIndex = 6">Kirim Hasil Desain</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 6. Deliverable Submission Desk -->
                                <template x-if="activePageIndex === 6">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-lg mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Kirim Penyerahan Tugas Akhir</h3>
                                        <p class="text-[10px] text-slate-400">Unggah hasil rancangan Anda. Pihak UMKM akan memverifikasi dalam waktu maksimal 3 hari kerja.</p>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Tautan Hasil Pekerjaan (Figma / GitHub)</label>
                                                <input type="url" placeholder="https://figma.com/file/..." class="input-field text-xs">
                                            </div>
                                            <div>
                                                <label class="input-label">Catatan Tambahan untuk Klien</label>
                                                <textarea placeholder="Tulis rincian perbaikan yang Anda kerjakan..." class="input-field text-xs"></textarea>
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Tugas berhasil dikirim ke Klien!'); activePageIndex = 5">Kirim Pekerjaan</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 7. Client Live Chat Console -->
                                <template x-if="activePageIndex === 7">
                                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-md mx-auto overflow-hidden flex flex-col h-96">
                                        <div class="p-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                            <span class="font-bold text-xs text-slate-900">Kontak Client: Kedai Kopi Kenangan</span>
                                            <span class="badge status-open text-[9px]">Online</span>
                                        </div>
                                        <div class="flex-1 p-4 space-y-3 overflow-y-auto font-sans">
                                            <template x-for="msg in chatMessages">
                                                <div :class="msg.sender === 'me' ? 'flex justify-end' : 'flex justify-start'">
                                                    <div :class="msg.sender === 'me' ? 'bg-[#1E45FB] text-white' : 'bg-slate-100 text-slate-800'" class="p-2.5 rounded-2xl text-xs max-w-[80%]">
                                                        <span x-text="msg.text"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="p-3 border-t border-slate-100 flex gap-2">
                                            <input type="text" x-model="chatInput" placeholder="Ketik pesan kerja..." class="input-field flex-1 py-1.5 text-xs" @keyup.enter="sendChatMessage">
                                            <button class="btn btn-primary btn-sm px-4" @click="sendChatMessage"><i class="fa-solid fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 8. Edit Freelancer Profile -->
                                <template x-if="activePageIndex === 8">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Ubah Data Diri Mahasiswa</h3>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Program Studi</label>
                                                <input type="text" value="Ilmu Komputer" class="input-field text-xs">
                                            </div>
                                            <div>
                                                <label class="input-label">Bio Singkat</label>
                                                <textarea class="input-field text-xs">Spesialisasi di bidang pembuatan antarmuka web modern responsif.</textarea>
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Profil berhasil diupdate!')">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 9. Payout & Account Settings -->
                                <template x-if="activePageIndex === 9">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Rekening Tujuan Pencairan Dana</h3>
                                        <p class="text-[10px] text-slate-400">Pengaturan data bank terverifikasi untuk pengiriman saldo insentif digital.</p>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Nama Bank</label>
                                                <select class="input-field text-xs">
                                                    <option>Bank Central Asia (BCA)</option>
                                                    <option>Bank Rakyat Indonesia (BRI)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="input-label">Nomor Rekening</label>
                                                <input type="text" value="128938129038" class="input-field text-xs">
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Akun payout berhasil disimpan!')">Simpan Akun Payout</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 10. Platform Notifications List -->
                                <template x-if="activePageIndex === 10">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Kotak Masuk Pemberitahuan</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 bg-blue-50/50 border-l-4 border-l-[#1E45FB] rounded-xl flex gap-3 text-xs">
                                                <i class="fa-solid fa-check-circle text-[#1E45FB] mt-0.5"></i>
                                                <div>
                                                    <h4 class="font-bold text-slate-900">Lamaran Diterima Klien!</h4>
                                                    <p class="text-[10px] text-slate-500 mt-0.5">UMKM Madu Sumatera menyetujui lamaran Anda. Silakan masuk workspace.</p>
                                                </div>
                                            </div>
                                            <div class="p-3 border border-slate-100 rounded-xl flex gap-3 text-xs">
                                                <i class="fa-solid fa-info-circle text-slate-400 mt-0.5"></i>
                                                <div>
                                                    <h4 class="font-bold text-slate-700">Skor XP Bertambah</h4>
                                                    <p class="text-[10px] text-slate-400 mt-0.5">Penyelesaian kuis mingguan sukses menambah +25 XP Anda.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 11. Interactive Rank Placement -->
                                <template x-if="activePageIndex === 11">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-sm mx-auto text-center space-y-4">
                                        <div class="w-16 h-16 rounded-full bg-[#CDF22B] flex items-center justify-center text-slate-900 font-extrabold text-xl mx-auto shadow-sm">#12</div>
                                        <div>
                                            <h3 class="font-bold text-sm text-slate-900">Peringkat Kompetensi Anda</h3>
                                            <p class="text-[10px] text-slate-500 mt-1">Tingkatkan skor Anda dengan menyelesaikan misi digitalisasi UMKM tingkat tinggi.</p>
                                        </div>
                                        <div class="p-4 bg-slate-50 rounded-xl">
                                            <div class="flex justify-between text-xs font-semibold text-slate-600">
                                                <span>Target Rank #10</span>
                                                <span>850 / 1000 XP</span>
                                            </div>
                                            <div class="progress-bar-track mt-2">
                                                <div class="progress-bar-fill" style="width: 85%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 12. Matching Projects Drawer -->
                                <template x-if="activePageIndex === 12">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h3 class="font-bold text-sm text-slate-900">Rekomendasi Misi AI Cocok</h3>
                                            <span class="badge badge-yellow">Match 95%</span>
                                        </div>
                                        <p class="text-[10px] text-slate-500">Berdasarkan data skill pemrograman PHP/Laravel pada profil portofolio Anda.</p>
                                        <div class="p-4 border border-slate-100 rounded-xl bg-slate-50 space-y-3">
                                            <h4 class="font-bold text-xs text-slate-900">Web Dashboard Admin Kopi Kenangan</h4>
                                            <p class="text-[10px] text-slate-500 leading-relaxed">Pihak UMKM membutuhkan dashboard admin terintegrasi untuk melihat riwayat pembelian digital.</p>
                                            <div class="flex justify-between items-center text-[10px]">
                                                <span class="font-bold text-[#1E45FB]">Rp2.500.000</span>
                                                <button class="btn btn-primary btn-sm py-0.5 px-3 text-[9px]" @click="alert('Misi Berhasil Diajukan!')">Ajukan Lamaran</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 13. Detail Page & Quick Bid -->
                                <template x-if="activePageIndex === 13">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <div class="pb-3 border-b border-slate-100">
                                            <span class="badge complexity-easy mb-1">UI/UX</span>
                                            <h3 class="font-bold text-sm text-slate-900">Redesign Antarmuka Web Bakery Shop</h3>
                                        </div>
                                        <div>
                                            <label class="input-label text-[10px]">Masukkan Penawaran Anda (Rp)</label>
                                            <input type="number" x-model="bidAmount" class="input-field text-xs mb-3">
                                            <button class="btn btn-secondary lime-glow w-full py-2 text-xs text-slate-900 font-bold" @click="hasApplied = true; alert('Lamaran berhasil terkirim sebesar Rp' + bidAmount)">Kirim Lamaran Instan</button>
                                        </div>
                                        <div x-show="hasApplied" class="p-3 bg-emerald-50 rounded-xl text-center text-emerald-800 text-[10px] font-bold" x-cloak>
                                            <i class="fa-solid fa-circle-check mr-1"></i> Lamaran Terdaftar untuk Verifikasi.
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </template>

                        <!-- ==================== CLIENT CATEGORY ==================== -->
                        <template x-if="activePageCategory === 'client'">
                            <div class="space-y-6">
                                
                                <!-- 1. Client Dashboard Panel -->
                                <template x-if="activePageIndex === 1">
                                    <div class="space-y-6 max-w-3xl mx-auto">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Dashboard Pengelola UMKM</h3>
                                                <p class="text-[10px] text-slate-400">Pantau proses penyelesaian digitalisasi bisnis Anda oleh mahasiswa.</p>
                                            </div>
                                            <button class="btn btn-primary btn-sm" @click="activePageIndex = 2">Posting Misi Baru</button>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">2 Proyek</span>
                                                <span class="stat-label block text-[9px]">Berjalan Aktif</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">12 Pelamar</span>
                                                <span class="stat-label block text-[9px]">Menunggu Review</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">Rp4.500.000</span>
                                                <span class="stat-label block text-[9px]">Dana Deposit Escrow</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 2. Post New Project -->
                                <template x-if="activePageIndex === 2">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Buat Proyek Digitalisasi Baru</h3>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Judul Kebutuhan Jasa</label>
                                                <input type="text" x-model="newProjTitle" class="input-field text-xs">
                                            </div>
                                            <div class="flex gap-2">
                                                <div class="flex-1">
                                                    <label class="input-label">Estimasi Budget (Rp)</label>
                                                    <input type="number" x-model="newProjBudget" class="input-field text-xs">
                                                </div>
                                                <div class="flex-1">
                                                    <label class="input-label">Durasi Kerja</label>
                                                    <input type="text" x-model="newProjDuration" class="input-field text-xs">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="input-label">Deskripsi Lengkap Keinginan Desain / Program</label>
                                                <textarea x-model="newProjDesc" class="input-field text-xs h-20"></textarea>
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Misi Berhasil Diposting ke Platform!'); activePageIndex = 3">Posting Sekarang</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 3. Manage Posted Missions -->
                                <template x-if="activePageIndex === 3">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Daftar Proyek yang Anda Publikasikan</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center">
                                                <div>
                                                    <h4 class="font-bold text-xs text-slate-900" x-text="newProjTitle"></h4>
                                                    <span class="text-[9px] text-[#1E45FB] font-bold block mt-0.5" x-text="'Budget: Rp' + newProjBudget"></span>
                                                </div>
                                                <span class="badge status-pending">Pending Admin</span>
                                            </div>
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center">
                                                <div>
                                                    <h4 class="font-bold text-xs text-slate-900">UI/UX Aplikasi Toko Roti Mandiri</h4>
                                                    <span class="text-[9px] text-[#1E45FB] font-bold block mt-0.5">Budget: Rp1.800.000</span>
                                                </div>
                                                <span class="badge status-in-progress">Berjalan</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4. Applicant Shortlist Board -->
                                <template x-if="activePageIndex === 4">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-lg mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Daftar Mahasiswa Pelamar Jasa</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-700 text-xs font-bold">AS</div>
                                                    <div>
                                                        <h4 class="font-bold text-xs text-slate-900">Ahmad Satrio</h4>
                                                        <span class="text-[9px] text-slate-400">UI / Skor Kompetensi: 9.2 XP</span>
                                                    </div>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button class="btn btn-ghost btn-sm py-0.5 px-3 text-[9px]" @click="activePageIndex = 5">Detail Profil</button>
                                                    <button class="btn btn-primary btn-sm py-0.5 px-3 text-[9px]" @click="alert('Pekerja sukses diterima!'); activePageIndex = 6">Terima Kerja</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 5. Review Applicant CV & Details -->
                                <template x-if="activePageIndex === 5">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                                            <div class="w-10 h-10 rounded-full bg-[#1E45FB] flex items-center justify-center text-white text-xs font-bold">AS</div>
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Ahmad Satrio</h3>
                                                <span class="text-[9px] text-slate-400">Universitas Indonesia - Semester 6</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <h4 class="font-bold text-xs text-slate-900">Pesan Pengantar Lamaran:</h4>
                                            <p class="text-xs text-slate-500 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">"Halo! Saya sangat tertarik merancang tampilan e-commerce untuk bisnis Anda. Saya sudah berpengalaman membuat mockup bertema kuliner di portfolio terlampir."</p>
                                        </div>
                                        <div class="pt-2 flex gap-3">
                                            <button class="btn btn-ghost btn-sm flex-1" @click="activePageIndex = 4">Kembali</button>
                                            <button class="btn btn-primary btn-sm flex-1" @click="alert('Mahasiswa berhasil diterima kerja!'); activePageIndex = 6">Terima Mahasiswa</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 6. Client Active Workspace -->
                                <template x-if="activePageIndex === 6">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-2xl mx-auto space-y-4">
                                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Workspace Kolaborasi Digital</h3>
                                                <span class="text-[9px] text-slate-400 block mt-0.5">Pekerja: Ahmad Satrio (Mahasiswa)</span>
                                            </div>
                                            <span class="badge complexity-medium">50% Progress</span>
                                        </div>
                                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 text-xs flex justify-between items-center">
                                            <div>
                                                <h4 class="font-bold text-slate-900">Hasil Rencana Rupa Tampilan Logo</h4>
                                                <span class="text-[10px] text-slate-400 mt-1 block">Tautan pekerjaan: <a href="#" class="text-[#1E45FB] hover:underline">figma.com/file/levelup-logo</a></span>
                                            </div>
                                            <div class="flex gap-2">
                                                <button class="btn btn-ghost btn-sm py-0.5 text-[9px]" @click="activePageIndex = 8">Minta Revisi</button>
                                                <button class="btn btn-primary btn-sm py-0.5 text-[9px]" @click="activePageIndex = 7">Approve & Beri Review</button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 7. Client Milestone Feedback -->
                                <template x-if="activePageIndex === 7">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Ulasan & Feedback Bintang Mahasiswa</h3>
                                        <p class="text-[10px] text-slate-400">Berikan penilaian performa kerja mahasiswa untuk kontribusi skor XP platform.</p>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Skor Kompetensi (Bintang 1-5)</label>
                                                <select class="input-field text-xs">
                                                    <option>⭐⭐⭐⭐⭐ (5 - Sangat Memuaskan)</option>
                                                    <option>⭐⭐⭐⭐ (4 - Memuaskan)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="input-label">Ulasan Singkat</label>
                                                <textarea placeholder="Pekerjaan selesai sangat rapi and komunikatif..." class="input-field text-xs"></textarea>
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Review berhasil terkirim, dana dilepas dari escrow!'); activePageIndex = 1">Kirim Penilaian</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 8. Revision / Approval Manager -->
                                <template x-if="activePageIndex === 8">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Ajukan Permintaan Revisi</h3>
                                        <p class="text-[10px] text-slate-400">Deskripsikan detail bagian tugas yang ingin diperbaiki oleh mahasiswa.</p>
                                        <div>
                                            <label class="input-label">Detail Catatan Revisi</label>
                                            <textarea placeholder="Warna latar belakang logo agar disesuaikan dengan kode warna dominan kami..." class="input-field text-xs h-24"></textarea>
                                        </div>
                                        <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Permintaan revisi terkirim ke Mahasiswa!'); activePageIndex = 6">Kirim Permintaan</button>
                                    </div>
                                </template>

                                <!-- 9. Chat Message Center -->
                                <template x-if="activePageIndex === 9">
                                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm max-w-md mx-auto overflow-hidden flex flex-col h-96">
                                        <div class="p-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                                            <span class="font-bold text-xs text-slate-900">Kontak Pekerja: Ahmad Satrio (Mahasiswa)</span>
                                            <span class="badge badge-yellow text-[9px]">Online</span>
                                        </div>
                                        <div class="flex-1 p-4 space-y-3 overflow-y-auto">
                                            <div class="flex justify-start">
                                                <div class="bg-slate-100 text-slate-800 p-2.5 rounded-2xl text-xs max-w-[80%]">
                                                    Halo! Proyek ini sudah saya selesaikan di workspace. Silakan dicek.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 border-t border-slate-100 flex gap-2">
                                            <input type="text" placeholder="Ketik pesan arahan kerja..." class="input-field flex-1 py-1.5 text-xs">
                                            <button class="btn btn-primary btn-sm px-4"><i class="fa-solid fa-paper-plane"></i></button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 10. Billing, Invoices & Payments -->
                                <template x-if="activePageIndex === 10">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Tagihan Riwayat Deposit Escrow</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                                                <div>
                                                    <h4 class="font-bold text-slate-900">Invoice #INV-2026-002</h4>
                                                    <p class="text-[9px] text-slate-400">Proyek: E-Commerce Web / 22 Mei 2026</p>
                                                </div>
                                                <span class="badge complexity-easy">Lunas</span>
                                            </div>
                                            <div class="p-3 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                                                <div>
                                                    <h4 class="font-bold text-slate-900">Invoice #INV-2026-001</h4>
                                                    <p class="text-[9px] text-slate-400">Proyek: Redesign Logo / 19 Mei 2026</p>
                                                </div>
                                                <span class="badge complexity-easy">Lunas</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 11. Edit UMKM Brand Profile -->
                                <template x-if="activePageIndex === 11">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Ubah Data Branding UMKM</h3>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Slogan Bisnis / Tagline</label>
                                                <input type="text" value="Cita Rasa Kopi Nusantara Terbaik" class="input-field text-xs">
                                            </div>
                                            <div>
                                                <label class="input-label">Deskripsi Usaha</label>
                                                <textarea class="input-field text-xs h-20">Menyediakan biji kopi pilihan lokal yang digiling oleh barista profesional daerah.</textarea>
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Data UMKM berhasil diperbarui!')">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 12. Client Platform Settings -->
                                <template x-if="activePageIndex === 12">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Pengaturan Notifikasi</h3>
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-slate-600 font-semibold">Kirim pemberitahuan lamaran baru via Email</span>
                                                <input type="checkbox" checked class="rounded text-[#1E45FB]">
                                            </div>
                                            <div class="flex items-center justify-between text-xs">
                                                <span class="text-slate-600 font-semibold">Ingatkan milestone berakhir dalam 24 jam</span>
                                                <input type="checkbox" checked class="rounded text-[#1E45FB]">
                                            </div>
                                            <button class="btn btn-primary w-full py-2 text-xs" @click="alert('Pengaturan notifikasi disimpan!')">Simpan Pengaturan</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 13. Support Hub -->
                                <template x-if="activePageIndex === 13">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto text-center space-y-4">
                                        <div class="w-12 h-12 rounded-full bg-blue-50 text-[#1E45FB] flex items-center justify-center text-lg mx-auto">
                                            <i class="fa-solid fa-headset"></i>
                                        </div>
                                        <h3 class="font-bold text-sm text-slate-900">Butuh Bantuan Teknis?</h3>
                                        <p class="text-[10px] text-slate-500 leading-relaxed">Tim dukungan LevelUp siap menjawab kesulitan Anda seputar escrow, sengketa pengerjaan tugas, atau pencairan saldo.</p>
                                        <button class="btn btn-ghost w-full py-2 text-xs" @click="alert('Tiket bantuan dibuat!')">Hubungi Customer Service</button>
                                    </div>
                                </template>

                            </div>
                        </template>

                        <!-- ==================== ADMIN CATEGORY ==================== -->
                        <template x-if="activePageCategory === 'admin'">
                            <div class="space-y-6">
                                
                                <!-- 1. Master Dashboard Panel -->
                                <template x-if="activePageIndex === 1">
                                    <div class="space-y-6 max-w-3xl mx-auto">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h3 class="font-bold text-sm text-slate-900">Analisis Data Dashboard Admin</h3>
                                                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Statistik Platform LevelUp</p>
                                            </div>
                                            <span class="badge badge-yellow">Sistem Normal</span>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">1,240</span>
                                                <span class="stat-label block text-[9px]">Total Mahasiswa Aktif</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">320 Mitra</span>
                                                <span class="stat-label block text-[9px]">Klien UMKM Terdaftar</span>
                                            </div>
                                            <div class="stat-card">
                                                <span class="stat-value text-xl">Rp42.000.000</span>
                                                <span class="stat-label block text-[9px]">Perputaran Saldo Platform</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 2. User Verification Directory -->
                                <template x-if="activePageIndex === 2">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Direktori Verifikasi Pengguna Baru</h3>
                                        <div class="space-y-3">
                                            <template x-for="user in users">
                                                <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                                                    <div>
                                                        <h4 class="font-bold text-slate-950" x-text="user.name"></h4>
                                                        <span class="text-[9px] text-slate-400 block mt-0.5" x-text="user.role"></span>
                                                    </div>
                                                    <div class="flex gap-2 items-center">
                                                        <span class="badge complexity-medium" x-text="user.status"></span>
                                                        <button class="btn btn-primary btn-sm py-0.5 px-2 text-[8px]" @click="user.status = 'Aktif'; alert('Verifikasi Sukses!')">Verifikasi</button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <!-- 3. Mission Moderation Queue -->
                                <template x-if="activePageIndex === 3">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Antrean Moderasi Proyek UMKM</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                                                <div>
                                                    <h4 class="font-bold text-slate-900">Landing Page Madu Sumatera</h4>
                                                    <span class="text-[9px] text-slate-400 block mt-0.5">Diajukan oleh: UMKM Madu Asli</span>
                                                </div>
                                                <div class="flex gap-2">
                                                    <button class="btn btn-danger btn-sm py-0.5 text-[8px]" @click="alert('Proyek ditolak moderasi!')">Tolak</button>
                                                    <button class="btn btn-primary btn-sm py-0.5 text-[8px]" @click="alert('Proyek sukses disetujui and terpublikasi!')">Setujui</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 4. Suspend User Form Console -->
                                <template x-if="activePageIndex === 4">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Penangguhan Akses Pengguna (Banned System)</h3>
                                        <p class="text-[10px] text-slate-400">Blokir sementara / permanen pengguna yang melanggar aturan transaksi escrow platform.</p>
                                        <div class="space-y-3">
                                            <div>
                                                <label class="input-label">Pilih Nama Pengguna</label>
                                                <select class="input-field text-xs" x-model="selectedUserToSuspend">
                                                    <option value="Budi Santoso">Budi Santoso (Mahasiswa)</option>
                                                    <option value="Robby Hermawan">Robby Hermawan (Client)</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="input-label">Alasan Penangguhan Akun</label>
                                                <textarea x-model="suspendReason" placeholder="Melakukan transaksi di luar platform escrow LevelUp..." class="input-field text-xs h-20"></textarea>
                                            </div>
                                            <button class="btn btn-danger w-full py-2 text-xs" @click="suspendUser">Tangguhkan Akun Pengguna</button>
                                        </div>
                                    </div>
                                </template>

                                <!-- 5. Category & Tags Manager -->
                                <template x-if="activePageIndex === 5">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-md mx-auto space-y-4">
                                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                                            <h3 class="font-bold text-sm text-slate-900">Manajemen Kategori Keahlian</h3>
                                            <button class="btn btn-primary btn-sm text-[9px]" @click="alert('Kategori baru ditambah!')">Tambah Kategori</button>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                                                <span class="font-bold text-slate-900">Desain Grafis / UI/UX</span>
                                                <span class="badge badge-blue">14 Subtags</span>
                                            </div>
                                            <div class="p-2.5 bg-slate-50 border border-slate-100 rounded-xl flex justify-between items-center text-xs">
                                                <span class="font-bold text-slate-900">Backend Development</span>
                                                <span class="badge badge-blue">8 Subtags</span>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                                <!-- 6. System Audit & Log Streams -->
                                <template x-if="activePageIndex === 6">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Aliran Log Audit Keamanan Sistem</h3>
                                        <div class="bg-slate-900 rounded-2xl p-4 font-mono text-[9px] text-slate-400 space-y-2 overflow-x-auto">
                                            <p><span class="text-slate-500">[2026-05-22 17:28:10]</span> <span class="text-[#CDF22B]">INFO:</span> Payout request approved for student ID #1283</p>
                                            <p><span class="text-slate-500">[2026-05-22 17:29:45]</span> <span class="text-blue-400">MODERATION:</span> Project E-Commerce approved by Admin #2</p>
                                            <p><span class="text-slate-500">[2026-05-22 17:34:02]</span> <span class="text-red-400">WARN:</span> Multiple failed login attempts for user 'budi@gmail.com'</p>
                                        </div>
                                    </div>
                                </template>

                                <!-- 7. Payout Approvals -->
                                <template x-if="activePageIndex === 7">
                                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm max-w-xl mx-auto space-y-4">
                                        <h3 class="font-bold text-sm text-slate-900">Persetujuan Pencairan Dana Mahasiswa</h3>
                                        <div class="space-y-3">
                                            <div class="p-3 border border-slate-100 rounded-xl flex items-center justify-between text-xs">
                                                <div>
                                                    <h4 class="font-bold text-slate-900">Ahmad Satrio</h4>
                                                    <span class="text-[9px] text-slate-400 block mt-0.5">BCA - 128938129038</span>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="font-black text-[#1E45FB]">Rp1.850.000</span>
                                                    <button class="btn btn-primary btn-sm py-0.5 px-3 text-[9px]" @click="alert('Pencairan berhasil ditransfer!')">Approve Transfer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </template>

                    </div>
                </div>

                <!-- Live Switch Page Guide -->
                <div class="mt-6 glass-card p-5 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#1E45FB] text-white flex items-center justify-center"><i class="fa-solid fa-code"></i></div>
                        <div>
                            <h4 class="font-bold text-xs text-slate-900">Ingin melihat mockup halaman lain?</h4>
                            <p class="text-[10px] text-slate-500 mt-0.5">Gunakan navigasi menu sidebar sebelah kiri atau klik panah navigasi di kanan atas untuk berpindah halaman secara cepat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        
    </main>

</div>

</body>
</html>
