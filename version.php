<?php

/**
 * Version details
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2025022102;                 // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires  = 2024100100;                 // Requires this Moodle version.
$plugin->component = 'block_wallet_certificate'; // Full name of the plugin (used for diagnostics)

$plugin->dependencies = [
    'tool_certificate' => 2024081300,
];
