<?php
acf_form_head();
get_header($name = 'page');

?>

<main id="primary" class="site-main px-2">
    <section class="main_content d-flex content-center">
        <div class="col-md-8 text-center">
            <?php //echo do_shortcode('[contact-form-7 id="d561db0" title="Formulaire de confirmation de venue"]')
                acf_form(array(
                    'post_id' => 'new_post',
                    'new_post' => array(
                        'post_type' => 'invites',
                        'post_status' => 'publish'
                    ),
                    'field_groups' => array(146), // L'ID du post du groupe de champs
                    'submit_value' => 'Confirmer ma venue',
                    // 'return' => add_query_arg('submitted', 'true', get_permalink())

                ));
                if (isset($_GET['submitted']) && $_GET['submitted'] == 'true') : ?>
                    <script type="text/javascript">
                        // alert('Le formulaire a été soumis avec succès.');
                        Swal.fire({
                            title: 'Error!',
                            text: 'Do you want to continue',
                            icon: 'error',
                            confirmButtonText: 'Cool'
                            })
                    </script>
                <?php endif;
            ?>
        </div>
    </section>
</main>
<?php
get_footer();
?>