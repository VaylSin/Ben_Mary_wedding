<?php
get_header($name = null);
global $activate_history ;
$backgroundResaCss  = 'style="background-image: url(' . get_field('image_de_fond_resa') . ');
    height: 100%;
	background-size: cover;
    background-attachment: fixed;
	background-position: top center;
    filter: saturate(0.5);
	background-repeat: no-repeat;"';
?>
<main id="primary" class="site-main px-2">
    <section class="main_content">
        <div class="" id="lieux-horaires">
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
    <section id="notre-histoire" class="history container_xl">
        <?php if($activate_history) :?>
        <div class="history_container my-14">
            <div class="history_title text-center">
                <h2><?php the_field('phrase_de_presentation'); ?></h2>
                <div class="ornements_container">
                    <hr>
                    <a href="<?php the_permalink(26);?>" class="button btn-confirm-coming px-6 py-3"><?=the_field('texte_du_bouton');?></a>
                    <hr>
                </div>
            </div>

        </div>
        <?php endif; ?>
    </section>
    <!-- container_full -->
    <section class=" reservation_container">
        <div class="d-flex align-items-center text-center content-center" <?=$backgroundResaCss;?>>
            <div class="absolute backgroundCss_filter"></div>
            <div class=" ">
                <?php if(get_field('phrase_de_presentation_resa')): 
                    echo '<div class="resa_main_text flex-column align-items-center gap-3" data-aos="zoom-in" >';
                        echo '<p>'.get_field('phrase_de_presentation_resa').'</p>';
                        echo' <a href="'.get_the_permalink(259).'" class="button btn-confirm-coming px-6 py-3">'.get_field('texte_du_bouton_resa').'</a>';
                    echo '</div>';
                endif; ?>
            </div>
        </div>
    </section>
</main><!-- #main -->
<?php
get_footer();