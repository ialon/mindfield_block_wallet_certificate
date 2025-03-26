<?php

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

namespace block_wallet_certificate;

require_once(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');

$wallet = required_param('wallet', PARAM_TEXT);
$issueid = required_param('issueid', PARAM_INT);

$classname = '\\block_wallet_certificate\\' . $wallet;
if (class_exists($classname)) {
    $wallet = new $classname($issueid);
    $wallet->generate_pass();
} else {
    throw new \moodle_exception('invalidwallet', 'block_wallet_certificate', '', $wallet);
}
