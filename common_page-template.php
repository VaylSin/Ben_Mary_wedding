<?php
/*
Template Name: modèle de page standard
*/


if(get_the_ID() == 26) {
    $header_page = 'page';
    $mt = 'my-6';
    $confirm_from_history = true;
} else {
    $header_page = null;
    $mt = null;
    $confirm_from_history = false;

}

get_header($header_page);
?>

<main id="primary" class="site-main ">
    <section class="main_content">
        <div class="">
            <div class="title_container container_xl <?=$mt;?> text-center">
                <h1><?php the_title(); ?></h1>
            </div>
            <?php if($header_page != null) { ?>
                <div class="content_container container_xl  text-center">
                    <?php the_content(); ?>
                </div>
            <?php } ?>
            <?php if( have_rows( 'bloc_image__texte' ) ): ?>
            <div class="block_pics-text_container  ">
                <?php while ( have_rows( 'bloc_image__texte' ) ) : the_row();
                        $exclude_aos_text = array('banderole_images_statiques', 'prestations');
                        $aos_image = get_sub_field('animations_image') ? get_sub_field('animations_image') : [];
                        $aos_texte = get_sub_field('animations_texte') ? get_sub_field('animations_texte') : [];
                        $aos_activate = ((isset($aos_image['activate_animation']) && $aos_image['activate_animation'])
                            || (isset($aos_texte['activate_animation']) && $aos_texte['activate_animation']))
                            ? true
                            : false;
                        if($aos_activate) {
                            if(is_array($exclude_aos_text) && !in_array(get_row_layout(), $exclude_aos_text)){
                                $aos_args = [
                                    'animation_image' => $aos_image['reglages']['type_danimation'],
                                    'duration_image' => $aos_image['reglages']['duree_de_lanimation'],
                                    'delay_image' => $aos_image['reglages']['delai'],
                                    'animation_texte' => $aos_texte['reglages']['type_danimation'],
                                    'duration_texte' => $aos_texte['reglages']['duree_de_lanimation'],
                                    'delay_texte' => $aos_texte['reglages']['delai'],
                                ];
                            } else {
                                $aos_args = [
                                    'animation_image' => $aos_image['reglages']['type_danimation'],
                                    'duration_image' => $aos_image['reglages']['duree_de_lanimation'],
                                    'delay_image' => $aos_image['reglages']['delai'],
                                ];
                            }
                        } else {
                            $aos_args = [];
                        }
                        if (get_row_layout() === 'banderole_images_statiques') {
                            $args = [
                                'images' => get_sub_field('banniere'),
                                'aos_args' => $aos_args
                            ];
                        } elseif (get_row_layout() === 'bloc_spacer') {
                            $args = [
                                'hauteur' => get_sub_field('hauteur'),
                            ];
                        } elseif (get_row_layout() === 'bloc_texte_simple') {
                            $args = [
                                'aos_args' => $aos_args,
                                'texte' => get_sub_field('contenu_texte')
                            ];
                        } else {
                            $args = [
                                'aos_args' => $aos_args
                            ];
                        }
                        $class_container = (get_row_layout() === 'banderole_images_statiques') ? null : 'container_xl';
                        echo '<div class="'.$class_container.' ">';
                            get_template_part('template-parts/layout_block', get_row_layout(), $args);
                        echo '</div>';
                    ?>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php if($confirm_from_history) :?>
        <section id="notre-histoire" class="history container_xl">
            <div class="history_container my-14">
                <div class="history_title text-center">
                    <h3 class="mb-6">Nous espérons vous compter parmi nous !</h3>
                    <div class="ornements_container">
                        <hr>
                        <a href="<?php the_permalink(259);?>" class="button btn-confirm-coming px-6 py-3">Confirmez votre venue</a>
                        <hr>
                    </div>
                </div>

            </div>
        </section>
        <?php endif;?>
    </section>
</main><!-- #main -->
<?php
get_footer();