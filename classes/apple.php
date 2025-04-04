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
    public function __construct(int $issueid) {
        parent::__construct($issueid, 'apple');
    }

    public function get_mapped_data(&$data, &$pass = null) {
        $issuer = $this->get_issuer_data();
        $user = $this->get_user_data();
        $course = $this->get_course_data();
        $certificate = $this->get_certificate_data();
        $cohort = $this->get_cohort_data();

        $data['organizationName'] = $issuer['name'];
        $data['logoText'] = $issuer['name'];
        $data['description'] = $course['certificatetype'];
        $data['serialNumber'] = $certificate['code'];

        // User personal data
        $data['generic']['primaryFields'][] = [
            'key' => 'fullname',
            'label' => $user['firstname'],
            'value' => $user['lastname']
        ];

        // Certificate and Crane Type
        $craneorprogram = $course['programname'] ?: $course['cranetype'];
        $data['generic']['secondaryFields'][] = [
            'key' => 'certficateDetails',
            'label' => $course['certificatetype'],
            'value' => $craneorprogram
        ];
        if ($course['programname'] && $course['displaycranetype']) {
            $data['generic']['backFields'][] = [
                'key' => 'craneType',
                'label' => $course['cranetypelabel'],
                'value' => $course['cranetype']
            ];
        }

        // Completion or Issue date
        if ($course['displaycompletedon'] && $course['completedon']) {
            $data['generic']['auxiliaryFields'][] = [
                'key' => 'completedOn',
                'label' => $course['completedonlabel'],
                'value' => $course['completedon']
            ];
        } else {
            $data['generic']['auxiliaryFields'][] = [
                'key' => 'issueDate',
                'label' => $course['issuedonlabel'],
                'value' => $certificate['issued']
            ];
        }

        // Expiration date
        if ($certificate['expiry'] > 0) {
            $data['generic']['auxiliaryFields'][] = [
                'key' => 'expiryDate',
                'label' => $course['expiresonlabel'],
                'value' => $certificate['expiry']
            ];
        }

        // Back fields
        if ($course['displayoperatoraddress'] && !empty($user['address'])) {
            $data['generic']['backFields'][] = [
                'key' => 'operatorAddress',
                'label' => $course['operatoraddresslabel'],
                'value' => $user['address']
            ];
        }

        // Duration dates
        if ($certificate['expiry'] > 0) {
            $data['RelevantDates'] = [
                'startDate' => $course['completedon'],
                'endDate' => $certificate['expiry']
            ];
        }

        // Company name and address
        if ($course['displaycompanyname'] && !empty($cohort['name'])) {
            $data['generic']['backFields'][] = [
                'key' => 'companyName',
                'label' => $course['companynamelabel'],
                'value' => $cohort['name']
            ];
        }
        if ($course['displaycompanyaddress'] && !empty($cohort['address'])) {
            $data['generic']['backFields'][] = [
                'key' => 'companyAddress',
                'label' => $course['companyaddresslabel'],
                'value' => $cohort['address']
            ];
        }

        // Back of card text
        if (!empty($course['backtext'])) {
            $data['generic']['backFields'][] = [
                'key' => 'backText',
                'label' => $course['backtextlabel'],
                'value' => $course['backtext']
            ];
        }

        // QR Code
        $data['barcode']['message'] = $certificate['verifyurl'];
        $data['barcode']['altText'] = $certificate['code'];

        // Styling
        $data['backgroundColor'] = $course['backgroundcolor'];
        $data['foregroundColor'] = $course['textcolor'];
        $data['labelColor'] = $course['textcolor'];

        // Add images
        if (empty($course['logourl'])) {
            $pass->addFile('pix/logo.png');
        } else {
            $pass->addRemoteFile($course['logourl'], 'logo.png');
        }
        $pass->addRemoteFile($user['photourl'], 'thumbnail.png');
        // Required but not dynamic
        $pass->addFile('pix/icon.png');
        $pass->addFile('pix/icon@2x.png');
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

        $this->get_mapped_data($data, $pass);

        $pass->setData($data);

        // Create and output the pass
        $pass->create(true);
    }
}
