document.addEventListener("DOMContentLoaded", function() {
    const quizForm = document.querySelector('.qsm-quiz-form'); // クイズフォームのクラスを指定
    const quizes = document.querySelectorAll('.qsm-question-wrapper');
    const mlw_qmn_timer = document.getElementById('mlw_qmn_timer'); // タイマー要素を取得

    // 送信ボタンの取得
    const submitBtns = document.querySelectorAll('.qmn_btn');
    // styleをjavascriptで設定するための記述
    const style = submitBtns[0].getAttribute('style');

    // 未回答の場合にエラーメッセージを表示する
    const errMessage = document.createElement('p');

    // input要素を取得
    const inputPersonInfos = document.querySelectorAll('.qsm_required_text'); 

    // タイマーが終了したかどうかのフラグ
    let timerExpired = false; 

    function checkAllFormsFilled() {
        let allFilled = true;

    
        inputPersonInfos.forEach(info => {
            info.addEventListener('input', function() {
                allFilled = true; // 初期状態をtrueに設定
                inputPersonInfos.forEach(input => {
                    if (!input.value.trim()) {
                        allFilled = false; // 空のinputがあればfalseに設定
                    }
                });
    
                if (allFilled) {
                    const formErrorTop = document.getElementById('mlw_error_message');
                    formErrorTop.style.display = 'none';
                    const formErrorBottom = document.getElementById('mlw_error_message_bottom');
                    formErrorBottom.style.display = 'none'; 
                } 
            });
        });

    }

    // クイズフォームに変化があれば、質問の回答がチェックされたかどうかを確認する関数を実行
    if (quizForm) {
        quizForm.addEventListener('change', function(event) {
            checkAllAnswered();
            checkAllFormsFilled();
        });
    }

    // ページ内のすべての質問に対してlabel::afterが存在するか確認する
    function checkAllAnswered() {
        let allAnswered = true;
        errMessage.innerHTML = '';

        quizes.forEach(quiz => {   
            const labels = quiz.querySelectorAll('label');
            let answered = false;
            labels.forEach(label => {
                const afterContent = window.getComputedStyle(label, '::after').content;
                if (afterContent !== 'none') {
                    answered = true;
                }
            });

            if (!answered) {
                allAnswered = false; // 1つでも未回答のクイズがあれば、全体を未回答とする
            }

            if(allAnswered || timerExpired) {
                console.log('全て回答済みまたはタイマー終了');
                submitBtns.forEach(btn => {
                    btn.setAttribute('style', style + 'background-color: #2c5b8a !important; color: white !important;');
                    btn.disabled = false;
                    

                });
                
           
            } else {
                submitBtns.forEach(btn => {
                    btn.setAttribute('style', style + 'color: gray !important; background-color: #bdc3c7 !important;');
                    btn.disabled = true;
                });
                console.log('未回答あり');
    
                errMessage.classList.add('error-message');
                errMessage.innerHTML = '※全ての問題に回答し、送信ボタンを押してください';
    
                const submitBox = document.querySelector('.quiz_end');
                submitBox.insertBefore(errMessage, submitBtns[0]);
            }
        });

        // label::afterが全て存在する場合、またはタイマーが終了した場合、ボタンのdisabledを解除して、色を変更

    }

    // タイマーが00:00:00になったらsubmitBtnを有効にする
    function checkTimer() {
        if (mlw_qmn_timer.textContent === '00:00:00') {
            timerExpired = true;
            submitBtns.forEach(btn => {
                btn.disabled = false;
                btn.style.backgroundColor = '#2c5b8a';
                btn.style.color = 'white';
                errMessage.innerHTML = '※制限時間を超過しました。必要情報を入力して、送信ボタンをクリックしてください';
            });
        } else {
            setTimeout(checkTimer, 10); // 1秒ごとにチェック
        }
    }

    // ページを開いたときにチェックを実行し、初期状態を設定
    checkAllAnswered();
    checkAllFormsFilled();
    checkTimer(); // タイマーのチェックを開始
});




/* -------------------試験問題の数字のデザイン変更 */

document.addEventListener("DOMContentLoaded", function() {
const numbers = document.querySelectorAll('.mlw_qmn_question_number');
numbers.forEach(number => {
    number.style.color = '#2C5B8A';
    number.style.fontSize = '38px';

    if(number.textContent < 10) {
        number.textContent = '0' + number.textContent;
    }

})


});


/* ----------------------

タイムアップモーダルの出現を監視し、
モーダルの中の英語表記を日本語に変更する

-----------------------------*/

// 監視ターゲットの取得
const targets = document.querySelectorAll('.qsm-popup.qsm-popup-slide');


// オブザーバーの作成
const mb = new MutationObserver((entries) => {
    // timeUPのモーダルの英語表示を日本語化
  const timeUPTexts = document.querySelectorAll('.qsm-time-up-text');
  const timeUpSubmitBtn = document.querySelector('.submit-the-form.qmn_btn');

//   モーダルに注意事項の追加
  const timeUpCaution = document.createElement('p');
  timeUpCaution.classList.add('timeUpText__content');
  timeUpCaution.textContent = "受験者情報を未入力の場合、すべての項目の入力を完了してから試験画面下部の回答ボタンをクリックしてください";


//   timeUp errorメッセージを日本語化
  const timeEnd = document.querySelector('.qsm_timer_ended');
  const timeEndError = timeEnd.querySelectorAll('.qmn_error_message');
  timeEndError[0].textContent = '制限時間を超過しました。ここからは試験問題を受けることができません。回答ボタンを押してください';



// タイムアップ後の選択肢のレイアウト調整
const timeUpChoices = document.querySelectorAll('.mrq_checkbox_class');
timeUpChoices.forEach(choice => {
    choice.classList.add('timeUp');
})

  timeUPTexts[1].textContent = '時間切れです';
  timeUpSubmitBtn.textContent = '回答する'
  timeUpSubmitBtn.style.backgroundColor = '#2c5b8a !important';
  timeUPTexts[1].appendChild(timeUpCaution);

//   mutationObserverの停止
  mb.disconnect();

  
})

// 監視の開始
targets.forEach(target => {
    mb.observe(target, {
        attributes: true,
    })
})


