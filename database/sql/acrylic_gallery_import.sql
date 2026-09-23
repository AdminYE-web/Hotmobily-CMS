-- Product gallery import template
--
-- Run database migrations first:
--   php artisan migrate
--
-- Replace `legacy_schema` with the schema/database containing the original
-- hm_acrylic_gallery tables. The source and target must be accessible from
-- the same MySQL connection for the INSERT ... SELECT form below.

INSERT INTO `hm_acrylic_gallery`
    (`id`, `arr_img`, `arr_txt1`, `arr_txt2`, `arr_txt3`, `arr_txt4`,
     `type`, `arr_web`, `created_by`, `created_at`, `manual_import`)
SELECT
    `id`, `arr_img`, `arr_txt1`, `arr_txt2`, `arr_txt3`, `arr_txt4`,
    `type`, `arr_web`, `created_by`, `created_at`, `manual_import`
FROM `legacy_schema`.`hm_acrylic_gallery`
WHERE `type` IN (
    'keyholder',
    'coaster',
    'standee',
    'acrylic_hair',
    'acrylic_strap',
    'rubber_strap',
    'rubber_keyholder',
    'rubber_coaster',
    'wappen'
);

-- Optional: preserve edit history for all imported gallery rows.
INSERT INTO `hm_acrylic_gallery_log`
    (`id`, `gallery_id`, `product`, `field`, `old`, `new`, `created_by`,
     `created_at`, `step`)
SELECT
    log.`id`, log.`gallery_id`, log.`product`, log.`field`, log.`old`,
    log.`new`, log.`created_by`, log.`created_at`, log.`step`
FROM `legacy_schema`.`hm_acrylic_gallery_log` AS log
INNER JOIN `hm_acrylic_gallery` AS gallery
    ON gallery.`id` = log.`gallery_id`
WHERE gallery.`type` IN (
    'keyholder',
    'coaster',
    'standee',
    'acrylic_hair',
    'acrylic_strap',
    'rubber_strap',
    'rubber_keyholder',
    'rubber_coaster',
    'wappen'
);

-- The image files are not stored in MySQL. Copy the source directory:
--   <original-web-root>/gallery/img-acrylic/
-- to:
--   <laravel-root>/public/gallery/img-acrylic/
