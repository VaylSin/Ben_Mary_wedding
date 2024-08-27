
<?php
$images = isset($args['images']) ? $args['images'] : [];
$aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;


$count = 0;
$dataAos =  'data-aos="'.$aos_args['animation_image'].'" data-aos-duration="'.$aos_args['duration_image'].'" ';

echo '<div class="block_pics-text d-flex static-banner align-items-center content-center gap-1" >';
    if($images) {
        foreach($images as $image) {
            echo '<div class="block_pics" '.$dataAos.' data-aos-delay='.$count.'>';
                echo '<a href="' . esc_url($image['url']) . '" data-lightbox="mariage">
                <img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt']) . '"></a>';
            echo '</div>';
            $count = $count + intval($aos_args['delay_image']);
        }
    }
echo '</div>';
