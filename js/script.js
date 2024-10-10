document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.wrapper');
    const btnPopup = document.querySelector('.btnLogin-popup1');
    const iconClose = document.querySelector('.icon-close');
    const iconClose2 = document.querySelector('.icon-close2');
    const btnPopupal = document.querySelector('.btnLogin-popup2');
    const DateU = document.querySelector('.Citatorios');
    const Cali = document.querySelector('.Calificaciones');
    const LogOutBtn = document.querySelector('.btnLogOut-popup');
    const LogOutBtnAl = document.querySelector('.btnLogOut-popupAl');
    const showPasswordCheckbox = document.querySelector('#showPassword');
    const showPasswordCheckbox2 = document.querySelector('#showPassword2');
    const passwordField = document.querySelector('#password');
    const passwordField2 = document.querySelector('#RegPass');

    if (btnPopup) {
        btnPopup.addEventListener('click', () => {
            btnPopup.classList.add('disable');
            if (wrapper) {
                wrapper.classList.add('active-popup');
            }
        });
    }

    if (showPasswordCheckbox && passwordField) {
        showPasswordCheckbox.addEventListener('change', () => {
            if (showPasswordCheckbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        });
    }

    if (showPasswordCheckbox2 && passwordField2) {
        showPasswordCheckbox2.addEventListener('change', () => {
            if (showPasswordCheckbox2.checked) {
                passwordField2.type = 'text';
            } else {
                passwordField2.type = 'password';
            }
        });
    }

    if (iconClose) {
        iconClose.addEventListener('click', () => {
            if (wrapper) {
                wrapper.classList.remove('active-popup');
                btnPopup.classList.remove('disable');
            }
        });
    }

    if (iconClose2) {
        iconClose2.addEventListener('click', () => {
            if (wrapper) {
                wrapper.classList.remove('active-popup');
                btnPopupal.classList.remove('disable');
            }
        });
    }

    if (btnPopupal) {
        btnPopupal.addEventListener('click', () => {
            btnPopupal.classList.add('disable');
            if (wrapper) {
                wrapper.classList.add('active-popup');
            }
        });
    }

    if (LogOutBtn) {
        LogOutBtn.addEventListener('click', () => {
            fetch('logout.php', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    if (LogOutBtnAl) {
        LogOutBtnAl.addEventListener('click', () => {
            fetch('logout.php', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }

    if (DateU) {
        DateU.addEventListener('click', () => {
            window.location.href = "citatorios.php";
        });
    }

    if (Cali) {
        Cali.addEventListener('click', () => {
            window.location.href = "calificaciones.php";
        });
    }

    let currentIndex = 0;
    const galleryContainer = document.querySelector('.gallery-container');
    const totalImages = document.querySelectorAll('.gallery-item').length;
    const autoMoveInterval = 5000; 

    document.querySelector('.prev-button').addEventListener('click', () => {
        navigate(-1);
    });

    document.querySelector('.next-button').addEventListener('click', () => {
        navigate(1);
    });

    function navigate(direction) {
        currentIndex = (currentIndex + direction + totalImages) % totalImages;
        const offset = -currentIndex * 100;
        galleryContainer.style.transform = `translateX(${offset}%)`;
    }

    function autoMoveCarousel() {
        setInterval(() => {
            navigate(1);
        }, autoMoveInterval);
    }

    autoMoveCarousel();

    function logout() {
        fetch('logout.php')
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    
});
