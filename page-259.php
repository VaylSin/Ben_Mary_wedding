<?php
    acf_form_head();
    get_header($name = 'page');
?>

<main id="primary" class="site-main contact px-2">
    <section class="main_content flex-column align-items-center content-center">
        <div class="col-md-6 my-8 text-center" data-aos="fade-up" data-aos-duration="750">
            <?php echo the_content();?>
        </div>
        <div class="col-md-6 form_container text-center"data-aos="fade-up" data-aos-duration="750" data-aos-delay="500">
            <?php 
                acf_form(array(
                    'post_id' => 'new_post',
                    'new_post' => array(
                        'post_type' => 'invites',
                        'post_status' => 'publish'
                    ),
                    'field_groups' => array(146), // L'ID du post du groupe de champs
                    'submit_value' => 'Confirmer ma venue',
                    'updated_message' => __("Votre confirmation a bien été prise en compte.", 'acf'),
                    'html_submit_button'  => '<input type="submit" class="button btn-confirm-coming px-4 py-2" value="%s" />',
                    'html_submit_spinner' => '<span class="acf-spinner"></span>',
                    'return' => add_query_arg('submitted', 'true', get_permalink())

                ));
                if (isset($_GET['submitted']) && $_GET['submitted'] == 'true') : ?>
                    <script type="text/javascript">
                        Swal.fire({
                            title: 'Merci !',
                            text: 'Nous vous tiendrons informés de la suite des évenements ! Vous allez être redirigé vers la page d\'accueil',
                            icon: 'success',
                            confirmButtonText: 'Compris !',
                        }).then(() => {
                            setTimeout(() => {
                                window.location.href = '<?php echo get_permalink(14);?>'
                            }, 3000);
                        })
                    </script>
                    <?php wp_redirect( get_permalink(14) );
endif;
            ?>
        </div>
    </section>
</main>
<?php
    get_footer();
?>