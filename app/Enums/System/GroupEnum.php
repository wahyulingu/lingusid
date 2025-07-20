<?php

namespace App\Enums\System;

enum GroupEnum: string
{
    // Core
    case DASHBOARD_SIDEBAR_MENU = 'dashboard sidebar menu';

    // Content
    case CONTENT_ARTICLE_CATEGORY = 'content article category';
    case CONTENT_ARTICLE_TAG = 'content article tag';
    case MEDIA_GALLERY_ALBUM = 'media gallery album';

    // Population
    case RESIDENT_RELIGION = 'resident religion';
    case RESIDENT_MARITAL_STATUS = 'resident marital status';
    case RESIDENT_EDUCATION_LEVEL = 'resident education level';
    case RESIDENT_OCCUPATION = 'resident occupation';
    case RESIDENT_BLOOD_TYPE = 'resident blood type';
    case FAMILY_RELATIONSHIP_STATUS = 'family relationship status';

    // Government
    case GOVERNMENT_OFFICIAL_POSITION = 'government official position';
    case LEGAL_PRODUCT_CATEGORY = 'legal product category';

    // Services
    case DOCUMENT_LETTER_TYPE = 'document letter type';

    // Social Assistance
    case SOCIAL_ASSISTANCE_TYPE = 'social assistance type';

    // Village Assets
    case VILLAGE_ASSET_TYPE = 'village asset type';
}
