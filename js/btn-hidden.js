
// 結果表示ページ
const resultPage = document.querySelector('.qsm-results-page');
const a = document.querySelector('.wrapperResult');

window.addEventListener('load',()=> {
    if(resultPage) {
        console.log(a);
    }
    
});

// 証明証ダウンロードリンクの文字変更
const certificate = document.querySelector(".qmn_certificate_link");


window.addEventListener('load',()=> {
    if(resultPage) {
        console.log('resultPage');
        if(certificate) {
            certificate.innerHTML = "証明証をダウンロードする";
        } 
        else {
            console.log('none');
        }
    }
});


// 受講データ申請ボタン
const applyBtn = document.querySelector('.applyBtn');

const caution = document.querySelector('.caution');

window.addEventListener('load',()=> {
    if(applyBtn) {
        console.log('ある');
        caution.style.color = 'blue';
        caution.style.backgroundColor = 'green';
    } 
});


