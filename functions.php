<?php

function jz_setup()
{
	add_editor_style();
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
	register_nav_menu('primary', 'Primary Menu');
}

add_action('after_setup_theme', 'jz_setup');

function jz_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed()) {
		return $title;
	}

	$title .= get_bloginfo('name');

	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page())) {
		$title = "$title $sep $site_description";
	}

	if ($paged >= 2 || $page >= 2) {
		$title = "$title $sep " . sprintf('ページ %s', max($paged, $page));
	}

	return $title;
}

add_filter('wp_title', 'jz_wp_title', 10, 2);

function jz_widgets_init()
{
	register_sidebar(array(
		'name'          => 'バナーエリア',
		'id'            => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}

add_action('widgets_init', 'jz_widgets_init');


add_filter('wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2);
add_filter('wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2);
function wpcf7_text_validation_filter_extend($result, $tag)
{
	$type           = $tag['type'];
	$name           = $tag['name'];
	$_POST[$name] = trim(strtr((string) $_POST[$name], "\n", " "));
	if ('email' == $type || 'email*' == $type) {
		if (preg_match('/(.*)_confirm$/', $name, $matches)) {
			$target_name = $matches[1];
			if ($_POST[$name] != $_POST[$target_name]) {
				if (method_exists($result, 'invalidate')) {
					$result->invalidate($tag, "確認用のメールアドレスが一致していません");
				} else {
					$result['valid']           = false;
					$result['reason'][$name] = '確認用のメールアドレスが一致していません';
				}
			}
		}
	}

	return $result;
}





//固定ページ以外ではpタグ自動挿入を無効にする
add_filter('the_content', 'wpautop_filter', 9);
function wpautop_filter($content) {
global $post;
$remove_filter = false;

//自動整形を無効にする投稿タイプを記述 ＝固定ページ
$arr_types = array('page');
$post_type = get_post_type( $post->ID );
if (in_array($post_type, $arr_types)){
$remove_filter = true;
}

//投稿ページ以外の自動整形を無効にしたければ
if (!is_single()){
$remove_filter = true;
}
if (!is_singular()){
    $remove_filter = true;
    }

if ( $remove_filter ) {
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
}

return $content;
}


/* 画像にsrcsetが埋め込まれるのを削除 */
add_filter('wp_calculate_image_srcset_meta', '__return_null');



// Contact Form 7で自動挿入されるPタグ、brタグを削除
add_filter('wpcf7_autop_or_not', 'wpcf7_autop_return_false');
function wpcf7_autop_return_false()
{
    return false;
}

//管理画面のメニューに「外観、メニュー」の表示  
add_action('after_setup_theme', 'register_menu');
function register_menu()
{
    register_nav_menu('primary', __('Primary Menu', 'theme-slug'));
}

//タクソノミーページでもページネーションができるよう設定
add_rewrite_rule('news/([^/]+)/page/([0-9]+)/?$', 'index.php?news_cat=$matches[1]&paged=$matches[2]', 'top');
add_rewrite_rule('works/([^/]+)/page/([0-9]+)/?$', 'index.php?works_cat=$matches[1]&paged=$matches[2]', 'top');

/*カラーパレットの色追加*/
function my_mce4_options($init)
{
    $default_colors = '
        "000000", "Black",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Brown",
        "C0C0C0", "Silver",
        "FF99CC", "Pink",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99FF", "Plum",
        "FFFFFF", "White"
        ';
    $custom_colors = '
        "ff6464", "Color1",
        "e88727", "Color2",
        "f2d729", "Color3",
        "91e079", "Color4",
        "3fc1c9", "Color5",
        "0000bb", "Color6",
        "ac5eb5", "Color7"
        ';
    $init['textcolor_map'] = '[' . $default_colors . ',' . $custom_colors . ']';
    $init['textcolor_rows'] = 6;
    return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');





function display_content_for_specific_emails($atts, $content = null) {
    // 特定のメールアドレスリストを定義
    $allowed_emails = array(
        'k.konishi@env-value.co.jp',
        'm.sato@env-value.co.jp',
        'sato@env-value.co.jp',

    );
    
    // 現在のユーザーを取得
    $current_user = wp_get_current_user();
    
    // デバッグ用出力
    error_log('Current User Email: ' . $current_user->user_email);
   
   
    $html = '';
    // ユーザーがログインしているか、そしてメールアドレスがリストに含まれているかを確認
    if (is_user_logged_in() && in_array($current_user->user_email, $allowed_emails)) {
        // 一致する場合、コンテンツを表示
        $html .= '
        <div class="wrapper">
                <div class="wrapper__Request wrapper--top">
        <div class="wrapper__Request__02Content">
                <div class="wrapper__Request__mainTitle">
                    <p class="wrapper__Request__mainTitle--text">受講データ申請</p>
                </div>
        </div>
       <div class="wrapper__Request__requestBox">
       <p class="wrapper__Request__detail">受講者データの申請は、こちらから行えます。
       </p>

  <a class="buttonSecondary" href=' . home_url('/application') .'" >受講データを申請する</a>
  </div></div>';


        
      
        return $html;
    }
    
    // 一致しない場合は何も表示しない
    return '';
}

// ショートコードを登録
add_shortcode('specific_email_content', 'display_content_for_specific_emails');




// セッションの開始
add_action('init', 'start_session', 1);
function start_session() {
    if ( !session_id() && !is_admin() && !defined('DOING_AJAX') && !defined('REST_REQUEST') ) {
        session_start();
    }
    
}

// カスタム投稿タイプの設定
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'quiz', /* カスタム投稿タイプスラッグ */
    array(
      'labels' => array( /* 表示させる文字 */
        'name' => __('試験問題'),
        'singular_name' => __('試験問題'),
        'all_items' => '試験問題一覧',
        'add_new' => '新規追加',
        'add_new_item' => '試験問題を追加',
        'edit_item' => '編集',
        'new_item' => '新規追加',
        'view_item' => '試験問題を表示',
        'search_items' => '試験問題を検索',
        'not_found' =>  '試験問題が見つかりません',
        'not_found_in_trash' => 'ゴミ箱内に試験問題が見つかりませんでした。',
        'parent_item_colon' => ''
      ),
      'public' => true, /* 管理画面にメニューを作る */
      'show_ui' => true, /* 管理画面にメニューを作る */
      'query_var' => true,
      'hierarchical' => false, /* 固定ページみたいに記事間の親子関係をつくる */
      'supports' => array('title','editor','thumbnail','revisions'), /* 管理画面で登録できる項目 */
      'menu_position' =>5, /* 管理画面のメニューの位置（5,10,15・・・） */
      'has_archive' => true, /* アーカイブページを持つ */
      'rewrite' => array( /* slug:スラッグ名　with_front:アーカイブページURLに/archive/をつける */
        'slug' => 'quiz','with_front' => false)
    )
  );

//   事例カスタム投稿ページのタクソノミー設定

  register_taxonomy('quiz_cat','quiz', array(
	'hierarchical' => true,
	'labels' => array( /* 表示させる文字 */
		'name' => 'カテゴリ',
		'singular_name' => 'カテゴリ',
		'search_items' =>  'カテゴリを検索',
		'all_items' => 'すべてのカテゴリ',
		'parent_item' => '親分類',
		'parent_item_colon' => '親分類：',
		'edit_item' => '編集',
		'update_item' => '更新',
		'add_new_item' => 'カテゴリを追加',
		'new_item_name' => '名前',
	),
	'show_ui' => true, /* 管理画面にメニューを作る */
	'rewrite' => array(
		'slug' => 'quiz','with_front' => true,'hierarchical' => true)
));
 
}
// クイズ選択フォームショートコード
function quiz_selection_form() {
    $args = array(
        'post_type' => 'quiz',
        'posts_per_page' => -1,
        'orderby' => 'date', // 作成日の古い順に並び替え
        'order' => 'ASC'     // 昇順で表示
    );
    $quizzes = new WP_Query($args);

    if ($quizzes->have_posts()) {
        $output = '<form class="category_form" method="post" action=""><div class="category_form__link">';
        while ($quizzes->have_posts()) {
            $quizzes->the_post();
            $output .= '<label class="selected_category"><input type="radio" name="selected_quizzes" value="' . get_the_ID() . '"> <div class="selected_category__inner"><span>' . get_the_title() . '</span><img src=" ' . get_template_directory_uri() .'/img/category-check.svg"></div></label>';
        }
        $output .= '</div>';
        $output .= '
    <div class="wrapper__cationBox">
    <div class="wrapper__cationBox__title">
        <img class="wrapper__cationBox__title--icon" src=" '. get_template_directory_uri() . '/img/exclamation.svg" alt="">
        <p class="wrapper__cationBox__title--text">検定の注意事項<span>  ※試験前に必ずお読みください</span></p>
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
    受験中に画面を閉じたり、ブラウザバックを行うと進捗が保存されているため、次回受験時に制限時間の途中から受験が開始します。
    また、制限時間の30分以上経過した場合、回答することができないため、一度、回答を送信するボタンをクリックし、結果を表示してから再受験を行ってください。</p>
</li>

</ul>
    </div>
</div>
        ';
        $output .= '<input class="buttonPrimary" type="submit" name="submit_quizzes" value="検定を受ける">';
        $output .= '</form>';
        wp_reset_postdata();
        return $output;
    }
}
add_shortcode('quiz_selection_form', 'quiz_selection_form');

// 選択されたクイズをセッションに保存
function save_selected_quizzes() {
    if (isset($_POST['submit_quizzes'])) {
        // 選択されたクイズの ID をセッションに保存
        if (isset($_POST['selected_quizzes'])) {
            $_SESSION['selected_quizzes'] = array($_POST['selected_quizzes']); // 選択されたクイズのIDを配列として保存
            wp_redirect(home_url('/selected-quizzes'));
            exit;
        }
    }
}
add_action('template_redirect', 'save_selected_quizzes');


// contactform 7でユーザー情報を自動入力させる
function my_dynamic_cf7_fields($tag) {
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        
        // if ($tag['name'] == 'user-name') {
        //     $tag['values'] = array($current_user->user_login);
        // }
        
        if ($tag['name'] == 'user-email') {
            $tag['values'] = array($current_user->user_email);
        }

        if ($tag['name'] == 'first-name') {
            $tag['values'] = array($current_user->user_firstname);
        }
        
        if ($tag['name'] == 'last-name') {
            $tag['values'] = array($current_user->user_lastname);
        }
    }
    return $tag;
}
add_filter('wpcf7_form_tag', 'my_dynamic_cf7_fields', 10, 2);

// クイズにすべて回答したかどうかを確認する
function qsm_custom_script() {
    if (is_page('quiz')) { // クイズが表示されるページのスラッグを指定
        wp_enqueue_script('qsm-custom-js', get_template_directory_uri() . '/qsm-custom.js', null, true);
    }
}
add_action('wp_enqueue_scripts', 'qsm_custom_script');




// 
//問い合わせ完了後　thanks ページにリダイレクト
add_action('wp_footer', 'kaiza_wp_footer');
function kaiza_wp_footer()
{
    global $post;

    if (is_page('application')) { //他のページで出したくないので、ページ特定
        $url = get_permalink($post->ID);
    ?>
        <script type="text/javascript">
            document.addEventListener('wpcf7mailsent', function(event) {
                location.replace("<?php echo $url; ?>thanks/");
            }, false);
        </script>
    <?php
    }
}

/* login pageのbodyにCSSを追加 */
function add_custom_css_for_quiz_login_page() {
    // 現在のページが "quiz-login" というスラッグのページか確認
    if (is_page('quiz-login')) {
        ?>
               <style type="text/css">
            body {
                background:linear-gradient(to right, transparent 0%, transparent 50%, #F1F7FF 50%, #F1F7FF 100%), 
                url('https://test-prime-college-certification.com/wordpress/wp-content/themes/prime-test-sec/img/login-bg.png') no-repeat;
                background-size: cover;
                background-position: center center;
               
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'add_custom_css_for_quiz_login_page');


