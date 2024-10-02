// Immediately apply theme
(function() {
    const root = document.documentElement;
    const savedDarkMode = localStorage.getItem('darkMode');
    const isDarkMode = savedDarkMode === null ? true : savedDarkMode === 'true';

    if (isDarkMode) {
        root.style.setProperty('--bg-color', '#242424');
        root.style.setProperty('--text-color', 'white');
        root.style.setProperty('--header-bg-color', '#202020');
        root.style.setProperty('--card-bg-color', '#333');
        root.style.setProperty('--input-bg-color', '#444');
        root.style.setProperty('--shadow-color', 'rgba(255, 255, 255, 0.1)');
        root.style.setProperty('--hover-shadow-color', 'rgba(255, 255, 255, 0.2)');
    } else {
        root.style.setProperty('--bg-color', 'white');
        root.style.setProperty('--text-color', 'black');
        root.style.setProperty('--header-bg-color', '#f8f9fa');
        root.style.setProperty('--card-bg-color', 'white');
        root.style.setProperty('--input-bg-color', '#f1f3f5');
        root.style.setProperty('--shadow-color', 'rgba(0, 0, 0, 0.1)');
        root.style.setProperty('--hover-shadow-color', 'rgba(0, 0, 0, 0.2)');
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.querySelector('.switch input');
    const modeText = document.querySelector('.mode-text');
    const root = document.documentElement;

    function setTheme(isDark) {
        if (isDark) {
            root.style.setProperty('--bg-color', '#242424');
            root.style.setProperty('--text-color', 'white');
            root.style.setProperty('--header-bg-color', '#202020');
            root.style.setProperty('--card-bg-color', '#333');
            root.style.setProperty('--input-bg-color', '#444');
            root.style.setProperty('--shadow-color', 'rgba(255, 255, 255, 0.1)');
            root.style.setProperty('--hover-shadow-color', 'rgba(255, 255, 255, 0.2)');
            modeText.textContent = 'Dark';
        } else {
            root.style.setProperty('--bg-color', 'white');
            root.style.setProperty('--text-color', 'black');
            root.style.setProperty('--header-bg-color', '#f8f9fa');
            root.style.setProperty('--card-bg-color', 'white');
            root.style.setProperty('--input-bg-color', '#f1f3f5');
            root.style.setProperty('--shadow-color', 'rgba(0, 0, 0, 0.1)');
            root.style.setProperty('--hover-shadow-color', 'rgba(0, 0, 0, 0.2)');
            modeText.textContent = 'Light';
        }
        localStorage.setItem('darkMode', isDark);
    }

    const savedDarkMode = localStorage.getItem('darkMode');

    if (savedDarkMode === null) {
        checkbox.checked = true;
        setTheme(true);
    } else {
        const isDarkMode = savedDarkMode === 'true';
        checkbox.checked = isDarkMode;
        setTheme(isDarkMode);
    }

    checkbox.addEventListener('change', function() {
        setTheme(this.checked);
    });
});