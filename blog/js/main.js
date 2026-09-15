const navItems = document.querySelector('.nav__items');
const openNavBtn = document.querySelector('#open__nav-btn');
const closeNavBtn = document.querySelector('#close__nav-btn');

// open nav dropdown
const openNav = () => {
    if (navItems) navItems.style.display = 'flex';
    if (openNavBtn) openNavBtn.style.display = 'none';
    if (closeNavBtn) closeNavBtn.style.display = 'inline-block';
};

// close nav dropdown
const closeNav = () => {
    if (navItems) navItems.style.display = 'none';
    if (openNavBtn) openNavBtn.style.display = 'inline-block';
    if (closeNavBtn) closeNavBtn.style.display = 'none';
};

if (openNavBtn && closeNavBtn) {
    openNavBtn.addEventListener('click', openNav);
    closeNavBtn.addEventListener('click', closeNav);
}

const sidebar = document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show__sidebar-btn');
const hideSidebarBtn = document.querySelector('#hide__sidebar-btn');

// shows side bar
const showSidebar = () => {
    if (sidebar) sidebar.style.left = '0';
    if (showSidebarBtn) showSidebarBtn.style.display = 'none';
    if (hideSidebarBtn) hideSidebarBtn.style.display = 'inline-block';
};

// hides side bar
const hideSidebar = () => {
    if (sidebar) sidebar.style.left = '-100%';
    if (showSidebarBtn) showSidebarBtn.style.display = 'inline-block';
    if (hideSidebarBtn) hideSidebarBtn.style.display = 'none';
};

if (showSidebarBtn && hideSidebarBtn) {
    showSidebarBtn.addEventListener('click', showSidebar);
    hideSidebarBtn.addEventListener('click', hideSidebar);
}