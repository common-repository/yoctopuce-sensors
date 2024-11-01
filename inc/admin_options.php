<?php

/**
 * Display the admin options page
 */
function ysensor_options_page() {
?>
    <div>
    <h2>Yocto-Sensor configuration page</h2>
    <form action="options.php" method="post">
    <?php settings_fields('ysensor_options'); ?>
    <?php do_settings_sections('ysensor_main'); ?>

    <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
    </form></div>
<?php
}

function ysensor_show_section() { 
?>
    <p>These options are important to link your sensors with this server.
    The MD5 signature is used to make sure only your sensors can post
    data to this server. </p>
    <p>Make sure the value here matches the Password
    set in the HTTP callback configuration on the device.</p>
<?php
}

function ysensor_show_signature() { 
    $options = get_option('ysensor_options');
    echo "<input id='ysensor_signature' name='ysensor_options[signature]' size='40' type='text' value='{$options['signature']}' />";
}

/**
 * Performs sanity checks on user input options
 */
function ysensor_options_register() {
    register_setting( 'ysensor_options', 'ysensor_options', 'ysensor_options_validate' );
    add_settings_section('ysensor_main', 'Connection settings', 'ysensor_show_section', 'ysensor_main' );
    add_settings_field('ysensor_signature', 'MD5 signature password', 'ysensor_show_signature', 
                       'ysensor_main', 'ysensor_main' );    
}

/**
 * Performs sanity checks on user input options
 */
function ysensor_options_validate($input) {
    $newinput['signature'] = trim($input['signature']);
    return $newinput;
}
    
