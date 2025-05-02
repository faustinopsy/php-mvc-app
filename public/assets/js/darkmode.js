document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.createElement('div');
    toggleButton.classList.add('theme-toggle');
    toggleButton.innerHTML = '☀️';
    document.body.appendChild(toggleButton);

    const isDarkMode = localStorage.getItem('dark-mode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        toggleButton.innerHTML = '🌙';
    }

    toggleButton.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('dark-mode', isDark);
        toggleButton.innerHTML = isDark ? '🌙' : '☀️';
    });
});