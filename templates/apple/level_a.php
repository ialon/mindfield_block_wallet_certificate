<?php

// CraneSafe Certificate - Level A
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'CraneSafe Certificate - Level A';
$data['serialNumber'] = 'MH2000000';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'CraneSafe Certificate - Level A',
    'value' => 'Mobile Hydraulic - 20 Tonnes and Under'
];

// User personal data
$data['generic']['primaryFields'][] = [
    'key' => 'fullname',
    'label' => 'Antonio Carlos',
    'value' => 'Cardoso Da Silva Filho'
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
    // ]
];

// Issue and expiration dates
$data['generic']['auxiliaryFields'][] = [
    'key' => 'assessmentDate',
    'label' => 'Date of Assessment',
    'value' => '01 January 2025'
];
// $data['generic']['auxiliaryFields'][] = [
//     'key' => 'expiryDate',
//     'label' => 'Date of Expiry',
//     'value' => '01 January 2028'
// ];

// Duration dates
$data['RelevantDates'] = [
    'startDate' => '2025-01-01T00:00:00Z',
    'endDate' => '2028-01-01T00:00:00Z'
];

// Back of card text
$data['generic']['backFields'][] = [
    'key' => 'backText',
    'label' => 'Certificate of Competence',
    'value' => 'The holder of this card has been assessed as competent to industry standards (BC 2017) and is certifified as Level A operator for Mobile Hydraulic cranes with a capacity of 20 tonnes and under.'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#0D860B';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
