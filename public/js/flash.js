setTimeout(() => {
    document.querySelectorAll('.flash-overlay').forEach(el => {
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 3000); // hide after 3 seconds
