<?php
    $images = get_sub_field('photos');
    $aos_args = isset($args['aos_args']) ? $args['aos_args'] : null;
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
    echo '<div class="block_text-pics d-flex align-items-center my-12">';
        echo '<div class="block_pics col-md-6 " >';
            if( $images ): ?>
                <div id="masonry-grid" class="grid">
                    <?php foreach( $images as $image ): ?>
                        <div class="grid-item" <?=$dataAosImage;?>>
                            <a href="<?=$image['url'] ; ?>" data-lightbox="Jonesy" data-title="Jonesy Agency - studio Paris 11 <?php echo esc_url($image['alt']); ?>" >
                                <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="Thumbnail of <?php echo esc_url($image['alt']); ?>" />
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif;
        echo '</div>';
        echo '<div class="block_text text-start col-md-6 px-6" '.$dataAosText.' >';
            the_sub_field('contenu_texte');
                if( have_rows('details_boutons') ):
                    while( have_rows('details_boutons') ): the_row();
                        if( get_sub_field('texte_bouton') ):
                            $buttonText = '<button class="button-52" role="button">';
                            $buttonText .= '<a href="'.get_sub_field('lien_du_bouton').'" class="btn2">'.get_sub_field('texte_bouton').'</a>';
                            $buttonText .= '</button>';
                        endif;
                        if (isset($buttonText)) {
                            echo $buttonText;
                        }
                    endwhile;
                endif;
        echo '</div>';
    echo '</div>';