<?php
return [
    'params' => [
        'navigation' => [
            'productAndMembership' => [
                'label' => 'Product Membership',
                'iconClass' => 'fa fa-award',
                'navigation' => [
                    'ProductService' => [
                        'label' => 'Product Service',
                        'url' => ['masterdata/product-service/index'],
                        'isDirect' => false,
                    ],
                    'membershipType' => [
                        'label' => 'Membership Type',
                        'url' => ['masterdata/membership-type/index'],
                        'isDirect' => false,
                    ]
                ]
            ],
            'productCategory' => [
                'label' => 'Product Category',
                'iconClass' => 'fa fa-utensils',
                'url' => ['masterdata/product-category/index'],
                'isDirect' => false,
            ],
            'businessCategory' => [
                'label' => 'Business Category',
                'iconClass' => 'fa fa-building',
                'url' => ['masterdata/category/index'],
                'isDirect' => false,
            ],
            'facility' => [
                'label' => 'Facility',
                'iconClass' => 'fa fa-couch',
                'url' => ['masterdata/facility/index'],
                'isDirect' => false,
            ],
            'ratingComponent' => [
                'label' => 'Rating Component',
                'iconClass' => 'fa fa-star',
                'url' => ['masterdata/rating-component/index'],
                'isDirect' => false,
            ],
            'area' => [
                'label' => 'Area',
                'iconClass' => 'fa fa-globe-asia',
                'navigation' => [
                    'province' => [
                        'label' => 'Province',
                        'url' => ['masterdata/province/index'],
                        'isDirect' => false,
                    ],
                    'city' => [
                        'label' => 'City',
                        'url' => ['masterdata/city/index'],
                        'isDirect' => false,
                    ],
                    'region' => [
                        'label' => 'Region',
                        'url' => ['masterdata/region/index'],
                        'isDirect' => false,
                    ],
                    'district' => [
                        'label' => 'District',
                        'url' => ['masterdata/district/index'],
                        'isDirect' => false,
                    ],
                    'village' => [
                        'label' => 'Village',
                        'url' => ['masterdata/village/index'],
                        'isDirect' => false,
                    ],
                ]
            ],
            'statusApproval' => [
                'label' => 'Approval Status',
                'iconClass' => 'fa fa-check',
                'url' => ['masterdata/status-approval/index'],
                'isDirect' => false,
            ],
            'paymentMethod' => [
                'label' => 'Payment Methods',
                'iconClass' => 'fa fa-hand-holding-usd',
                'url' => ['masterdata/payment-method/index'],
                'isDirect' => false,
            ],
            'deliveryMethod' => [
                'label' => 'Delivery Methods',
                'iconClass' => 'fa fa-truck',
                'url' => ['masterdata/delivery-method/index'],
                'isDirect' => false,
            ]
        ]
    ]
];