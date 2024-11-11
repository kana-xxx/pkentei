

<?php get_header(); ?>
    <div class="contentBox">
        <div class="contentBox__pageTitleWrapper">
            <p class="contentBox__pageTitleWrapper--text">Prime College検定</p>

            <div class="wrapper wrapperTop">

                <div class="wrapper__categoryBox wrapper-top" >
                <div class="wrapper__categoryBox__mainTitle">
                    <p class="wrapper__categoryBox__mainTitle--text">廃棄物検定を受講する</p>
                </div>
                <p class="wrapper__categoryBox__detail">受講するカテゴリーを一つ選択してください</p>
                <div class="wrapper__categoryBox__categoryButton">

                </div>
                </div>
           
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
?>

<div class="wrapper__cationBox">
    <div class="wrapper__cationBox__title">
        <img class="wrapper__cationBox__title--icon" src="<?php echo get_template_directory_uri(); ?>/img/exclamation.svg" alt="">
        <p class="wrapper__cationBox__title--text">検定の注意事項 検定の注意事項  <span>※試験前に必ずお読みください</span></p>
    </div>

    <div class="wrapper__cationBox__detail">
<ul>
<li class="wrapper__cationBox__detail--text">
    <p><span>1. 受験者情報の入力</span><br>
    検定結果を正確に反映するため、受験者情報を正しく入力してください。<br>
    不完全な情報だと、結果が正常に表示されない可能性がありますので、必ず正確に入力をしてください。</p>
</li>

<li class="wrapper__cationBox__detail--text">
    <p><span>2. 制限時間と回答の完了</span><br>
    検定には制限時間が設定されています。時間切れとなると、未回答の問題はすべて不正解扱いとなり、以降、回答することができません。<br>
    制限時間内にすべての問題に回答し、送信ボタンを押して結果画面へ進んでください。</p>
</li>

<li class="wrapper__cationBox__detail--text">
    <p><span>3. 受験中の注意 （制限時間内に回答している場合）</span><br>
    すべての問題に何らかの回答を選択しないと、回答を送信するボタンを押すことができません。<br>
    未回答の問題がないことを確認してから、送信ボタンを押してください。</p>
</li>

<li class="wrapper__cationBox__detail--text">
    <p><span>4. 途中終了した場合</span><br>
    受験中に画面を閉じたり、ブラウザバックを行うと進捗が保存されているため、次回受験時に制限時間の途中から受験が開始します。<br>
    また、制限時間の30分以上経過した場合、回答することができないため、一度、回答を送信するボタンをクリックし、結果を表示してから再受験を行ってください。</p>
</li>

</ul>
    </div>

    <a class="buttonPrimary">
        <span class="buttonPrimary--text">検定を受ける</span>
    </a>
</div>

            </div>
        </div>

        <div class="wrapper__Request wrapper-top">
        <div class="wrapper__Request__02Content">
                <div class="wrapper__Request__mainTitle">
                    <p class="wrapper__Request__mainTitle--text">受講データ申請</p>
                </div>
        </div>
       <div class="wrapper__Request__requestBox">
       <p class="wrapper__Request__detail">受講者データの申請は、こちらから行えます。
       </p>

       <a class="buttonSecondary">
        <span class="buttonSecondary--text">受講データ申請</span>
        </a>

       </div>
    </div>

        </div>
    <?php get_footer(); ?>

