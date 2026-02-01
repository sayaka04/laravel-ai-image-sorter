    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}">

    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/sidebar.js') }}"></script>

    <style>
        :root {
            /* MASTER CONTROL: Change this hex and the WHOLE app transforms */
            --neon-primary: #00ff22;

            /* This calculates the glow based on your color choice automatically */
            --neon-glow: var(--neon-primary);
            --neon-low-op: rgba(0, 255, 34, 0.15);
            /* For borders */
            --neon-mid-op: rgba(0, 255, 34, 0.3);
            /* For inputs */
        }

        /* 1. HIJACK TEXT & ICONS */
        .text-ai-accent,
        .text-indigo-400,
        .text-indigo-500,
        .text-emerald-500,
        .text-emerald-400 {
            color: var(--neon-primary) !important;
        }

        /* 2. HIJACK BACKGROUNDS (Buttons, Progress Bars) */
        .bg-ai-accent,
        .bg-indigo-500,
        .bg-indigo-600,
        .bg-emerald-500,
        .bg-emerald-600 {
            background-color: var(--neon-primary) !important;
            color: #000 !important;
            /* Makes text black on neon background for readability */
        }

        /* 3. BACKGROUND LAYERS (Brighter Dark Mode) */
        .bg-slate-950 {
            background-color: #020617 !important;
        }

        .bg-slate-900 {
            background-color: #0f172a !important;
            border-color: var(--neon-low-op) !important;
        }

        /* 4. BORDER & HOVER HIJACK */
        .border-ai-accent,
        .border-slate-800,
        .border-slate-700,
        .border-indigo-500 {
            border-color: var(--neon-low-op) !important;
        }

        .group:hover,
        .hover\:border-slate-600:hover {
            border-color: var(--neon-primary) !important;
            box-shadow: 0 0 15px var(--neon-low-op) !important;
        }

        /* 5. INPUTS & SELECTS (High Vis) */
        input,
        textarea,
        select {
            background-color: #020617 !important;
            border-color: var(--neon-mid-op) !important;
            color: #fff !important;
        }

        input:focus,
        textarea:focus {
            border-color: var(--neon-primary) !important;
            box-shadow: 0 0 8px var(--neon-primary) !important;
        }

        /* 6. SPECIAL COMPONENTS (Queues & Categories) */
        circle.text-ai-accent {
            stroke: var(--neon-primary) !important;
        }

        .bg-indigo-500\/10,
        .bg-emerald-500\/10 {
            background-color: var(--neon-low-op) !important;
            border: 1px solid var(--neon-primary) !important;
            color: var(--neon-primary) !important;
        }

        /* 7. SCROLLBARS */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #020617;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--neon-primary);
            border-radius: 10px;
        }

        /* 8. ACTIVE STATES (Sidebar/Nav) */
        .active-link,
        [class*="active"] {
            color: var(--neon-primary) !important;
            border-left: 3px solid var(--neon-primary) !important;
            background: linear-gradient(90deg, var(--neon-low-op) 0%, transparent 100%) !important;
        }

        /* 9. SECONDARY BUTTONS (Forces Neon Text) */
        .bg-slate-800.text-slate-300,
        .bg-slate-800.text-slate-400 {
            color: var(--neon-primary) !important;
            border: 1px solid var(--neon-mid-op) !important;
        }

        /* 10. PULSE & GLOW */
        .animate-pulse {
            filter: drop-shadow(0 0 5px var(--neon-primary));
        }
    </style>