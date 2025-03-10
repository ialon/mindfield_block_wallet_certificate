<?php

// CraneSafe Certificate - Level B Provisional
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'CraneSafe Certificate - Level B Provisional';
$data['serialNumber'] = 'SB4000000-B';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'CraneSafe Certificate - Level B Provisional',
    'value' => 'Stiff Boom - 40 Tonnes & Under'
];

// User personal data
$data['generic']['primaryFields'][] = [
    'key' => 'fullname',
    'label' => 'Christopher',
    'value' => 'Montgomery'
];
$data['generic']['backFields'] = [
    // [
    //     'key' => 'operatorAddress',
    //     'label' => 'Operator Address',
    //     'value' => '508-602 West Hastings Street, Vancouver, BC, V6B 1P2'
    // ],
    [
        'key' => 'employerName',
        'label' => 'Employer',
        'value' => 'Company Name'
    ],
    [
        'key' => 'employerAddress',
        'label' => 'Employer Address',
        'value' => '508-602 West Hastings Street, Vancouver, BC, V6B 1P2'
    ],
];

// Issue and expiration dates
// $data['generic']['auxiliaryFields'][] = [
//     'key' => 'assessmentDate',
//     'label' => 'Date of Assessment',
//     'value' => '01 January 2025'
// ];
$data['generic']['auxiliaryFields'][] = [
    'key' => 'expiryDate',
    'label' => 'Date of Expiry',
    'value' => '01 January 2028'
];

// Duration dates
$data['RelevantDates'] = [
    'startDate' => '2025-01-01T00:00:00Z',
    'endDate' => '2028-01-01T00:00:00Z'
];

// Back of card text
$data['generic']['backFields'][] = [
    'key' => 'backText',
    'label' => 'Registered Trainee Operator',
    'value' => 'The holder of this card is permitted to operate the classification of crane listed on the front of the card as a trainee under indirect supervision and direct supervision for all Critical Lifts as defined by BC OHS regulation. The holder of this card has passed a crane core theory exam and is understood to be working toward Full Scope Certification for the crane type listed.'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#E64E1F';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
