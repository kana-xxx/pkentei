<!DOCTYPE html>
<html lang="ja">

<?php get_template_part('inc/head'); ?>

<body>
<?php wp_body_open(); ?>
    <header>
      <div class="headerContent">
      <a class="headerContent__link" href="<?php echo home_url(); ?>">
        <?php 
        if(is_page( 'quiz-login' )) {

        
          echo ' <img class="headerContent__link__logo" src=" ' . get_template_directory_uri() . '/img/logo-white.svg" alt="ロゴ白">';
        } else {
          echo ' <img class="headerContent__link__logo" src=" ' .get_template_directory_uri() . '/img/plogo.svg" alt="Prime Collegeロゴ">';
        }
        ?>
       
        </a>

        <div class="profileContent">


        
          <div class="profileContent__nameBox">
            <div class="profileContent__nameBox__imgBox">
            <img class="profileContent__nameBox__imgBox--icon" src="https://test-prime-college-certification.com/wordpress/wp-content/themes/prime-test-sec/img/user-icon.svg" alt="ユーザーアイコン">
            </div>
          
            <?php
// 現在のユーザー情報を取得
$current_user = wp_get_current_user();

// ユーザーがログインしているかどうかをチェック
if ( is_user_logged_in() ) {
    // 苗字と名前を取得
    $first_name = $current_user->user_firstname;
    $last_name = $current_user->user_lastname;

    // 苗字と名前を表示
    echo ' <p class="profileContent__nameBox--userName">
    <span class="name login">' . esc_html($first_name) . ' ' . esc_html($last_name) .' さん' . '</span></p></div>';
} else {
    // ログインしていない場合のメッセージ
    echo ' <p class="profileContent__nameBox--userName">
    <span class="name login">こんにちは、ゲストさん！</span></p></div>';
}
?>

<div class="profileContent__modal">
  <div class="profileContent__modal--outer">

  <div class="profileContent__modal__userInfo">
    <div class="profileContent__modal__userInfo__imgBox">
    <img class="profileContent__modal__userInfo--icon" src="https://test-prime-college-certification.com/wordpress/wp-content/themes/prime-test-sec/img/user-icon.svg" alt="ユーザーアイコン">
    </div>
    <div class="profileContent__modal__userInfo__nameContent">
      <p class="profileContent__modal__userInfo__nameContent--name">
    <?php
// ユーザーがログインしているかどうかをチェック
if ( is_user_logged_in() ) {
    // 苗字と名前を取得
    $first_name = $current_user->user_firstname;
    $last_name = $current_user->user_lastname;

    // 苗字と名前を表示
    echo '<span class="name login">' . esc_html($first_name) . ' ' . esc_html($last_name) .' さん' . '</span>';
} else {
    // ログインしていない場合のメッセージ
    echo '<span class="name login">こんにちは、ゲストさん！</span>';
}
?></p>

 <p class="profileContent__modal__userInfo__nameContent--email">
  <?php
  if ( is_user_logged_in() ) {
    // 苗字と名前を取得
    $email = $current_user->user_email;

    // 苗字と名前を表示
    echo '<span class="email">' . esc_html($email) . '</span>';
} else {
    // ログインしていない場合のメッセージ
    echo '';
} ?>
</p>
    </div>
  </div>


<?php
if (is_user_logged_in()) {
  echo '<div class="profileContent__modal__logout">

<div class="profileContent__modal__logout--text">';
    // ログアウトURLを取得し、リダイレクト先を指定
    $logout_url = wp_logout_url(home_url('/quiz-login'));
    echo '<a href="' . esc_url($logout_url) . '" class="button logout-button">ログアウト</a>';

    echo '</div></div>';
}
else {
  echo '<div class="profileContent__modal__logout">

  <div class="profileContent__modal__logout--text">';
  // ログインURLを取得し、リダイレクト先を指定
  $logout_url = wp_logout_url(home_url('/quiz-login'));
  echo '<a href="' . esc_url($logout_url) . '" class="button logout-button">ログイン</a></div></div>';
}
?>

</div>
</div>
          </div>
        </div>

      </div>  
    </header>
    <body>