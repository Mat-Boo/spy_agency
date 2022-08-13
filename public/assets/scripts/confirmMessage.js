let confirmMessage = document.querySelector('.confirmMessage');
if (confirmMessage != null) {
    confirmMessage.style.display = 'block';
    confirmMessage.style.opacity = 1;
    setTimeout(() => {
        confirmMessage.style.opacity = 0;
        confirmMessage.style.display = 'none';
    }, 3000);
}
