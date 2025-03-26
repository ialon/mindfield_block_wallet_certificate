<?php

namespace block_wallet_certificate;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/blocks/wallet_certificate/vendor/autoload.php');

use Firebase\JWT\JWT;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client as GoogleClient;
use Google\Service\Walletobjects;
use Google\Service\Walletobjects\LoyaltyPointsBalance;
use Google\Service\Walletobjects\LoyaltyPoints;
use Google\Service\Walletobjects\LoyaltyObject;
use Google\Service\Walletobjects\LoyaltyClass;
use Google\Service\Walletobjects\LatLongPoint;
use Google\Service\Walletobjects\Barcode;
use Google\Service\Walletobjects\ImageModuleData;
use Google\Service\Walletobjects\LinksModuleData;
use Google\Service\Walletobjects\TextModuleData;
use Google\Service\Walletobjects\TranslatedString;
use Google\Service\Walletobjects\LocalizedString;
use Google\Service\Walletobjects\ImageUri;
use Google\Service\Walletobjects\Image;
use Google\Service\Walletobjects\Message;
use Google\Service\Walletobjects\AddMessageRequest;
use Google\Service\Walletobjects\Uri;

use Google\Service\Walletobjects\ClassTemplateInfo;
use Google\Service\Walletobjects\CardTemplateOverride;
use Google\Service\Walletobjects\CardRowTemplateInfo;
use Google\Service\Walletobjects\CardRowOneItem;
use Google\Service\Walletobjects\CardRowTwoItems;
use Google\Service\Walletobjects\TemplateItem;
use Google\Service\Walletobjects\FieldSelector;
use Google\Service\Walletobjects\FieldReference;

/**
 * Wallet Certificate block
 *
 * @package    block_wallet_certificate
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
class google extends base {
    /**
     * The Google API Client
     * https://github.com/google/google-api-php-client
     */
    public GoogleClient $client;
  
    /**
     * Service account credentials for Google Wallet APIs.
     */
    public ServiceAccountCredentials $credentials;
  
    /**
     * Google Wallet service client.
     */
    public Walletobjects $service;

    public function __construct(int $issueid) {
        parent::__construct($issueid, 'google');
    }

    public function get_mapped_data(&$data, &$pass = null) {
        $issuer = $this->get_issuer_data();
        $user = $this->get_user_data();
        $course = $this->get_course_data();
        $certificate = $this->get_certificate_data();
    }

    public function generate_pass() {
        global $CFG, $SITE;

        $this->auth();

        $siteid = $SITE->shortname;
        $type = strtolower(str_replace(' ', '', $this->get_template()->name));
        $id = "{$this->config->issuerid}.{$this->issue->code}";
        $classid = "{$this->config->issuerid}.{$siteid}_{$type}";

        $newClass = new LoyaltyClass([
            'id' => $classid,
            'issuerName' => $SITE->fullname,
            'reviewStatus' => 'UNDER_REVIEW',
            'programName' => $SITE->fullname,
            'programLogo' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'https://fulford.ca/wp-content/uploads/2019/12/cropped-logo-dark-192x192.png'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => $SITE->fullname
                    ])
                ])
            ]),
            'classTemplateInfo' => new ClassTemplateInfo([
                'cardTemplateOverride' => new CardTemplateOverride([
                    'cardRowTemplateInfos' => [
                        new CardRowTemplateInfo([
                            'oneItem' => new CardRowOneItem([
                                'item' => new TemplateItem([
                                    'firstValue' => new FieldSelector([
                                        new FieldReference([
                                            'fieldPath' => 'object.textModulesData["jobtitle"]'
                                        ])
                                    ])
                                ])
                            ]),
                        ]),
                        new CardRowTemplateInfo([
                            'twoItems' => new CardRowTwoItems([
                                'startItem' => new TemplateItem([
                                    'firstValue' => new FieldSelector([
                                        new FieldReference([
                                            'fieldPath' => 'object.textModulesData["completion"]'
                                        ])
                                    ])
                                ]),
                                'endItem' => new TemplateItem([
                                    'firstValue' => new FieldSelector([
                                        new FieldReference([
                                            'fieldPath' => 'object.textModulesData["expiry"]'
                                        ])
                                    ])
                                ])
                            ])
                        ])
                    ]
                ])
            ])
        ]);

        // Check if the class exists
        try {
            // Let's update the class
            $this->service->loyaltyclass->get($classid);
            $this->service->loyaltyclass->update($classid, $newClass);
        } catch (\Google\Service\Exception $ex) {
            if (!empty($ex->getErrors()) && $ex->getErrors()[0]['reason'] == 'classNotFound') {
                // Class does not exist. Let's create it.
                $this->service->loyaltyclass->insert($newClass);
            } else {
                // Something went wrong...
                throw new \moodle_exception('classnotfound', 'block_wallet_certificate', '', $ex->getMessage());
            }
        }

        $data = [
            'id' => $id,
            'classId' => $classid,
            'state' => 'ACTIVE',
            'barcode' => new Barcode([
                'type' => 'QR_CODE',
                'value' => $this->issue->code,
                'alternateText' => $this->issue->code
            ]),
            'heroImage' => new Image([
                'sourceUri' => new ImageUri([
                    'uri' => 'https://placehold.co/52x52.png'
                ]),
                'contentDescription' => new LocalizedString([
                    'defaultValue' => new TranslatedString([
                        'language' => 'en-US',
                        'value' => 'Hero image description'
                    ])
                ])
            ]),
            'hexBackgroundColor' => '#16883d',
        ];

        // User name
        $data['accountNameLabel'] = 'Randy';
        $data['accountName'] = 'GRISEWOOD';

        // Completion and expiration
        $data['textModulesData'] = [
            new TextModuleData([
                'id' => 'jobtitle',
                'header' => 'CraneSafe Certificate - Level A',
                'body' => 'Mobile Hydraulic - 20 Tonnes and Under'
            ]),
            new TextModuleData([
                'id' => 'completion',
                'header' => 'Completion',
                'body' => 'Aug 11th, 2024'
            ]),
            new TextModuleData([
                'id' => 'expiry',
                'header' => 'Expiry',
                'body' => 'Aug 10th, 2025'
            ])
        ];

        $newObject = new LoyaltyObject($data);

        // Check if the object exists
        try {
            // Let's update the object
            $this->service->loyaltyobject->get($id);
            $this->service->loyaltyobject->update($id, $newObject);
        } catch (\Google\Service\Exception $ex) {
            if (!empty($ex->getErrors()) && $ex->getErrors()[0]['reason'] == 'resourceNotFound') {
                // Object does not exist. Let's create it.
                $this->service->loyaltyobject->insert($newObject);
            } else {
                // Something went wrong...
                throw new \moodle_exception('objectnotfound', 'block_wallet_certificate', '', $ex->getMessage());
            }
        }

        // The service account credentials are used to sign the JWT
        $serviceAccount = json_decode(file_get_contents($this->config->keyfilepath), true);

        // Create the JWT as an array of key/value pairs
        $claims = [
            'iss' => $serviceAccount['client_email'],
            'aud' => 'google',
            'origins' => [$CFG->wwwroot],
            'typ' => 'savetowallet',
            'payload' => [
                'loyaltyObjects' => [
                    [
                        'id' => $id,
                        'classId' => $classid
                    ]
                ],
            ]
        ];

        $token = JWT::encode(
            $claims,
            $serviceAccount['private_key'],
            'RS256'
        );

        redirect("https://pay.google.com/gp/v/save/{$token}");
    }

   public function auth() {
        global $SITE;

        $this->credentials = new ServiceAccountCredentials(
            Walletobjects::WALLET_OBJECT_ISSUER,
            $this->config->keyfilepath
        );

        // Initialize Google Wallet API service
        $this->client = new GoogleClient();
        $this->client->setApplicationName($SITE->fullname);
        $this->client->setScopes(Walletobjects::WALLET_OBJECT_ISSUER);
        $this->client->setAuthConfig($this->config->keyfilepath);

        $this->service = new Walletobjects($this->client);
    }
}
