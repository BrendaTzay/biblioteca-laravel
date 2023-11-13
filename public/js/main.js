const showNavbar = (toggleId, navId, bodyId, headerId) => {
    const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        bodypd = document.getElementById(bodyId),
        headerpd = document.getElementById(headerId);

    const menuOpen = localStorage.getItem('menuOpen');

    if (menuOpen === 'true') {
        nav.classList.add('menu-show');
        toggle.classList.add('bx-x');
        bodypd.classList.add('body-pd');
        headerpd.classList.add('body-pd');
    }

    if (toggle && nav && bodypd && headerpd) {
        toggle.addEventListener('click', () => {
            nav.classList.toggle('menu-show');
            toggle.classList.toggle('bx-x');
            bodypd.classList.toggle('body-pd');
            headerpd.classList.toggle('body-pd');

            localStorage.setItem('menuOpen', nav.classList.contains('menu-show'));
        });
    }
}

showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

const linkColor = document.querySelectorAll('.nav__link');

function colorLink() {
    if (linkColor) {
        linkColor.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    }
}
linkColor.forEach(l => l.addEventListener('click', colorLink));
