// Toast notifications
window.showToast = function(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const icons = {
        success: '✓',
        error:   '✕',
        warning: '⚠',
    };

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<span class="text-lg">${icons[type] || '●'}</span><span>${message}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
};

// Loading overlay
window.showLoading  = () => document.getElementById('loading-overlay')?.classList.remove('hidden');
window.hideLoading  = () => document.getElementById('loading-overlay')?.classList.add('hidden');

// Real-time clock
window.startClock = function(serverIso) {
    const serverTime = new Date(serverIso);
    const localTime  = new Date();
    const drift      = serverTime - localTime;

    function tick() {
        const now = new Date(Date.now() + drift);
        const pad = n => String(n).padStart(2, '0');
        const dateEl = document.getElementById('clock-date');
        const timeEl = document.getElementById('clock-time');

        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
            });
        }
        if (timeEl) {
            timeEl.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        }
    }

    tick();
    setInterval(tick, 1000);
};

// Auto-dismiss flash messages
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 300);
        }, 4000);
    }
});
