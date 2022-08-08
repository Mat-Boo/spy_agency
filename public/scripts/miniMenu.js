let displayMiniMenuBtn = document.querySelector('.displayMiniMenuBtn');
let closeMiniMenuBtn = document.querySelector('.closeMiniMenuBtn');
let menu = document.querySelector('.menu');
let loginBtn = document.querySelector('.loginBtn');
let logoutBtn = document.querySelector('.logoutBtn');


displayMiniMenuBtn.addEventListener('click', (e) => {
    document.body.style.overflow = 'hidden';
    miniMenuDisplayed = true;
    menu.style.left = 0;
    loginBtn === null ? '' : loginBtn.style.left = '50%';
    logoutBtn === null ? '' : logoutBtn.style.left = '50%';
    closeMiniMenuBtn.style.display = 'block';
    displayMiniMenuBtn.style.display = 'none';
})

closeMiniMenuBtn.addEventListener('click', (e) => {
    document.body.style.overflow = 'auto';
    miniMenuDisplayed = false;
    menu.style.left = '-100vw';
    loginBtn === null ? '' : loginBtn.style.left = '-50%';
    logoutBtn === null ? '' : logoutBtn.style.left = '-50%';
    displayMiniMenuBtn.style.display = 'block';
    closeMiniMenuBtn.style.display = 'none';
})