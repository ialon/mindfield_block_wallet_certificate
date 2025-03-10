<?php

// Rigger Trainer
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'Rigger Trainer';
$data['serialNumber'] = 'RT-12345';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'Rigger Trainer',
    'value' => 'Level 1 Rigging Fundamentals Program'
];

// User personal data
$data['generic']['primaryFields'][] = [
    'key' => 'fullname',
    'label' => 'Christopher',
    'value' => 'Montgomery'
];
$data['generic']['backFields'] = [
    [
        'key' => 'trainerAddress',
        'label' => 'Trainer Address',
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
    'label' => 'Rigger Trainer',
    'value' => 'The individual named on the front of this card has completed Fulford Certification\'s Level 1 Rigging Fundamentals Trainer Program. A Rigger Trainer with a valid certificate is authorized to deliver the program. The Level 1 Rigging Fundamentals program is based on Canadian Trade and OHS Standards (2013).'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#7853B8';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
