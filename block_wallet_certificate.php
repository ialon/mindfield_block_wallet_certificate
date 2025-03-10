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
        return true;
    }

    function specialization() {
        $this->title = !empty($this->config->title) ? $this->config->title : get_string('blocktitle', 'block_wallet_certificate');
    }

    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG, $OUTPUT, $USER, $COURSE, $DB;

        //note: do NOT include files at the top of this file
        require_once($CFG->libdir . '/filelib.php');

        require_once($CFG->dirroot . '/blocks/wallet_certificate/classes/apple.php');
        require_once($CFG->dirroot . '/blocks/wallet_certificate/classes/google.php');

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $text = '';

        // Check if user has certificate
        $issued = null;
        $courseinfo = new \course_modinfo($COURSE, $USER->id);
        $mods = $courseinfo->get_instances_of('coursecertificate');

        foreach ($mods as $modinfo) {
            if ($modinfo->get_user_visible()) {
                $certificate = $DB->get_record('coursecertificate', ['id' => $modinfo->instance], '*', MUST_EXIST);
                $issued = \mod_coursecertificate\helper::get_user_certificate($USER->id, $COURSE->id, $certificate->template);
            }
        }

        if ($issued) {
            $text .= \html_writer::start_tag('div', array('class' => 'wallet-certificate-links pt-3'));

            // Add to Apple Wallet
            $apple = new apple($issued->id);
            if ($applelink = $apple->get_download_link()) {
                $imgurl = $OUTPUT->image_url('apple_addtowallet', 'block_wallet_certificate');
                $image = \html_writer::img($imgurl, get_string('apple_addtowallet', 'block_wallet_certificate'));
                $text .= \html_writer::link($applelink, $image, array('class' => 'wallet-certificate d-block mb-3'));
            }

            // Add to Google Wallet
            $google = new google($issued->id);
            if ($googlelink = $google->get_download_link()) {
                $imgurl = $OUTPUT->image_url('google_addtowallet', 'block_wallet_certificate');
                $image = \html_writer::img($imgurl, get_string('google_addtowallet', 'block_wallet_certificate'));
                $text .= \html_writer::link($googlelink, $image, array('class' => 'wallet-certificate d-block mb-3'));
            }

            $text .= \html_writer::end_tag('div');
        }

        $this->content->text = $text;

        return $this->content;
    }
}

