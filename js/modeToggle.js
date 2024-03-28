// Light/Dark mode
const darkModeToggle = document.getElementById('mode-toggle');

function applyDarkMode(savedMode) {
    document.body.classList.toggle('dark-mode', savedMode);
    // Define o background-color de acordo com o modo escuro
    document.body.style.backgroundColor = savedMode ? '#1E1E1E' : '#EFECEC';
    // Define a cor do texto de acordo com o modo escuro
    const homeTextoA = document.querySelector('.home-texto-a');
    homeTextoA.style.color = savedMode ? '#00917C' : '#035950';
}

darkModeToggle.addEventListener('click', () => {
    const currentMode = localStorage.getItem('dark-mode') === 'true';
    localStorage.setItem('dark-mode', String(!currentMode));
    applyDarkMode(!currentMode);
});

document.addEventListener('DOMContentLoaded', () => {
    const savedMode = localStorage.getItem('dark-mode') === 'true';
    applyDarkMode(savedMode);
});
