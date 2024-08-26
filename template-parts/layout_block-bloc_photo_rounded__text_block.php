<?php $aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
    if ($aos_args) {
        $dataAosImage = 'data-aos="' . $aos_args['animation_image'] . '"
            data-aos-duration="' . $aos_args['duration_image'] . '"
            data-aos-delay="' . $aos_args['delay_image'] . '"';
        $dataAosText = 'data-aos="' . $aos_args['animation_texte'] . '"
            data-aos-duration="' . $aos_args['duration_texte'] . '"
            data-aos-delay="' . $aos_args['delay_texte'] . '"';
    }
    echo '<div class="block_pics-text pic-rounded flex-column align-items-center " >';
        echo '<div class="block_pics col-md-4" >';
            $image = get_sub_field('photo');
                if( $image ) {
                    echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" '.$dataAosImage.'>';
                }
        echo '</div>';
        echo '<div class="block_text col-md-10 py-3 text-center" '.$dataAosText.'>';
            echo '<p>'.the_sub_field('contenu_texte').'</p>';
        echo '</div>';
    echo '</div>';