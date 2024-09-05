<?php
/**
 * mariage ben et marie Theme Customizer
 *
 * @package mariage_ben_et_marie
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mariage_ben_et_marie_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'mariage_ben_et_marie_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'mariage_ben_et_marie_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'mariage_ben_et_marie_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mariage_ben_et_marie_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mariage_ben_et_marie_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mariage_ben_et_marie_customize_preview_js() {
	wp_enqueue_script( 'mariage-ben-et-marie-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'mariage_ben_et_marie_customize_preview_js' );


// Hook pour générer et enregistrer un mot de passe hashé
add_action('acf/save_post', 'generate_and_save_password', 20);
function generate_and_save_password($post_id) {
    if ($post_id == 'new_post') {
        return;
    }
    // Récupérer les valeurs des champs nom et prenom
    $nom = get_field('nom', $post_id);
    $prenom = get_field('prenom', $post_id);
	$post_title = sanitize_text_field($nom . ' ' . $prenom);

    // Mettre à jour le titre du post
    wp_update_post(array(
        'ID' => $post_id,
        'post_title' => $post_title
    ));

    // Générer un mot de passe aléatoire
    $password = wp_generate_password();

    // Hacher le mot de passe
    $hashed_password = wp_hash_password($password);

    // Enregistrer le mot de passe haché dans la base de données
    update_post_meta($post_id, 'mot_de_passe', $hashed_password);
}


// Ajouter des colonnes personnalisées
function custom_guest_columns($columns) {
    $columns['presence'] = 'Présent';
    $columns['invitation_repas'] = 'Pour';
    $columns['nb_personnes'] = 'Nombre de personnes';
    $columns['allergies'] = 'allergies alimentaires';
    return $columns;
}
add_filter('manage_edit-invites_columns', 'custom_guest_columns');

// Remplir les colonnes personnalisées
function custom_guest_column_content($column, $post_id) {
    switch ($column) {
        case 'invitation_repas':
            $repas = get_post_meta($post_id, 'invitation_repas', true);
            if($repas == 'vin') {
                echo 'Vin d\'honneur';
            } elseif($repas == 'vin_repas') {
                echo 'Vin d\'honneur et repas';
            } else {
                echo 'Formule complète';
            }
            break;
        case 'presence':
            $presence = get_post_meta($post_id, 'presence', true);
             if ($presence == 'oui') {
                echo 'Présent';
            } elseif ($presence == 'non') {
                echo 'Absent';
            } else {
                echo 'Non spécifié';
            }
            break;
        case 'nb_personnes':
            echo get_post_meta($post_id, 'nb_personnes', true);
            break;
        case 'allergies':
            echo get_post_meta($post_id, 'allergies', true);
            break;
    }
}
add_action('manage_invites_posts_custom_column', 'custom_guest_column_content', 10, 2);

// Rendre les colonnes triables
function custom_guest_sortable_columns($columns) {
    $columns['invitation_repas'] = 'invitation_repas';
    $columns['presence'] = 'presence';
    $columns['nb_personnes'] = 'nb_personnes';
    $columns['allergies'] = 'allergies';
    return $columns;
}
add_filter('manage_edit-invites_sortable_columns', 'custom_guest_sortable_columns');

// Gérer le tri des colonnes
function custom_guest_orderby($query) {
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

  	if ('invitation_repas' == $orderby) {
        $query->set('meta_key', 'invitation_repas');
        $query->set('orderby', 'meta_value');
    } elseif ('presence' == $orderby) {
        $query->set('meta_key', 'presence');
        $query->set('orderby', 'meta_value');
    } elseif ('nb_personnes' == $orderby) {
        $query->set('meta_key', 'nb_personnes');
        $query->set('orderby', 'meta_value');
    } elseif ('allergies' == $orderby) {
        $query->set('meta_key', 'allergies');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'custom_guest_orderby');


// Ajouter un compteur de présences et d'absences dans l'admin bar
function add_presence_counter_to_admin_bar($wp_admin_bar) {
    if (!is_admin()) {
        return;
    }

    $args_present = array(
        'post_type' => 'invites',
        'meta_query' => array(
            array(
                'key' => 'presence',
                'value' => 'oui',
                'compare' => '='
            )
        )
    );
    $query_present = new WP_Query($args_present);
    $count_present = $query_present->found_posts;

    $args_absent = array(
        'post_type' => 'invites',
        'meta_query' => array(
            array(
                'key' => 'presence',
                'value' => 'non',
                'compare' => '='
            )
        )
    );
    $query_absent = new WP_Query($args_absent);
    $count_absent = $query_absent->found_posts;

    $args_total_presents = array(
        'post_type' => 'invites',
        'meta_query' => array(
            array(
                'key' => 'nb_personnes',
                'value' => 'non',
                'compare' => '='
            )
        )
    );
    $query_total_presents = new WP_Query($args_absent);
    $count_total_presents = $query_absent->found_posts;

// Calculer le nombre total de personnes présentes
$total_personnes_presentes = 0;
if ($query_present->have_posts()) {
    while ($query_present->have_posts()) {
        $query_present->the_post();
        $nb_personnes = get_post_meta(get_the_ID(), 'nb_personnes', true);
        $total_personnes_presentes += intval($nb_personnes);
    }
    wp_reset_postdata();
}

    $wp_admin_bar->add_node(array(
        'id'    => 'presence_counter',
        'title' => sprintf(__('Total de toutes les personnes présentes: %d (Foyers Présents : %d / Foyers Absents: %d)', 'textdomain'), $total_personnes_presentes,$count_present, $count_absent ),
        'href'  => admin_url('edit.php?post_type=invites'),
    ));
}
add_action('admin_bar_menu', 'add_presence_counter_to_admin_bar', 100);