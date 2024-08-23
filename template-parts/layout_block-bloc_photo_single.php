<?php $aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
$dataAosImage = ''; // Initialisation avec une chaîne vide
$dataAosText = ''; // Initialisation avec une chaîne vide
$imagePosition = get_sub_field('position_image');

    if ($aos_args) {
        $dataAosImage = 'data-aos="' . $aos_args['animation_image'] . '"
            data-aos-duration="' . $aos_args['duration_image'] . '"
            data-aos-delay="' . $aos_args['delay_image'] . '"';
        $dataAosText = 'data-aos="' . $aos_args['animation_texte'] . '"
            data-aos-duration="' . $aos_args['duration_texte'] . '"
            data-aos-delay="' . $aos_args['delay_texte'] . '"';
    }
    echo '<div class="block_pic-single d-flex '.$imagePosition.' align-items-center my-10">';
        echo '<div class="block_pics col-md-7" >';
            $image = get_sub_field('photo');
                if( $image ) {
                    echo '<img  src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" '.$dataAosImage.'>';
                }
        echo '</div>';
    echo '</div>';
