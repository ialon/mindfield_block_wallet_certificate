<?php

// Rigger - Certificate of Completion
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'Rigger - Certificate of Completion';
$data['serialNumber'] = 'CCFR-12345';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'Rigger - Certificate of Completion',
    'value' => 'Rigging Fundamentals Orientation & Training'
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
    'label' => 'Certificate of Completion',
    'value' => 'This person has attended Fulford Certification\'s Level 1 Rigging Fundamentals Orientation and Training session. Participants who hold a certificate of completion have been orientated on the fundamentals of rigging, loading calculations and lift planning. This is based on ISO 23853-200 and OHS standards.'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#BE2A2A';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
