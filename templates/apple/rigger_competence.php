<?php

// Rigger - Certificate of Competence
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'Rigger - Certificate of Competence';
$data['serialNumber'] = 'FR1-12345';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'Rigger - Certificate of Competence',
    'value' => 'Level 1 - Rigger'
];

// User personal data
$data['generic']['primaryFields'][] = [
    'key' => 'fullname',
    'label' => 'Christopher',
    'value' => 'Montgomery'
];
$data['generic']['backFields'] = [
    [
        'key' => 'operatorAddress',
        'label' => 'Operator Address',
        'value' => '508-602 West Hastings Street, Vancouver, BC, V6B 1P2'
    ],
    // [
    //     'key' => 'employerName',
    //     'label' => 'Employer',
    //     'value' => 'Company Name'
    // ],
    // [
    //     'key' => 'employerAddress',
    //     'label' => 'Work Site Address',
    //     'value' => '508-602 West Hastings Street, Vancouver, BC, V6B 1P2'
    // ],
];

// Issue and expiration dates
$data['generic']['auxiliaryFields'][] = [
    'key' => 'issueDate',
    'label' => 'Date of Issue',
    'value' => '01 January 2025'
];
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
    'label' => 'Certificate of Competence',
    'value' => 'The person named on the front of this card was assessed to Fulford Certification Level 1 Rigging Standards. These standards are based on Canadian Trade practice standards, relevant Provincial OHS legislation as well as the ISO 23853-2004 Slingers and Signallers standard. The person was found competent to these standards at the time of assessment.'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#2773F2';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
