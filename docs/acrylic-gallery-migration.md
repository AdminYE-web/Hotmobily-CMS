# Dynamic product gallery pages and legacy data

The admin now stores page definitions in `gallery_pages`. Administrators can
create another gallery page without adding a controller, route, or sidebar
link in code. Each definition provides:

- Page name and admin slug.
- Public URL slug (`/gallery/{public_slug}`).
- The legacy `hm_acrylic_gallery.type` value used to select its items.
- The image directory under `public/gallery`.
- Legacy filename extension, website-field visibility, menu order, and status.

The definition table does not replace or modify the legacy item table. Existing
rows remain in `hm_acrylic_gallery`, and the seeded definitions point to their
current `type` values. A definition that already has items cannot change its
database type or be deleted; it can be deactivated instead.

## Adding a future gallery page

1. Open `Admin > Management > Gallery Page Settings`.
2. Add a page name, unique admin/public slugs, and a unique database type.
3. Set an image directory beginning with `gallery/`, for example
   `gallery/new-product`.
4. Save. The admin item page, sidebar entry, and public page are available
   immediately.
5. Add items in the new page. They are written to `hm_acrylic_gallery` with the
   configured type, so the same legacy table continues to be used.

The Laravel page is available at `/admin/acrylic-gallery` and replaces the
legacy `/admin/acrylic_gallery.php` page. It intentionally reads the legacy
table shape so existing data can be imported without transforming the text
fields.

In the checked-in original connection file, the source database is named
`xb220664_hm`; verify the actual source name before running the import.

## Data to bring from the original system

Required:

1. `hm_acrylic_gallery` rows for these types:
   `keyholder`, `coaster`, `standee`, `acrylic_hair`, `acrylic_strap`,
   `rubber_strap`, `rubber_keyholder`, `rubber_coaster`, and `wappen`.
2. The image files referenced by those rows in `arr_img`. Copy them while
   preserving their original file names and directory mapping:

   | Gallery type(s) | Original media directory |
   | --- | --- |
   | `keyholder`, `standee`, `acrylic_hair`, `acrylic_strap` | `gallery/img-acrylic/` |
   | `coaster` | `gallery/img-acrylic-coaster/` |
   | `rubber_strap`, `rubber_keyholder`, `rubber_coaster` | `gallery/img-rubber/` |
   | `wappen` | `gallery/img-wappen/` |

   Legacy rows that store a name without an extension are resolved as `.webp`
   when that file exists. Rubber manual-import rows may contain a complete
   external URL in `arr_img`; those URLs are kept as-is.

Optional:

3. `hm_acrylic_gallery_log` rows for those gallery IDs. These are only the
   edit-history records; the gallery list and form work without old history.

The `admin` table is needed for Laravel admin login, but it is not gallery
data. Product, order, price, and option tables are not required by this page.
The new `gallery_pages` table is created and prefilled by Laravel migration; it
does not need to be imported from the original system.

The `gallery_pages.gallery_type` column is automatically aligned to the
character set and collation of the legacy `hm_acrylic_gallery.type` column.
This prevents MySQL "Illegal mix of collations" errors when old databases use
`utf8mb4_general_ci` and the Laravel default is `utf8mb4_unicode_ci`.

## Import order

1. Run the new migration:

   ```text
   php artisan migrate
   ```

2. Import the filtered `hm_acrylic_gallery` rows, preserving `id` values so
   the optional log rows still point to the correct gallery item.
3. Import/copy each referenced media directory to the matching directory
   under:

   ```text
   public/gallery/
   ```

4. Import the optional history rows after the gallery rows.

`database/sql/acrylic_gallery_import.sql` contains the cross-schema SQL
template. Replace `legacy_schema` with the source database name and run it
against the Laravel database connection. If the source database is on a
different server, export the two filtered result sets first and import them
into the same target tables.
