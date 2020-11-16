<?php

return [



    // METAS FOR ALL PAGES
    'metas' => [
        'title_prefix' => '', // se agrega como prefijo al titulo de todas las paginas
        'title_postfix' => ' | Digital Media Kit | Viacom', // se agrega como postfijo al titulo de todas las paginas
        'title_common' => 'Digital Media Kit | Viacom', // aplica a todas las paginas que no tengan un titulo dinamico
        'description_common' => 'Different ad formats on each platform, to contact the specific audience.', // aplica a todas las paginas que no tengan una descripcion dinámico
        'defaultImage' => '/assets/front/images/share/shareCommon.png', // aplica a todas las paginas que no tengan una descripcion dinámico
    ],



    // FOOTER FOR ALL PAGES
    'footer' => [
        'langs' => [
            'eng' => 'English (US)',
            'esp' => 'Español',
            'por' => 'Portugues',
        ],
        'legalsLinks' => [
            'Copyright' => 'Copyright Compliance Policy',
            'Terms' => 'Terms of Use',
        ],
        'copyright' => '© Viacom Inc. All rights reserved.',
        'socialNetworksLinks' => 
        [
            'facebookUrl'=> 'https://www.facebook.com/viacom',
            'twitterUrl'=> 'https://twitter.com/viacom',
        ],
    ],



    // MANU NAVIGATION
    'navMenu' =>
    [
        'placeHolderSearch' => 'Search',
        'links' => 
        [
            'home'=>'Home',
            'formatGallery'=> 'SEARCH BY PRODUCT',
            'brands'=>'SEARCH BY BRAND',
            'successCases'=>'Success cases',
            'news'=>'News',
            'back'=>'Back',
            'tutorials'=>'Tutorials',
        ],
    ],



    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // ::::::::::::::::::::::::::::::::COMMON PAGES MODULES:::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    'commonPagesModules' =>
    [
        "successCases" => 
        [
            "title" => "SUCCESS CASES",
            "copy" => "We accompany our partners to achieve<br>the success of their digital campaigns",
            "viewMoreButton" => "View More",
        ],
    ],

    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // ::::::::::::::::::::::::::::::::EMAILS  ::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    'emails' =>
        [
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////LOGIN     //////////////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'createPassword' =>[
                "hi" => "Hello",
                "copyNewUser"   => "Wellcome to Viacom Media Kit, enter to the following link: ",
                "copy1"         => "Wellcome to Viacom Media Kit, to create your new password, enter to the following link: ",
                "button"        => "Create new password",
                "buttonNewUser" => "Viacom Media Kit",
                "copy2" => "<br><br>For any question send an email to MediaKit&CatalogueViacomAmericas@vimn.com.<br><br>Thanks<br>",
                "email" => "E-Mail",
                "clave" => "Password",
            ],
        
        ],

    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // ::::::::::::::::::::::::::::::::PAGES AND MODALS ::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    'pages' =>
        [
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////LOGIN     //////////////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'login' =>
            [
            'email' => 'E-MAIL',
            'password' => 'PASSWORD',
            'submitButton' => 'LOG IN',
            'exitButton' => 'CLOSE',
            'rePassword' => 'I forgot my password',
            'register' => 'Quiero solicitar una cuenta',
        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////FORGOT PASSWORD     ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'forgotPassword' =>
            [
            'title' => 'To recover your password enter the following data:',
            'email' => 'E-MAIL',
            'submitButton' => 'SEND',
            'exitButton' => 'BACK',
            'page_recover_notEmail' => "These email do not match our records.",
            'page_recover_sendEmail' => "We have e-mailed your password reset link!",
            'page_recover_token_not_mach' => "These token do not match our records, re-generate it.",
            'page_recover_change_success' => "Your new password was updated.",
        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////LOG OUT             ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'logOut' =>
            [
            'title' => 'Are you sure you want to close the session?',
            'submitButton' => 'CONFIRM',
            'exitButton' => 'CLOSE',
        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////CREATE PASSWORD     ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'createPassword' =>
            [
            'title' => 'To create a new password enter the following data:',
            'email' => 'E-MAIL',
            'password' => 'PASSWORD',
            'repassword' => 'RE-PASSWORD',
            'submitButton' => 'SEND',
            'exitButton' => 'CLOSE',
        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////REGISTER    ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'register' =>
            [
            'title' => 'To request an account enter the following data:',
            'email' => 'E-MAIL',
            'password' => 'PASSWORD',
            'repassword' => 'RE-PASSWORD',
            'submitButton' => 'SEND',
            'exitButton' => 'CLOSE',
        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////HOME                ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'home' =>
            [
                'metaPageTitle' => 'Home',
                'subNav' => [
                    "brands" => "Brands",
                    "products" => "Products",
                    "news" => "News",
                    "successCases" => "Success cases",
                    "tutorials" => "Tutorials",
                ],

                'modules' => [
                    "products" =>
                    [
                        "title" => "Products",
                        "copy" => "Different ad formats on each platform, to contact the specific audience.",
                        "viewAllButton" => "View All",
                    ],
                    "news" =>
                    [
                        "readMoreButton" => "Read More",
                    ],
                    "tutoriales" =>
                        [
                        "title" => "Tutorials",
                        "copy" => "",
                        "viewAllButton" => "View All",
                    ],
                ],
                
            ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////SUCCESS CASES       ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'successCases' =>
            [
                'metaPageTitle' => 'Success Case',
                'relatedBrands'     => 'Related brands:',
                'relatedAds' => 'Related ads:',
                'recentListTitle'   => 'Recent Cases:',
                'moreList'   => 'More Cases:',
                'notLogged'   => 'To read this content you must be logged in.',

                
            ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////NEWS      ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'news' =>
            [
                'metaPageTitle' => 'News',
                'recentListTitle'   => 'Recent News:',
                'moreList' => 'More News:',
            ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////PRODUCT GALLERY     ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'productsGallery' =>
            [
                'formats' => 'Formats',
                'metaPageTitle' => 'Products Gallery',
                'title'   => 'PRODUCTS GALLERY',
                'copy' => 'Different ad formats on each platform, to contact the specific audience.',
            ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////SEARCH              ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'searchResult' =>
            [
            'metaPageTitle' => 'Search',
            ],

        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////BRANDS                ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'brand' =>
            [
            'metaPageTitle' => ' | Brand',
            'subNav' => [
                "quickView" => "Quick view",
                "formats" => "Formats",
                "rate" => "Rate",
                "successCases" => "Success cases",
                "contacts" => "Contacts",
            ],

            'modules' => [
                "quickView" =>
                    [
                    "title" => "Quick <b>View</b>",
                    "prefixBrand" => "About ",
                    "download" => "Download ",
                ],
                "contact" =>
                    [
                    "title" => "CONTACT",
                    "subtitle" => "CONTACTS",
                    "notLogged" => "To access contacts you must be logged in.",
                ],
                "rates" =>
                    [
                    "title" => "RATES",
                    "rateTitle" => "rates",
                    "vigencia" => "Vigente del {datefrom} al {dateTo}",
                    "calendarSelectTitle" => "Select a date to download file:",
                    "notLogged" => "To access prices you must be logged in.",
                    "logIn" => "Log In",
                ],
            ],

        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////ADS                 ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'ad' =>
            [
            'title' => 'AD DETAILS',
            'metaPageTitle' => ' | Ad',
            'subNav' => [
                "description" => "Description",
                "examples" => "View examples",
                "specs" => "Specs",
            ],

            'modules' => [
                "about" =>
                    [
                    "available" => "Available in:",
                ],
                "examples" =>
                    [
                    "titleDemo" => "View examples",
                    "titleDownloadExtras"   => "Download extras",
                    "titleDownloadSpecs"    => "Download specs",
                    "notLoggedExtras"       => "To download extra files you must be logged in.",
                    "notLoggedSpecs"        => "To download spec files you must be logged in.",
                    "download"              => "Download",
                ],
                "specifications" =>
                    [
                    "title"                 => "Specifications",
                    "listSpecs"             => [
                                                "productionTime" => "Production time",
                                                "implementationTime" => "Implementation time",
                                                "cost" => "Cost",
                                                "minimumSales" => "Minimum sales price per market",
                                                "usageClientInterest" => "Usage - Client interest",
                                                "initialDimensions" => "Initial dimensions",
                                                "maxInitialFileLoad" => "Max initial file load size allowance (see further HTML5 guidance in notes)",
                                                "subsequentMaxPite" => "Subsequent Max polite file load size",
                                                "maxVideoFrameRate" => "Max animation & video frame rate",
                                                "maxVideoLenght" => "Max animation & video lenght",
                                                "minimumRequiredControls" => "Minimum required controls",
                                                "3rdPartyServingTag" => "3rd Party serving (TAG)",
                                                "3rdPartyTracking" => "3rd Party tracking",
                                                "submissionLeadTime" => "Submission lead-time",
                                            ],

                ],
                "considerations" =>
                    [
                    "title"                 => "CONSIDERATIONS",
                    "listSpecs"             => [
                                            ],

                ],
                "extraConsiderations" =>
                    [
                    "title"                 => "EXTRA CONSIDERATIONS",
                    "listSpecs"             => [
                                            ],

                ],
                "rates" =>
                    [
                    "title" => "RATES",
                    "rateTitle" => "rates",
                    "vigencia" => "Valid from {datefrom} to {dateTo}",
                    "calendarSelectTitle" => "Select a date to download file:",
                    "notLogged" => "To access prices you must be logged in.",
                    "logIn" => "Log In",
                ],
                "faqs" =>
                    [
                    "title" => "FAQS",
                    ],
            ],

        ],
        // ///////////////////////////////////////////////////////////////////////////////////
        // ///////////////////////////////////TUTORIALES     ////////////////////////////
        // ///////////////////////////////////////////////////////////////////////////////////
        'tutorials' =>
            [
            'metaPageTitle' => 'Tutorials',
            'title' => 'TUTORIALS',
            'copy' => 'Key Tips to plan a digital campaign the best way possible.',
            'notLogged' => 'To watch this tutorial you must be logged in.',
        ],
    ],
];
