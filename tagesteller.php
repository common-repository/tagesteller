<?php
/*
Plugin Name: Tagesteller / Mittagsmenü Plugin
Plugin URI: http://wordpress.org/plugins/tagesteller
Description: Plugin, zur Anzeige von Mittagsmenü / Tagesteller Angeboten auf Gastronomie Websites
Version: v.1.1
Author: Helmuth Lammer
Author URI: http://helmuth-lammer.at
License: GPL, http://helmuth-lammer.at/tagesetller_licens.txt
*/

//error_reporting(E_ALL);
include( "settings.php" );

add_action( 'admin_menu', 'tt_init' );
register_activation_hook( __FILE__, 'tt_dbtable_install' );
add_shortcode( 'tagesteller', 'tt_frontend' );

function tt_init(){
    
    //php add_plugins_page( $page_title, $menu_title, $capability, $menu_slug, $function); 
    add_action( 'wp_enqueue_scripts', 'tt_add_scripts' );
    add_menu_page( 'Tagesteller', 'Tagesteller', 'manage_options', 'tt-pi', 'tt_backend', plugins_url( 'icon_big.png', __FILE__ ) );
    add_submenu_page( 'tt-pi', 'Einstellungen', 'Einstellungen', 'manage_options', 'tt-pi-options', 'tt_options' );
    wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
    tt_add_scripts();
}

function tt_admin_tabs( $wdate, $current = 'monday' ) {
    $tabs = array(
        'monday'    => 'Montag',
        'thuesday'  => 'Dienstag',
        'wensday'   => 'Mittwoch',
        'thursday'  => 'Donnerstag',
        'friday'    => 'Freitag',
        'saturday'  => 'Samstag',
        'sunday'    => 'Sonntag'
        );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';

    $d = 1;
    
    $options = get_tt_options();
    if( $current == "" ){
        $current = "monday";
    }
    
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        $date = date("d.m.", date("U", strtotime($wdate))-((date("N",strtotime($wdate))-$d)*86400)); $d++;
        
        if( $options[$tab] == 0 ){
            continue; //das datum weiterrechnen aber nicht ausgeben
        }
        echo "<a class='nav-tab$class' href='?page=tt-pi&tab=$tab&date=". date( 'Y-m-d', strtotime( $wdate ) )."'>$name (" .$date. ")</a>";

    }
    echo '</h2>';
}

function tt_dbtable_install(){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
    $table_name = $wpdb->prefix . "tt_types";
    
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(128) NOT NULL,
      created_at timestamp DEFAULT NOW() NOT NULL,
      UNIQUE KEY id (id)
    );";
    dbDelta( $sql );
    
    $sql = "INSERT INTO $table_name (id, name) VALUES
    (1, 'Suppe'),
    (2, 'Vorspeise'),
    (3, 'Hauptspeise1'),
    (4, 'Hauptspeise2'),
    (5, 'Hauptspeise3'),
    (6, 'Vegetarisch'),
    (7, 'Nachspeise')";
    dbDelta( $sql );
    
    $table_name = $wpdb->prefix . "tt_dishes";
    
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      id_types int(11) NOT NULL,
      name VARCHAR(128) NOT NULL,
      price FLOAT,
      created_at timestamp DEFAULT NOW() NOT NULL,
      UNIQUE KEY id (id)
    );";
    dbDelta( $sql );
    
    $table_name = $wpdb->prefix . "tt_datehasmenu";
    
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      id_dishes int(11) NOT NULL,
      daydate DATE NOT NULL,
      holiday TINYINT(1) DEFAULT 0,
      created_at timestamp DEFAULT NOW() NOT NULL,
      UNIQUE KEY id (id)
    );";
    
    dbDelta( $sql );
    
    $table_name = $wpdb->prefix . "tt_config";
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(128) NOT NULL,
      value VARCHAR(128) NOT NULL,
      created_at timestamp DEFAULT NOW() NOT NULL,
      UNIQUE KEY id (id)
    );";
    dbDelta( $sql );
    
    $sql = "INSERT INTO ".$wpdb->prefix ."tt_config (id, name, value) VALUES
            (1, 'monday', '1'),
            (2, 'thuesday', '1'),
            (3, 'wensday', '1'),
            (4, 'thursday', '1'),
            (5, 'friday', '1'),
            (6, 'saturday', 0),
            (7, 'sunday', 0),
            (8, 'soup', '1'),
            (9, 'starter', '1'),
            (10, 'maindish1', '1'),
            (11, 'maindish2', '1'),
            (12, 'maindish3', '0'),
            (13, 'veggy', '1'),
            (14, 'dessert', '1'),
            (15, 'permission', '0'); ";

    dbDelta( $sql );    
    
}

function tt_add_scripts() {

    wp_enqueue_script('jquery');
}

//[tagesteller]
function tt_frontend( $attributes  ){

    global $wpdb;
    
    $tabs = array( //todo: create function for that
        ''          =>1,
        'monday'    => 1,
        'thuesday'  => 2,
        'wensday'   => 3,
        'thursday'  => 4,
        'friday'    => 5,
        'saturday'  => 6,
        'sunday'    => 7
        );

    $wdate = date( "Y-m-d" );
    $options = get_tt_options();
    
    $d = 1;  
    $weekmenu = array();
    foreach( $tabs as $tab => $name ){
        if( $d == 8 || ( ! empty( $options[$tab] ) && $options[$tab] == 0 ) ){
            continue;
        }
        $date = date( "U", date( "U", strtotime( $wdate ) ) - ( ( date( "N", strtotime( $wdate ) ) - $d ) * 86400 ) ); 
        $d++;
        $day_date = date( 'Y-m-d', $date );
        $dishes = $wpdb->get_results( "SELECT * FROM (SELECT d.id_types, d.name, d.price, d.id FROM ".$wpdb->prefix."tt_dishes d JOIN ".$wpdb->prefix ."tt_datehasmenu dm ON dm.id_dishes = d.id WHERE dm.daydate =  '{$day_date}' ORDER BY d.id_types, d.id desc) AS x  GROUP BY x.id_types ", 'ARRAY_A' );
        $weekmenu[$date] = $dishes;
    }
    
    $week_interval = date( "D. d.m.", date( "U", strtotime( $wdate ) ) - ( ( date( "N", strtotime( $wdate ) ) - 1 ) * 86400 ) )." bis ". date( "D. d.m.", date( "U", strtotime( $wdate ) ) + ( ( 7 - date( "N", strtotime( $wdate ) ) ) * 86400 ) );

    include ( "frontend.php" );
}

function get_tt_options(){
    global $wpdb;
    $options_data = $wpdb->get_results( "SELECT name, value FROM ".$wpdb->prefix."tt_config ", 'ARRAY_A' );
    $options = array();
    foreach( $options_data as $item ){
        $options[$item['name']] = $item['value'];
    }
    return $options;
}

function set_tt_options( $options ){
    global $wpdb;
    print_r($options, true);
    foreach( $options as $name => $value ){
        
        $wpdb->update( $wpdb->prefix .'tt_config', array( 'value' => $value ), array( 'name' => $name ), array( '%s' ), array( '%s' ) );
        
    }
    
    return get_tt_options();
}

function tt_options(){
    
    
    $options = get_tt_options();
    
    if( ! empty( $_REQUEST['action'] ) && $_REQUEST['action'] == 'tt-options-form'){
        
        $days = $_REQUEST['dish-day'];
        $dishes = $_REQUEST['fieldgroups'];
        if( !empty( $_REQUEST['permission'] ) ){
            $permission = array( '1' => 'permission' );
        } else {
            $permission = array();
        }
        
        $current_options = $permission;
        if( ! empty( $days ) ){
            $current_options = array_merge( $days, $current_options );
        }
        
        if( ! empty( $dishes ) ){
            $current_options = array_merge( $dishes, $current_options );
        }
        
        $current_options = array_flip( $current_options );
        
        foreach( $options as $name => &$value ){
            if( ! empty( $current_options[$name] ) || $current_options[$name] === 0) {
                $value = 1;
            } else {
                $value = 0;
            }
            
        }
            
        set_tt_options( $options );
    }
    
    $options = get_tt_options();
    

    include( "config.php" );
}

function tt_throw_error( $message ){
    tt_add_scripts();
    ob_start();
    $message = $message;
    include( "error.php" );
    $output_string = ob_get_contents();
    ob_end_clean();
   
    return $output_string;
}

function tt_backend(){

    global $wpdb;
    
    if( ! empty( $_GET['reg'] ) ){
        
        $token = $_GET['reg'];
        error_log( "reg : ". $token );
        $wpdb->insert( $wpdb->prefix . 'tt_config', array( 'name' => 'token', 'value' => $token), array( '%s', '%s' ) );
    } 
    $tabs = array( 
        ''          =>1,
        'monday'    => 1,
        'thuesday'  => 2,
        'wensday'   => 3,
        'thursday'  => 4,
        'friday'    => 5,
        'saturday'  => 6,
        'sunday'    => 7
    );
    
    if( ! empty( $_REQUEST['date'] ) ){
        $wdate = $_REQUEST['date'];
    } else {
        $wdate = date( "Y-m-d" );
    }
    //print($wdate);
    
    if( ! empty($_REQUEST['tab'] ) ){
        $tab_index = $_REQUEST['tab'];   
    } else {
        $tab_index = '';
    }
    $day_date = date( "Y-m-d", date( "U", strtotime( $wdate ) ) - ( ( date( "N", strtotime( $wdate ) ) - $tabs[$tab_index] ) * 86400 ) );
    //print($day_date);
    
    if( ! empty( $_POST['action'] ) && $_POST['action'] == 'tt-options-dishes' ){
    
        $meals = array( 'soup','starter','maindish1','maindish2','maindish3','veggy', 'desert' );//todo get from DB-config table

        //todo: update if already exists, check holiday
        for( $i = 0; $i < count( $meals ); $i++){
            if( empty( $_POST[$meals[$i]] ) ){
                 $data = array(
                    'name'      => "",
                    'price'     => 0,
                    'id_types'  => $i+1
                );
            } else {
                $data = array(
                    'name'      => $_POST[$meals[$i]],
                    'price'     => str_replace( ",", ".", $_POST[$meals[$i]."-price"] ), //todo: clear wrong entries: characters, comma, etc.
                    'id_types'  => $i+1
                );
            }

            $wpdb->insert( $wpdb->prefix.'tt_dishes', $data, array( '%s','%s','%d' ) );
            $id_dishes = $wpdb->insert_id;
            unset( $data );
            
            $data = array(
                'daydate'   => $day_date,
                'id_dishes' => $id_dishes
            );
            $wpdb->insert( $wpdb->prefix.'tt_datehasmenu', $data, array( '%s', '%d' ) );
            unset( $data );
        }
        
        wp_redirect( menu_page_url( "tt-pi&tab=".$_POST['tab'] ) );
    }
    
    //load menu
    $dishes = $wpdb->get_results( "SELECT * FROM (SELECT d.id_types, d.name, d.price, d.id FROM ".$wpdb->prefix."tt_dishes d JOIN ".$wpdb->prefix."tt_datehasmenu dm ON dm.id_dishes = d.id WHERE dm.daydate =  '{$day_date}' ORDER BY d.id_types, d.id desc) AS x  GROUP BY x.id_types ", 'ARRAY_A' );
    $week_interval = date( "D. d.m.", date( "U", strtotime( $wdate ) ) - ( ( date( "N", strtotime( $wdate ) ) - 1 ) * 86400 ) )." bis ". date( "D. d.m.", date( "U", strtotime( $wdate ) ) + ( ( 7 - date( "N", strtotime( $wdate ) ) ) * 86400 ) );

    $options = get_tt_options();

    include ( "backend.php" );
}


function tt_admin_notice() {    
    $options = get_tt_options();
    if( $options['permission'] == 0 ){
        include ( "admin_notice.php" );
    }
}
add_action( 'admin_notices', 'tt_admin_notice' );

?>
