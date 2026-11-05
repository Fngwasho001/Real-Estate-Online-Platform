CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB;


INSERT INTO `admin` (`id`, `name`, `email`, `username`, `password`) VALUES
(1, 'Admin', 'admin@example.com', 'admin', '$2y$10$Qln8I4Kia7/4jb89IIqWNulqBLTF6T6KdlncCXc2RAUbtwQictfxC');


CREATE TABLE `city` (
  `city_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` text
) ENGINE=InnoDB;


CREATE TABLE `cms_page` (
  `id` int NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB;


CREATE TABLE `contact_logs` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB;


CREATE TABLE `customer_entity` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255)   NOT NULL,
  `phone` varchar(255)  NOT NULL,
  `secret_answer` varchar(255) NOT NULL,
  `password_hash` varchar(255)  NOT NULL,
  `description` text,
  `image_path` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE `property` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `property_type` varchar(255) NOT NULL,
  `selling_type` varchar(255) NOT NULL,
  `bathroom` int NOT NULL,
  `balcony` int NOT NULL,
  `kitchen` int NOT NULL,
  `hall` int NOT NULL,
  `bedroom` int NOT NULL,
  `location` longtext NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` float NOT NULL,
  `price` float NOT NULL,
  `amenities` text,
  `thumbnail` text NOT NULL,
  `image1` text NOT NULL,
  `image2` text NOT NULL,
  `image3` text NOT NULL,
  `image4` text NOT NULL,
  `seller_id` int NOT NULL,
  `status` varchar(255) NOT NULL,
  `comment` text,
  `visibility` int DEFAULT '0',
  `faults` text NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `seller_profile` (
  `id` int NOT NULL,
  `address` text NOT NULL,
  `facebook_profile_url` varchar(255) DEFAULT NULL,
  `instagram_profile_url` varchar(255)  DEFAULT NULL,
  `twitter_profile_url` varchar(255)  DEFAULT NULL,
  `linkedin_profile_url` varchar(255)  DEFAULT NULL,
  `account_status` int NOT NULL DEFAULT '0',
  `customer_id` int DEFAULT NULL
) ENGINE=InnoDB;


CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `property_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);


ALTER TABLE `cms_page`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `contact_logs`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `customer_entity`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `SELLER_PROFILE_ID_PROPERTY_AGENT_ID` (`seller_id`);


ALTER TABLE `seller_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CUSTOMER_ENTITY_ID_SELLER_PROFILE_CUSTOMER_ID` (`customer_id`);


ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CUSTOMER_WISHLIST` (`customer_id`),
  ADD KEY `PROPERTY_WISHLIST` (`property_id`);

ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `city`
  MODIFY `city_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `cms_page`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `contact_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `customer_entity`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `property`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `seller_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `property`
ADD CONSTRAINT `SELLER_PROFILE_ID_PROPERTY_AGENT_ID` FOREIGN KEY (`seller_id`) REFERENCES `seller_profile` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `seller_profile`
  ADD CONSTRAINT `CUSTOMER_ENTITY_ID_SELLER_PROFILE_CUSTOMER_ID` FOREIGN KEY (`customer_id`) REFERENCES `customer_entity` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE `wishlist`
  ADD CONSTRAINT `CUSTOMER_WISHLIST` FOREIGN KEY (`customer_id`) REFERENCES `customer_entity` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `PROPERTY_WISHLIST` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
