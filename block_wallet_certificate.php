<?php

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

class block_wallet_certificate extends block_base {

    function init() {
        $this->title = get_string('blocktitle','block_wallet_certificate');
    }

    function applicable_formats() {
        return array(
            'course-view' => true,
            'site' => true,
            'mod' => false,
            'my' => false,
        );
    }

    /**
     * It can be configured.
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    function specialization() {
        $this->title = !empty($this->config->title) ? $this->config->title : get_string('blocktitle', 'block_wallet_certificate');
    }

    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG, $OUTPUT;

        //note: do NOT include files at the top of this file
        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $text = '';

        $text .= \html_writer::start_tag('div', array('class' => 'wallet-certificate-links pt-3'));

        // Add to Apple Wallet
        $imgurl = $OUTPUT->image_url('apple_addtowallet', 'block_wallet_certificate');
        $image = \html_writer::img($imgurl, get_string('apple_addtowallet', 'block_wallet_certificate'));
        $text .= \html_writer::link('#', $image, array('class' => 'wallet-certificate d-block mb-3'));

        // Add to Google Wallet
        $imgurl = $OUTPUT->image_url('google_addtowallet', 'block_wallet_certificate');
        $image = \html_writer::img($imgurl, get_string('google_addtowallet', 'block_wallet_certificate'));
        $text .= \html_writer::link('#', $image, array('class' => 'wallet-certificate d-block mb-3'));

        $text .= \html_writer::end_tag('div');

        $this->content->text = $text;

        return $this->content;
    }
}

