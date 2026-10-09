/**
 * Author:  BinhNguyen
 * Created: Jul 15, 2019
 */
--
-- Table structure for table `#__standardextension_content`
--

CREATE TABLE `#__standardextension_content` (
    `id` int(10) UNSIGNED NOT NULL,
    `asset_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
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

    `state` tinyint(3) NOT NULL DEFAULT '0',
    `catid` int(10) UNSIGNED NOT NULL DEFAULT '0',

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

    `links` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,

    `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
    `version` int(10) UNSIGNED NOT NULL DEFAULT '1',
    `ordering` int(11) NOT NULL DEFAULT '0',

    `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `access` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `hits` int(10) UNSIGNED NOT NULL DEFAULT '0',
    `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
    `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the article.',
    `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
    `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standardextension_content`
--
ALTER TABLE `#__standardextension_content`
    ADD PRIMARY KEY (`id`),
    ADD KEY `idx_access` (`access`),
    ADD KEY `idx_checkout` (`checked_out`),
    ADD KEY `idx_state` (`state`),
    ADD KEY `idx_catid` (`catid`),
    ADD KEY `idx_displaytype_id` (`displaytype_id`),

    ADD KEY `idx_banner_status` (`banner_status`),
    ADD KEY `idx_banner_home` (`banner_home`),

    ADD KEY `idx_createdby` (`created_by`),
    ADD KEY `idx_featured_catid` (`featured`,`catid`),
    ADD KEY `idx_language` (`language`),
    ADD KEY `idx_xreference` (`xreference`),
    ADD KEY `idx_alias` (`alias`(191));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standardextension_content`
--
ALTER TABLE `#__standardextension_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
-- --------------------------------------------------------

--
-- Table structure for table `#__standardextension_contentitem_tag_map`
--
CREATE TABLE `#__standardextension_contentitem_tag_map` (
  `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_content_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the core content table',
  `content_item_id` int(11) NOT NULL COMMENT 'PK from the content type table',
  `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint(8) NOT NULL COMMENT 'PK from the content_type table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from content tables to tags';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standardextension_contentitem_tag_map`
--
ALTER TABLE `#__standardextension_contentitem_tag_map`
  ADD UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`content_item_id`,`tag_id`),
  ADD KEY `idx_tag_type` (`tag_id`,`type_id`),
  ADD KEY `idx_date_id` (`tag_date`,`tag_id`),
  ADD KEY `idx_core_content_id` (`core_content_id`);

-- --------------------------------------------------------

--
-- Table structure for table `#__standardextension_content_frontpage`
--

CREATE TABLE `#__standardextension_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standardextension_content_frontpage`
--
ALTER TABLE `#__standardextension_content_frontpage`
  ADD PRIMARY KEY (`content_id`);

-- --------------------------------------------------------

--
-- Table structure for table `#__standardextension_content_rating`
--

CREATE TABLE `#__standardextension_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `lastip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `#__standardextension_content_rating`
--
ALTER TABLE `#__standardextension_content_rating`
  ADD PRIMARY KEY (`content_id`);
-- --------------------------------------------------------

--
-- Table structure for table `#__standardextension_content_types`
--

CREATE TABLE `#__standardextension_content_types` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_standardextensionhistory options'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for table `#__standardextension_content_types`
--
ALTER TABLE `#__standardextension_content_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `idx_alias` (`type_alias`(100));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `#__standardextension_content_types`
--
ALTER TABLE `#__standardextension_content_types`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
