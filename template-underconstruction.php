<?php
/*
Template Name: Under Contruction
*/?>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<title><?php wp_title('|', true, 'right'); ?></title>
</head>	

<body <?php body_class(); ?>>
<center>
<?php get_template_part( 'includes/loop', 'page' ); ?>
</center>
</body>
</html>