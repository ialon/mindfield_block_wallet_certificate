<?php

namespace block_wallet_certificate;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/completion/completion_completion.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
abstract class base {
    protected $issue;

    protected $template;

    protected $wallet;

    protected $config;

    public function __construct(int $issueid, string $wallet) {
        global $DB;

    	$this->wallet = $wallet;
        $this->config = get_config('block_wallet_certificate');
        $this->issue = $DB->get_record('tool_certificate_issues', array('id' => $issueid), '*', MUST_EXIST);
    }

    abstract public function generate_pass();
    abstract public function get_mapped_data(&$data, &$pass = null);

    public function get_issuer_data() {
        global $SITE;

        $issuer = [
            'name' => $SITE->fullname,
        ];

        return $issuer;
    }

    public function get_user_data() {
        global $USER, $PAGE;

        $userpicture = new \core\output\user_picture($USER);
        $userpicture->size = 101;
        $user = [
            'firstname' => $USER->firstname,
            'lastname' => $USER->lastname,
            'address' => $USER->address,
            'photourl' => $userpicture->get_url($PAGE)->out(false)
        ];

        return $user;
    }

    public function get_course_data() {
        global $USER;

        $course = get_course($this->issue->courseid);

        // Load custom fields
        $handler = \core_course\customfield\course_handler::create();
        $datacontroller = $handler->get_instance_data($course->id, true);
        $customfields = [];
        foreach ($datacontroller as $data) {
            $customfields[$data->get_field()->get('shortname')] = $data->get_value();
        }

        // Load completion data
        $cparams = array(
            'userid' => $USER->id,
            'course' => $course->id,
        );
        $completion = new \completion_completion($cparams);
        $completiondate = $completion->timecompleted ? userdate($completion->timecompleted, get_string('strftimedate', 'langconfig')) : null;

        // Prepare course data
        $coursedata = [
            'fullname' => $course->fullname,
            'shortname' => $course->shortname,
            'summary' => $course->summary,
            'completedon' => $completiondate,
            // Custom fields
            'operatoraddresslabel' => $customfields['operatoraddresslabel'] ?? '',
            'displaycompletedon' => $customfields['displaycompletedon'] ?? false,
            'completedonlabel' => $customfields['completedonlabel'] ?? '',
            'issuedonlabel' => $customfields['issuedonlabel'] ?? '',
            'expiresonlabel' => $customfields['expiresonlabel'] ?? '',
            'certificatetype' => $customfields['certificatetype'] ?? '',
            'displaycranetype' => $customfields['displaycranetype'] ?? false,
            'cranetypelabel' => $customfields['cranetypelabel'] ?? '',
            'cranetype' => $customfields['cranetype'] ?? '',
            'programname' => $customfields['programname'] ?? '',
            'backtextlabel' => $customfields['backtextlabel'] ?? '',
            'backtext' => strip_tags($customfields['backtext']) ?? '',
            'logourl' => $customfields['logourl'] ?? '',
            'backgroundcolor' => $customfields['backgroundcolor'] ?? '#0D860B',
            'textcolor' => $customfields['foregroundcolor'] ?? '#FFFFFF',
            'cohortidnumber' => $customfields['cohortidnumber'] ?? false,
            'displaycompanyname' => $customfields['displaycompanyname'] ?? false,
            'companynamelabel' => $customfields['companynamelabel'] ?? '',
            'displaycompanyaddress' => $customfields['displaycompanyaddress'] ?? false,
            'companyaddresslabel' => $customfields['companyaddresslabel'] ?? '',
        ];

        return $coursedata;
    }

    public function get_certificate_data() {
        $verifyurl = new \moodle_url(
            "/admin/tool/certificate/index.php", 
            ['code' => $this->issue->code]
        );

        $certificate = [
            'verifyurl' => $verifyurl->out(false),
            'code' => $this->issue->code,
            'issued' => userdate($this->issue->timecreated, get_string('strftimedate', 'langconfig')),
            'expiry' => userdate($this->issue->expires, get_string('strftimedate', 'langconfig')),
        ];

        return $certificate;
    }

    public function get_cohort_data($cohortidnumber = 0) {
        global $USER;

        $cohort = [];

        $cohorts = cohort_get_user_cohorts($USER->id, true);

        if ($cohorts) {
            foreach ($cohorts as $c) {
                if ($c->idnumber != $cohortidnumber) {
                    continue;
                }

                $address = [];
                
                /** @var \core_customfield\data_controller $cf */
                foreach ($c->customfields as $cf) {
                    switch ($cf->get_field()->get('shortname')) {
                        case 'co_addr1':
                            $address[0] = $cf->export_value() ? $cf->export_value() . ',' : '';
                            break;
                        case 'co_addr2':
                            $address[1] = $cf->export_value() ? $cf->export_value() . ',' : '';
                            break;
                        case 'co_city':
                            $address[2] = $cf->export_value() ? $cf->export_value() . ',' : '';
                            break;
                        case 'co_prov':
                            $address[3] = $cf->export_value() ?? '';
                            break;
                        case 'co_postalcode':
                            $address[4] = $cf->export_value() ?? '';
                            break;
                    }
                }

                $cohort = [
                    'id' => $c->id,
                    'name' => $c->name,
                    'address' => implode(' ', $address)
                ];
            }
        }

        return $cohort;
    }

    /**
     * Retrieves the certificate template associated with the current issue.
     *
     * This method fetches the template record from the database if it is not already
     * cached in the `$this->template` property. The template is identified by the
     * `templateid` property of the `$this->issue` object.
     *
     * @global \moodle_database $DB The global database object used to query the database.
     * @return \stdClass The template record from the 'tool_certificate_templates' table.
     */
    public function get_template() {
        global $DB;

        if ($this->template) {
            return $this->template;
        }

        $this->template = $DB->get_record('tool_certificate_templates', array('id' => $this->issue->templateid), '*', MUST_EXIST);

        return $this->template;
    }

    /**
     * Generates and returns the download link for the certificate.
     *
     * This method constructs a URL pointing to the certificate download page,
     * including the wallet and issue ID as query parameters.
     *
     * @return \moodle_url The URL for downloading the certificate.
     */
    public function get_download_link() {
        $url = new \moodle_url('/blocks/wallet_certificate/certificate.php', array('wallet' => $this->wallet, 'issueid' => $this->issue->id));
        return $url;
    }
}
