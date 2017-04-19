<?php 
/*
 * Uses the 'admin_menu' hook to load 'ap_update_menu'.
 */
add_action( 'admin_menu', 'ap_update_menu' );


/*
 * Creates a sub-menu under Appearance.
 */
function ap_update_menu() {
    add_theme_page( 'Theme options', 'Theme options', 'manage_options', 'ap-theme-options', 'ap_theme_options' );
}


/*
 * Uses the 'admin_init' hook to load 'ap_init_settings'.
 */
add_action( 'admin_init', 'ap_init_settings' );



/*
 * Registers and adds settings, sections and fields.
 */
function ap_init_settings() {
    // Register a general setting.
    // The $option_group is the same as $option_name to prevent the "Error: options page not found." problem.
    register_setting( "ap_options", "ap_options", "ap_options_validate" );

    // Add sections.
    add_settings_section( "general-section", "General settings", "general_section_callback", "ap-theme-options" );

    // Add settings fields.
    add_settings_field( "ap-test-field-1", "Test field 1", "test_field_1_callback", "ap-theme-options", "general-section" );
}


/*
 * Callback function for add_settings_field.
 * Displays the HTML for the field.
 */
function test_field_1_callback() {
    $options = get_option( 'ap_options' ); ?>
	<input type='text' name='ap_options[ap-test-field-1]' value='<?php echo $options['ap-test-field-1']; ?>'>
<?php }


/*
 * Callback function for add_settings_section.
 * Displays the section HTML.
 */
function general_section_callback() {
    echo "This is a section description.";
}


/*
 * Callback function for add_theme_page.
 * Displays the theme options page.
 */
function ap_theme_options() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have sufficient permissions to access this page.' );
    } ?>

    <div class="wrap">
        <h1>Theme options</h1>

        <form action="options.php" method="post">
            <?php
                settings_fields( "ap_options" );
                do_settings_sections( "ap-theme-options" );
                submit_button();
            ?>
        </form>
    </div>
<?php }


/*
 * Sanitizes the settings.
 */
function ap_options_validate( $input ) {
    $validated['ap-test-field-1'] = sanitize_text_field( $input['ap-test-field-1'] );

    return $validated;
}