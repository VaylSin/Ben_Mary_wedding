<?php $aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
    if ($aos_args) {
        $dataAosImage = 'data-aos="' . $aos_args['animation_image'] . '"
            data-aos-duration="' . $aos_args['duration_image'] . '"
            data-aos-delay="' . $aos_args['delay_image'] . '"';
        $dataAosText = 'data-aos="' . $aos_args['animation_texte'] . '"
            data-aos-duration="' . $aos_args['duration_texte'] . '"
            data-aos-delay="' . $aos_args['delay_texte'] . '"';
    }
    echo '<div class="block_pics-text pic-rounded flex-column align-items-center my-12" >';
        echo '<div class="block_pics col-md-3" >';
            $image = get_sub_field('photo');
                if( $image ) {
                    echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" '.$dataAosImage.'>';
                }
        echo '</div>';
        echo '<div class="block_text col-md-6 py-3 text-center" '.$dataAosText.'>';
            echo '<p>'.the_sub_field('contenu_texte').'</p>';
                if( have_rows('details_boutons') ):
                    while( have_rows('details_boutons') ): the_row();
                        if( get_sub_field('texte_bouton') ):
                            echo '<button class="button-52" role="button">';
                                echo '<a href="'.the_sub_field('lien_du_bouton').'" class="btn2">'.the_sub_field('texte_bouton').'</a>';
                            echo '</button>';
                        endif;
                    endwhile;
                endif;
        echo '</div>';
    echo '</div>';