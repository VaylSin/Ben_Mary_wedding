<?php
$aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
$texte = $args['texte'];
$dataAosText = '';
    if ($aos_args) {
        $dataAosText = 'data-aos="' . $aos_args['animation_texte'] . '"
            data-aos-duration="' . $aos_args['duration_texte'] . '"
            data-aos-delay="' . $aos_args['delay_texte'] . '"';
    }
    echo '<div class="block_text-pics d-flex align-items-center ">';
        echo '<div class="block_text col-md-12 px-4" '.$dataAosText.' >'.$texte.'</div>';
    echo '</div>';
