
<?php echo theme_view('partials/_header'); ?>
<?php echo theme_view('partials/_left'); ?>
<section>
    <!-- START Page content-->
    <section class="main-content">
        <?php echo Template::yield(); ?>
    </section>
</section>
<?php echo theme_view('partials/_footer'); ?>