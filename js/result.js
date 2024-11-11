const AnswerSubmits = document.querySelectorAll('.qmn_btn');

AnswerSubmits.forEach(AnswerSubmit => {
    AnswerSubmit.addEventListener('click', () => {
        const observer = new MutationObserver((mutationsList, observe) => {
            // 結果画面が表示されたら、qsm-results-page が追加されるのでそれを監視
            const results = document.querySelector('.qsm-results-page');
            
            if (results) {
                // 結果画面の mlw_qmn_question_number のスタイルを変更
                const resultNums = document.querySelectorAll('.mlw_qmn_question_number');
                resultNums.forEach(num => {
                    num.style.color = '#2C5B8A';
                    num.style.fontSize = '38px';
                    
                    // 10未満の数字に 0 を追加（1回だけ）
                    if (parseInt(num.textContent, 10) < 10 && !num.dataset.zeroAdded) {
                        num.textContent = '0' + num.textContent;
                        num.dataset.zeroAdded = 'true'; // フラグを設定
                    }
                });

                const certificateBtn = document.querySelector('.qmn_certificate_link');
                certificateBtn.classList.add('active');
                certificateBtn.textContent = '合格証明書のダウンロード';

                           observer.disconnect();
    
                
             
            }
        });

        // body 要素全体を監視して、子要素や属性の変化を監視する
        observer.observe(document.body, {
            childList: true,
            subtree: true,
        });
    });
});