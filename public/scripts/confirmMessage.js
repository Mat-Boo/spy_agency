let confirmMessage = document.querySelector('.confirmMessage');
if (confirmMessage != null) {
    confirmMessage.style.opacity = 1;
    setTimeout(() => {
        confirmMessage.style.opacity = 0;
    }, 3000);
}
