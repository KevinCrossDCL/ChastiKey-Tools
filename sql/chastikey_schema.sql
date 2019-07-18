-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Generation Time: Jul 18, 2019 at 07:59 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `Locks_V2`
--

CREATE TABLE `Locks_V2` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `lock_id` int(11) NOT NULL,
  `lock_group_id` int(11) NOT NULL,
  `shared_id` varchar(20) NOT NULL,
  `bot_chosen` int(11) NOT NULL,
  `build` int(11) NOT NULL,
  `card_info_hidden` int(11) NOT NULL,
  `chances_accumulated_before_freeze` int(11) NOT NULL,
  `combination` varchar(10) NOT NULL,
  `cumulative` int(11) NOT NULL,
  `daily` int(11) NOT NULL,
  `date_deleted` varchar(10) NOT NULL,
  `date_last_picked` varchar(10) NOT NULL,
  `date_locked` varchar(10) NOT NULL,
  `date_unlocked` varchar(10) NOT NULL,
  `deleted` int(11) NOT NULL,
  `discard_pile` text NOT NULL,
  `display_in_stats` int(11) NOT NULL DEFAULT '1',
  `double_up_cards` int(11) NOT NULL,
  `double_up_cards_added` int(11) NOT NULL,
  `double_up_cards_picked` int(11) NOT NULL,
  `fake` int(11) NOT NULL,
  `fake_card_count_percentage` decimal(11,2) NOT NULL,
  `fixed` int(11) NOT NULL,
  `flag_chosen` int(11) NOT NULL,
  `freeze_cards` int(11) NOT NULL,
  `go_again_cards` int(11) NOT NULL,
  `green_cards` int(11) NOT NULL,
  `greens_picked_since_reset` int(11) NOT NULL,
  `hide_greens_until_picked_count` int(11) NOT NULL,
  `initial_double_up_cards` int(11) NOT NULL,
  `initial_freeze_cards` int(11) NOT NULL,
  `initial_green_cards` int(11) NOT NULL,
  `initial_red_cards` int(11) NOT NULL,
  `initial_reset_cards` int(11) NOT NULL,
  `initial_yellow_cards` int(11) NOT NULL,
  `initial_yellow_minus_2_cards` int(11) NOT NULL,
  `initial_yellow_minus_1_cards` int(11) NOT NULL,
  `initial_yellow_add_1_cards` int(11) NOT NULL,
  `initial_yellow_add_2_cards` int(11) NOT NULL,
  `initial_yellow_add_3_cards` int(11) NOT NULL,
  `key_disabled` int(11) NOT NULL,
  `key_used` int(11) NOT NULL,
  `keyholder_disabled_key` int(11) NOT NULL,
  `keyholder_emoji` int(11) NOT NULL,
  `last_update_id_seen` int(11) NOT NULL,
  `lock_frozen_by_card` int(11) NOT NULL,
  `lock_frozen_by_keyholder` int(11) NOT NULL,
  `minimum_red_cards` int(11) NOT NULL,
  `multiple_greens_required` int(11) NOT NULL,
  `no_of_add_1_cards` int(11) NOT NULL,
  `no_of_add_2_cards` int(11) NOT NULL,
  `no_of_add_3_cards` int(11) NOT NULL,
  `no_of_keys_required` int(11) NOT NULL DEFAULT '1',
  `no_of_minus_1_cards` int(11) NOT NULL,
  `no_of_minus_2_cards` int(11) NOT NULL,
  `no_of_times_green_card_revealed` int(11) NOT NULL,
  `permanent` int(11) NOT NULL,
  `picked_count` int(11) NOT NULL,
  `picked_count_including_yellows` int(11) NOT NULL,
  `picked_count_since_reset` int(11) NOT NULL,
  `platform` varchar(25) NOT NULL,
  `random_cards_added` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `rating_from_keyholder` int(11) NOT NULL,
  `ready_to_unlock` int(11) NOT NULL,
  `red_cards` int(11) NOT NULL,
  `red_cards_added` int(11) NOT NULL,
  `regularity` float NOT NULL,
  `reset_cards` int(11) NOT NULL,
  `reset_cards_added` int(11) NOT NULL,
  `reset_cards_picked` int(11) NOT NULL,
  `safe_id` varchar(255) NOT NULL,
  `show_fake_card_count` int(11) NOT NULL,
  `time_left_until_next_chance_before_freeze` int(11) NOT NULL,
  `timer_hidden` int(11) NOT NULL,
  `timestamp_clean_time_request_blocked_until` int(11) NOT NULL,
  `timestamp_deleted` int(11) NOT NULL,
  `timestamp_denied_clean_time` int(11) NOT NULL,
  `timestamp_ended_clean_time` int(11) NOT NULL,
  `timestamp_frozen_by_card` int(11) NOT NULL,
  `timestamp_frozen_by_keyholder` int(11) NOT NULL,
  `timestamp_keyholder_rated` int(11) NOT NULL,
  `timestamp_last_picked` int(11) NOT NULL,
  `timestamp_last_reset` int(11) NOT NULL,
  `timestamp_last_synced` int(11) NOT NULL,
  `timestamp_last_updated` int(11) NOT NULL,
  `timestamp_locked` int(11) NOT NULL,
  `timestamp_rated` int(11) NOT NULL,
  `timestamp_requested_clean_time` int(11) NOT NULL,
  `timestamp_requested_keyholders_decision` int(11) NOT NULL,
  `timestamp_started_clean_time` int(11) NOT NULL,
  `timestamp_unfreezes` int(11) NOT NULL,
  `timestamp_unfrozen` int(11) NOT NULL,
  `timestamp_unlocked` int(11) NOT NULL,
  `total_time_cleaning` int(11) NOT NULL,
  `total_time_frozen` int(11) NOT NULL,
  `trust_keyholder` int(11) NOT NULL,
  `unlocked` int(11) NOT NULL,
  `user_emoji` int(11) NOT NULL,
  `version` varchar(25) NOT NULL,
  `yellow_cards` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ModifiedLocks_V2`
--

CREATE TABLE `ModifiedLocks_V2` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `lock_id` bigint(20) NOT NULL,
  `shared_id` varchar(25) NOT NULL,
  `card_info_hidden_modified_by` int(11) NOT NULL,
  `double_up_cards_modified_by` int(11) NOT NULL,
  `freeze_cards_modified_by` int(11) NOT NULL,
  `green_cards_modified_by` int(11) NOT NULL,
  `lock_frozen_modified_by` int(11) NOT NULL,
  `no_of_add_1_cards` int(11) NOT NULL,
  `no_of_add_2_cards` int(11) NOT NULL,
  `no_of_add_3_cards` int(11) NOT NULL,
  `no_of_minus_1_cards` int(11) NOT NULL,
  `no_of_minus_2_cards` int(11) NOT NULL,
  `red_cards_modified_by` int(11) NOT NULL,
  `reset` int(11) NOT NULL,
  `reset_cards_modified_by` int(11) NOT NULL,
  `timer_hidden_modified_by` int(11) NOT NULL,
  `timestamp_modified` int(11) NOT NULL,
  `unlocked` int(11) NOT NULL,
  `user_notified` int(11) NOT NULL,
  `yellow_cards_modified_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `News`
--

CREATE TABLE `News` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReservedUsernames_V2`
--

CREATE TABLE `ReservedUsernames_V2` (
  `id` bigint(20) NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ServerVariables`
--

CREATE TABLE `ServerVariables` (
  `id` bigint(20) NOT NULL,
  `variable` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ShareableLocks_V2`
--

CREATE TABLE `ShareableLocks_V2` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `share_id` varchar(25) NOT NULL,
  `name` varchar(30) NOT NULL,
  `allow_copies` int(11) NOT NULL,
  `block_users_already_locked` int(11) NOT NULL,
  `build` int(11) NOT NULL,
  `card_info_hidden` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `cumulative` int(11) NOT NULL,
  `daily` int(11) NOT NULL,
  `double_up_cards` int(11) NOT NULL,
  `fixed` int(11) NOT NULL,
  `force_trust` int(11) NOT NULL,
  `freeze_cards` int(11) NOT NULL,
  `green_cards` int(11) NOT NULL,
  `hide_from_owner` int(11) NOT NULL,
  `key_disabled` int(11) NOT NULL,
  `max_random_double_ups` int(11) NOT NULL,
  `max_random_freezes` int(11) NOT NULL,
  `max_random_greens` int(11) NOT NULL,
  `max_random_reds` int(11) NOT NULL,
  `max_random_resets` int(11) NOT NULL,
  `max_random_yellows` int(11) NOT NULL,
  `max_random_yellows_add` int(11) NOT NULL,
  `max_random_yellows_minus` int(11) NOT NULL,
  `maximum_copies` int(11) NOT NULL,
  `maximum_users` int(11) NOT NULL,
  `min_random_double_ups` int(11) NOT NULL,
  `min_random_freezes` int(11) NOT NULL,
  `min_random_greens` int(11) NOT NULL,
  `min_random_reds` int(11) NOT NULL,
  `min_random_resets` int(11) NOT NULL,
  `min_random_yellows` int(11) NOT NULL,
  `min_random_yellows_add` int(11) NOT NULL,
  `min_random_yellows_minus` int(11) NOT NULL,
  `minimum_version_required` varchar(25) NOT NULL,
  `multiple_greens_required` int(11) NOT NULL,
  `random_double_ups` int(11) NOT NULL,
  `random_freezes` int(11) NOT NULL,
  `random_greens` int(11) NOT NULL,
  `random_reds` int(11) NOT NULL,
  `random_resets` int(11) NOT NULL,
  `random_yellows` int(11) NOT NULL,
  `random_yellows_add` int(11) NOT NULL,
  `random_yellows_minus` int(11) NOT NULL,
  `red_cards` int(11) NOT NULL,
  `regularity` float NOT NULL,
  `reset_cards` int(11) NOT NULL,
  `timer_hidden` int(11) NOT NULL,
  `timestamp_hidden` int(11) NOT NULL,
  `version` varchar(25) NOT NULL,
  `yellow_cards` int(11) NOT NULL,
  `yellow_cards_add` int(11) NOT NULL,
  `yellow_cards_minus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserIDs_V2`
--

CREATE TABLE `UserIDs_V2` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `admin_notes` varchar(500) NOT NULL,
  `api_token` varchar(255) NOT NULL,
  `avatar_id` bigint(20) NOT NULL,
  `banned` int(11) NOT NULL,
  `build_number_installed` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `date_deleted` datetime NOT NULL,
  `deleted` int(11) NOT NULL,
  `discord_discriminator` int(11) NOT NULL,
  `discord_name` varchar(60) NOT NULL,
  `discord_snowflake` varchar(30) NOT NULL,
  `display_in_stats` int(11) NOT NULL DEFAULT '1',
  `free_ads_removal_available` int(11) NOT NULL,
  `free_keys_available` int(11) NOT NULL,
  `keyholder_level` smallint(3) NOT NULL,
  `last_active` datetime NOT NULL,
  `lockee_level` smallint(3) NOT NULL,
  `main_role` smallint(3) NOT NULL,
  `no_of_keys` int(11) NOT NULL,
  `no_of_keys_purchased` int(11) NOT NULL,
  `no_of_times_review_box_shown` int(11) NOT NULL,
  `platform` varchar(25) NOT NULL,
  `push_notifications_disabled` int(11) NOT NULL,
  `reason_banned` varchar(500) NOT NULL,
  `removed_ads` tinyint(1) NOT NULL,
  `requests` bigint(20) NOT NULL,
  `status` smallint(3) NOT NULL DEFAULT '1',
  `timestamp_deleted` int(11) NOT NULL,
  `timestamp_last_active` int(11) NOT NULL,
  `token` text NOT NULL,
  `version_installed` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Server time is 8 hours behind GMT. I''m the first 3 user ids.';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Locks_V2`
--
ALTER TABLE `Locks_V2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`lock_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shared_id` (`shared_id`),
  ADD KEY `lock_id` (`lock_id`),
  ADD KEY `lock_group_id` (`lock_group_id`);

--
-- Indexes for table `ModifiedLocks_V2`
--
ALTER TABLE `ModifiedLocks_V2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shared_id` (`shared_id`),
  ADD KEY `lock_id` (`lock_id`);

--
-- Indexes for table `News`
--
ALTER TABLE `News`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ReservedUsernames_V2`
--
ALTER TABLE `ReservedUsernames_V2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ServerVariables`
--
ALTER TABLE `ServerVariables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `variable` (`variable`);

--
-- Indexes for table `ShareableLocks_V2`
--
ALTER TABLE `ShareableLocks_V2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`share_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `UserIDs_V2`
--
ALTER TABLE `UserIDs_V2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Locks_V2`
--
ALTER TABLE `Locks_V2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291546;

--
-- AUTO_INCREMENT for table `ModifiedLocks_V2`
--
ALTER TABLE `ModifiedLocks_V2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=582589;

--
-- AUTO_INCREMENT for table `News`
--
ALTER TABLE `News`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ReservedUsernames_V2`
--
ALTER TABLE `ReservedUsernames_V2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ServerVariables`
--
ALTER TABLE `ServerVariables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ShareableLocks_V2`
--
ALTER TABLE `ShareableLocks_V2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25033;

--
-- AUTO_INCREMENT for table `UserIDs_V2`
--
ALTER TABLE `UserIDs_V2`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78828;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
