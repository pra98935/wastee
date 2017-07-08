-- 04-mar-2017
ALTER TABLE  `tbl_items` ADD  `is_sold` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `favourite_count`

-- Create table tbl_followers

--- 09 mar 2017---
ALTER TABLE  `ms_category` ADD  `category_class` VARCHAR( 50 ) NULL DEFAULT NULL AFTER  `category_name`

---- 10 mar 2017----
ALTER TABLE  `tbl_users` ADD  `search_tag` TEXT NULL DEFAULT NULL AFTER  `image`

---- 12 mar 2017----

-- Create table ms_notiofication_type and tbl_notification


---- Above Done on staging ---