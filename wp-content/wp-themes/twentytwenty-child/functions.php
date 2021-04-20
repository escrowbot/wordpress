<?php
// parent heritage
add_action( 'wp_enqueue_scripts', function() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
} );

flush_rewrite_rules();

// add escrowbot_id rewrite
add_rewrite_rule('^((f|w)?[0-9]{5,30})\/?$','index.php?pagename=profile&escrowbot_id=$matches[1]', 'top');

// add escrowbot_id param to read in page escrowbot_id
add_filter( 'query_vars', function ( $vars ) {
    array_push( $vars, 'escrowbot_id' );
    return $vars;
}, 1 );


function get_user($escrowbot_id) {
    $table = substr($escrowbot_id,0,1) === 'w' ? 'bot_wsp_usuarios' : 'bot_usuarios';
    $idcolumn = substr($escrowbot_id,0,1) === 'w' ? 'wspid' : 'fbid';
    if(substr($escrowbot_id,0,1) === 'w' || substr($escrowbot_id,0,1) === 'f')
        $escrowbot_id = substr($escrowbot_id,1);
    $results = $GLOBALS['wpdb']->get_results( "SELECT * FROM db_escrowbot.$table WHERE $idcolumn = '$escrowbot_id'", OBJECT );
    if( count($results) > 0 )
        return $results[0];
    else
        throw new Exception('Usuario inexistente.');
}

function get_confidentes($escrowbot_id) {
    $table = substr($escrowbot_id,0,1) === 'w' ? 'bot_wsp_confidencias' : 'bot_confidencias';
    $escrowbot_id = substr($escrowbot_id,1);
    return $GLOBALS['wpdb']->get_results( "SELECT * FROM db_escrowbot.$table WHERE usuario_confiado = '$escrowbot_id'" , OBJECT );
}
 
function get_confiantes($escrowbot_id) {
    $table = substr($escrowbot_id,0,1) === 'w' ? 'bot_wsp_confidencias' : 'bot_confidencias';
    $escrowbot_id = substr($escrowbot_id,1);
    return $GLOBALS['wpdb']->get_results( "SELECT * FROM db_escrowbot.$table WHERE usuario_confidente = '$escrowbot_id'" , OBJECT );
}

function give_404() {
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    get_template_part( 404 ); exit();
}

function ago_function($date) {
    return sprintf( esc_html__( '%s', 'textdomain' ), human_time_diff(strtotime($date), current_time( 'timestamp' ) ) );
}