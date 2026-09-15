-- Add the optional red remark shown below an Option Group on the product page.
-- Run this once for databases where option_groups already exists.

ALTER TABLE `option_groups`
    ADD COLUMN `remark_text` TEXT NULL AFTER `help_text`;
