<?php $aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
$dataAosImage = '';
$dataAosText = '';
    if ($aos_args) {
        $dataAosImage = 'data-aos="' . $aos_args['animation_image'] . '"
            data-aos-duration="' . $aos_args['duration_image'] . '"
            data-aos-delay="' . $aos_args['delay_image'] . '"';
        $dataAosText = 'data-aos="' . $aos_args['animation_texte'] . '"
            data-aos-duration="' . $aos_args['duration_texte'] . '"
            data-aos-delay="' . $aos_args['delay_texte'] . '"';
    }
    echo '<div class="block_text-pics d-flex align-items-center ">';
        echo '<div class="block_text text-end col-md-5 px-6" '.$dataAosText.' >';
            the_sub_field('contenu_texte');
        echo '</div>';
        echo '<div class="block_pics d-flex content-end  col-md-7 col-sm-6" >';
            $image = get_sub_field('photo');
                if( $image ) {
                    echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" '.$dataAosImage.'>';
                }
        echo '</div>';
    echo '</div>';
