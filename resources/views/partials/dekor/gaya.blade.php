<style>
    @media (prefers-reduced-motion: no-preference) {
        .mw-rise { animation: mw-rise .5s ease-out both; }
        .mw-float { animation: mw-float 7s ease-in-out infinite; }
        .mw-sway { animation: mw-sway 9s ease-in-out infinite; transform-origin: 50% 100%; }
        .mw-breathe { animation: mw-breathe 8s ease-in-out infinite; }
        .mw-twinkle { animation: mw-twinkle 4s ease-in-out infinite; }
    }
    @keyframes mw-rise { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }
    @keyframes mw-float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes mw-sway { 0%, 100% { transform: rotate(-1.5deg); } 50% { transform: rotate(1.5deg); } }
    @keyframes mw-breathe { 0%, 100% { transform: scale(.8); } 50% { transform: scale(1.08); } }
    @keyframes mw-twinkle { 0%, 100% { opacity: .3; } 50% { opacity: 1; } }
</style>
