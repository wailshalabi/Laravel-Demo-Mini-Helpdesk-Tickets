
document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form[data-disable-on-submit]');
    if (!form) return;

    form.addEventListener('submit', () => {
        const btn = form.querySelector('button[type="submit"]');
        if (btn) btn.disabled = true;
    });
});