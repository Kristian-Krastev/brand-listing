USE `laravel`;

CREATE TABLE `brands`
(
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `brand_name`  VARCHAR(255)    NOT NULL,
    `brand_image` VARCHAR(255)    NOT NULL,
    `rating`      INT             NOT NULL,
    `created_at`  TIMESTAMP       NULL,
    `updated_at`  TIMESTAMP       NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `countries`
(
    `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `country_code` VARCHAR(2)      NOT NULL,
    `country_name` VARCHAR(255)    NOT NULL,
    `is_default`   TINYINT(1)      NOT NULL DEFAULT 0,
    `created_at`   TIMESTAMP       NULL,
    `updated_at`   TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `countries_country_code_unique` (`country_code`)
);

CREATE TABLE `country_brand`
(
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `country_id` BIGINT UNSIGNED NOT NULL,
    `brand_id`   BIGINT UNSIGNED NOT NULL,
    `position`   INT             NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP       NULL,
    `updated_at` TIMESTAMP       NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `country_brand_country_id_brand_id_unique` (`country_id`, `brand_id`),
    KEY `country_brand_country_id_foreign` (`country_id`),
    KEY `country_brand_brand_id_foreign` (`brand_id`),
    CONSTRAINT `country_brand_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
    CONSTRAINT `country_brand_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
);

INSERT INTO `countries` (`country_code`, `country_name`, `is_default`, `created_at`, `updated_at`)
VALUES ('US', 'United States', 1, NOW(), NOW()),
       ('GB', 'United Kingdom', 0, NOW(), NOW()),
       ('DE', 'Germany', 0, NOW(), NOW()),
       ('FR', 'France', 0, NOW(), NOW()),
       ('JP', 'Japan', 0, NOW(), NOW()),
       ('CA', 'Canada', 0, NOW(), NOW()),
       ('AU', 'Australia', 0, NOW(), NOW()),
       ('IT', 'Italy', 0, NOW(), NOW()),
       ('ES', 'Spain', 0, NOW(), NOW()),
       ('CN', 'China', 0, NOW(), NOW());

INSERT INTO `brands` (`brand_name`, `brand_image`, `rating`, `created_at`, `updated_at`)
VALUES ('Nike', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/nike.svg', 5, NOW(), NOW()),
       ('Adidas', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/adidas.svg', 4, NOW(), NOW()),
       ('Apple', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/apple.svg', 5, NOW(), NOW()),
       ('Samsung', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/samsung.svg', 4, NOW(), NOW()),
       ('Sony', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/sony.svg', 4, NOW(), NOW()),
       ('Microsoft', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/microsoft.svg', 4, NOW(), NOW()),
       ('Coca-Cola', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/cocacola.svg', 5, NOW(), NOW()),
       ('Toyota', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/toyota.svg', 4, NOW(), NOW()),
       ('Amazon', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/amazon.svg', 5, NOW(), NOW()),
       ('Google', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg', 5, NOW(), NOW()),
       ('BMW', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/bmw.svg', 4, NOW(), NOW()),
       ('Mercedes-Benz', 'https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/mercedes.svg', 5, NOW(), NOW());

INSERT INTO `country_brand` (`country_id`, `brand_id`, `position`, `created_at`, `updated_at`)
VALUES (1, 1, 1, NOW(), NOW()),
       (1, 3, 2, NOW(), NOW()),
       (1, 7, 3, NOW(), NOW()),
       (1, 9, 4, NOW(), NOW()),
       (1, 10, 5, NOW(), NOW()),
       (2, 2, 1, NOW(), NOW()),
       (2, 3, 2, NOW(), NOW()),
       (2, 4, 3, NOW(), NOW()),
       (2, 9, 4, NOW(), NOW()),
       (3, 2, 1, NOW(), NOW()),
       (3, 11, 2, NOW(), NOW()),
       (3, 12, 3, NOW(), NOW()),
       (3, 6, 4, NOW(), NOW()),
       (4, 2, 1, NOW(), NOW()),
       (4, 3, 2, NOW(), NOW()),
       (4, 12, 3, NOW(), NOW()),
       (5, 4, 1, NOW(), NOW()),
       (5, 5, 2, NOW(), NOW()),
       (5, 8, 3, NOW(), NOW()),
       (6, 1, 1, NOW(), NOW()),
       (6, 3, 2, NOW(), NOW()),
       (6, 7, 3, NOW(), NOW()),
       (7, 1, 1, NOW(), NOW()),
       (7, 3, 2, NOW(), NOW()),
       (7, 9, 3, NOW(), NOW()),
       (8, 2, 1, NOW(), NOW()),
       (8, 11, 2, NOW(), NOW()),
       (8, 12, 3, NOW(), NOW()),
       (9, 2, 1, NOW(), NOW()),
       (9, 7, 2, NOW(), NOW()),
       (9, 12, 3, NOW(), NOW()),
       (10, 4, 1, NOW(), NOW()),
       (10, 8, 2, NOW(), NOW()),
       (10, 10, 3, NOW(), NOW());