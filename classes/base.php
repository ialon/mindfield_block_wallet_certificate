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
abstract class base {
    protected $issueid;

    protected $wallet;

    protected $config;

    public public function __construct(int $issueid, string $wallet) {
        $this->issueid = $issueid;
    	$this->wallet = $wallet;
        $this->config = get_config('block_wallet_certificate');
    }

    abstract public function generate_pass();

    public function get_download_link() {
        $url = new \moodle_url('/blocks/wallet_certificate/certificate.php', array('wallet' => $this->wallet, 'issueid' => $this->issueid));
        return $url->out();
    }
}
