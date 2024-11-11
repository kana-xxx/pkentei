<?php
/* Template Name: Quiz Login */

if (is_user_logged_in()) {
    wp_redirect(home_url('/quiz-selection'));
    exit;
}

get_header();
?>

<div class="loginBox">

<div class="loginBox__moodBoard">
    <p class="loginBox__moodBoard--text">Prime College検定へ<br>
    ようこそ</p>
</div>

<div class="loginBox__loginForm">
<form name="qsm-login-form" id="qsm-login-form" action="https://test-prime-college-certification.com/wordpress/wp-login.php" method="post">
    <h2 class="loginBox__loginForm--text">ログイン情報を入力してください</h2>
    <p class="loginBox__loginForm__item login-username">
        <p class="Form-Item-Label">メールアドレス</p>
        <input class="loginBox__loginForm__form" type="text" name="log" id="user_login" autocomplete="username" placeholder="メールアドレスを入力してください" value="" size="20" />
    </p>
    <p class="loginBox__loginForm__item login-password">
        <p class="Form-Item-Label">パスワード</p>
        <input class="loginBox__loginForm__form" type="password" name="pwd" id="user_pass" autocomplete="current-password" spellcheck="false" placeholder="パスワードを入力してください" value="" size="20" />
    </p>
    <!-- <p class="login-remember">
        <label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> ログイン状態を保存する</label>
    </p> -->
    <p class="login-submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="buttonPrimary" value="ログイン" />
        <input type="hidden" name="redirect_to" value="<?php echo home_url('/quiz-selection'); ?>" />
       
        
    </p>
    <p class="loginForget--text">ログインパスワードを忘れた場合は、<a href="#">こちら</a>から<br>お問い合わせください</p>
</form>

</div>

</div>
<?php get_footer(); ?>

