-- SET sql_mode = '';

--
-- Table structure for table `#__standard_vendors`
--

CREATE TABLE `#__standard_vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__standard_currencies table.',
  `accepted_currencies` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the vendor.'
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Vendors manage their products in your store';

--
-- Indexes for table `#__standard_vendors`
--
ALTER TABLE `#__standard_vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_vendors`
--
ALTER TABLE `#__standard_vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- Table structure for table `#__standard_categories`
--

CREATE TABLE `#__standard_categories` (
    `id` int(11) NOT NULL, 
    `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
    `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `lft` int(11) NOT NULL DEFAULT '0',
    `rgt` int(11) NOT NULL DEFAULT '0',
    `level` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 
    `minimumprice` decimal(15,5) NOT NULL DEFAULT '0',
    `currency_id` int(10) UNSIGNED NOT NULL,

    `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `address` text COLLATE utf8mb4_unicode_ci,
    `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `file_terms_conditions` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `attachments` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `isService` TINYINT(3) NOT NULL DEFAULT '2',
    `profileCode` VARCHAR(11) NOT NULL,

    `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `banners` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banners_tablet` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banners_phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banner_status` tinyint(3) NOT NULL DEFAULT '0',
    `banner_home` tinyint(3) NOT NULL DEFAULT '0',

    `maps` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `published` tinyint(1) NOT NULL DEFAULT '0',
    `checked_out` int(11) UNSIGNED NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
    `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
    `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
    `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_categories`
--
ALTER TABLE `#__standard_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `cat_idx` (`extension`,`published`,`access`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_path` (`path`(100)),
  ADD KEY `idx_left_right` (`lft`,`rgt`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_categories`
--
ALTER TABLE `#__standard_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- -----------------------------------------------------------------------------

--
-- Table structure for table `#__standard_products`
--

CREATE TABLE `#__standard_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `paymenttype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `subtitle` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `description_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',  
  `description_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `descriptions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_column` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `merge_column` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `number_days` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `number_nights` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `adult` int(10) UNSIGNED NOT NULL,
  `children` int(10) UNSIGNED NOT NULL,
  `infant` int(10) UNSIGNED NOT NULL,  
  `price` Decimal(15,5) NOT NULL DEFAULT '0',

  `in_stock` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `max_occupancy` int(10) UNSIGNED NOT NULL,
  `max_adult` int(10) UNSIGNED NOT NULL,
  `max_children` int(10) UNSIGNED NOT NULL,
  `max_infant` int(10) UNSIGNED NOT NULL,

  `price_children_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_infant_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_single_supplement_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_extra_bed_percent_adult` int(10) UNSIGNED NOT NULL,

  `ordered` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `banners` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_tablet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_status` tinyint(3) NOT NULL DEFAULT '0',
  `banner_home` tinyint(3) NOT NULL DEFAULT '0',

  `gallery_mediadisplaytype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gallery_layout` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `gallery_medialayoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `galleries` text COLLATE utf8mb4_unicode_ci NOT NULL,


  `videos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aspect_ratio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `frame_rate` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `plans_mediadisplaytype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `plans_medialayoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',

  `plans_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_layout` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `plans_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `plans_image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans_num_leading` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_column_leading` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_num_intro` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_column_intro` int(10) UNSIGNED NOT NULL DEFAULT '0',
  
  `links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `period_block` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_in_date` tinyint(3) NOT NULL DEFAULT '0',

  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Set if product is featured.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the product.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_products`
--
ALTER TABLE `#__standard_products`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_catid` (`catid`),
    ADD KEY `idx_currency_id` (`currency_id`),
    ADD KEY `idx_displaytype_id` (`displaytype_id`),
    ADD KEY `idx_plans_displaytype_id` (`plans_displaytype_id`),

    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_state` (`state`),
    ADD KEY `idx_block_in_date` (`block_in_date`),

    ADD KEY `idx_banner_status` (`banner_status`),
    ADD KEY `idx_banner_home` (`banner_home`),

    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_featured_catid` (`featured`,`catid`),
    ADD KEY `idx_language` (`language`),
    ADD KEY `idx_xreference` (`xreference`);

--
-- AUTO_INCREMENT for table `#__standard_products`
--
ALTER TABLE `#__standard_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- 
--
--
CREATE TABLE `#__standard_products_frontpage` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_products_frontpage`
--
ALTER TABLE `#__standard_products_frontpage`
  ADD PRIMARY KEY (`product_id`);

--
-- Table structure for table `#__standard_products_types`
--

CREATE TABLE `#__standard_products_types` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_contenthistory options'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_products_types`
--
ALTER TABLE `#__standard_products_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `idx_alias` (`type_alias`(100));

--
-- AUTO_INCREMENT for table `#__standard_products_types`
--
ALTER TABLE `#__standard_products_types`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Table structure for table `#__standard_products_rating`
--

CREATE TABLE `#__standard_products_rating` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lastip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_products_rating`
--
ALTER TABLE `#__standard_products_rating`
  ADD PRIMARY KEY (`product_id`);
--
-- Table structure for table `#__standard_products_item_tag_map`
--

CREATE TABLE `#__standard_products_item_tag_map` (
  `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_product_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the core standard_products table',
  `product_item_id` int(11) NOT NULL COMMENT 'PK from the standard_products type table',
  `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint(8) NOT NULL COMMENT 'PK from the standard_products_type table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from standard_products tables to tags';

--
-- Indexes for table `#__standard_productsitem_tag_map`
--
ALTER TABLE `#__standard_products_item_tag_map`
  ADD UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`product_item_id`,`tag_id`),
  ADD KEY `idx_tag_type` (`tag_id`,`type_id`),
  ADD KEY `idx_date_id` (`tag_date`,`tag_id`),
  ADD KEY `idx_core_product_id` (`core_product_id`);

--
-- Indexes for table `#__standard_product_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_product_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_products.id',
  
  PRIMARY KEY (`manufacturer_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_itinerary_types`
--

CREATE TABLE `#__standard_itinerary_types` (
    `id` int(11) NOT NULL, 
    `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
    `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `lft` int(11) NOT NULL DEFAULT '0',
    `rgt` int(11) NOT NULL DEFAULT '0',
    `level` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 
    `minimumprice` decimal(15,5) NOT NULL DEFAULT '0',
    `currency_id` int(10) UNSIGNED NOT NULL,

    `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `address` text COLLATE utf8mb4_unicode_ci,
    `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `banners` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banners_tablet` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banners_phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `banner_status` tinyint(3) NOT NULL DEFAULT '0',
    `banner_home` tinyint(3) NOT NULL DEFAULT '0',

    `summary_itineraries` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `published` tinyint(1) NOT NULL DEFAULT '0',
    `checked_out` int(11) UNSIGNED NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `params` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
    `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
    `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
    
    `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_itinerary_types`
--
ALTER TABLE `#__standard_itinerary_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `cat_idx` (`extension`,`published`,`access`),
  ADD KEY `idx_banner_status` (`banner_status`),
  ADD KEY `idx_banner_home` (`banner_home`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_path` (`path`(100)),
  ADD KEY `idx_left_right` (`lft`,`rgt`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_itinerary_types`
--
ALTER TABLE `#__standard_itinerary_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- -----------------------------------------------------------------------------

--
-- Table structure for table `#__standard_itineraries`
--

CREATE TABLE `#__standard_itineraries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `itinerarytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `paymenttype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `subtitle` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `description_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',  
  `description_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `descriptions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_column` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `merge_column` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `itinerary_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `itinerary_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `itinerary_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `itinerary_column` int(10) UNSIGNED NOT NULL DEFAULT '0',
   
  `number_days` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `number_nights` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `adult` int(10) UNSIGNED NOT NULL,
  `children` int(10) UNSIGNED NOT NULL,
  `infant` int(10) UNSIGNED NOT NULL, 
  `price` Decimal(15,5) NOT NULL DEFAULT '0',

  `in_stock` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `max_occupancy` int(10) UNSIGNED NOT NULL,
  `max_adult` int(10) UNSIGNED NOT NULL,
  `max_children` int(10) UNSIGNED NOT NULL,
  `max_infant` int(10) UNSIGNED NOT NULL,

  `price_children_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_infant_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_single_supplement_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_extra_bed_percent_adult` int(10) UNSIGNED NOT NULL,

  `ordered` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `banners` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_tablet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_status` tinyint(3) NOT NULL DEFAULT '0',
  `banner_home` tinyint(3) NOT NULL DEFAULT '0',

  `gallery_mediadisplaytype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gallery_layout` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `gallery_medialayoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `galleries` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `overview` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `videos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aspect_ratio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `frame_rate` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `plans_image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans_column` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `itinerary` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `period_block` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_in_date` tinyint(3) NOT NULL DEFAULT '0',

  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Set if itinerary is featured.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the itinerary.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_itineraries`
--
ALTER TABLE `#__standard_itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_itinerarytype_id` (`itinerarytype_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `idx_displaytype_id` (`displaytype_id`),
  ADD KEY `idx_plans_displaytype_id` (`plans_displaytype_id`),

  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_block_in_date` (`block_in_date`),

  ADD KEY `idx_banner_status` (`banner_status`),
  ADD KEY `idx_banner_home` (`banner_home`),

  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_featured_itinerarytype_id` (`featured`,`itinerarytype_id`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- AUTO_INCREMENT for table `#__standard_itineraries`
--
ALTER TABLE `#__standard_itineraries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- 
--
--
CREATE TABLE `#__standard_itineraries_frontpage` (
  `itinerary_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_itineraries_frontpage`
--
ALTER TABLE `#__standard_itineraries_frontpage`
  ADD PRIMARY KEY (`itinerary_id`);

--
-- Table structure for table `#__standard_itineraries_types`
--

CREATE TABLE `#__standard_itineraries_types` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_contenthistory options'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Indexes for table `#__standard_itineraries_types`
--
ALTER TABLE `#__standard_itineraries_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `idx_alias` (`type_alias`(100));
--
-- AUTO_INCREMENT for table `#__standard_itineraries_types`
--
ALTER TABLE `#__standard_itineraries_types`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Indexes for table `#__standard_itineraries_rating`
--
CREATE TABLE `#__standard_itineraries_rating`(
    `itinerary_id` int(11) NOT NULL DEFAULT '0',
    `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `rating_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `lastip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_itineraries_rating`
--
ALTER TABLE `#__standard_itineraries_rating`
    ADD PRIMARY KEY (`itinerary_id`);

--
-- Indexes for table `#__standard_itineraries_item_tag_map`
--
CREATE TABLE `#__standard_itineraries_item_tag_map`(
    `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `core_itinerary_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the core standard_itineraries table',
    `itinerary_item_id` int(11) NOT NULL COMMENT 'PK from the standard_itineraries type table',
    `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the tag table',
    `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
    `type_id` mediumint(8) NOT NULL COMMENT 'PK from the standard_itinerary_type table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from standard_itineraries tables to tags';
--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_itineraries_item_tag_map`
--
ALTER TABLE `#__standard_itineraries_item_tag_map`
  ADD UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`itinerary_item_id`,`tag_id`),
  ADD KEY `idx_tag_type` (`tag_id`,`type_id`),
  ADD KEY `idx_date_id` (`tag_date`,`tag_id`),
  ADD KEY `idx_core_itinerary_id` (`core_itinerary_id`);

--
-- Indexes for table `#__standard_itinerary_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_itinerary_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `itinerary_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_itineraries.id',
  
  PRIMARY KEY (`manufacturer_id`,`itinerary_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------

--
-- Table structure for table `#__standard_combos`
--

CREATE TABLE IF NOT EXISTS `#__standard_combos` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `itinerary_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `paymenttype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `subtitle` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `description_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',  
  `description_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `descriptions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_column` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `description_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `merge_column` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `number_days` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `number_nights` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `adult` int(10) UNSIGNED NOT NULL,
  `children` int(10) UNSIGNED NOT NULL,
  `infant` int(10) UNSIGNED NOT NULL,  
  `price` Decimal(15,5) NOT NULL DEFAULT '0',

  `in_stock` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `max_occupancy` int(10) UNSIGNED NOT NULL,
  `max_adult` int(10) UNSIGNED NOT NULL,
  `max_children` int(10) UNSIGNED NOT NULL,
  `max_infant` int(10) UNSIGNED NOT NULL,

  `price_children_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_infant_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_single_supplement_percent_adult` int(10) UNSIGNED NOT NULL,
  `price_extra_bed_percent_adult` int(10) UNSIGNED NOT NULL,

  `ordered` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `banners` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_tablet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banners_phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_status` tinyint(3) NOT NULL DEFAULT '0',
  `banner_home` tinyint(3) NOT NULL DEFAULT '0',

  `gallery_mediadisplaytype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `gallery_layout` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `gallery_medialayoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `galleries` text COLLATE utf8mb4_unicode_ci NOT NULL,


  `videos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aspect_ratio` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `frame_rate` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `plans_mediadisplaytype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `plans_medialayoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',

  `plans_displaytype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_layout` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `plans_layoutelement` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `plans_image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `plans_num_leading` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_column_leading` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_num_intro` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `plans_column_intro` int(10) UNSIGNED NOT NULL DEFAULT '0',
  
  `links` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `period_block` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `block_in_date` tinyint(3) NOT NULL DEFAULT '0',

  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Set if product is featured.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the product.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_combos`
--
ALTER TABLE `#__standard_combos`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_catid` (`catid`),
    ADD KEY `idx_product_id` (`product_id`),
    ADD KEY `idx_itinerary_id` (`itinerary_id`),
    ADD KEY `idx_currency_id` (`currency_id`),
    ADD KEY `idx_displaytype_id` (`displaytype_id`),
    ADD KEY `idx_plans_displaytype_id` (`plans_displaytype_id`),

    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_state` (`state`),
    ADD KEY `idx_block_in_date` (`block_in_date`),

    ADD KEY `idx_banner_status` (`banner_status`),
    ADD KEY `idx_banner_home` (`banner_home`),

    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_featured_catid` (`featured`,`catid`),
    ADD KEY `idx_language` (`language`),
    ADD KEY `idx_xreference` (`xreference`);

--
-- AUTO_INCREMENT for table `#__standard_combos`
--
ALTER TABLE `#__standard_combos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- 
--
--
CREATE TABLE IF NOT EXISTS `#__standard_combos_frontpage` (
  `combo_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_combos_frontpage`
--
ALTER TABLE `#__standard_combos_frontpage`
  ADD PRIMARY KEY (`combo_id`);

-- --------------------------------------------------------
--
-- Table structure for table `#__standard_allotment`
--
CREATE TABLE IF NOT EXISTS `#__standard_allotment` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_products.id',
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_categories.id',
  
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sunday` tinyint(1) NOT NULL DEFAULT '1',
  `monday` tinyint(1) NOT NULL DEFAULT '1',
  `tuesday` tinyint(1) NOT NULL DEFAULT '1',
  `wednesday` tinyint(1) NOT NULL DEFAULT '1',
  `thursday` tinyint(1) NOT NULL DEFAULT '1',
  `friday` tinyint(1) NOT NULL DEFAULT '1',
  `saturday` tinyint(1) NOT NULL DEFAULT '1',

  `allotment` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `booking` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',  
  `ordering` int(11) NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the product.',
  `version` int(10) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_allotment`
--
ALTER TABLE `#__standard_allotment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_date` (`date`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for table `#__standard_allotment`
--
ALTER TABLE `#__standard_allotment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- --------------------------------------------------------

--
-- Table structure for table `#__standard_locations`
--
CREATE TABLE `#__standard_locations` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',

  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_locations`
--
ALTER TABLE `#__standard_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `location_idx` (`state`,`access`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_locations`
--
ALTER TABLE `#__standard_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- -----------------------------------------------------------------------------

--
-- Table structure for table `#__standard_routes`
--
CREATE TABLE `#__standard_routes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `from_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__standard_location table.',
  `to_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__standard_location table.',
  `departure_time` time NOT NULL DEFAULT '00:00:00',
  `arrival_time` time NOT NULL DEFAULT '00:00:00',

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `subtitle` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `departure_day` tinyint(3) NOT NULL DEFAULT '-1' COMMENT '0: Sunday, 1: Monday, 2: Tuesday, 3: Wednesday, 4: Thursday, 5: Friday, 6: Saturday.',
  `number_days` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',

  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_routes`
--
ALTER TABLE `#__standard_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_idx` (`state`,`access`),

  ADD KEY `idx_from_id` (`from_id`),
  ADD KEY `idx_to_id` (`to_id`),
  ADD KEY `time_idx` (`departure_time`,`arrival_time`),

  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_departure_day` (`departure_day`),

  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_routes`
--
ALTER TABLE `#__standard_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_rates`
--
CREATE TABLE `#__standard_rates` (
  `id` int(11) NOT NULL,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `currency_id` int(10) UNSIGNED NOT NULL,

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',

  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_rates`
--
ALTER TABLE `#__standard_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `rate_idx` (`state`,`access`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_rates`
--
ALTER TABLE `#__standard_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --- rate details ---
CREATE TABLE IF NOT EXISTS `#__standard_rate_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `rate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_rates.id',

  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `price` Decimal(15,5) NOT NULL DEFAULT '0',
  `inforate_status` tinyint(3) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_rate_details`
--
ALTER TABLE `#__standard_rate_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rate_id` (`rate_id`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_inforate_status` (`inforate_status`);

--
-- AUTO_INCREMENT for table `#__standard_rates`
--
ALTER TABLE `#__standard_rate_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- ----------- map ----------
--
-- Table structure for table `#__standard_routerate_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_routerate_map` (
  `route_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_routes.id',
  `rate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_rates.id',
  PRIMARY KEY (`route_id`,`rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `#__standard_productrate_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_productrate_map` (
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_products.id',
  `rate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_rates.id',
  PRIMARY KEY (`product_id`,`rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_contractrates`
--
CREATE TABLE `#__standard_contractrates` (
  `id` int(11) NOT NULL, 
  `catid` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_categories.id',
  `contractgroup_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_contractgroups.id',
  `currency_id` int(10) UNSIGNED NOT NULL COMMENT 'Foreign Key to #__standard_currencies.id',

  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',

  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_contractrates`
--
ALTER TABLE `#__standard_contractrates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_contractgroup_id` (`contractgroup_id`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `rate_idx` (`state`,`access`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_contractrates`
--
ALTER TABLE `#__standard_contractrates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --- contractrate details ---
CREATE TABLE IF NOT EXISTS `#__standard_contractrate_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `contractrate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_contractrates.id',

  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `price` Decimal(15,5) NOT NULL DEFAULT '0',
  `inforate_status` tinyint(3) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_contractrate_details`
--
ALTER TABLE `#__standard_contractrate_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contractrate_id` (`contractrate_id`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_inforate_status` (`inforate_status`);

--
-- AUTO_INCREMENT for table `#__standard_contractrates`
--
ALTER TABLE `#__standard_contractrate_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- ---------- Map ---------
--
-- Table structure for table `#__standard_routecontractrate_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_routecontractrate_map` (
  `route_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_routes.id',
  `contractrate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_contractrates.id',
  PRIMARY KEY (`route_id`,`contractrate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `#__standard_productcontractrate_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_productcontractrate_map` (
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_products.id',
  `contractrate_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_contractrates.id',
  PRIMARY KEY (`product_id`,`contractrate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------

-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_contractgroups`
--
CREATE TABLE IF NOT EXISTS `#__standard_contractgroups` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the contract group',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(10) UNSIGNED DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_contractgroups`
--
ALTER TABLE `#__standard_contractgroups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_published` (`state`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for table `#hicq6_standard_contractgroups`
--
ALTER TABLE `#__standard_contractgroups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- ---------- Map -- user --------
--
-- Table structure for table `#__standard_contractgroup_usergroup_map`
--

CREATE TABLE IF NOT EXISTS `#__standard_contractgroup_usergroup_map` (
  `usergroup_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  `contractgroup_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_contractgroups.id',
  PRIMARY KEY (`usergroup_id`,`contractgroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_usergroup_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_usergroup_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_categories.id',
  `usergroup_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_usergroups.id',
  
  PRIMARY KEY (`catid`,`usergroup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_calculations`
--

CREATE TABLE `#__standard_calculations` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the rule',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `descr` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Description',
  `kind` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Tax/Margin/Commission',
  `value_mathop` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'the mathematical operation like (+,-,+%,-%)',
  `value` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Currency of the Rule',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED DEFAULT '0',
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to taxes calculations rules';

--
-- Dumping data for table `#__standard_calculations`
--

INSERT INTO `#__standard_calculations` (`id`, `title`, `alias`, `descr`, `kind`, `value_mathop`, `value`, `currency_id`, `publish_up`, `publish_down`, `version`, `ordering`, `state`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `access`, `language`) VALUES
(1, 'Tax 20%', '', 'common vat, if your shop needs only one VAT, just use it without any category set', 'VatTax', '+%', '20.0000', 47, '1970-01-01 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, '0000-00-00 00:00:00', 0, '', '2017-02-16 16:12:31', 12, 0, '0000-00-00 00:00:00', 0, NULL),
(2, 'Discount 5% for ladies', '', 'The discount is based on net price with VAT, the tax amount is recalculated based on the new net price', 'DATax', '-%', '5.0000', 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, NULL),
(3, 'Tax 10%', '', 'as example for the category product variants', 'VatTax', '+%', '10.0000', 47, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0, 0, '0000-00-00 00:00:00', 0, NULL),
(4, 'Tax 7%', 'tax-7', 'as example for the category product attributes', 'VatTax', '+%', '7.0000', 47, '2017-04-06 07:35:51', '0000-00-00 00:00:00', 2, 0, 1, '0000-00-00 00:00:00', 0, '', '2017-04-06 07:35:51', 591, 591, '2017-04-06 07:35:51', 1, '*');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_calculations`
--
ALTER TABLE `#__standard_calculations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_published` (`state`),
  ADD KEY `idx_kind` (`kind`(191)),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_calculations`
--
ALTER TABLE `#__standard_calculations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Indexes for table `#__standard_calc_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_calc_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `calculation_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_calculations.id',
  PRIMARY KEY (`manufacturer_id`,`calculation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_calc_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_calc_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `calculation_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_calculations.id',
  PRIMARY KEY (`catid`,`calculation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_manufacturers`
--

CREATE TABLE `#__standard_manufacturers` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the product.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



--
-- Indexes for table `#__standard_manufacturers`
--
ALTER TABLE `#__standard_manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_manufacturers`
--
ALTER TABLE `#__standard_manufacturers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_promotions`
--

CREATE TABLE `#__standard_promotions` (
 `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the rule',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value_mathop` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'the mathematical operation like (-,-%)',
  `value` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Currency of the Rule',
  
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `childimages` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED DEFAULT '0',
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store promotion codes';

--
-- Indexes for table `#__standard_promotions`
--
ALTER TABLE `#__standard_promotions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `idx_published` (`state`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_promotions`
--
ALTER TABLE `#__standard_promotions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Indexes for table `#__standard_promotion_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_promotion_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `promotion_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_promotions.id',
  PRIMARY KEY (`manufacturer_id`,`promotion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_promotion_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_promotion_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `promotion_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_promotions.id',
  PRIMARY KEY (`catid`,`promotion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Table structure for table `#__standard_couponstypes`
--

CREATE TABLE `#__standard_couponstypes` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the rule',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `prefix` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  
  `value_mathop` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'the mathematical operation like (-,-%)',
  `value` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',
  `value_valid` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Currency of the Rule',
  
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED DEFAULT '0',
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store coupon codes';

--
-- Indexes for table `#__standard_couponstypes`
--
ALTER TABLE `#__standard_couponstypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_limit` (`limit`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_couponstypes`
--
ALTER TABLE `#__standard_couponstypes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- -----------------------------------------------------------------------------

--
-- Indexes for table `#__standard_couponstype_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_couponstype_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `couponstype_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_couponstypes.id',
  PRIMARY KEY (`catid`,`couponstype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_couponstype_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_couponstype_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `couponstype_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_couponstypes.id',
  PRIMARY KEY (`manufacturer_id`,`couponstype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------

-- --------
--
-- Table structure for table `#__standard_coupons`
--

CREATE TABLE `#__standard_coupons` (
    `id` int(10) UNSIGNED NOT NULL,
    `coupontype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `used` int(11) UNSIGNED NOT NULL DEFAULT '0',

    `state` tinyint(3) NOT NULL DEFAULT '0',
    `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
    `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  
    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(11) NOT NULL DEFAULT '0',
    `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) NOT NULL DEFAULT '0',
    `checked_out` int(10) UNSIGNED DEFAULT '0',
    `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(11) NOT NULL DEFAULT '0',

    `access` int(10) UNSIGNED DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store promotion codes';

--
-- Indexes for table `#__standard_coupons`
--
ALTER TABLE `#__standard_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_coupontype_id` (`coupontype_id`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_used` (`used`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_coupons`
--
ALTER TABLE `#__standard_coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

/*
-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_coupons`
--

CREATE TABLE `#__standard_coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the rule',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value_mathop` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'the mathematical operation like (-,-%)',
  `value` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',
  `currency_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Currency of the Rule',
  
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,

  `state` tinyint(3) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `used` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
  
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out` int(10) UNSIGNED DEFAULT '0',
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED DEFAULT '0',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store promotion codes';

--
-- Indexes for table `#__standard_coupons`
--
ALTER TABLE `#__standard_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_code` (`code`),
  ADD KEY `idx_currency_id` (`currency_id`),
  ADD KEY `idx_published` (`state`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_used` (`used`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_coupons`
--
ALTER TABLE `#__standard_coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Indexes for table `#__standard_coupon_manufacturer_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_coupon_manufacturer_map` (
  `manufacturer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_manufacturers.id',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_coupons.id',
  PRIMARY KEY (`manufacturer_id`,`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_coupon_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_coupon_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_coupons.id',
  PRIMARY KEY (`catid`,`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_shipmentmethods`
--
CREATE TABLE IF NOT EXISTS `#__standard_shipmentmethods` (
    `id` int(10) UNSIGNED NOT NULL,
    `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `tax_id` int(10) NOT NULL DEFAULT '0',

    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the shipment method',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `currency_id` int(10) UNSIGNED DEFAULT NULL,
    `price` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Shipment Cost',
    `nbproducts_start` int(10) UNSIGNED NOT NULL COMMENT 'Minimum number of products',
    `nbproducts_stop` int(10) UNSIGNED NOT NULL COMMENT 'Maximum number of products',
    `orderamount_start` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount',
    `orderamount_stop` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Maximum order amount',
    `package_fee` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Package Fee',
    `free_shipment` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount for Free Shipment',

    `shared` tinyint(10) NOT NULL DEFAULT '1',
    `state` tinyint(3) NOT NULL DEFAULT '0',
    `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
    `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` int(10) NOT NULL DEFAULT '0',

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) NOT NULL DEFAULT '0',
    `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `checked_out` int(10) NOT NULL DEFAULT '0',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Shipment created from the shipment plugins';
--
-- Indexes for table `#__standard_shipmentmethods`
--
ALTER TABLE `#__standard_shipmentmethods`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_vendor_id` (`vendor_id`),
    ADD KEY `idx_tax_id` (`tax_id`),
    ADD KEY `idx_currency_id` (`currency_id`),
    ADD KEY `idx_ordering` (`ordering`),
    ADD KEY `idx_publish_up` (`publish_up`),
    ADD KEY `idx_publish_down` (`publish_down`),
    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_language` (`language`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_shipmentmethods`
--
ALTER TABLE `#__standard_shipmentmethods`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*
-- --- shipmentmethod details ---
CREATE TABLE IF NOT EXISTS `#__standard_shipmentmethod_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `shipmentmethod_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_shipmentmethods.id',

  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expiry_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  `price` Decimal(15,5) NOT NULL DEFAULT '0',

  `infoshipment_status` tinyint(3) NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_shipmentmethod_details`
--
ALTER TABLE `#__standard_shipmentmethod_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shipmentmethod_id` (`shipmentmethod_id`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_expiry_date` (`expiry_date`),
  ADD KEY `idx_inforate_status` (`inforate_status`);

--
-- AUTO_INCREMENT for table `#__standard_rates`
--
ALTER TABLE `#__standard_shipmentmethod_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
*/
-- --------------------------------------------------------
--
-- Indexes for table `#__standard_shipmentmethod_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_shipmentmethod_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `shipmentmethod_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_shipmentmethods.id',
  PRIMARY KEY (`catid`,`shipmentmethod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Table structure for table `#__standard_shipmentmethod_shoppergroups`
--
CREATE TABLE IF NOT EXISTS `#__standard_shipmentmethod_shoppergroups` (
    `shoppergroup_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `shipmentmethod_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`shoppergroup_id`, `shipmentmethod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='xref table for shipment to shoppergroup';

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_extras`
--
CREATE TABLE IF NOT EXISTS `#__standard_extras` (
    `id` int(10) UNSIGNED NOT NULL,
    `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `tax_id` int(10) NOT NULL DEFAULT '0',

    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the extra method',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `currency_id` int(10) UNSIGNED DEFAULT NULL,
    `price` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Extra Cost',
    `nbproducts_start` int(10) UNSIGNED NOT NULL COMMENT 'Minimum number of products',
    `nbproducts_stop` int(10) UNSIGNED NOT NULL COMMENT 'Maximum number of products',
    `orderamount_start` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount',
    `orderamount_stop` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Maximum order amount',
    `package_fee` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Package Fee',
    `free_extra` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount for Free Extra',

    `shared` tinyint(10) NOT NULL DEFAULT '1',
    `state` tinyint(3) NOT NULL DEFAULT '0',
    `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
    `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` int(10) NOT NULL DEFAULT '0',

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) NOT NULL DEFAULT '0',
    `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `checked_out` int(10) NOT NULL DEFAULT '0',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Extra created from the extra plugins';
--
-- Indexes for table `#__standard_extras`
--
ALTER TABLE `#__standard_extras`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_vendor_id` (`vendor_id`),
    ADD KEY `idx_tax_id` (`tax_id`),
    ADD KEY `idx_currency_id` (`currency_id`),
    ADD KEY `idx_ordering` (`ordering`),
    ADD KEY `idx_publish_up` (`publish_up`),
    ADD KEY `idx_publish_down` (`publish_down`),
    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_language` (`language`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_extras`
--
ALTER TABLE `#__standard_extras`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Table structure for table `#__standard_extra_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_extra_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `extra_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_extras.id',
  PRIMARY KEY (`catid`,`extra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Table structure for table `#__standard_extra_shoppergroups`
--
CREATE TABLE IF NOT EXISTS `#__standard_extra_shoppergroups` (
    `shoppergroup_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `extra_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`shoppergroup_id`, `extra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='xref table for extra to shoppergroup';

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_paymentmethods`
--
CREATE TABLE IF NOT EXISTS `#__standard_paymentmethods` (
    `id` int(10) UNSIGNED NOT NULL,
    `paymenttype_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `tax_id` int(10) NOT NULL DEFAULT '0',

    `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the payment method',
    `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
    `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `limit_days_deposit` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `limit_days_remaining` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `percent_or_total` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percent',
    `value` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT 'The Amount',

    `currency_id` int(10) UNSIGNED DEFAULT NULL,
    `price` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Payment Cost',
    `nbproducts_start` int(10) UNSIGNED NOT NULL COMMENT 'Minimum number of products',
    `nbproducts_stop` int(10) UNSIGNED NOT NULL COMMENT 'Maximum number of products',
    `orderamount_start` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount',
    `orderamount_stop` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Maximum order amount',
    `package_fee` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Package Fee',
    `free_paymentmethod` Decimal(15,5) NOT NULL DEFAULT '0' COMMENT 'Minimum order amount for Free paymentme thod',

    `shared` tinyint(10) NOT NULL DEFAULT '1',
    `state` tinyint(3) NOT NULL DEFAULT '0',
    `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Startdate if nothing is set = permanent',
    `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Enddate if nothing is set = permanent',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` int(10) NOT NULL DEFAULT '0',

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) NOT NULL DEFAULT '0',
    `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `checked_out` int(10) NOT NULL DEFAULT '0',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Payment created from the payment method plugins';
--
-- Indexes for table `#__standard_paymentmethods`
--
ALTER TABLE `#__standard_paymentmethods`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_paymenttype_id` (`paymenttype_id`),
    ADD KEY `idx_vendor_id` (`vendor_id`),
    ADD KEY `idx_tax_id` (`tax_id`),
    ADD KEY `idx_currency_id` (`currency_id`),
    ADD KEY `idx_ordering` (`ordering`),
    ADD KEY `idx_publish_up` (`publish_up`),
    ADD KEY `idx_publish_down` (`publish_down`),
    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_language` (`language`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_paymentmethods`
--
ALTER TABLE `#__standard_paymentmethods`
  MODIFY `id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Table structure for table `#__standard_paymentmethod_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_paymentmethod_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__categories.id',
  `paymentmethod_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_paymentmethods.id',
  PRIMARY KEY (`catid`,`paymentmethod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
--
-- Table structure for table `#__standard_paymentmethod_shoppergroups`
--
CREATE TABLE IF NOT EXISTS `#__standard_paymentmethod_shoppergroups` (
    `shoppergroup_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `paymentmethod_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (`shoppergroup_id`, `paymentmethod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='xref table for payment to shoppergroup';

-- --------------------------------------------------------
--
-- Table structure for table `#__standard_currencies`
--

CREATE TABLE `#__standard_currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `code_2` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_3` char(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numeric_code` int(4) DEFAULT NULL,
  `exchange_rate` decimal(20,10) DEFAULT NULL,
  `symbol` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimal_place` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `decimal_symbol` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thousands` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `positive_style` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negative_style` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` int(10) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '1',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store currencies';

--
-- Dumping data for table `#__standard_currencies`
--

INSERT INTO `#__standard_currencies` (`id`, `title`, `alias`, `code_2`, `code_3`, `numeric_code`, `exchange_rate`, `symbol`, `decimal_place`, `decimal_symbol`, `thousands`, `positive_style`, `negative_style`, `ordering`, `shared`, `state`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out_time`, `checked_out`, `language`, `access`) VALUES
(2, 'United Arab Emirates dirham', '', '', 'AED', 784, '0.0000000000', 'د.إ', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 83, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(4, 'Albanian lek', '', '', 'ALL', 8, '0.0000000000', 'Lek', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 111, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(5, 'Netherlands Antillean gulden', '', '', 'ANG', 532, '0.0000000000', 'ƒ', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 110, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(7, 'Argentine peso', '', '', 'ARS', 32, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 109, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(9, 'Australian dollar', '', '', 'AUD', 36, '0.0000000000', '$', '2', '.', '', '{symbol} {number}', '{sign}{symbol} {number}', 108, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(10, 'Aruban florin', '', '', 'AWG', 533, '0.0000000000', 'ƒ', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 107, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(11, 'Barbadian dollar', '', '', 'BBD', 52, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 106, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(12, 'Bangladeshi taka', '', '', 'BDT', 50, '0.0000000000', '৳', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 105, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(15, 'Bahraini dinar', '', '', 'BHD', 48, '0.0000000000', 'ب.د', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 104, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(16, 'Burundian franc', '', '', 'BIF', 108, '0.0000000000', 'Fr', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 112, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(17, 'Bermudian dollar', '', '', 'BMD', 60, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 113, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(18, 'Brunei dollar', '', '', 'BND', 96, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 121, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(19, 'Bolivian boliviano', '', '', 'BOB', 68, '0.0000000000', '$b', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 120, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(20, 'Brazilian real', '', '', 'BRL', 986, '0.0000000000', 'R$', '2', ',', '.', '{symbol} {number}', '{symbol} {sign}{number}', 119, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(21, 'Bahamian dollar', '', '', 'BSD', 44, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 118, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(22, 'Bhutanese ngultrum', '', '', 'BTN', 64, '0.0000000000', 'BTN', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 117, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(24, 'Botswana pula', '', '', 'BWP', 72, '0.0000000000', 'P', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 116, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(25, 'Belize dollar', '', '', 'BZD', 84, '0.0000000000', 'BZ$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 115, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(26, 'Canadian dollar', '', '', 'CAD', 124, '0.0000000000', '$', '2', '.', ',', '{symbol}{number}', '{symbol}{sign}{number}', 114, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(27, 'Swiss franc', '', '', 'CHF', 756, '0.0000000000', 'CHF', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 103, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(28, 'Unidad de Fomento', '', '', 'CLF', 990, '0.0000000000', 'CLF', '0', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 102, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(29, 'Chilean peso', '', '', 'CLP', 152, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 91, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(30, 'Chinese renminbi yuan', '', '', 'CNY', 156, '0.0000000000', '元', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 90, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(31, 'Colombian peso', '', '', 'COP', 170, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 89, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(32, 'Costa Rican colón', '', '', 'CRC', 188, '0.0000000000', '₡', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 88, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(33, 'Czech koruna', '', '', 'CZK', 203, '0.0000000000', 'Kč', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 87, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(34, 'Cuban peso', '', '', 'CUP', 192, '0.0000000000', '₱', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 86, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(35, 'Cape Verdean escudo', '', '', 'CVE', 132, '0.0000000000', '$', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 85, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(40, 'Danish krone', '', '', 'DKK', 208, '0.0000000000', 'kr', '2', '.', ',', '{symbol}{number}', '{symbol}{sign}{number}', 84, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(41, 'Dominican peso', '', '', 'DOP', 214, '0.0000000000', 'RD$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 92, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(42, 'Algerian dinar', '', '', 'DZD', 12, '0.0000000000', 'د.ج', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 93, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(44, 'Egyptian pound', '', '', 'EGP', 818, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 101, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(46, 'Ethiopian birr', '', '', 'ETB', 230, '0.0000000000', 'ETB', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 100, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(47, 'Euro', '', '', 'EUR', 978, '0.0000000000', '€', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 99, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(49, 'Fijian dollar', '', '', 'FJD', 242, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 98, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(50, 'Falkland pound', '', '', 'FKP', 238, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 97, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(52, 'British pound', '', '', 'GBP', 826, '0.0000000000', '£', '2', '.', ',', '{symbol}{number}', '{symbol}{sign}{number}', 96, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(54, 'Gibraltar pound', '', '', 'GIP', 292, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 95, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(55, 'Gambian dalasi', '', '', 'GMD', 270, '0.0000000000', 'D', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 94, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(56, 'Guinean franc', '', '', 'GNF', 324, '0.0000000000', 'Fr', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 122, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(58, 'Guatemalan quetzal', '', '', 'GTQ', 320, '0.0000000000', 'Q', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 123, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(60, 'Guyanese dollar', '', '', 'GYD', 328, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 124, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(61, 'Hong Kong dollar', '', '', 'HKD', 344, '0.0000000000', '元', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 152, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(62, 'Honduran lempira', '', '', 'HNL', 340, '0.0000000000', 'L', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 151, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(63, 'Haitian gourde', '', '', 'HTG', 332, '0.0000000000', 'G', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 150, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(64, 'Hungarian forint', '', '', 'HUF', 348, '0.0000000000', 'Ft', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 149, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(65, 'Indonesian rupiah', '', '', 'IDR', 360, '0.0000000000', 'Rp', '0', '', '', '{symbol}{number}', '{symbol}{sign}{number}', 148, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(67, 'Israeli new sheqel', '', '', 'ILS', 376, '0.0000000000', '₪', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 147, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(68, 'Indian rupee', '', '', 'INR', 356, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 146, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(69, 'Iraqi dinar', '', '', 'IQD', 368, '0.0000000000', 'ع.د', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 145, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(70, 'Iranian rial', '', '', 'IRR', 364, '0.0000000000', '﷼', '2', ',', '', '{number} {symbol}', '{sign}{number}{symb0l}', 153, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(73, 'Jamaican dollar', '', '', 'JMD', 388, '0.0000000000', 'J$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 154, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(74, 'Jordanian dinar', '', '', 'JOD', 400, '0.0000000000', 'د.ا', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 162, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(75, 'Japanese yen', '', '', 'JPY', 392, '0.0000000000', '¥', '0', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 161, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(76, 'Kenyan shilling', '', '', 'KES', 404, '0.0000000000', 'Sh', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 160, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(77, 'Cambodian riel', '', '', 'KHR', 116, '0.0000000000', '៛', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 159, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(78, 'Comorian franc', '', '', 'KMF', 174, '0.0000000000', 'Fr', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 158, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(79, 'North Korean won', '', '', 'KPW', 408, '0.0000000000', '₩', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 157, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(80, 'South Korean won', '', '', 'KRW', 410, '0.0000000000', '₩', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 156, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(81, 'Kuwaiti dinar', '', '', 'KWD', 414, '0.0000000000', 'د.ك', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 155, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(82, 'Cayman Islands dollar', '', '', 'KYD', 136, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 144, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(83, 'Lao kip', '', '', 'LAK', 418, '0.0000000000', '₭', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 143, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(84, 'Lebanese pound', '', '', 'LBP', 422, '0.0000000000', '£', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 132, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(85, 'Sri Lankan rupee', '', '', 'LKR', 144, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 131, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(86, 'Liberian dollar', '', '', 'LRD', 430, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 130, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(87, 'Lesotho loti', '', '', 'LSL', 426, '0.0000000000', 'L', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 129, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(89, 'Libyan dinar', '', '', 'LYD', 434, '0.0000000000', 'ل.د', '3', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 128, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(90, 'Moroccan dirham', '', '', 'MAD', 504, '0.0000000000', 'د.م.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 127, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(92, 'Mongolian tögrög', '', '', 'MNT', 496, '0.0000000000', '₮', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 126, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(93, 'Macanese pataca', '', '', 'MOP', 446, '0.0000000000', 'P', '1', ',', '', '{symbol}{number}', '{symbol}{sign}{number}', 125, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(94, 'Mauritanian ouguiya', '', '', 'MRO', 478, '0.0000000000', 'UM', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 133, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(96, 'Mauritian rupee', '', '', 'MUR', 480, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 134, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(97, 'Maldivian rufiyaa', '', '', 'MVR', 462, '0.0000000000', 'ރ.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 142, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(98, 'Malawian kwacha', '', '', 'MWK', 454, '0.0000000000', 'MK', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 141, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(100, 'Malaysian ringgit', '', '', 'MYR', 458, '0.0000000000', 'RM', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 140, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(102, 'Nigerian naira', '', '', 'NGN', 566, '0.0000000000', '₦', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 139, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(105, 'Norwegian krone', '', '', 'NOK', 578, '0.0000000000', 'kr', '2', ',', '', '{symbol}{number}', '{symbol}{sign}{number}', 138, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(106, 'Nepalese rupee', '', '', 'NPR', 524, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 137, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(107, 'New Zealand dollar', '', '', 'NZD', 554, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{symbol}{sign}{number}', 136, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(108, 'Omani rial', '', '', 'OMR', 512, '0.0000000000', '﷼', '3', '.', '', '{number} {symbol}', '{sign}{number} {symbol}', 135, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(109, 'Panamanian balboa', '', '', 'PAB', 590, '0.0000000000', 'B/.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 163, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(110, 'Peruvian nuevo sol', '', '', 'PEN', 604, '0.0000000000', 'S/.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 82, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(111, 'Papua New Guinean kina', '', '', 'PGK', 598, '0.0000000000', 'K', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 1, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(112, 'Philippine peso', '', '', 'PHP', 608, '0.0000000000', '₱', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 29, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(113, 'Pakistani rupee', '', '', 'PKR', 586, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 28, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(114, 'Polish Złoty', '', '', 'PLN', 985, '0.0000000000', 'zł', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 27, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(116, 'Paraguayan guaraní', '', '', 'PYG', 600, '0.0000000000', '₲', '0', '', '.', '{symbol} {number}', '{symbol} {sign}{number}', 26, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(117, 'Qatari riyal', '', '', 'QAR', 634, '0.0000000000', '﷼', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 25, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(118, 'Romanian leu', '', '', 'RON', 946, '0.0000000000', 'lei', '2', ',', '.', '{number} {symbol}', '{sign}{number} {symbol}', 24, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(119, 'Rwandan franc', '', '', 'RWF', 646, '0.0000000000', 'Fr', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 23, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(120, 'Saudi riyal', '', '', 'SAR', 682, '0.0000000000', '﷼', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 22, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(121, 'Solomon Islands dollar', '', '', 'SBD', 90, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 30, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(122, 'Seychellois rupee', '', '', 'SCR', 690, '0.0000000000', '₨', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 31, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(124, 'Swedish krona', '', '', 'SEK', 752, '0.0000000000', 'kr', '2', ',', '.', '{number} {symbol}', '{sign}{number} {symbol}', 39, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(125, 'Singapore dollar', '', '', 'SGD', 702, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 38, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(126, 'Saint Helenian pound', '', '', 'SHP', 654, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 37, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(127, 'Sierra Leonean leone', '', '', 'SLL', 694, '0.0000000000', 'Le', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 36, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(128, 'Somali shilling', '', '', 'SOS', 706, '0.0000000000', 'S', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 35, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(130, 'São Tomé and Príncipe dobra', '', '', 'STD', 678, '0.0000000000', 'Db', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 34, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(131, 'Russian ruble', '', '', 'RUB', 643, '0.0000000000', 'руб', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 33, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(132, 'Salvadoran colón', '', '', 'SVC', 222, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 32, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(133, 'Syrian pound', '', '', 'SYP', 760, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 21, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(134, 'Swazi lilangeni', '', '', 'SZL', 748, '0.0000000000', 'L', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 20, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(135, 'Thai baht', '', '', 'THB', 764, '0.0000000000', '฿', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 9, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(136, 'Tunisian dinar', '', '', 'TND', 788, '0.0000000000', 'د.ت', '3', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 8, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(137, 'Tongan paʻanga', '', '', 'TOP', 776, '0.0000000000', 'T$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 7, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(139, 'Türk Lirası', '', '', 'TRY', 949, '0.0000000000', 'TL', '2', ',', '.', '{number} {symbol}', '{sign}{number} {symbol}', 6, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(140, 'Trinidad and Tobago dollar', '', '', 'TTD', 780, '0.0000000000', 'TT$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 5, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(141, 'New Taiwan dollar', '', '', 'TWD', 901, '0.0000000000', 'NT$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 4, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(142, 'Tanzanian shilling', '', '', 'TZS', 834, '0.0000000000', 'Sh', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 3, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(144, 'United States dollar', '', '', 'USD', 840, '0.0000000000', '$', '2', '.', ',', '{symbol}{number}', '{symbol}{sign}{number}', 2, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(147, 'Vietnamese Dong', '', '', 'VND', 704, '0.0000000000', '₫', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 10, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(148, 'Vanuatu vatu', '', '', 'VUV', 548, '0.0000000000', 'Vt', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 11, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(149, 'Samoan tala', '', '', 'WST', 882, '0.0000000000', 'T', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 19, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(151, 'Yemeni rial', '', '', 'YER', 886, '0.0000000000', '﷼', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 18, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(152, 'Serbian dinar', '', '', 'RSD', 941, '0.0000000000', 'Дин.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 17, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(153, 'South African rand', '', '', 'ZAR', 710, '0.0000000000', 'R', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 16, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(154, 'Zambian kwacha', '', '', 'ZMK', 894, '0.0000000000', 'ZK', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 15, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(156, 'Zimbabwean dollar', '', '', 'ZWD', 932, '0.0000000000', 'Z$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 14, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(158, 'Armenian dram', '', '', 'AMD', 51, '0.0000000000', 'դր.', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 13, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(159, 'Myanmar kyat', '', '', 'MMK', 104, '0.0000000000', 'K', '2', ',', '', '{number} {symbol}', '{symbol} {sign}{number}', 12, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(160, 'Croatian kuna', '', '', 'HRK', 191, '0.0000000000', 'kn', '2', ',', '.', '{number} {symbol}', '{sign}{number} {symbol}', 40, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(161, 'Eritrean nakfa', '', '', 'ERN', 232, '0.0000000000', 'Nfk', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 41, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(162, 'Djiboutian franc', '', '', 'DJF', 262, '0.0000000000', 'Fr', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 42, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(163, 'Icelandic króna', '', '', 'ISK', 352, '0.0000000000', 'kr', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 70, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(164, 'Kazakhstani tenge', '', '', 'KZT', 398, '0.0000000000', 'лв', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 69, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(165, 'Kyrgyzstani som', '', '', 'KGS', 417, '0.0000000000', 'лв', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 68, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(166, 'Latvian lats', '', '', 'LVL', 428, '0.0000000000', 'Ls', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 67, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(167, 'Lithuanian litas', '', '', 'LTL', 440, '0.0000000000', 'Lt', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 66, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(168, 'Mexican peso', '', '', 'MXN', 484, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 65, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(169, 'Moldovan leu', '', '', 'MDL', 498, '0.0000000000', 'L', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 64, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(170, 'Namibian dollar', '', '', 'NAD', 516, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 63, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(171, 'Nicaraguan córdoba', '', '', 'NIO', 558, '0.0000000000', 'C$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 71, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(172, 'Ugandan shilling', '', '', 'UGX', 800, '0.0000000000', 'Sh', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 72, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(173, 'Macedonian denar', '', '', 'MKD', 807, '0.0000000000', 'ден', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 80, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(174, 'Uruguayan peso', '', '', 'UYU', 858, '0.0000000000', '$', '0', '', '', '{symbol}number}', '{symbol}{sign}{number}', 79, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(175, 'Uzbekistani som', '', '', 'UZS', 860, '0.0000000000', 'лв', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 78, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(176, 'Azerbaijani manat', '', '', 'AZN', 934, '0.0000000000', 'ман', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 77, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(177, 'Ghanaian cedi', '', '', 'GHS', 936, '0.0000000000', '₵', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 76, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(178, 'Venezuelan bolívar', '', '', 'VEF', 937, '0.0000000000', 'Bs', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 75, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(179, 'Sudanese pound', '', '', 'SDG', 938, '0.0000000000', '£', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 74, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(180, 'Uruguay Peso', '', '', 'UYI', 940, '0.0000000000', 'UYI', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 73, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(181, 'Mozambican metical', '', '', 'MZN', 943, '0.0000000000', 'MT', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 62, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(182, 'WIR Euro', '', '', 'CHE', 947, '0.0000000000', '€', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 61, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(183, 'WIR Franc', '', '', 'CHW', 948, '0.0000000000', 'CHW', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 50, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(184, 'Central African CFA franc', '', '', 'XAF', 950, '0.0000000000', 'Fr', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 49, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(185, 'East Caribbean dollar', '', '', 'XCD', 951, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 48, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(186, 'West African CFA franc', '', '', 'XOF', 952, '0.0000000000', 'Fr', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 47, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(187, 'CFP franc', '', '', 'XPF', 953, '0.0000000000', 'Fr', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 46, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(188, 'Surinamese dollar', '', '', 'SRD', 968, '0.0000000000', '$', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 45, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(189, 'Malagasy ariary', '', '', 'MGA', 969, '0.0000000000', 'MGA', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 44, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(190, 'Unidad de Valor Real', '', '', 'COU', 970, '0.0000000000', 'COU', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 43, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(191, 'Afghan afghani', '', '', 'AFN', 971, '0.0000000000', '؋', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 51, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(192, 'Tajikistani somoni', '', '', 'TJS', 972, '0.0000000000', 'ЅМ', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 52, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(193, 'Angolan kwanza', '', '', 'AOA', 973, '0.0000000000', 'Kz', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 60, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(194, 'Belarusian ruble', '', '', 'BYR', 974, '0.0000000000', 'p.', '0', '', '', '{number} {symbol}', '{sign}{number} {symbol}', 59, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(195, 'Bulgarian lev', '', '', 'BGN', 975, '0.0000000000', 'лв', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 58, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(196, 'Congolese franc', '', '', 'CDF', 976, '0.0000000000', 'Fr', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 57, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(197, 'Bosnia and Herzegovina convert', '', '', 'BAM', 977, '0.0000000000', 'KM', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 56, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(198, 'Mexican Unid', '', '', 'MXV', 979, '0.0000000000', 'MXV', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 55, 1, 1, '2017-01-11 23:00:00', 591, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '*', 0),
(199, 'Ukrainian hryvnia', 'ukrainian-hryvnia', '', 'UAH', 980, '0.0000000000', '₴', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 54, 1, 1, '2017-01-11 23:00:00', 591, '', '2017-01-17 00:53:12', 591, '0000-00-00 00:00:00', 0, '*', 1),
(200, 'Georgian lari', 'georgian-lari', '', 'GEL', 981, '0.0000000000', 'ლ', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 53, 1, 1, '2017-01-11 23:00:00', 591, '', '2017-01-17 00:52:18', 591, '0000-00-00 00:00:00', 0, '*', 1),
(201, 'Mvdol', 'mvdol', '', 'BOV', 984, '0.0000000000', 'BOV', '2', ',', '', '{number} {symbol}', '{sign}{number} {symbol}', 81, 1, 1, '2017-01-11 23:00:00', 591, '', '2017-01-17 01:42:26', 591, '0000-00-00 00:00:00', 0, '*', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_currencies`
--
ALTER TABLE `#__standard_currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency_code_3` (`code_3`),
  ADD KEY `ordering` (`ordering`),
  ADD KEY `currency_name` (`title`),
  ADD KEY `published` (`state`),
  ADD KEY `shared` (`shared`),
  ADD KEY `currency_numeric_code` (`numeric_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_currencies`
--
ALTER TABLE `#__standard_currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
-- --------------------------------------------------------

--
-- Table structure for table `#__standard_countries`
--

CREATE TABLE `#__standard_countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `code_3` char(3) DEFAULT NULL,
  `code_2` char(2) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Country records';

--
-- Dumping data for table `#__standard_countries`
--

INSERT INTO `#__standard_countries` (`id`, `title`, `code_3`, `code_2`, `ordering`, `state`, `created`, `created_by`, `modified`, `modified_by`, `checked_out_time`, `checked_out`) VALUES
(1, 'Afghanistan', 'AFG', 'AF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'Albania', 'ALB', 'AL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'Algeria', 'DZA', 'DZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(4, 'American Samoa', 'ASM', 'AS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(5, 'Andorra', 'AND', 'AD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(6, 'Angola', 'AGO', 'AO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(7, 'Anguilla', 'AIA', 'AI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(8, 'Antarctica', 'ATA', 'AQ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(9, 'Antigua and Barbuda', 'ATG', 'AG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(10, 'Argentina', 'ARG', 'AR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(11, 'Armenia', 'ARM', 'AM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(12, 'Aruba', 'ABW', 'AW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(13, 'Australia', 'AUS', 'AU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(14, 'Austria', 'AUT', 'AT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(15, 'Azerbaijan', 'AZE', 'AZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(16, 'Bahamas', 'BHS', 'BS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(17, 'Bahrain', 'BHR', 'BH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(18, 'Bangladesh', 'BGD', 'BD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(19, 'Barbados', 'BRB', 'BB', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(20, 'Belarus', 'BLR', 'BY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(21, 'Belgium', 'BEL', 'BE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(22, 'Belize', 'BLZ', 'BZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(23, 'Benin', 'BEN', 'BJ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(24, 'Bermuda', 'BMU', 'BM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(25, 'Bhutan', 'BTN', 'BT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(26, 'Bolivia', 'BOL', 'BO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(27, 'Bosnia and Herzegowina', 'BIH', 'BA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(28, 'Botswana', 'BWA', 'BW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(29, 'Bouvet Island', 'BVT', 'BV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(30, 'Brazil', 'BRA', 'BR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(31, 'British Indian Ocean Territory', 'IOT', 'IO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(32, 'Brunei Darussalam', 'BRN', 'BN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(33, 'Bulgaria', 'BGR', 'BG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(34, 'Burkina Faso', 'BFA', 'BF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(35, 'Burundi', 'BDI', 'BI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(36, 'Cambodia', 'KHM', 'KH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(37, 'Cameroon', 'CMR', 'CM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(38, 'Canada', 'CAN', 'CA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(39, 'Cape Verde', 'CPV', 'CV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(40, 'Cayman Islands', 'CYM', 'KY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(41, 'Central African Republic', 'CAF', 'CF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(42, 'Chad', 'TCD', 'TD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(43, 'Chile', 'CHL', 'CL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(44, 'China', 'CHN', 'CN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(45, 'Christmas Island', 'CXR', 'CX', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(46, 'Cocos (Keeling) Islands', 'CCK', 'CC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(47, 'Colombia', 'COL', 'CO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(48, 'Comoros', 'COM', 'KM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(49, 'Congo', 'COG', 'CG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(50, 'Cook Islands', 'COK', 'CK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(51, 'Costa Rica', 'CRI', 'CR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(52, 'Cote D''Ivoire', 'CIV', 'CI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(53, 'Croatia', 'HRV', 'HR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(54, 'Cuba', 'CUB', 'CU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(55, 'Cyprus', 'CYP', 'CY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(56, 'Czech Republic', 'CZE', 'CZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(57, 'Denmark', 'DNK', 'DK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(58, 'Djibouti', 'DJI', 'DJ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(59, 'Dominica', 'DMA', 'DM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(60, 'Dominican Republic', 'DOM', 'DO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(61, 'East Timor', 'TLS', 'TL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(62, 'Ecuador', 'ECU', 'EC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(63, 'Egypt', 'EGY', 'EG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(64, 'El Salvador', 'SLV', 'SV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(65, 'Equatorial Guinea', 'GNQ', 'GQ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(66, 'Eritrea', 'ERI', 'ER', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(67, 'Estonia', 'EST', 'EE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(68, 'Ethiopia', 'ETH', 'ET', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(69, 'Falkland Islands (Malvinas)', 'FLK', 'FK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(70, 'Faroe Islands', 'FRO', 'FO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(71, 'Fiji', 'FJI', 'FJ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(72, 'Finland', 'FIN', 'FI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(73, 'France', 'FRA', 'FR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(75, 'French Guiana', 'GUF', 'GF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(76, 'French Polynesia', 'PYF', 'PF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(77, 'French Southern Territories', 'ATF', 'TF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(78, 'Gabon', 'GAB', 'GA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(79, 'Gambia', 'GMB', 'GM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(80, 'Georgia', 'GEO', 'GE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(81, 'Germany', 'DEU', 'DE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(82, 'Ghana', 'GHA', 'GH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(83, 'Gibraltar', 'GIB', 'GI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(84, 'Greece', 'GRC', 'GR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(85, 'Greenland', 'GRL', 'GL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(86, 'Grenada', 'GRD', 'GD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(87, 'Guadeloupe', 'GLP', 'GP', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(88, 'Guam', 'GUM', 'GU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(89, 'Guatemala', 'GTM', 'GT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(90, 'Guinea', 'GIN', 'GN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(91, 'Guinea-bissau', 'GNB', 'GW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(92, 'Guyana', 'GUY', 'GY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(93, 'Haiti', 'HTI', 'HT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(94, 'Heard and Mc Donald Islands', 'HMD', 'HM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(95, 'Honduras', 'HND', 'HN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(96, 'Hong Kong', 'HKG', 'HK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(97, 'Hungary', 'HUN', 'HU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(98, 'Iceland', 'ISL', 'IS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(99, 'India', 'IND', 'IN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(100, 'Indonesia', 'IDN', 'ID', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(101, 'Iran (Islamic Republic of)', 'IRN', 'IR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(102, 'Iraq', 'IRQ', 'IQ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(103, 'Ireland', 'IRL', 'IE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(104, 'Israel', 'ISR', 'IL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(105, 'Italy', 'ITA', 'IT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(106, 'Jamaica', 'JAM', 'JM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(107, 'Japan', 'JPN', 'JP', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(108, 'Jordan', 'JOR', 'JO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(109, 'Kazakhstan', 'KAZ', 'KZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(110, 'Kenya', 'KEN', 'KE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(111, 'Kiribati', 'KIR', 'KI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(112, 'Korea, Democratic People''s Republic of', 'PRK', 'KP', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(113, 'Korea, Republic of', 'KOR', 'KR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(114, 'Kuwait', 'KWT', 'KW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(115, 'Kyrgyzstan', 'KGZ', 'KG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(116, 'Lao People''s Democratic Republic', 'LAO', 'LA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(117, 'Latvia', 'LVA', 'LV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(118, 'Lebanon', 'LBN', 'LB', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(119, 'Lesotho', 'LSO', 'LS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(120, 'Liberia', 'LBR', 'LR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(121, 'Libya', 'LBY', 'LY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(122, 'Liechtenstein', 'LIE', 'LI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(123, 'Lithuania', 'LTU', 'LT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(124, 'Luxembourg', 'LUX', 'LU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(125, 'Macau', 'MAC', 'MO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(126, 'Macedonia, The Former Yugoslav Republic of', 'MKD', 'MK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(127, 'Madagascar', 'MDG', 'MG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(128, 'Malawi', 'MWI', 'MW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(129, 'Malaysia', 'MYS', 'MY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(130, 'Maldives', 'MDV', 'MV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(131, 'Mali', 'MLI', 'ML', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(132, 'Malta', 'MLT', 'MT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(133, 'Marshall Islands', 'MHL', 'MH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(134, 'Martinique', 'MTQ', 'MQ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(135, 'Mauritania', 'MRT', 'MR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(136, 'Mauritius', 'MUS', 'MU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(137, 'Mayotte', 'MYT', 'YT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(138, 'Mexico', 'MEX', 'MX', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(139, 'Micronesia, Federated States of', 'FSM', 'FM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(140, 'Moldova, Republic of', 'MDA', 'MD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(141, 'Monaco', 'MCO', 'MC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(142, 'Mongolia', 'MNG', 'MN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(143, 'Montserrat', 'MSR', 'MS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(144, 'Morocco', 'MAR', 'MA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(145, 'Mozambique', 'MOZ', 'MZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(146, 'Myanmar', 'MMR', 'MM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(147, 'Namibia', 'NAM', 'NA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(148, 'Nauru', 'NRU', 'NR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(149, 'Nepal', 'NPL', 'NP', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(150, 'Netherlands', 'NLD', 'NL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(151, 'Netherlands Antilles', 'ANT', 'AN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(152, 'New Caledonia', 'NCL', 'NC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(153, 'New Zealand', 'NZL', 'NZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(154, 'Nicaragua', 'NIC', 'NI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(155, 'Niger', 'NER', 'NE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(156, 'Nigeria', 'NGA', 'NG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(157, 'Niue', 'NIU', 'NU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(158, 'Norfolk Island', 'NFK', 'NF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(159, 'Northern Mariana Islands', 'MNP', 'MP', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(160, 'Norway', 'NOR', 'NO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(161, 'Oman', 'OMN', 'OM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(162, 'Pakistan', 'PAK', 'PK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(163, 'Palau', 'PLW', 'PW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(164, 'Panama', 'PAN', 'PA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(165, 'Papua New Guinea', 'PNG', 'PG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(166, 'Paraguay', 'PRY', 'PY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(167, 'Peru', 'PER', 'PE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(168, 'Philippines', 'PHL', 'PH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(169, 'Pitcairn', 'PCN', 'PN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(170, 'Poland', 'POL', 'PL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(171, 'Portugal', 'PRT', 'PT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(172, 'Puerto Rico', 'PRI', 'PR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(173, 'Qatar', 'QAT', 'QA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(174, 'Reunion', 'REU', 'RE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(175, 'Romania', 'ROM', 'RO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(176, 'Russian Federation', 'RUS', 'RU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(177, 'Rwanda', 'RWA', 'RW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(178, 'Saint Kitts and Nevis', 'KNA', 'KN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(179, 'Saint Lucia', 'LCA', 'LC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(180, 'Saint Vincent and the Grenadines', 'VCT', 'VC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(181, 'Samoa', 'WSM', 'WS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(182, 'San Marino', 'SMR', 'SM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(183, 'Sao Tome and Principe', 'STP', 'ST', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(184, 'Saudi Arabia', 'SAU', 'SA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(185, 'Senegal', 'SEN', 'SN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(186, 'Seychelles', 'SYC', 'SC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(187, 'Sierra Leone', 'SLE', 'SL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(188, 'Singapore', 'SGP', 'SG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(189, 'Slovakia', 'SVK', 'SK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(190, 'Slovenia', 'SVN', 'SI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(191, 'Solomon Islands', 'SLB', 'SB', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(192, 'Somalia', 'SOM', 'SO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(193, 'South Africa', 'ZAF', 'ZA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(194, 'South Georgia and the South Sandwich Islands', 'SGS', 'GS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(195, 'Spain', 'ESP', 'ES', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(196, 'Sri Lanka', 'LKA', 'LK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(197, 'St. Helena', 'SHN', 'SH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(198, 'St. Pierre and Miquelon', 'SPM', 'PM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(199, 'Sudan', 'SDN', 'SD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(200, 'Suriname', 'SUR', 'SR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(201, 'Svalbard and Jan Mayen Islands', 'SJM', 'SJ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(202, 'Swaziland', 'SWZ', 'SZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(203, 'Sweden', 'SWE', 'SE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(204, 'Switzerland', 'CHE', 'CH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(205, 'Syrian Arab Republic', 'SYR', 'SY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(206, 'Taiwan', 'TWN', 'TW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(207, 'Tajikistan', 'TJK', 'TJ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(208, 'Tanzania, United Republic of', 'TZA', 'TZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(209, 'Thailand', 'THA', 'TH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(210, 'Togo', 'TGO', 'TG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(211, 'Tokelau', 'TKL', 'TK', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(212, 'Tonga', 'TON', 'TO', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(213, 'Trinidad and Tobago', 'TTO', 'TT', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(214, 'Tunisia', 'TUN', 'TN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(215, 'Turkey', 'TUR', 'TR', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(216, 'Turkmenistan', 'TKM', 'TM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(217, 'Turks and Caicos Islands', 'TCA', 'TC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(218, 'Tuvalu', 'TUV', 'TV', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(219, 'Uganda', 'UGA', 'UG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(220, 'Ukraine', 'UKR', 'UA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(221, 'United Arab Emirates', 'ARE', 'AE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(222, 'United Kingdom', 'GBR', 'GB', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(223, 'United States', 'USA', 'US', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(224, 'United States Minor Outlying Islands', 'UMI', 'UM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(225, 'Uruguay', 'URY', 'UY', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(226, 'Uzbekistan', 'UZB', 'UZ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(227, 'Vanuatu', 'VUT', 'VU', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(228, 'Vatican City State (Holy See)', 'VAT', 'VA', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(229, 'Venezuela', 'VEN', 'VE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(230, 'Viet Nam', 'VNM', 'VN', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(231, 'Virgin Islands (British)', 'VGB', 'VG', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(232, 'Virgin Islands (U.S.)', 'VIR', 'VI', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(233, 'Wallis and Futuna Islands', 'WLF', 'WF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(234, 'Western Sahara', 'ESH', 'EH', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(235, 'Yemen', 'YEM', 'YE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(237, 'The Democratic Republic of Congo', 'RCB', 'CD', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(238, 'Zambia', 'ZMB', 'ZM', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(239, 'Zimbabwe', 'ZWE', 'ZW', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(241, 'Jersey', 'JEY', 'JE', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(242, 'St. Barthelemy', 'BLM', 'BL', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(243, 'St. Eustatius', 'BES', 'BQ', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(244, 'Canary Islands', 'XCA', 'IC', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(245, 'Serbia', 'SRB', 'RS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(246, 'Sint Maarten (French Antilles)', 'MAF', 'MF', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(247, 'Sint Maarten (Netherlands Antilles)', 'SXM', 'SX', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(248, 'Palestinian Territory, occupied', 'PSE', 'PS', 0, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_countries`
--
ALTER TABLE `#__standard_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_code_3` (`code_3`),
  ADD KEY `idx_code_2` (`code_2`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_ordering` (`ordering`),
  ADD KEY `idx_state` (`state`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_countries`
--
ALTER TABLE `#__standard_countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;


-- --------------------------------------------------------

--
-- Table structure for table `#__standard_states`
--

CREATE TABLE `#__standard_states` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(155) DEFAULT NULL,
  `code_3` char(3) DEFAULT NULL,
  `code_2` char(2) DEFAULT NULL,
  `ordering` int(10) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '1',
  `state` tinyint(3) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `language` char(7) CHARACTER SET utf8mb4 NOT NULL,
  `locked` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locked_by` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='States that are assigned to a country';

--
-- Dumping data for table `#__standard_states`
--

INSERT INTO `#__standard_states` (`id`, `country_id`, `title`, `code_3`, `code_2`, `ordering`, `shared`, `state`, `created`, `created_by`, `modified`, `modified_by`, `checked_out_time`, `checked_out`, `language`, `locked`, `locked_by`) VALUES
(1, 223, 'Alabama', 'ALA', 'AL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(2, 223, 'Alaska', 'ALK', 'AK', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(3, 223, 'Arizona', 'ARZ', 'AZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(4, 223, 'Arkansas', 'ARK', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(5, 223, 'California', 'CAL', 'CA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(6, 223, 'Colorado', 'COL', 'CO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(7, 223, 'Connecticut', 'CCT', 'CT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(8, 223, 'Delaware', 'DEL', 'DE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(9, 223, 'District Of Columbia', 'DOC', 'DC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(10, 223, 'Florida', 'FLO', 'FL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(11, 223, 'Georgia', 'GEA', 'GA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(12, 223, 'Hawaii', 'HWI', 'HI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(13, 223, 'Idaho', 'IDA', 'ID', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(14, 223, 'Illinois', 'ILL', 'IL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(15, 223, 'Indiana', 'IND', 'IN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(16, 223, 'Iowa', 'IOA', 'IA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(17, 223, 'Kansas', 'KAS', 'KS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(18, 223, 'Kentucky', 'KTY', 'KY', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(19, 223, 'Louisiana', 'LOA', 'LA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(20, 223, 'Maine', 'MAI', 'ME', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(21, 223, 'Maryland', 'MLD', 'MD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(22, 223, 'Massachusetts', 'MSA', 'MA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(23, 223, 'Michigan', 'MIC', 'MI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(24, 223, 'Minnesota', 'MIN', 'MN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(25, 223, 'Mississippi', 'MIS', 'MS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(26, 223, 'Missouri', 'MIO', 'MO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(27, 223, 'Montana', 'MOT', 'MT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(28, 223, 'Nebraska', 'NEB', 'NE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(29, 223, 'Nevada', 'NEV', 'NV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(30, 223, 'New Hampshire', 'NEH', 'NH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(31, 223, 'New Jersey', 'NEJ', 'NJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(32, 223, 'New Mexico', 'NEM', 'NM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(33, 223, 'New York', 'NEY', 'NY', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(34, 223, 'North Carolina', 'NOC', 'NC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(35, 223, 'North Dakota', 'NOD', 'ND', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(36, 223, 'Ohio', 'OHI', 'OH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(37, 223, 'Oklahoma', 'OKL', 'OK', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(38, 223, 'Oregon', 'ORN', 'OR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(39, 223, 'Pennsylvania', 'PEA', 'PA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(40, 223, 'Rhode Island', 'RHI', 'RI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(41, 223, 'South Carolina', 'SOC', 'SC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(42, 223, 'South Dakota', 'SOD', 'SD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(43, 223, 'Tennessee', 'TEN', 'TN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(44, 223, 'Texas', 'TXS', 'TX', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(45, 223, 'Utah', 'UTA', 'UT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(46, 223, 'Vermont', 'VMT', 'VT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(47, 223, 'Virginia', 'VIA', 'VA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(48, 223, 'Washington', 'WAS', 'WA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(49, 223, 'West Virginia', 'WEV', 'WV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(50, 223, 'Wisconsin', 'WIS', 'WI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(51, 223, 'Wyoming', 'WYO', 'WY', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(52, 38, 'Alberta', 'ALB', 'AB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(53, 38, 'British Columbia', 'BRC', 'BC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(54, 38, 'Manitoba', 'MAB', 'MB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(55, 38, 'New Brunswick', 'NEB', 'NB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(56, 38, 'Newfoundland and Labrador', 'NFL', 'NL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(57, 38, 'Northwest Territories', 'NWT', 'NT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(58, 38, 'Nova Scotia', 'NOS', 'NS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(59, 38, 'Nunavut', 'NUT', 'NU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(60, 38, 'Ontario', 'ONT', 'ON', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(61, 38, 'Prince Edward Island', 'PEI', 'PE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(62, 38, 'Quebec', 'QEC', 'QC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(63, 38, 'Saskatchewan', 'SAK', 'SK', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(64, 38, 'Yukon', 'YUT', 'YT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(65, 222, 'England', 'ENG', 'EN', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(66, 222, 'Northern Ireland', 'NOI', 'NI', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(67, 222, 'Scotland', 'SCO', 'SD', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(68, 222, 'Wales', 'WLS', 'WS', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(69, 13, 'Australian Capital Territory', 'ACT', 'AC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(70, 13, 'New South Wales', 'NSW', 'NS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(71, 13, 'Northern Territory', 'NOT', 'NT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(72, 13, 'Queensland', 'QLD', 'QL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(73, 13, 'South Australia', 'SOA', 'SA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(74, 13, 'Tasmania', 'TAS', 'TS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(75, 13, 'Victoria', 'VIC', 'VI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(76, 13, 'Western Australia', 'WEA', 'WA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(77, 138, 'Aguascalientes', 'AGS', 'AG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(78, 138, 'Baja California Norte', 'BCN', 'BN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(79, 138, 'Baja California Sur', 'BCS', 'BS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(80, 138, 'Campeche', 'CAM', 'CA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(81, 138, 'Chiapas', 'CHI', 'CS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(82, 138, 'Chihuahua', 'CHA', 'CH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(83, 138, 'Coahuila', 'COA', 'CO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(84, 138, 'Colima', 'COL', 'CM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(85, 138, 'Distrito Federal', 'DFM', 'DF', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(86, 138, 'Durango', 'DGO', 'DO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(87, 138, 'Guanajuato', 'GTO', 'GO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(88, 138, 'Guerrero', 'GRO', 'GU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(89, 138, 'Hidalgo', 'HGO', 'HI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(90, 138, 'Jalisco', 'JAL', 'JA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(91, 138, 'M', 'EDM', 'EM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(92, 138, 'Michoac', 'MCN', 'MI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(93, 138, 'Morelos', 'MOR', 'MO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(94, 138, 'Nayarit', 'NAY', 'NY', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(95, 138, 'Nuevo Le', 'NUL', 'NL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(96, 138, 'Oaxaca', 'OAX', 'OA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(97, 138, 'Puebla', 'PUE', 'PU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(98, 138, 'Quer', 'QRO', 'QU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(99, 138, 'Quintana Roo', 'QUR', 'QR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(100, 138, 'San Luis Potos', 'SLP', 'SP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(101, 138, 'Sinaloa', 'SIN', 'SI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(102, 138, 'Sonora', 'SON', 'SO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(103, 138, 'Tabasco', 'TAB', 'TA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(104, 138, 'Tamaulipas', 'TAM', 'TM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(105, 138, 'Tlaxcala', 'TLX', 'TX', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(106, 138, 'Veracruz', 'VER', 'VZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(107, 138, 'Yucat', 'YUC', 'YU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(108, 138, 'Zacatecas', 'ZAC', 'ZA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(109, 30, 'Acre', 'ACR', 'AC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(110, 30, 'Alagoas', 'ALG', 'AL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(111, 30, 'Amapá', 'AMP', 'AP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(112, 30, 'Amazonas', 'AMZ', 'AM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(113, 30, 'Bahía', 'BAH', 'BA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(114, 30, 'Ceará', 'CEA', 'CE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(115, 30, 'Distrito Federal', 'DFB', 'DF', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(116, 30, 'Espírito Santo', 'ESS', 'ES', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(117, 30, 'Goiás', 'GOI', 'GO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(118, 30, 'Maranhão', 'MAR', 'MA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(119, 30, 'Mato Grosso', 'MAT', 'MT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(120, 30, 'Mato Grosso do Sul', 'MGS', 'MS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(121, 30, 'Minas Gerais', 'MIG', 'MG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(122, 30, 'Paraná', 'PAR', 'PR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(123, 30, 'Paraíba', 'PRB', 'PB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(124, 30, 'Pará', 'PAB', 'PA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(125, 30, 'Pernambuco', 'PER', 'PE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(126, 30, 'Piauí', 'PIA', 'PI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(127, 30, 'Rio Grande do Norte', 'RGN', 'RN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(128, 30, 'Rio Grande do Sul', 'RGS', 'RS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(129, 30, 'Rio de Janeiro', 'RDJ', 'RJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(130, 30, 'Rondônia', 'RON', 'RO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(131, 30, 'Roraima', 'ROR', 'RR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(132, 30, 'Santa Catarina', 'SAC', 'SC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(133, 30, 'Sergipe', 'SER', 'SE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(134, 30, 'São Paulo', 'SAP', 'SP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(135, 30, 'Tocantins', 'TOC', 'TO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(136, 44, 'Anhui', 'ANH', '34', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(137, 44, 'Beijing', 'BEI', '11', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(138, 44, 'Chongqing', 'CHO', '50', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(139, 44, 'Fujian', 'FUJ', '35', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(140, 44, 'Gansu', 'GAN', '62', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(141, 44, 'Guangdong', 'GUA', '44', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(142, 44, 'Guangxi Zhuang', 'GUZ', '45', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(143, 44, 'Guizhou', 'GUI', '52', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(144, 44, 'Hainan', 'HAI', '46', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(145, 44, 'Hebei', 'HEB', '13', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(146, 44, 'Heilongjiang', 'HEI', '23', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(147, 44, 'Henan', 'HEN', '41', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(148, 44, 'Hubei', 'HUB', '42', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(149, 44, 'Hunan', 'HUN', '43', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(150, 44, 'Jiangsu', 'JIA', '32', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(151, 44, 'Jiangxi', 'JIX', '36', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(152, 44, 'Jilin', 'JIL', '22', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(153, 44, 'Liaoning', 'LIA', '21', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(154, 44, 'Nei Mongol', 'NML', '15', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(155, 44, 'Ningxia Hui', 'NIH', '64', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(156, 44, 'Qinghai', 'QIN', '63', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(157, 44, 'Shandong', 'SNG', '37', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(158, 44, 'Shanghai', 'SHH', '31', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(159, 44, 'Shaanxi', 'SHX', '61', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(160, 44, 'Sichuan', 'SIC', '51', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(161, 44, 'Tianjin', 'TIA', '12', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(162, 44, 'Xinjiang Uygur', 'XIU', '65', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(163, 44, 'Xizang', 'XIZ', '54', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(164, 44, 'Yunnan', 'YUN', '53', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(165, 44, 'Zhejiang', 'ZHE', '33', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(166, 104, 'Israel', 'ISL', 'IL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(167, 104, 'Gaza Strip', 'GZS', 'GZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(168, 104, 'West Bank', 'WBK', 'WB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(169, 151, 'St. Maarten', 'STM', 'SM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(170, 151, 'Bonaire', 'BNR', 'BN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(171, 151, 'Curacao', 'CUR', 'CR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(172, 175, 'Alba', 'ABA', 'AB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(173, 175, 'Arad', 'ARD', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(174, 175, 'Arges', 'ARG', 'AG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(175, 175, 'Bacau', 'BAC', 'BC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(176, 175, 'Bihor', 'BIH', 'BH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(177, 175, 'Bistrita-Nasaud', 'BIS', 'BN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(178, 175, 'Botosani', 'BOT', 'BT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(179, 175, 'Braila', 'BRL', 'BR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(180, 175, 'Brasov', 'BRA', 'BV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(181, 175, 'Bucuresti', 'BUC', 'B', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(182, 175, 'Buzau', 'BUZ', 'BZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(183, 175, 'Calarasi', 'CAL', 'CL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(184, 175, 'Caras Severin', 'CRS', 'CS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(185, 175, 'Cluj', 'CLJ', 'CJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(186, 175, 'Constanta', 'CST', 'CT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(187, 175, 'Covasna', 'COV', 'CV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(188, 175, 'Dambovita', 'DAM', 'DB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(189, 175, 'Dolj', 'DLJ', 'DJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(190, 175, 'Galati', 'GAL', 'GL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(191, 175, 'Giurgiu', 'GIU', 'GR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(192, 175, 'Gorj', 'GOR', 'GJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(193, 175, 'Hargita', 'HRG', 'HR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(194, 175, 'Hunedoara', 'HUN', 'HD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(195, 175, 'Ialomita', 'IAL', 'IL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(196, 175, 'Iasi', 'IAS', 'IS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(197, 175, 'Ilfov', 'ILF', 'IF', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(198, 175, 'Maramures', 'MAR', 'MM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(199, 175, 'Mehedinti', 'MEH', 'MH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(200, 175, 'Mures', 'MUR', 'MS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(201, 175, 'Neamt', 'NEM', 'NT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(202, 175, 'Olt', 'OLT', 'OT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(203, 175, 'Prahova', 'PRA', 'PH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(204, 175, 'Salaj', 'SAL', 'SJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(205, 175, 'Satu Mare', 'SAT', 'SM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(206, 175, 'Sibiu', 'SIB', 'SB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(207, 175, 'Suceava', 'SUC', 'SV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(208, 175, 'Teleorman', 'TEL', 'TR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(209, 175, 'Timis', 'TIM', 'TM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(210, 175, 'Tulcea', 'TUL', 'TL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(211, 175, 'Valcea', 'VAL', 'VL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(212, 175, 'Vaslui', 'VAS', 'VS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(213, 175, 'Vrancea', 'VRA', 'VN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(214, 105, 'Agrigento', 'AGR', 'AG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(215, 105, 'Alessandria', 'ALE', 'AL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(216, 105, 'Ancona', 'ANC', 'AN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(217, 105, 'Aosta', 'AOS', 'AO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(218, 105, 'Arezzo', 'ARE', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(219, 105, 'Ascoli Piceno', 'API', 'AP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(220, 105, 'Asti', 'AST', 'AT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(221, 105, 'Avellino', 'AVE', 'AV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(222, 105, 'Bari', 'BAR', 'BA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(223, 105, 'Belluno', 'BEL', 'BL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(224, 105, 'Benevento', 'BEN', 'BN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(225, 105, 'Bergamo', 'BEG', 'BG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(226, 105, 'Biella', 'BIE', 'BI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(227, 105, 'Bologna', 'BOL', 'BO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(228, 105, 'Bolzano', 'BOZ', 'BZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(229, 105, 'Brescia', 'BRE', 'BS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(230, 105, 'Brindisi', 'BRI', 'BR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(231, 105, 'Cagliari', 'CAG', 'CA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(232, 105, 'Caltanissetta', 'CAL', 'CL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(233, 105, 'Campobasso', 'CBO', 'CB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(234, 105, 'Carbonia-Iglesias', 'CAR', 'CI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(235, 105, 'Caserta', 'CAS', 'CE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(236, 105, 'Catania', 'CAT', 'CT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(237, 105, 'Catanzaro', 'CTZ', 'CZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(238, 105, 'Chieti', 'CHI', 'CH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(239, 105, 'Como', 'COM', 'CO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(240, 105, 'Cosenza', 'COS', 'CS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(241, 105, 'Cremona', 'CRE', 'CR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(242, 105, 'Crotone', 'CRO', 'KR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(243, 105, 'Cuneo', 'CUN', 'CN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(244, 105, 'Enna', 'ENN', 'EN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(245, 105, 'Ferrara', 'FER', 'FE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(246, 105, 'Firenze', 'FIR', 'FI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(247, 105, 'Foggia', 'FOG', 'FG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(248, 105, 'Forli-Cesena', 'FOC', 'FC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(249, 105, 'Frosinone', 'FRO', 'FR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(250, 105, 'Genova', 'GEN', 'GE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(251, 105, 'Gorizia', 'GOR', 'GO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(252, 105, 'Grosseto', 'GRO', 'GR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(253, 105, 'Imperia', 'IMP', 'IM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(254, 105, 'Isernia', 'ISE', 'IS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(255, 105, 'L''Aquila', 'AQU', 'AQ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(256, 105, 'La Spezia', 'LAS', 'SP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(257, 105, 'Latina', 'LAT', 'LT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(258, 105, 'Lecce', 'LEC', 'LE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(259, 105, 'Lecco', 'LCC', 'LC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(260, 105, 'Livorno', 'LIV', 'LI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(261, 105, 'Lodi', 'LOD', 'LO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(262, 105, 'Lucca', 'LUC', 'LU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(263, 105, 'Macerata', 'MAC', 'MC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(264, 105, 'Mantova', 'MAN', 'MN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(265, 105, 'Massa-Carrara', 'MAS', 'MS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(266, 105, 'Matera', 'MAA', 'MT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(267, 105, 'Medio Campidano', 'MED', 'VS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(268, 105, 'Messina', 'MES', 'ME', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(269, 105, 'Milano', 'MIL', 'MI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(270, 105, 'Modena', 'MOD', 'MO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(271, 105, 'Napoli', 'NAP', 'NA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(272, 105, 'Novara', 'NOV', 'NO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(273, 105, 'Nuoro', 'NUR', 'NU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(274, 105, 'Ogliastra', 'OGL', 'OG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(275, 105, 'Olbia-Tempio', 'OLB', 'OT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(276, 105, 'Oristano', 'ORI', 'OR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(277, 105, 'Padova', 'PDA', 'PD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(278, 105, 'Palermo', 'PAL', 'PA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(279, 105, 'Parma', 'PAA', 'PR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(280, 105, 'Pavia', 'PAV', 'PV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(281, 105, 'Perugia', 'PER', 'PG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(282, 105, 'Pesaro e Urbino', 'PES', 'PU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(283, 105, 'Pescara', 'PSC', 'PE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(284, 105, 'Piacenza', 'PIA', 'PC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(285, 105, 'Pisa', 'PIS', 'PI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(286, 105, 'Pistoia', 'PIT', 'PT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(287, 105, 'Pordenone', 'POR', 'PN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(288, 105, 'Potenza', 'PTZ', 'PZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(289, 105, 'Prato', 'PRA', 'PO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(290, 105, 'Ragusa', 'RAG', 'RG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(291, 105, 'Ravenna', 'RAV', 'RA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(292, 105, 'Reggio Calabria', 'REG', 'RC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(293, 105, 'Reggio Emilia', 'REE', 'RE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(294, 105, 'Rieti', 'RIE', 'RI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(295, 105, 'Rimini', 'RIM', 'RN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(296, 105, 'Roma', 'ROM', 'RM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(297, 105, 'Rovigo', 'ROV', 'RO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(298, 105, 'Salerno', 'SAL', 'SA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(299, 105, 'Sassari', 'SAS', 'SS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(300, 105, 'Savona', 'SAV', 'SV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(301, 105, 'Siena', 'SIE', 'SI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(302, 105, 'Siracusa', 'SIR', 'SR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(303, 105, 'Sondrio', 'SOO', 'SO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(304, 105, 'Taranto', 'TAR', 'TA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(305, 105, 'Teramo', 'TER', 'TE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(306, 105, 'Terni', 'TRN', 'TR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(307, 105, 'Torino', 'TOR', 'TO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(308, 105, 'Trapani', 'TRA', 'TP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(309, 105, 'Trento', 'TRE', 'TN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(310, 105, 'Treviso', 'TRV', 'TV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(311, 105, 'Trieste', 'TRI', 'TS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(312, 105, 'Udine', 'UDI', 'UD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(313, 105, 'Varese', 'VAR', 'VA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(314, 105, 'Venezia', 'VEN', 'VE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(315, 105, 'Verbano Cusio Ossola', 'VCO', 'VB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(316, 105, 'Vercelli', 'VER', 'VC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(317, 105, 'Verona', 'VRN', 'VR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(318, 105, 'Vibo Valenzia', 'VIV', 'VV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(319, 105, 'Vicenza', 'VII', 'VI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(320, 105, 'Viterbo', 'VIT', 'VT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(321, 195, 'A Coru', 'ACO', '15', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(322, 195, 'Alava', 'ALA', '01', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(323, 195, 'Albacete', 'ALB', '02', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0);
INSERT INTO `#__standard_states` (`id`, `country_id`, `title`, `code_3`, `code_2`, `ordering`, `shared`, `state`, `created`, `created_by`, `modified`, `modified_by`, `checked_out_time`, `checked_out`, `language`, `locked`, `locked_by`) VALUES
(324, 195, 'Alicante', 'ALI', '03', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(325, 195, 'Almeria', 'ALM', '04', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(326, 195, 'Asturias', 'AST', '33', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(327, 195, 'Avila', 'AVI', '05', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(328, 195, 'Badajoz', 'BAD', '06', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(329, 195, 'Baleares', 'BAL', '07', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(330, 195, 'Barcelona', 'BAR', '08', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(331, 195, 'Burgos', 'BUR', '09', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(332, 195, 'Caceres', 'CAC', '10', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(333, 195, 'Cadiz', 'CAD', '11', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(334, 195, 'Cantabria', 'CAN', '39', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(335, 195, 'Castellon', 'CAS', '12', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(336, 195, 'Ceuta', 'CEU', '51', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(337, 195, 'Ciudad Real', 'CIU', '13', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(338, 195, 'Cordoba', 'COR', '14', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(339, 195, 'Cuenca', 'CUE', '16', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(340, 195, 'Girona', 'GIR', '17', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(341, 195, 'Granada', 'GRA', '18', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(342, 195, 'Guadalajara', 'GUA', '19', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(343, 195, 'Guipuzcoa', 'GUI', '20', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(344, 195, 'Huelva', 'HUL', '21', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(345, 195, 'Huesca', 'HUS', '22', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(346, 195, 'Jaen', 'JAE', '23', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(347, 195, 'La Rioja', 'LRI', '26', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(348, 195, 'Las Palmas', 'LPA', '35', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(349, 195, 'Leon', 'LEO', '24', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(350, 195, 'Lleida', 'LLE', '25', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(351, 195, 'Lugo', 'LUG', '27', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(352, 195, 'Madrid', 'MAD', '28', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(353, 195, 'Malaga', 'MAL', '29', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(354, 195, 'Melilla', 'MEL', '52', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(355, 195, 'Murcia', 'MUR', '30', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(356, 195, 'Navarra', 'NAV', '31', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(357, 195, 'Ourense', 'OUR', '32', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(358, 195, 'Palencia', 'PAL', '34', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(359, 195, 'Pontevedra', 'PON', '36', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(360, 195, 'Salamanca', 'SAL', '37', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(361, 195, 'Santa Cruz de Tenerife', 'SCT', '38', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(362, 195, 'Segovia', 'SEG', '40', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(363, 195, 'Sevilla', 'SEV', '41', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(364, 195, 'Soria', 'SOR', '42', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(365, 195, 'Tarragona', 'TAR', '43', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(366, 195, 'Teruel', 'TER', '44', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(367, 195, 'Toledo', 'TOL', '45', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(368, 195, 'Valencia', 'VAL', '46', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(369, 195, 'Valladolid', 'VLL', '47', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(370, 195, 'Vizcaya', 'VIZ', '48', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(371, 195, 'Zamora', 'ZAM', '49', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(372, 195, 'Zaragoza', 'ZAR', '50', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(373, 10, 'Buenos Aires', 'BAS', 'BA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(374, 10, 'Ciudad Autonoma De Buenos Aires', 'CBA', 'CB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(375, 10, 'Catamarca', 'CAT', 'CA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(376, 10, 'Chaco', 'CHO', 'CH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(377, 10, 'Chubut', 'CTT', 'CT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(378, 10, 'Cordoba', 'COD', 'CO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(379, 10, 'Corrientes', 'CRI', 'CR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(380, 10, 'Entre Rios', 'ERS', 'ER', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(381, 10, 'Formosa', 'FRM', 'FR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(382, 10, 'Jujuy', 'JUJ', 'JU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(383, 10, 'La Pampa', 'LPM', 'LP', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(384, 10, 'La Rioja', 'LRI', 'LR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(385, 10, 'Mendoza', 'MED', 'ME', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(386, 10, 'Misiones', 'MIS', 'MI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(387, 10, 'Neuquen', 'NQU', 'NQ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(388, 10, 'Rio Negro', 'RNG', 'RN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(389, 10, 'Salta', 'SAL', 'SA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(390, 10, 'San Juan', 'SJN', 'SJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(391, 10, 'San Luis', 'SLU', 'SL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(392, 10, 'Santa Cruz', 'SCZ', 'SC', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(393, 10, 'Santa Fe', 'SFE', 'SF', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(394, 10, 'Santiago Del Estero', 'SEN', 'SE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(395, 10, 'Tierra Del Fuego', 'TFE', 'TF', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(396, 10, 'Tucuman', 'TUC', 'TU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(397, 11, 'Aragatsotn', 'ARG', 'AG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(398, 11, 'Ararat', 'ARR', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(399, 11, 'Armavir', 'ARM', 'AV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(400, 11, 'Gegharkunik', 'GEG', 'GR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(401, 11, 'Kotayk', 'KOT', 'KT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(402, 11, 'Lori', 'LOR', 'LO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(403, 11, 'Shirak', 'SHI', 'SH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(404, 11, 'Syunik', 'SYU', 'SU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(405, 11, 'Tavush', 'TAV', 'TV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(406, 11, 'Vayots-Dzor', 'VAD', 'VD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(407, 11, 'Yerevan', 'YER', 'ER', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(408, 99, 'Andaman & Nicobar Islands', 'ANI', 'AI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(409, 99, 'Andhra Pradesh', 'AND', 'AN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(410, 99, 'Arunachal Pradesh', 'ARU', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(411, 99, 'Assam', 'ASS', 'AS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(412, 99, 'Bihar', 'BIH', 'BI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(413, 99, 'Chandigarh', 'CHA', 'CA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(414, 99, 'Chhatisgarh', 'CHH', 'CH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(415, 99, 'Dadra & Nagar Haveli', 'DAD', 'DD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(416, 99, 'Daman & Diu', 'DAM', 'DA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(417, 99, 'Delhi', 'DEL', 'DE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(418, 99, 'Goa', 'GOA', 'GO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(419, 99, 'Gujarat', 'GUJ', 'GU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(420, 99, 'Haryana', 'HAR', 'HA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(421, 99, 'Himachal Pradesh', 'HIM', 'HI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(422, 99, 'Jammu & Kashmir', 'JAM', 'JA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(423, 99, 'Jharkhand', 'JHA', 'JH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(424, 99, 'Karnataka', 'KAR', 'KA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(425, 99, 'Kerala', 'KER', 'KE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(426, 99, 'Lakshadweep', 'LAK', 'LA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(427, 99, 'Madhya Pradesh', 'MAD', 'MD', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(428, 99, 'Maharashtra', 'MAH', 'MH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(429, 99, 'Manipur', 'MAN', 'MN', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(430, 99, 'Meghalaya', 'MEG', 'ME', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(431, 99, 'Mizoram', 'MIZ', 'MI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(432, 99, 'Nagaland', 'NAG', 'NA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(433, 99, 'Orissa', 'ORI', 'OR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(434, 99, 'Pondicherry', 'PON', 'PO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(435, 99, 'Punjab', 'PUN', 'PU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(436, 99, 'Rajasthan', 'RAJ', 'RA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(437, 99, 'Sikkim', 'SIK', 'SI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(438, 99, 'Tamil Nadu', 'TAM', 'TA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(439, 99, 'Tripura', 'TRI', 'TR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(440, 99, 'Uttaranchal', 'UAR', 'UA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(441, 99, 'Uttar Pradesh', 'UTT', 'UT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(442, 99, 'West Bengal', 'WES', 'WE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(443, 101, 'Ahmadi va Kohkiluyeh', 'BOK', 'BO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(444, 101, 'Ardabil', 'ARD', 'AR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(445, 101, 'Azarbayjan-e Gharbi', 'AZG', 'AG', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(446, 101, 'Azarbayjan-e Sharqi', 'AZS', 'AS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(447, 101, 'Bushehr', 'BUS', 'BU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(448, 101, 'Chaharmahal va Bakhtiari', 'CMB', 'CM', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(449, 101, 'Esfahan', 'ESF', 'ES', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(450, 101, 'Fars', 'FAR', 'FA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(451, 101, 'Gilan', 'GIL', 'GI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(452, 101, 'Gorgan', 'GOR', 'GO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(453, 101, 'Hamadan', 'HAM', 'HA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(454, 101, 'Hormozgan', 'HOR', 'HO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(455, 101, 'Ilam', 'ILA', 'IL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(456, 101, 'Kerman', 'KER', 'KE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(457, 101, 'Kermanshah', 'BAK', 'BA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(458, 101, 'Khorasan-e Junoubi', 'KHJ', 'KJ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(459, 101, 'Khorasan-e Razavi', 'KHR', 'KR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(460, 101, 'Khorasan-e Shomali', 'KHS', 'KS', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(461, 101, 'Khuzestan', 'KHU', 'KH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(462, 101, 'Kordestan', 'KOR', 'KO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(463, 101, 'Lorestan', 'LOR', 'LO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(464, 101, 'Markazi', 'MAR', 'MR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(465, 101, 'Mazandaran', 'MAZ', 'MZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(466, 101, 'Qazvin', 'QAS', 'QA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(467, 101, 'Qom', 'QOM', 'QO', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(468, 101, 'Semnan', 'SEM', 'SE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(469, 101, 'Sistan va Baluchestan', 'SBA', 'SB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(470, 101, 'Tehran', 'TEH', 'TE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(471, 101, 'Yazd', 'YAZ', 'YA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(472, 101, 'Zanjan', 'ZAN', 'ZA', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(535, 84, 'ΛΕΥΚΑΔΑΣ', 'ΛΕΥ', 'ΛΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(532, 84, 'ΛΑΡΙΣΑΣ', 'ΛΑΡ', 'ΛΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(504, 84, 'ΑΡΚΑΔΙΑΣ', 'ΑΡΚ', 'ΑΚ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(503, 84, 'ΑΡΓΟΛΙΔΑΣ', 'ΑΡΓ', 'ΑΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(533, 84, 'ΛΑΣΙΘΙΟΥ', 'ΛΑΣ', 'ΛΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(534, 84, 'ΛΕΣΒΟΥ', 'ΛΕΣ', 'ΛΣ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(530, 84, 'ΚΥΚΛΑΔΩΝ', 'ΚΥΚ', 'ΚΥ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(553, 84, 'ΑΙΤΩΛΟΑΚΑΡΝΑΝΙΑΣ', 'ΑΙΤ', 'ΑΙ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(529, 84, 'ΚΟΡΙΝΘΙΑΣ', 'ΚΟΡ', 'ΚΟ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(531, 84, 'ΛΑΚΩΝΙΑΣ', 'ΛΑΚ', 'ΛK', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(517, 84, 'ΗΜΑΘΙΑΣ', 'ΗΜΑ', 'ΗΜ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(518, 84, 'ΗΡΑΚΛΕΙΟΥ', 'ΗΡΑ', 'ΗΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(519, 84, 'ΘΕΣΠΡΩΤΙΑΣ', 'ΘΕΠ', 'ΘΠ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(520, 84, 'ΘΕΣΣΑΛΟΝΙΚΗΣ', 'ΘΕΣ', 'ΘΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(521, 84, 'ΙΩΑΝΝΙΝΩΝ', 'ΙΩΑ', 'ΙΩ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(522, 84, 'ΚΑΒΑΛΑΣ', 'ΚΑΒ', 'ΚΒ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(523, 84, 'ΚΑΡΔΙΤΣΑΣ', 'ΚΑΡ', 'ΚΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(524, 84, 'ΚΑΣΤΟΡΙΑΣ', 'ΚΑΣ', 'ΚΣ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(525, 84, 'ΚΕΡΚΥΡΑΣ', 'ΚΕΡ', 'ΚΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(526, 84, 'ΚΕΦΑΛΛΗΝΙΑΣ', 'ΚΕΦ', 'ΚΦ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(527, 84, 'ΚΙΛΚΙΣ', 'ΚΙΛ', 'ΚΙ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(528, 84, 'ΚΟΖΑΝΗΣ', 'ΚΟΖ', 'ΚZ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(507, 84, 'ΑΧΑΪΑΣ', 'ΑΧΑ', 'ΑΧ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(508, 84, 'ΒΟΙΩΤΙΑΣ', 'ΒΟΙ', 'ΒΟ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(509, 84, 'ΓΡΕΒΕΝΩΝ', 'ΓΡΕ', 'ΓΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(510, 84, 'ΔΡΑΜΑΣ', 'ΔΡΑ', 'ΔΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(511, 84, 'ΔΩΔΕΚΑΝΗΣΟΥ', 'ΔΩΔ', 'ΔΩ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(512, 84, 'ΕΒΡΟΥ', 'ΕΒΡ', 'ΕΒ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(513, 84, 'ΕΥΒΟΙΑΣ', 'ΕΥΒ', 'ΕΥ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(514, 84, 'ΕΥΡΥΤΑΝΙΑΣ', 'ΕΥΡ', 'ΕΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(515, 84, 'ΖΑΚΥΝΘΟΥ', 'ΖΑΚ', 'ΖΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(516, 84, 'ΗΛΕΙΑΣ', 'ΗΛΕ', 'ΗΛ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(505, 84, 'ΑΡΤΑΣ', 'ΑΡΤ', 'ΑΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(506, 84, 'ΑΤΤΙΚΗΣ', 'ΑΤΤ', 'ΑΤ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(536, 84, 'ΜΑΓΝΗΣΙΑΣ', 'ΜΑΓ', 'ΜΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(537, 84, 'ΜΕΣΣΗΝΙΑΣ', 'ΜΕΣ', 'ΜΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(538, 84, 'ΞΑΝΘΗΣ', 'ΞΑΝ', 'ΞΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(539, 84, 'ΠΕΛΛΗΣ', 'ΠΕΛ', 'ΠΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(540, 84, 'ΠΙΕΡΙΑΣ', 'ΠΙΕ', 'ΠΙ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(541, 84, 'ΠΡΕΒΕΖΑΣ', 'ΠΡΕ', 'ΠΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(542, 84, 'ΡΕΘΥΜΝΗΣ', 'ΡΕΘ', 'ΡΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(543, 84, 'ΡΟΔΟΠΗΣ', 'ΡΟΔ', 'ΡΟ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(544, 84, 'ΣΑΜΟΥ', 'ΣΑΜ', 'ΣΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(545, 84, 'ΣΕΡΡΩΝ', 'ΣΕΡ', 'ΣΕ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(546, 84, 'ΤΡΙΚΑΛΩΝ', 'ΤΡΙ', 'ΤΡ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(547, 84, 'ΦΘΙΩΤΙΔΑΣ', 'ΦΘΙ', 'ΦΘ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(548, 84, 'ΦΛΩΡΙΝΑΣ', 'ΦΛΩ', 'ΦΛ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(549, 84, 'ΦΩΚΙΔΑΣ', 'ΦΩΚ', 'ΦΩ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(550, 84, 'ΧΑΛΚΙΔΙΚΗΣ', 'ΧΑΛ', 'ΧΑ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(551, 84, 'ΧΑΝΙΩΝ', 'ΧΑΝ', 'ΧΝ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(552, 84, 'ΧΙΟΥ', 'ΧΙΟ', 'ΧΙ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(569, 81, 'Schleswig-Holstein', 'SHO', 'SH', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(554, 81, 'Freie und Hansestadt Hamburg', 'HAM', 'HH', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(555, 81, 'Niedersachsen', 'NIS', 'NI', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(556, 81, 'Freie Hansestadt Bremen', 'HBR', 'HB', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(557, 81, 'Nordrhein-Westfalen', 'NRW', 'NW', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(558, 81, 'Hessen', 'HES', 'HE', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(559, 81, 'Rheinland-Pfalz', 'RLP', 'RP', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(560, 81, 'Baden-Württemberg', 'BWÜ', 'BW', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(561, 81, 'Freistaat Bayern', 'BAV', 'BY', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(562, 81, 'Saarland', 'SLA', 'SL', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(563, 81, 'Berlin', 'BER', 'BE', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(564, 81, 'Brandenburg', 'BRB', 'BB', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(565, 81, 'Mecklenburg-Vorpommern', 'MVO', 'MV', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(566, 81, 'Freistaat Sachsen', 'SAC', 'SN', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(567, 81, 'Sachsen-Anhalt', 'SAA', 'ST', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(568, 81, 'Freistaat Thüringen', 'THÜ', 'TH', 0, 1, 0, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(570, 176, 'Адыгея Республика', 'AD', '01', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(571, 176, 'Алтай Республика', 'AL', '04', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(572, 176, 'Алтайский край', 'ALT', '22', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(573, 176, 'Амурская область', 'AMU', '28', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(574, 176, 'Архангельская область', 'ARK', '29', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(575, 176, 'Астраханская область', 'AST', '30', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(576, 176, 'Башкортостан Республика', 'BA', '02', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(577, 176, 'Белгородская область', 'BEL', '31', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(578, 176, 'Брянская область', 'BRY', '32', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(579, 176, 'Бурятия Республика', 'BU', '03', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(580, 176, 'Владимирская область', 'VLA', '33', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(581, 176, 'Волгоградская область', 'VGG', '34', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(582, 176, 'Вологодская область', 'VLG', '35', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(583, 176, 'Воронежская область', 'VOR', '36', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(584, 176, 'Дагестан Республика', 'DA', '05', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(585, 176, 'Еврейская автономная область', 'YEV', '79', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(586, 176, 'Забайкальский край', 'ZAB', '75', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(587, 176, 'Ивановская область', 'IVA', '37', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(588, 176, 'Ингушетия Республика', 'IN', '06', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(589, 176, 'Иркутская область', 'IRK', '38', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(590, 176, 'Кабардино-Балкарская Республика', 'KB', '07', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(591, 176, 'Калининградская область', 'KGD', '39', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(592, 176, 'Калмыкия Республика', 'KL', '08', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(593, 176, 'Калужская область', 'KLU', '40', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(594, 176, 'Камчатский край', 'KAM', '41', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(595, 176, 'Карачаево-Черкесская Республика', 'KC', '09', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(596, 176, 'Карелия Республика', 'KR', '10', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(597, 176, 'Кемеровская область', 'KEM', '42', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(598, 176, 'Кировская область', 'KIR', '43', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(599, 176, 'Коми Республика', 'KO', '11', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(600, 176, 'Костромская область', 'KOS', '44', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(601, 176, 'Краснодарский край', 'KDA', '23', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(602, 176, 'Красноярский край', 'KIA', '24', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(603, 176, 'Курганская область', 'KGN', '45', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(604, 176, 'Курская область', 'KRS', '46', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(605, 176, 'Ленинградская область', 'LEN', '47', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(606, 176, 'Липецкая область', 'LIP', '48', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(607, 176, 'Магаданская область', 'MAG', '49', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(608, 176, 'Марий Эл Республика', 'ME', '12', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(609, 176, 'Мордовия Республика', 'MO', '13', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(610, 176, 'Москва', 'MOW', '77', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(611, 176, 'Московская область', 'MOS', '50', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(612, 176, 'Мурманская область', 'MUR', '51', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(613, 176, 'Ненецкий автономный округ', 'NEN', '83', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(614, 176, 'Нижегородская область', 'NIZ', '52', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(615, 176, 'Новгородская область', 'NGR', '53', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(616, 176, 'Новосибирская область', 'NVS', '54', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(617, 176, 'Омская область', 'OMS', '55', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(618, 176, 'Оренбургская область', 'ORE', '56', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(619, 176, 'Орловская область', 'ORL', '57', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(620, 176, 'Пензенская область', 'PNZ', '58', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(621, 176, 'Пермский край', 'PER', '59', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(622, 176, 'Приморский край', 'PRI', '25', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(623, 176, 'Псковская область', 'PSK', '60', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(624, 176, 'Ростовская область', 'ROS', '61', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(625, 176, 'Рязанская область', 'RYA', '62', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(626, 176, 'Самарская область', 'SAM', '63', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(627, 176, 'Санкт-Петербург', 'SPE', '78', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(628, 176, 'Саратовская область', 'SAR', '64', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(629, 176, 'Саха (Якутия) Республика', 'SA', '14', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(630, 176, 'Сахалинская область', 'SAK', '65', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(631, 176, 'Свердловская область', 'SVE', '66', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(632, 176, 'Северная Осетия-Алания Республика', 'SE', '15', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(633, 176, 'Смоленская область', 'SMO', '67', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(634, 176, 'Ставропольский край', 'STA', '26', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(635, 176, 'Тамбовская область', 'TAM', '68', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(636, 176, 'Татарстан Республика', 'TA', '16', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(637, 176, 'Тверская область', 'TVE', '69', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(638, 176, 'Томская область', 'TOM', '70', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(639, 176, 'Тульская область', 'TUL', '71', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(640, 176, 'Тыва Республика', 'TY', '17', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(641, 176, 'Тюменская область', 'TYU', '72', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(642, 176, 'Удмуртская Республика', 'UD', '18', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(643, 176, 'Ульяновская область', 'ULY', '73', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(644, 176, 'Хакасия Республика', 'KK', '19', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(645, 176, 'Челябинская область', 'CHE', '74', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(646, 176, 'Чеченская Республика', 'CE', '20', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(647, 176, 'Чувашская Республика', 'CU', '21', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(648, 176, 'Чукотский автономный округ', 'CHU', '87', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(649, 176, 'Хабаровский край', 'KHA', '27', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(650, 176, 'Ханты-Мансийский автономный округ', 'KHM', '86', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(651, 176, 'Ямало-Ненецкий автономный округ', 'YAN', '89', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(652, 176, 'Ярославская область', 'YAR', '76', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(653, 209, 'กระบี่', 'กบ', 'กบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(654, 209, 'กรุงเทพมหานคร', 'กทม', 'กท', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(655, 209, 'กาญจนบุรี', 'กจ', 'กจ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(656, 209, 'กาฬสินธุ์', 'กส', 'กส', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(657, 209, 'กำแพงเพชร', 'กพ', 'กพ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(658, 209, 'ขอนแก่น', 'ขก', 'ขก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(659, 209, 'จันทบุรี', 'จบ', 'จบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(660, 209, 'ฉะเชิงเทรา', 'ฉช', 'ฉช', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(661, 209, 'ชลบุรี', 'ชบ', 'ชบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(662, 209, 'ชัยนาท', 'ชน', 'ชน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(663, 209, 'ชัยภูมิ', 'ชย', 'ชย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(664, 209, 'ชุมพร', 'ชพ', 'ชพ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(665, 209, 'เชียงราย', 'ชร', 'ชร', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(666, 209, 'เชียงใหม่', 'ชม', 'ชม', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(667, 209, 'ตรัง', 'ตง', 'ตง', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(668, 209, 'ตราด', 'ตร', 'ตร', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(669, 209, 'ตาก', 'ตก', 'ตก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0);
INSERT INTO `#__standard_states` (`id`, `country_id`, `title`, `code_3`, `code_2`, `ordering`, `shared`, `state`, `created`, `created_by`, `modified`, `modified_by`, `checked_out_time`, `checked_out`, `language`, `locked`, `locked_by`) VALUES
(670, 209, 'นครนายก', 'นย', 'นย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(671, 209, 'นครปฐม', 'นฐ', 'นฐ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(672, 209, 'นครพนม', 'นพ', 'นพ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(673, 209, 'นครราชสีมา', 'นม', 'นม', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(674, 209, 'นครศรีธรรมราช', 'นศ', 'นศ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(675, 209, 'นครสวรรค์', 'นว', 'นว', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(676, 209, 'นนทบุรี', 'นบ', 'นบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(677, 209, 'นราธิวาส', 'นธ', 'นธ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(678, 209, 'น่าน', 'นน', 'นน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(679, 209, 'บุรีรัมย์', 'บร', 'บร', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(680, 209, 'บึงกาฬ', 'บก', 'บก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(681, 209, 'ปทุมธานี', 'ปท', 'ปท', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(682, 209, 'ประจวบคีรีขันธ์', 'ปข', 'ปข', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(683, 209, 'ปราจีนบุรี', 'ปจ', 'ปจ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(684, 209, 'ปัตตานี', 'ปน', 'ปน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(685, 209, 'พระนครศรีอยุธยา', 'อย', 'อย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(686, 209, 'พังงา', 'พง', 'พง', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(687, 209, 'พัทลุง', 'พท', 'พท', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(688, 209, 'พิจิตร', 'พจ', 'พจ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(689, 209, 'พิษณุโลก', 'พล', 'พล', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(690, 209, 'เพชรบุรี', 'พบ', 'พบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(691, 209, 'เพชรบูรณ์', 'พช', 'พช', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(692, 209, 'แพร่', 'พร', 'พร', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(693, 209, 'พะเยา', 'พย', 'พย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(694, 209, 'ภูเก็ต', 'ภก', 'ภก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(695, 209, 'มหาสารคาม', 'มค', 'มค', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(696, 209, 'แม่ฮ่องสอน', 'มส', 'มส', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(697, 209, 'มุกดาหาร', 'มห', 'มห', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(698, 209, 'ยะลา', 'ยล', 'ยล', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(699, 209, 'ยโสธร', 'ยส', 'ยส', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(700, 209, 'ร้อยเอ็ด', 'รอ', 'รอ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(701, 209, 'ระนอง', 'รน', 'รน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(702, 209, 'ระยอง', 'รย', 'รย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(703, 209, 'ราชบุรี', 'รบ', 'รบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(704, 209, 'ลพบุรี', 'ลบ', 'ลบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(705, 209, 'ลำปาง', 'ลป', 'ลป', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(706, 209, 'ลำพูน', 'ลพ', 'ลพ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(707, 209, 'เลย', 'ลย', 'ลย', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(708, 209, 'ศรีสะเกษ', 'ศก', 'ศก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(709, 209, 'สกลนคร', 'สน', 'สน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(710, 209, 'สงขลา', 'สข', 'สข', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(711, 209, 'สตูล', 'สต', 'สต', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(712, 209, 'สมุทรปราการ', 'สป', 'สป', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(713, 209, 'สมุทรสงคราม', 'สส', 'สส', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(714, 209, 'สมุทรสาคร', 'สค', 'สค', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(715, 209, 'สระบุรี', 'สบ', 'สบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(716, 209, 'สระแก้ว', 'สก', 'สก', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(717, 209, 'สิงห์บุรี', 'สห', 'สห', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(718, 209, 'สุโขทัย', 'สท', 'สท', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(719, 209, 'สุพรรณบุรี', 'สพ', 'สพ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(720, 209, 'สุราษฎร์ธานี', 'สฎ', 'สฎ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(721, 209, 'สุรินทร์', 'สร', 'สร', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(722, 209, 'หนองคาย', 'นค', 'นค', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(723, 209, 'หนองบัวลำภู', 'นภ', 'นภ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(724, 209, 'อ่างทอง', 'อท', 'อท', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(725, 209, 'อุดรธานี', 'อด', 'อด', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(726, 209, 'อุตรดิตถ์', 'อต', 'อต', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(727, 209, 'อุทัยธานี', 'อน', 'อน', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(728, 209, 'อุบลราชธานี', 'อบ', 'อบ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(729, 209, 'อำนาจเจริญ', 'อจ', 'อจ', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(730, 150, 'Drenthe', 'DR', 'DR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(731, 150, 'Flevoland', 'FLV', 'FL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(732, 150, 'Friesland', 'FR', 'FR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(733, 150, 'Gelderland', 'GLD', 'GL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(734, 150, 'Groningen', 'GR', 'GR', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(735, 150, 'Limburg', 'LB', 'LB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(736, 150, 'Noord-Brabant', 'NB', 'NB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(737, 150, 'Noord-Holland', 'NH', 'NH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(738, 150, 'Overijssel', 'OVR', 'OV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(739, 150, 'Utrecht', 'UT', 'UT', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(740, 150, 'Zuid-Holland', 'ZH', 'ZH', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(741, 150, 'Zeeland', 'ZL', 'ZL', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(742, 21, 'Antwerpen', 'ant', 'AW', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(743, 21, 'Limburg', 'lim', 'LI', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(744, 21, 'Oost-Vlaanderen', 'ov', 'OV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(745, 21, 'Vlaams-Brabant', 'vb', 'VB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(746, 21, 'West-Vlaanderen', 'wv', 'WV', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(747, 21, 'Waals-Brabant (Brabant wallon)', 'wb', 'WB', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(748, 21, 'Henegouwen (Hainaut),', 'he', 'HE', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(749, 21, 'Luik (Liège/Lüttich)', 'lui', 'LU', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(750, 21, 'Luxemburg (Luxembourg)', 'lux', 'LX', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(751, 215, 'Adana', 'ADN', '01', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(752, 215, 'Adıyaman', 'ADY', '02', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(753, 215, 'Afyon', 'AFN', '03', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(754, 215, 'Ağrı', 'AGR', '04', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(755, 215, 'Amasya', 'AMS', '05', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(756, 215, 'Ankara', 'ANK', '06', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(757, 215, 'Antalya', 'ANT', '07', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(758, 215, 'Artvin', 'ART', '08', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(759, 215, 'Aydın', 'AYD', '09', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(760, 215, 'Balıkesir', 'BLK', '10', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(761, 215, 'Bilecik', 'BLC', '11', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(762, 215, 'Bingöl', 'BIN', '12', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(763, 215, 'Bitlis', 'BIT', '13', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(764, 215, 'Bolu', 'BOL', '14', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(765, 215, 'Burdur', 'DRD', '15', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(766, 215, 'Bursa', 'BUR', '16', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(767, 215, 'Çanakkale', 'CNK', '17', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(768, 215, 'Çankırı', 'CAK', '18', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(769, 215, 'Çorum', 'COR', '19', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(770, 215, 'Denizli', 'DEN', '20', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(771, 215, 'Diyarbakır', 'DYB', '21', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(772, 215, 'Edirne', 'EDR', '22', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(773, 215, 'Elazığ', 'ELZ', '23', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(774, 215, 'Erzincan', 'ERN', '24', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(775, 215, 'Erzurum', 'ERZ', '25', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(776, 215, 'Eskişehir', 'ESK', '26', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(777, 215, 'Gaziantep', 'GZA', '27', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(778, 215, 'Giresun', 'GRS', '28', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(779, 215, 'Gümüşhane', 'GMH', '29', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(780, 215, 'Hakkari', 'HKK', '30', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(781, 215, 'Hatay', 'HTY', '31', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(782, 215, 'Isparta', 'ISP', '32', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(783, 215, 'İçel (Mersin)', 'ICE', '33', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(784, 215, 'İstanbul', 'IST', '34', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(785, 215, 'İzmir', 'IZM', '35', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(786, 215, 'Kars', 'KRS', '36', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(787, 215, 'Kastamonu', 'KST', '37', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(788, 215, 'Kayseri', 'KYS', '38', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(789, 215, 'Kırklareli', 'KIR', '39', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(790, 215, 'Kırşehir', 'KIS', '40', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(791, 215, 'Kocaeli', 'KCL', '41', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(792, 215, 'Konya', 'KNY', '42', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(793, 215, 'Kütahya', 'KTH', '43', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(794, 215, 'Malatya', 'MLT', '44', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(795, 215, 'Manisa', 'MNS', '45', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(796, 215, 'K.maraş', 'KAH', '46', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(797, 215, 'Mardin', 'MRD', '47', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(798, 215, 'Muğla', 'MGL', '48', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(799, 215, 'Muş', 'MUS', '49', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(800, 215, 'Nevşehir', 'NEV', '50', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(801, 215, 'Niğde', 'NIG', '51', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(802, 215, 'Ordu', 'ORD', '52', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(803, 215, 'Rize', 'RIZ', '53', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(804, 215, 'Sakarya', 'SKR', '54', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(805, 215, 'Samsun', 'SMS', '55', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(806, 215, 'Siirt', 'SRT', '56', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(807, 215, 'Sinop', 'SNP', '57', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(808, 215, 'Sivas', 'SVS', '58', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(809, 215, 'Tekirdağ', 'TKR', '59', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(810, 215, 'Tokat', 'TKT', '60', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(811, 215, 'Trabzon', 'TRZ', '61', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(812, 215, 'Tunceli', 'TUN', '62', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(813, 215, 'Şanlıurfa', 'SNF', '63', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(814, 215, 'Uşak', 'USK', '64', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(815, 215, 'Van', 'VAN', '65', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(816, 215, 'Yozgat', 'YZT', '66', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(817, 215, 'Zonguldak', 'ZNG', '67', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(818, 215, 'Aksaray', 'AKS', '68', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(819, 215, 'Bayburt', 'BYB', '69', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(820, 215, 'Karaman', 'KRM', '70', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(821, 215, 'Kırıkkale', 'KRK', '71', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(822, 215, 'Batman', 'BTM', '72', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(823, 215, 'Şırnak', 'SRK', '73', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(824, 215, 'Bartın', 'BRT', '74', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(825, 215, 'Ardahan', 'ARH', '75', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(826, 215, 'Iğdır', 'IGD', '76', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(827, 215, 'Yalova', 'TLV', '77', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(828, 215, 'Karabük', 'KRB', '78', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(829, 215, 'Kilis', 'KLS', '79', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(830, 215, 'Osmaniye', 'OSM', '80', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0),
(831, 215, 'Düzce', 'DZC', '81', 0, 1, 1, '2017-02-25 00:00:00', 591, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, '', '0000-00-00 00:00:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standard_states`
--
ALTER TABLE `#__standard_states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_state_3_code` (`country_id`,`code_3`),
  ADD UNIQUE KEY `idx_state_2_code` (`country_id`,`code_2`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_ordering` (`ordering`),
  ADD KEY `idx_shared` (`shared`),
  ADD KEY `idx_published` (`state`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_states`
--
ALTER TABLE `#__standard_states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=832;

-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_agent_users`
--
CREATE TABLE IF NOT EXISTS `#__standard_agent_users` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `credit` tinyint(3) NOT NULL DEFAULT '0', 
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state_id` int(10) UNSIGNED NOT NULL DEFAULT '0'
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_agent_users`
--
ALTER TABLE `#__standard_agent_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`);
--
-- Indexes for table `#__standard_agent_user_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_agent_user_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `agent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_agents.id',
  PRIMARY KEY (`user_id`,`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `#__standard_agents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of the  agent',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `credit` tinyint(3) NOT NULL DEFAULT '0', 
  `limit_products` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address` text COLLATE utf8mb4_unicode_ci,
  `country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `state_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',

  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',

  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1'
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_agents`
--
ALTER TABLE `#__standard_agents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_country_id` (`country_id`),
  ADD KEY `idx_state_id` (`state_id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_publish_up` (`publish_up`),
  ADD KEY `idx_publish_down` (`publish_down`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_language` (`language`);
--
-- AUTO_INCREMENT for table `#__standard_agents`
--
ALTER TABLE `#__standard_agents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Indexes for table `#__standard_agent_categories_map`
--
CREATE TABLE IF NOT EXISTS `#__standard_agent_categories_map` (
  `catid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_categoriess.id',
  `agent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__standard_agents.id',
  
  PRIMARY KEY (`catid`,`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
--
-- Table structure for table `#__standard_orders`
--

CREATE TABLE `#__standard_orders` (
    `id` int(10) UNSIGNED NOT NULL,
    `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `number` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `customer_number` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `contact_gender` tinyint(3) NOT NULL DEFAULT '0',
    `contact_birthday` date NOT NULL DEFAULT '0000-00-00',
    `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `pass` varchar(34) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `create_invoice_pass` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `totalQuantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `total` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `salesPrice` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `billTaxAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `billTax` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `billDiscountAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `discountAmount` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `subtotal` decimal(15,5) DEFAULT NULL,
    `tax` decimal(10,5) DEFAULT NULL,

    `shipment` decimal(10,5) DEFAULT NULL,
    `shipment_tax` decimal(10,5) DEFAULT NULL,
    `payment` decimal(10,2) DEFAULT NULL,
    `payment_tax` decimal(10,5) DEFAULT NULL,

    `coupon_discount` decimal(12,2) NOT NULL DEFAULT '0.00',
    `coupon_code` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
    `currency` smallint(10) DEFAULT NULL,
    `state` tinyint(3) NOT NULL DEFAULT '0',

    `user_currency_id` smallint(10) DEFAULT NULL,
    `user_currency_rate` decimal(10,5) NOT NULL DEFAULT '1.00000',

    `payment_currency_id` smallint(10) DEFAULT NULL,
    `payment_currency_rate` decimal(10,5) NOT NULL DEFAULT '1.00000',
    `payment_currency_code_3` char(3) DEFAULT NULL,
    `payment_currency_symbol` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '', 

    `paymentmethod_id` int(10) UNSIGNED DEFAULT NULL,
    `payment_gateway` varchar(100) DEFAULT NULL,
    `payment_status` tinyint(3) DEFAULT NULL,
    `payment_message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `paymentmethod_currency_id` int(10) UNSIGNED DEFAULT NULL,
    `paymentmethod_currency_code_3` char(3) DEFAULT NULL,
    `paymentmethod_payable_amount` decimal(15,5) NOT NULL DEFAULT '0.00000',

    `email_status` tinyint(3) DEFAULT NULL,
    `email_message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `shipmentmethod_id` int(10) UNSIGNED DEFAULT NULL,

    `delivery_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `language` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `device` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `content_mail` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `message_error` MEDIUMTEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL
    `message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `log_order` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `payment_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `dorecovery_url` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(11) NOT NULL DEFAULT '0',
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `block` tinyint(4) UNSIGNED NOT NULL DEFAULT '0',
    `currency_history` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store all orders';

--
-- Indexes for table `#__standard_orders`
--
ALTER TABLE `#__standard_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_number` (`number`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_vendor_id` (`vendor_id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_payment_currency_id` (`payment_currency_id`),
  ADD KEY `idx_payment_currency_code_3` (`payment_currency_code_3`),
  ADD KEY `idx_paymentmethod_id` (`paymentmethod_id`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_paymentmethod_currency_id` (`paymentmethod_currency_id`),
  ADD KEY `idx_paymentmethod_currency_code_3` (`paymentmethod_currency_code_3`),
  ADD KEY `idx_shipmentmethod_id` (`shipmentmethod_id`),
  ADD KEY `idx_created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_orders`
--
ALTER TABLE `#__standard_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_order_items`
--

CREATE TABLE `#__standard_order_items` (
    `id` int(10) UNSIGNED NOT NULL,
    `order_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `vendor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `order_item_sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `order_item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `product_quantity` int(10) DEFAULT NULL,

    `product_adult` int(10) DEFAULT NULL,
    `product_children` int(10) DEFAULT NULL,
    `product_singlesupplement` int(10) DEFAULT NULL,
    `product_extrabed` int(10) DEFAULT NULL,
    `product_sharebed` int(10) DEFAULT NULL,

    `product_price_adult` decimal(15,5) DEFAULT NULL,
    `price_children_percent_adult` int(10) DEFAULT NULL,
    `price_single_supplement_percent_adult` int(10) DEFAULT NULL,
    `price_extra_bed_percent_adult` int(10) DEFAULT NULL,
    `price_share_bed_percent_adult` int(10) DEFAULT NULL,

    `product_item_price` decimal(15,5) DEFAULT NULL,
    `product_priceWithoutTax` decimal(15,5) DEFAULT NULL,
    `product_tax` decimal(15,5) DEFAULT NULL,
    `product_basePriceWithTax` decimal(15,5) DEFAULT NULL,
    `product_discountedPriceWithoutTax` decimal(15,5) DEFAULT NULL,
    `product_final_price` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `product_subtotal_discount` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `product_subtotal_with_tax` decimal(15,5) NOT NULL DEFAULT '0.00000',
    `order_item_currency` int(10) DEFAULT NULL,
    `order_item_currency_rate` decimal(10,5) NOT NULL DEFAULT '1.00000',
    `order_status` tinyint(3) NOT NULL DEFAULT '0',
    `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,

    `delivery_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

    `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `departure_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `number_days` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standard_order_items`
--
ALTER TABLE `#__standard_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_vendor_id` (`vendor_id`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_order_status` (`order_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_order_items`
--
ALTER TABLE `#__standard_order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Table structure for table `#__standard_request`
--

CREATE TABLE `#__standard_request` (
    `id` int(10) UNSIGNED NOT NULL,
    `number` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `customer_number` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `contact_fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `contact_gender` tinyint(3) NOT NULL DEFAULT '0',
    `contact_birthday` date NOT NULL DEFAULT '0000-00-00',
    `contact_home` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `contact_country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `contact_states_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `contact_message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    
    `language` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `device` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `content_mail` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `state` tinyint(3) NOT NULL DEFAULT '0',
    `message_error` MEDIUMTEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `email_status` tinyint(3) NOT NULL DEFAULT '0',
    `email_message` MEDIUMTEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `paymentmethod_id` int(10) UNSIGNED DEFAULT NULL,
    `payment_status` tinyint(3) DEFAULT NULL,
    `payment_message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(11) NOT NULL DEFAULT '0',
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store all request';

--
-- Indexes for table `#__standard_request`
--
ALTER TABLE `#__standard_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_number` (`number`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_email_status` (`email_status`),
  ADD KEY `idx_paymentmethod_id` (`paymentmethod_id`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_request`
--
ALTER TABLE `#__standard_request`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `#__standard_subscribe` (
  `id` int(10) UNSIGNED NOT NULL,
  `subscribe_email` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(3) NOT NULL DEFAULT '0',

  `language` char(7) NOT NULL COMMENT 'The language code for the article.',
  `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `device` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',

  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `access` int(10) UNSIGNED NOT NULL DEFAULT '0'

)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store all more infomation';
--
-- Indexes for table `#__standard_subscribe`
--
ALTER TABLE `#__standard_subscribe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_language` (`language`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_subscribe`
--
ALTER TABLE `#__standard_subscribe`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `#__standard_registration`
--

CREATE TABLE `#__standard_registration` (
    `id` int(10) UNSIGNED NOT NULL,

    `fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,

    `gender` tinyint(3) NOT NULL DEFAULT '0',
    `birthday` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    
    `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `companyName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rentalCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `typeOfBusiness` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `revenueLevel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `fbWebsite` text COLLATE utf8mb4_unicode_ci NOT NULL,
    
    `language` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `device` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `browser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    `content_mail` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
    `content_mail_team` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,

    `state` tinyint(3) NOT NULL DEFAULT '0',
    `message_error` MEDIUMTEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `message` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `email_status` tinyint(3) NOT NULL DEFAULT '0',
    `email_message` MEDIUMTEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL,

    `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `created_by` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` int(10) UNSIGNED NOT NULL DEFAULT '0',

    `checked_out` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(11) NOT NULL DEFAULT '0',
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Used to store all registration';

--
-- Indexes for table `#__standard_registration`
--
ALTER TABLE `#__standard_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_email_status` (`email_status`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standard_registration`
--
ALTER TABLE `#__standard_registration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------