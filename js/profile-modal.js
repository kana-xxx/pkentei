const userName = document.querySelector('.profileContent__nameBox');
const userModal = document.querySelector('.profileContent__modal');
const UserModalOuter = document.querySelector('.profileContent__modal--outer')

userName.addEventListener('click', () => {
userModal.classList.add('active');
});


// 画面のどこかをクリックしたときにモーダルを閉じる
window.onclick = function(event) {
    if (event.target == userModal) {
        closeModal();
    }
}

function closeModal() {
    userModal.classList.remove('active');
}