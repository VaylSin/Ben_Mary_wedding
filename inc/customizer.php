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


/**
 * Add customizer options
 */
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Réglages Globaux',
        'menu_title'	=> 'Réglages Globaux',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

}

function cf7_create_post_invite_on_submit($contact_form) {
	// Get the contact form object
	$submission = WPCF7_Submission::get_instance();
	if ($submission) {
		$data = $submission->get_posted_data();
		// var_dump($data);
		// die();
		$post_id = wp_insert_post(array(
			'post_title' => sanitize_text_field($data['nom'] . ' ' . $data['prenom']),
			'post_type' => 'invites',
			'post_status' => 'publish'

		));
		if ($post_id) {
			 error_log("Post ID créé : " . $post_id);
			 // Débogage : Obtenez tous les champs ACF associés au post
            $fields = get_fields(146);
            if ($fields === false) {
                error_log("Aucun champ ACF trouvé pour le post ID : " . $post_id);
            } else {
                error_log(print_r($fields, true)); // Affiche les champs dans le log pour vérification
            }
            // Parcourez les données du formulaire et mettez à jour les champs ACF
            foreach ($data as $key => $value) {
				// Vérifiez si le champ ACF existe avant de le mettre à jour
                $field = get_field_object($key, $post_id);
                // Vérifiez si le champ ACF existe avant de le mettre à jour
                if ($field) {

                    update_field($key, $value, $post_id);
                } else {
                    error_log(print_r("Champ ACF non trouvé : " . $key)).'<br>'; // Log si le champ n'est pas trouvé
                }
            }


			// Générer un mot de passe aléatoire
			$password = wp_generate_password(16, false);

			// Crypter le mot de passe en MD5
			$password_hashed = md5($password);

			// Mettre à jour le champ ACF pour le mot de passe
			update_field('mot_de_passe', $password_hashed, $post_id);

			// Optionnel : Envoyer le mot de passe en clair à l'utilisateur par email
            // $to = $data['your-email'];
            // $subject = 'Votre mot de passe';
            // $message = 'Votre mot de passe pour accéder à l\'espace de connexion est : ' . $password;
            // wp_mail($to, $subject, $message);
        }
	}
}
// add_action('wpcf7_before_send_mail', 'cf7_create_post_invite_on_submit');

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
    $columns['adresse_email'] = 'Email';
    $columns['presence'] = 'Présent';
    $columns['nb_personnes'] = 'Nombre de personnes';
    return $columns;
}
add_filter('manage_edit-invites_columns', 'custom_guest_columns');

// Remplir les colonnes personnalisées
function custom_guest_column_content($column, $post_id) {
    switch ($column) {
        case 'guest_name':
            echo get_post_meta($post_id, 'adresse_email', true);
            break;
        case 'guest_email':
            echo get_post_meta($post_id, 'presence', true);
            break;
        case 'guest_rsvp':
            echo get_post_meta($post_id, 'nb_personnes', true);
            break;
    }
}
add_action('manage_invites_posts_custom_column', 'custom_guest_column_content', 10, 2);

// Rendre les colonnes triables
function custom_guest_sortable_columns($columns) {
    $columns['adresse_email'] = 'adresse_email';
    $columns['presence'] = 'presence';
    $columns['nb_personnes'] = 'nb_personnes';
    return $columns;
}
add_filter('manage_edit-invites_sortable_columns', 'custom_guest_sortable_columns');

// Gérer le tri des colonnes
function custom_guest_orderby($query) {
    if (!is_admin()) {
        return;
    }

    $orderby = $query->get('orderby');

  	if ('guest_email' == $orderby) {
        $query->set('meta_key', 'adresse_email');
        $query->set('orderby', 'meta_value');
    } elseif ('guest_rsvp' == $orderby) {
        $query->set('meta_key', 'presence');
        $query->set('orderby', 'meta_value');
    } elseif ('guest_rsvp' == $orderby) {
        $query->set('meta_key', 'nb_personnes');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'custom_guest_orderby');