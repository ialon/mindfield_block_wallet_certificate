<?php
/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    // Add heading for Apple Wallet configuration
    $setting = new admin_setting_heading('block_wallet_certificate/applewalletheading',
        get_string('applewalletheading', 'block_wallet_certificate'),
        ''
    );
    $settings->add($setting);

    // Server path to the certificate file (.p12)
    $setting = new admin_setting_configtext('block_wallet_certificate/certificatepath',
        get_string('certificatepath', 'block_wallet_certificate'),
        get_string('certificatepath_desc', 'block_wallet_certificate'),
        '',
        PARAM_TEXT
    );
    $settings->add($setting);

    // Password for the certificate file
    $setting = new admin_setting_configpasswordunmask('block_wallet_certificate/certificatepassword',
        get_string('certificatepassword', 'block_wallet_certificate'),
        get_string('certificatepassword_desc', 'block_wallet_certificate'),
        ''
    );
    $settings->add($setting);

    // Pass Type Identifier from the Developer Portal
    $setting = new admin_setting_configtext('block_wallet_certificate/passtypeidentifier',
        get_string('passtypeidentifier', 'block_wallet_certificate'),
        get_string('passtypeidentifier_desc', 'block_wallet_certificate'),
        '',
        PARAM_TEXT
    );
    $settings->add($setting);

    // Team Identifier from the Developer Portal
    $setting = new admin_setting_configtext('block_wallet_certificate/teamidentifier',
        get_string('teamidentifier', 'block_wallet_certificate'),
        get_string('teamidentifier_desc', 'block_wallet_certificate'),
        '',
        PARAM_TEXT
    );
    $settings->add($setting);

    // Add heading for Google Wallet configuration
    $setting = new admin_setting_heading('block_wallet_certificate/googlewalletheading',
        get_string('googlewalletheading', 'block_wallet_certificate'),
        ''
    );
    $settings->add($setting);

    // Server path to the key file
    $setting = new admin_setting_configtext('block_wallet_certificate/keyfilepath',
        get_string('keyfilepath', 'block_wallet_certificate'),
        get_string('keyfilepath_desc', 'block_wallet_certificate'),
        '',
        PARAM_TEXT
    );
    $settings->add($setting);

    // Issuer ID
    $setting = new admin_setting_configtext('block_wallet_certificate/issuerid',
        get_string('issuerid', 'block_wallet_certificate'),
        get_string('issuerid_desc', 'block_wallet_certificate'),
        '',
        PARAM_TEXT
    );
    $settings->add($setting);
}
