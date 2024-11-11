<?php if (!is_front_page()) : ?>
    <?php if (!is_front_page()) { ?>
        <div class="breadcrumbs">
            <ul>
                <?php if (function_exists('bcn_display')) {
                    bcn_display_list();
                } ?>
            </ul>
        </div>
    <?php } ?>
<?php endif; ?>