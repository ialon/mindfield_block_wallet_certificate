<?php

namespace block_wallet_certificate;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
class google extends base {
    public public function __construct(int $issueid) {
        parent::__construct($issueid, 'google');
    }

    public function generate_pass() {
        // Your Issuer account ID
        $issuerId = $this->config->issuerid;

        // Create a class instance
        // $generic = new \DemoGeneric($this->config->keyfilepath);

        // // Create a pass class
        // $generic->createClass($issuerId, 'class_suffix');

        // // Update a pass class
        // $generic->updateClass($issuerId, 'class_suffix');

        // // Patch a pass class
        // $generic->patchClass($issuerId, 'class_suffix');

        // // Add a message to a pass class
        // // $generic->addClassMessage($issuerId, 'class_suffix', 'header', 'body');

        // // Create a pass object
        // $generic->createObject($issuerId, 'class_suffix', 'object_suffix');

        // // Update a pass object
        // $generic->updateObject($issuerId, 'object_suffix');

        // // Patch a pass object
        // $generic->patchObject($issuerId, 'object_suffix');

        // // Add a message to a pass object
        // // $generic->addObjectMessage($issuerId, 'object_suffix', 'header', 'body');

        // // Expire a pass object
        // $generic->expireObject($issuerId, 'object_suffix');

        // // Generate an Add to Google Wallet link that creates a new pass class and object
        // $generic->createJWTNewObjects($issuerId, 'class_suffix', 'object_suffix');

    }
}
