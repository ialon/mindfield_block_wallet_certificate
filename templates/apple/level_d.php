<?php

// Level D: Limited Scope Operator
$data['organizationName'] = 'Fulford Certification';
$data['logoText'] = 'Fulford Certification';
$data['description'] = 'Level D: Limited Scope Operator';
$data['serialNumber'] = 'MC000000-D';

// Certificate and Crane Type
$data['generic']['secondaryFields'][] = [
    'key' => 'certficateDetails',
    'label' => 'Level D: Limited Scope Operator',
    'value' => 'Mobile Crane'
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
        'label' => 'Work Site Address',
        'value' => '508-602 West Hastings Street, Vancouver, BC, V6B 1P2'
    ],
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
    'label' => 'Limited Scope Crane Operation',
    'value' => 'This certificate permits this individual to operate the crane type specified on the front of this card. The Level D certificate is only valid for the employer and the worksite indicated on this card. It is not transferable between employers and worksites. The employer must be able to show evidence that the operator has received training for the crane operated and the task(s) performed.'
];

// QR Code
$data['barcode']['message'] = 'https://fulford.ca/';
$data['barcode']['altText'] = $data['serialNumber'];

// Styling
$data['backgroundColor'] = '#00B59E';
$data['foregroundColor'] = '#FFFFFF';
$data['labelColor'] = '#FFFFFF';

// Add files to the pass package
$pass->addFile(__DIR__ . '/../../pix/icon.png');
$pass->addFile(__DIR__ . '/../../pix/icon@2x.png');
$pass->addFile(__DIR__ . '/../../pix/logo.png');
