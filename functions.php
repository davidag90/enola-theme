<?php

// style and scripts
add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
function bootscore_child_enqueue_styles() {

  // style.css
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  wp_enqueue_style('owlcarousel-css', get_stylesheet_directory_uri() . '/css/owlcarousel/owl.carousel.min.css');
  wp_enqueue_style('owlcarousel-theme', get_stylesheet_directory_uri() . '/css/owlcarousel/owl.theme.default.min.css');

  // Compiled main.css
  $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/css/main.css'));
  wp_enqueue_style('main', get_stylesheet_directory_uri() . '/css/main.css', array('parent-style'), $modified_bootscoreChildCss);

  // Owl Carousel
  wp_enqueue_script('owl-carousel-js', get_stylesheet_directory_uri() . '/js/owlcarousel/owl.carousel.min.js', false, '', true);

  // custom.js
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js', false, '', true);
}

// WooCommerce
require get_template_directory() . '/woocommerce/woocommerce-functions.php';

function add_login_cart_icons($items, $args) {
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
      $count = WC()->cart->cart_contents_count;
      
      if($count > 0) {
        $cart_badge = strip_tags($count);
      }
    }

    if( $args->theme_location == 'main-menu' ) {
        $items .= '<li class="menu-item d-none d-lg-inline">'
               . '<a class="btn btn-outline-secondary ms-1 ms-md-2" data-bs-toggle="offcanvas" role="button" data-bs-target="#offcanvas-user" aria-controls="offcanvas-user">'
               . '<i class="fa-solid fa-user"></i><span class="visually-hidden-focusable">Account</span>'
               . '</a>'
               . '</li>';

        $items .= '<li class="menu-item d-none d-lg-inline">'
               . '<a class="btn btn-outline-secondary ms-1 ms-md-2 position-relative" data-bs-toggle="offcanvas" role="button" data-bs-target="#offcanvas-cart" aria-controls="offcanvas-cart">'
               . '<i class="fa-solid fa-bag-shopping"></i><span class="visually-hidden-focusable">Cart</span><span class="cart-content">' . $cart_badge . '</span>'
               . '</a>'
               . '</li>';

        $items .= '<li class="menu-item d-lg-none">'
               . '<a class="nav-link" data-bs-toggle="offcanvas" role="button" data-bs-target="#offcanvas-user" aria-controls="offcanvas-user"><i class="fa-solid fa-user me-1"></i>Mi cuenta</a>'
               . '</li>';

        $items .= '<li class="menu-item d-lg-none">'
               . '<a class="nav-link" data-bs-toggle="offcanvas" role="button" data-bs-target="#offcanvas-cart" aria-controls="offcanvas-cart"><i class="fa-solid fa-bag-shopping me-1"></i>Carrito'
               . '<span class="ms-1 cart-content-count badge rounded-pill bg-danger border border-light">' . $cart_badge . '</span>'
               . '</a>'
               . '</li>';
    } 
    
    return $items;
}

add_filter('wp_nav_menu_items', 'add_login_cart_icons', 20, 2 );

/**
 * Aplicar descuento por transferencia bancaria en WooCommerce
 */
function aplicar_descuento_transferencia_bancaria($cart) {
    if (is_admin() && !defined('DOING_AJAX'))
        return;

    // Define el porcentaje de descuento
    $porcentaje_descuento = 15; // Cambia este valor al porcentaje deseado

    // Verifica si se seleccionó la opción de transferencia bancaria
    if (WC()->session->get('chosen_payment_method') === 'bacs') {
        // Calcula el descuento
        $descuento = $cart->subtotal * ($porcentaje_descuento / 100);

        // Aplica el descuento al carrito
        $cart->add_fee(__('15% OFF por transferencia bancaria', 'woocommerce'), -$descuento);
    }
}
add_action('woocommerce_cart_calculate_fees', 'aplicar_descuento_transferencia_bancaria');
