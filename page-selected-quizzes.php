<?php get_header(); ?>
<?php
/*
Template Name: Page Selected Quizzes
*/

// セッションから選択されたクイズ ID を取得
$selected_quizzes = isset($_SESSION['selected_quizzes']) ? $_SESSION['selected_quizzes'] : array();

if (!empty($selected_quizzes)) {
    // 選択されたクイズのみを表示
    $args = array(
        'post_type' => 'quiz', // クイズの投稿タイプ
        'post__in' => $selected_quizzes, // セッションに保存されたクイズ ID でフィルター
        'orderby' => 'date', // 作成日の古い順に並び替え
        'order' => 'ASC', // 昇順で表示
    );

    $quizzes = new WP_Query($args);
    if ($quizzes->have_posts()) :
        while ($quizzes->have_posts()) : $quizzes->the_post();
            ?>
            <div class="quiz-item">
                <!-- <h2><?php the_title(); ?></h2> -->
                 <div class="contentBox">
                 <?php the_content(); ?>
                 </div>
            </div>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
} else {
    echo '<p>選択されたクイズがありません。</p>';
}
?>


<?php get_footer(); ?>