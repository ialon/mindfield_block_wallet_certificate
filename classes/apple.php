<?php

namespace block_wallet_certificate;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');

use PKPass\PKPass;

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
class apple extends base {
    public public function __construct(int $issueid) {
        parent::__construct($issueid, 'apple');
    }

    public function generate_pass() {
        $pass = new PKPass($this->config->certificatepath, $this->config->certificatepassword);

        // Pass content
        $data = [
            'formatVersion' => 1,
            'passTypeIdentifier' => $this->config->passtypeidentifier,
            'teamIdentifier' => $this->config->teamidentifier,
            'barcode' => [
                'format' => 'PKBarcodeFormatQR',
                'messageEncoding' => 'iso-8859-1',
            ]
        ];

        $pass->addFile('pix/thumbnail.png');

        // Add certificate specific data
        require_once(__DIR__ . '/certificates/apple/' . $type . '.php');

        $pass->setData($data);

        // Create and output the pass
        $pass->create(true);
    }
}
