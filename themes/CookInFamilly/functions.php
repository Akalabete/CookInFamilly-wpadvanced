<?php
  function cookinfamily_add_admin_pages() {
    add_menu_page(__('Paramètres du thème CookInFamily', 'cookinfamily'), __('CookInFamily', 'cookinfamily'), 'manage_options', 'cookinfamily-settings', 'cookinfamily_theme_settings', 'dashicons-admin-settings', 60); 
  }

  function cookinfamily_theme_settings() {
    echo '<h1>'.esc_html( get_admin_page_title() ).'</h1>';
    echo '<form action="options.php" method="post" name="cookinfamily_settings">';
    echo '<div>';

    settings_fields('cookinfamily_settings_fields');
    do_settings_sections('cookinfamily_settings_section');
    submit_button();

    echo '</div>';
    echo '</form>';
  }

  function cookinfamily_settings_register() {
    register_setting('cookinfamily_settings_fields', 'cookinfamily_settings_fields', 'cookinfamily_settings_fields_validate');
    add_settings_section('cookinfamily_settings_section', __('Paramètres', 'cookinfamily'), 'cookinfamily_settings_section_introduction', 'cookinfamily_settings_section');
    add_settings_field('cookinfamily_settings_field_introduction', __('Introduction', 'cookinfamily'), 'cookinfamily_settings_field_introduction_output', 'cookinfamily_settings_section', 'cookinfamily_settings_section');
    add_settings_field('cookinfamily_settings_field_phone_number', __('Numéro de téléphone', 'cookinfamily'), 'cookinfamily_settings_field_phone_number_output', 'cookinfamily_settings_section', 'cookinfamily_settings_section');
    add_settings_field('cookinfamily_settings_field_email', __('Email', 'cookinfamily'), 'cookinfamily_settings_field_email_output', 'cookinfamily_settings_section', 'cookinfamily_settings_section');
  }

  function cookinfamily_settings_section_introduction() {
    echo __('Paramètrez les différentes options de votre thème CookInFamily.', 'cookinfamily');
  }

  function cookinfamily_settings_fields_validate($inputs) {  
    if(isset($_POST) && !empty($_POST)):
      if(isset($_POST['cookinfamily_settings_field_introduction']) && !empty($_POST['cookinfamily_settings_field_introduction'])):
        update_option('cookinfamily_settings_field_introduction', $_POST['cookinfamily_settings_field_introduction']);
      endif;
      if(isset($_POST['cookinfamily_settings_field_phone_number']) && !empty($_POST['cookinfamily_settings_field_phone_number'])):
        update_option('cookinfamily_settings_field_phone_number', $_POST['cookinfamily_settings_field_phone_number']);
      endif;
      if(isset($_POST['cookinfamily_settings_field_email']) && !empty($_POST['cookinfamily_settings_field_email'])):
        update_option('cookinfamily_settings_field_email', $_POST['cookinfamily_settings_field_email']);
      endif;
    endif;

    return $inputs;
  }

  function cookinfamily_settings_field_introduction_output() {
    $value = get_option('cookinfamily_settings_field_introduction');

    echo '<input name="cookinfamily_settings_field_introduction" type="text" value="'.$value.'" />';
  }

  function cookinfamily_settings_field_phone_number_output() {
    $value = get_option('cookinfamily_settings_field_phone_number');

    echo '<input name="cookinfamily_settings_field_phone_number" type="text" value="'.$value.'" />';
  }

  function cookinfamily_settings_field_email_output() {
    $value = get_option('cookinfamily_settings_field_email');

    echo '<input name="cookinfamily_settings_field_email" type="text" value="'.$value.'" />';
  }

  function cookinfamily_register_custom_post_types() {
    $labels_ingredient = array(
      'menu_name'             => __('Ingrédients', 'cookinfamily'),
      'name_admin_bar'        => __('Ingrédient', 'cookinfamily'),
      'add_new_item'          => __('Ajouter un nouvel ingrédient', 'cookinfamily'),
      'new_item'              => __('Nouvel ingrédient', 'cookinfamily'),
      'edit_item'             => __('Modifier l\'ingrédient', 'cookinfamily'),
    );

    $args_ingredient = array(
      'label'                 => __('Ingrédients', 'cookinfamily'),
      'description'           => __('Ingrédients', 'cookinfamily'),
      'labels'                => $labels_ingredient,
      'supports'              => array('title', 'thumbnail', 'excerpt', 'editor'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 40,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'post',
      'menu_icon'   					=> 'dashicons-drumstick',
    );

    register_post_type('cif_ingredient', $args_ingredient);
  }

  function cookinfamily_register_taxonomies() {
    $labels = array(
      'name'              => __( 'Types de plat' ),
      'singular_name'     => __( 'Type de plat' ),
      'search_items'      => __( 'Rechercher un type de plat' ),
      'all_items'         => __( 'Tous les types de plat' ),
      'parent_item'       => __( 'Parent Type de plat' ),
      'parent_item_colon' => __( 'Parent Type de plat:' ),
      'edit_item'         => __( 'Modifier un type de plat' ), 
      'update_item'       => __( 'Mettre à jour un type de plat' ),
      'add_new_item'      => __( 'Ajouter un nouveau type de plat' ),
      'new_item_name'     => __( 'Nouveau type de plat' ),
      'menu_name'         => __( 'Type de plat' )
    );

    $args = array(
      'hierarchical'      => true, 
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'show_in_rest'      => true,
      'rewrite'           => array( 'slug' => 'type-de-plat' )
    );

    register_taxonomy('type_de_plat', array('recettes'), $args);
    
    $labels = array(
      'name'              => __( 'Régimes alimentaire' ),
      'singular_name'     => __( 'Régime alimentaire' ),
      'search_items'      => __( 'Rechercher un régime alimentaire' ),
      'all_items'         => __( 'Tous les régimes alimentaire' ),
      'parent_item'       => __( 'Parent régime alimentaire' ),
      'parent_item_colon' => __( 'Parent régime alimentaire:' ),
      'edit_item'         => __( 'Modifier un régime alimentaire' ), 
      'update_item'       => __( 'Mettre à jour un régime alimentaire' ),
      'add_new_item'      => __( 'Ajouter un nouveau régime alimentaire' ),
      'new_item_name'     => __( 'Nouveau régime alimentaire' ),
      'menu_name'         => __( 'Régime alimentaire' )
    );

    $args = array(
      'hierarchical'      => true, 
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'show_in_rest'      => true,
      'rewrite'           => array( 'slug' => 'regime-alimentaire' )
    );

	  register_taxonomy('regime_alimentaire', array('recettes'), $args);
  }

  function cookinfamily_request_recettes() {
    $args = array(
      'post_type' => 'recettes',
      'posts_per_page' => 2
    );

    $query = new WP_Query($args);

    if($query->have_posts()):
      $response = $query;
    else:
      $response = false;
    endif;

    wp_send_json($response);
    wp_die();
  }

  function cookinfamily_scripts() {
    wp_enqueue_script('cookinfamily', get_template_directory_uri() . '/assets/js/cookinfamily.js', array('jquery'), '1.0.0', true);
    wp_localize_script('cookinfamily', 'cookinfamily_js', array('ajax_url' => admin_url('admin-ajax.php')));
  }

  /***** Actions *****/
  add_action('admin_menu', 'cookinfamily_add_admin_pages', 10);
  add_action('admin_init', 'cookinfamily_settings_register');
  add_action('init', 'cookinfamily_register_custom_post_types', 11);
  add_action('init', 'cookinfamily_register_taxonomies');
  add_action('wp_ajax_request_recettes', 'cookinfamily_request_recettes');
  add_action('wp_ajax_nopriv_request_recettes', 'cookinfamily_request_recettes');
  add_action('wp_enqueue_scripts', 'cookinfamily_scripts');
?>