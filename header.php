<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mariage_ben_et_marie
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="robots" content="noindex">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php 
wp_body_open();
global $activate_history ;
$activate_history = get_field('activer_lencart');

$backgroundCss = 'style="background-image: url(' . get_field('image_de_fond') . ');
	background-size: cover;
	filter: saturate(0.5);
	background-position: center;
	background-repeat: no-repeat;"';
?>
	<div class="menu_fixed_to_sticky absolute">
		<nav id="site-navigation" class="main-navigation px-4">
			<button class="menu-toggle" aria-controls="primary-menu"
				aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'mariage-ben-et-marie' ); ?></button>
			<?php
		// wp_nav_menu(
		// 	array(
		// 		'theme_location' => 'menu-1',
		// 		'menu_id'        => 'primary-menu',
		// 	)
		// );
		?>
			<div class="menu-menu-1-container" >
				<ul id="primary-menu" class="menu nav-menu">
					<?php if ($activate_history) : ?>
						<li id="menu-item-116" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-116">
							<a href="#notre-histoire">Notre Histoire</a>
						</li>
					<?php endif; ?>
					<li id="menu-item-24" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24">
						<a href="#lieux-horaires">Lieux &amp; Horaires</a>
					</li>
				</ul>
			</div>
			<a href="#title"><h3 >B&M 07.06.2025</h3></a>
			<a href="<?php the_permalink(16);?>" class="button btn-confirm-coming px-4 py-2" data-aos="fade-right"
				data-aos-duration="750" data-aos-delay="1500">Confirmez votre venue</a>
		</nav><!-- #site-navigation -->
	</div>
	<header id="title" class="site-header d-flex align-items-center" <?=$backgroundCss;?>>
		<!-- <div class="absolute backgroundCss_filter"></div> -->
		<div class="container_full header-main__container">
			<?php if(get_field('texte_au_centre_de_la_page')): 
			echo '<div class="header-main__text" data-aos="zoom-in" data-aos-delay="1000">';
				the_field('texte_au_centre_de_la_page');
			echo '</div>';
		endif; ?>
		</div>

	</header><!-- #masthead -->