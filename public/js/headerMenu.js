const headerMenu = document.querySelector('.header_menu');
const sidebar = document.querySelector('.sidebar');
const content = document.querySelector('.content');

if (headerMenu) {
    headerMenu.classList.add('enabled');

    headerMenu.addEventListener('click', async (event) => {
        sidebar.classList.toggle("sidebar--enabled");
        content.classList.toggle("sidebar--enabled");
    })
}
