// 同じクラスを持つ要素をすべて取得
const examForms = document.querySelectorAll('.qsm_contact_div');

// ラップ用の新しい要素を作成
const wrapper = document.createElement('div');
wrapper.classList.add('examContactForm__box');

/* ラップ内にテキストを追加 */
const examFormText = document.createElement('p');
examFormText.classList.add('examContactForm__box--text');
examFormText.textContent = '受験者の情報を入力してください';

const examFormTextSmall = document.createElement('span');
examFormTextSmall.textContent = '（受講レポートに使用いたしますので、正確に入力してください）';

const formLabels = document.querySelectorAll('.mlw_qmn_question.qsm_question');

formLabels.forEach(label => {
  const formLabelRequired = document.createElement('span');
  formLabelRequired.textContent = '必須';
formLabelRequired.classList.add('Form-Item-Label-Required');
  label.appendChild(formLabelRequired);
});

// 最初の要素の親要素を取得
const parent = examForms[0].parentNode;

// 最初の要素の前に新しい要素を挿入
parent.insertBefore(wrapper, examForms[0]);

// 取得した要素をすべてラップ要素に移動
examForms.forEach(form => {
  wrapper.appendChild(form);
});


wrapper.prepend(examFormText);
examFormText.appendChild(examFormTextSmall);
