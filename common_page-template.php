<?php
/*
Template Name: modèle de page standard
*/

get_header();
?>
// * @package mariage_ben_et_marie
// */
// ! Reste a gérer le header, le bloc histoire  + resa 
<main id="primary" class="site-main ">
    <section class="main_content">
        <div class="">
            <div class="title_container container_xl  text-center">
                <h1><?php the_title(); ?></h1>
            </div>
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
    </section>
</main><!-- #main -->
<?php
get_footer();