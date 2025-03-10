<?php

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

require_once(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/classes/apple.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/classes/google.php');

$wallet = required_param('wallet', PARAM_TEXT);
$issueid = required_param('issueid', PARAM_INT);

if (class_exists($wallet)) {
    $wallet = new $wallet($issueid);
    $wallet->generate_pass();
}
