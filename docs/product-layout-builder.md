# Product Layout Builder: คู่มือย้ายไปใช้เครื่องหรือโปรเจกต์อื่น

เอกสารนี้อธิบายการนำ `resources/views/admin/product-layouts/builder.blade.php` ไปใช้ต่อใน Laravel โปรเจกต์อื่น โดยอ้างอิงโครงสร้างของโปรเจกต์นี้

## สรุปก่อนเริ่ม

ไฟล์ `builder.blade.php` ไม่ใช่หน้าแบบ standalone เพราะทำหน้าที่เป็น UI สำหรับแก้ไข `draft_layout_json` ผ่าน API ดังนั้นการย้ายเฉพาะไฟล์ Blade จะยังใช้งานไม่ได้ ต้องย้ายหรือสร้างส่วนประกอบต่อไปนี้ให้ครบ:

1. หน้า Blade และ layout ของฝั่ง Admin
2. Route และ API สำหรับ Product Layout
3. `ProductLayout` model และตารางฐานข้อมูล
4. ระบบ login, session, CSRF และสิทธิ์ Admin
5. Renderer ฝั่งหน้าร้าน หากต้องการให้ layout แสดงบนหน้า Product จริง

## เลือกขอบเขตที่ต้องการย้าย

### ย้ายเฉพาะ Layout Builder

ใช้สำหรับสร้างโครงสร้างแถว/คอลัมน์/บล็อกและกด Save Draft หรือ Publish โดยยังไม่แสดงหน้า Product ให้ผู้ใช้งานทั่วไป

ไฟล์หลักที่ต้องมี:

```text
resources/views/admin/product-layouts/builder.blade.php
resources/views/admin/product-layouts/index.blade.php       # หน้า create/manage layout
app/Http/Controllers/Api/V1/Admin/ProductLayoutController.php
app/Models/ProductLayout.php
```

ต้อง merge route จาก `routes/web.php` และ `routes/api.php` ตามตัวอย่างด้านล่าง รวมถึงมีตาราง `product_layouts` และความสัมพันธ์ `ProductLayout::products()` ด้วย เพราะ controller ปัจจุบันใช้ `withCount('products')` และตรวจสอบก่อนลบ layout ว่ามี Product ใช้อยู่หรือไม่

### ย้ายพร้อมหน้า Product ที่แสดงผลจริง

ต้องเพิ่มส่วนของ Product Content และ Storefront:

```text
app/Models/Product.php
app/Models/ProductPage.php
app/Http/Controllers/Api/V1/Admin/ProductController.php
app/Http/Controllers/Api/V1/Admin/ProductPageController.php
app/Http/Controllers/Storefront/ProductController.php
resources/views/admin/products/content.blade.php
resources/views/products/show.blade.php
resources/views/products/partials/layout-rows.blade.php
resources/views/products/partials/block.blade.php
```

รวมถึง `layouts.product`, CSS/รูปภาพ และ route ที่หน้า Product ต้องใช้ด้วย ชุดนี้จึงจะทำงานครบตั้งแต่เลือก layout ให้ Product, กรอก content, publish และแสดงผลหน้าร้าน

## ข้อกำหนดของโปรเจกต์ปลายทาง

โปรเจกต์นี้ใช้ PHP 8.3, Laravel 13, Laravel Sanctum 4 และหน้า Admin ใช้ Bootstrap กับ jQuery ถ้าโปรเจกต์ปลายทางใช้เวอร์ชันอื่น ให้ตรวจสอบ syntax และ API ที่เกี่ยวข้องก่อนย้าย

`admin.layouts.app` ของโปรเจกต์ปลายทางต้องรองรับอย่างน้อย:

```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
@stack('styles')
@stack('scripts')
```

และต้องโหลดตามลำดับนี้:

```text
Bootstrap CSS
jQuery
Bootstrap JavaScript
builder.blade.php scripts
```

Builder ใช้ Bootstrap modal ผ่าน `$('#blockModal').modal(...)` และใช้ SortableJS 1.15.6 จาก CDN หากปลายทางไม่มีอินเทอร์เน็ต ให้ดาวน์โหลด SortableJS มาเก็บไว้ใน `public/` แล้วเปลี่ยน URL ใน `builder.blade.php`:

```html
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
```

## ขั้นตอนการย้าย

### 1. ติดตั้ง package และเตรียม environment

ในโปรเจกต์ปลายทาง:

```bash
composer install
php artisan key:generate
```

ตั้งค่า `.env` ให้ถูกต้องสำหรับฐานข้อมูล, `APP_URL`, session และระบบ Admin อย่า copy secret จากเครื่องเดิมลง Git หรือใช้ร่วมกันโดยไม่จำเป็น

### 2. Copy ไฟล์แล้วปรับ namespace/path

Copy ไฟล์หลักจากรายการด้านบน แล้ว merge แทนการวางทับ `routes/web.php` หรือ `routes/api.php` ทั้งไฟล์

ตรวจสอบรายการต่อไปนี้ในโปรเจกต์ปลายทาง:

- `admin.layouts.app` มีอยู่จริง หรือแก้ `@extends('admin.layouts.app')` ให้ตรงกับ layout ของปลายทาง
- มี route ชื่อ `admin.product-layouts.index` เพราะปุ่ม Back ใน Builder เรียก route นี้
- มี `App\Models\ProductLayout` และ route model binding สำหรับ `{productLayout}`
- ชื่อ API ใน JavaScript ยังคงเป็น `/api/v1/admin/...` หรือถูกแก้ให้ตรงกับ prefix ใหม่
- asset path ของ Bootstrap, jQuery และไฟล์ Admin ใช้ได้จริง
- ถ้าจะให้มีเมนูใน sidebar ให้เพิ่ม link ไปที่ `route('admin.product-layouts.index')`

### 3. สร้างฐานข้อมูล

#### ตารางขั้นต่ำสำหรับ implementation ปัจจุบัน

สร้าง migration ของ `product_layouts` ให้มีโครงสร้างเทียบเท่านี้:

```php
Schema::create('product_layouts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('description', 500)->nullable();
    $table->string('status', 20)->default('draft');
    $table->longText('draft_layout_json')->nullable();
    $table->longText('published_layout_json')->nullable();
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
});
```

ใน `ProductLayout` model ต้องมี fillable และ cast ดังนี้:

```php
protected $fillable = [
    'name',
    'slug',
    'description',
    'status',
    'draft_layout_json',
    'published_layout_json',
    'published_at',
];

protected function casts(): array
{
    return [
        'draft_layout_json' => 'array',
        'published_layout_json' => 'array',
        'published_at' => 'datetime',
    ];
}
```

เนื่องจาก controller ปัจจุบันนับจำนวน Product และห้ามลบ layout ที่ถูกใช้งาน จึงต้องมีความสัมพันธ์นี้ด้วย:

```php
public function products(): HasMany
{
    return $this->hasMany(Product::class);
}
```

ถ้าปลายทางยังไม่มี `products` table ให้สร้าง Product model/table ขั้นต่ำ หรือแก้ `ProductLayoutController@index()` และ `destroy()` ไม่ให้เรียก relation ดังกล่าว

#### ถ้าย้ายพร้อม Product Content และ Storefront

`products` ต้องมีอย่างน้อย `product_layout_id`:

```php
$table->foreignId('product_layout_id')
    ->nullable()
    ->constrained('product_layouts')
    ->nullOnDelete();
```

`product_pages` ต้องมีโครงสร้างที่ตรงกับ `ProductPage` model และ `ProductPageController`:

```php
$table->id();
$table->foreignId('product_id')
    ->unique()
    ->constrained('products')
    ->cascadeOnDelete();
$table->longText('draft_content_json')->nullable();
$table->longText('published_content_json')->nullable();
$table->timestamp('published_at')->nullable();
$table->timestamps();
```

หลังสร้าง migration แล้วรัน:

```bash
php artisan migrate
```

การ copy source code ไม่ได้ copy ข้อมูล layout เดิม ต้อง export/import แถวใน `product_layouts` และข้อมูล Product/Page ที่เกี่ยวข้องแยกต่างหาก หรือสร้าง Seeder ให้ข้อมูลเหล่านั้น

### 4. เพิ่ม Web routes

เพิ่มใน `routes/web.php` และเปลี่ยน middleware ให้ตรงกับระบบ auth ของปลายทาง:

```php
use AppModels\ProductLayout;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth:admin')
    ->group(function () {
        Route::view(
            '/product-layouts',
            'admin.product-layouts.index'
        )->name('product-layouts.index');

        Route::get(
            '/product-layouts/{productLayout}/builder',
            function (ProductLayout $productLayout) {
                return view(
                    'admin.product-layouts.builder',
                    compact('productLayout')
                );
            }
        )->name('product-layouts.builder');
    });
```

ถ้าปลายทางใช้ guard `web` แทน `admin` ให้เปลี่ยน `auth:admin` เป็น guard ที่ใช้งานจริง และแก้ทุกจุดที่เกี่ยวข้องให้สอดคล้องกัน

### 5. เพิ่ม API routes

Controller ของ Builder ใช้ endpoint เหล่านี้:

| Method | Endpoint | หน้าที่ |
|---|---|---|
| GET | `/api/v1/admin/product-layouts` | รายการ layout |
| POST | `/api/v1/admin/product-layouts` | สร้าง layout |
| GET | `/api/v1/admin/product-layouts/{id}` | โหลด layout/draft |
| PUT | `/api/v1/admin/product-layouts/{id}` | แก้ชื่อ slug description |
| DELETE | `/api/v1/admin/product-layouts/{id}` | ลบ layout ที่ยังไม่ถูกใช้ |
| PUT | `/api/v1/admin/product-layouts/{id}/layout` | บันทึก layout draft |
| POST | `/api/v1/admin/product-layouts/{id}/publish` | publish layout |

ตัวอย่าง route:

```php
use App\Http\Controllers\Api\V1\Admin\ProductLayoutController;

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')
        ->prefix('admin')
        ->group(function () {
            Route::get(
                '/product-layouts',
                [ProductLayoutController::class, 'index']
            );
            Route::post(
                '/product-layouts',
                [ProductLayoutController::class, 'store']
            );
            Route::get(
                '/product-layouts/{productLayout}',
                [ProductLayoutController::class, 'show']
            );
            Route::put(
                '/product-layouts/{productLayout}',
                [ProductLayoutController::class, 'update']
            );
            Route::delete(
                '/product-layouts/{productLayout}',
                [ProductLayoutController::class, 'destroy']
            );
            Route::put(
                '/product-layouts/{productLayout}/layout',
                [ProductLayoutController::class, 'saveLayout']
            );
            Route::post(
                '/product-layouts/{productLayout}/publish',
                [ProductLayoutController::class, 'publish']
            );
        });
});
```

หมายเหตุ: comment เดิมใน `routes/api.php` ระบุ body เป็น `blocks` แต่ implementation จริงของ `saveLayout()` รับ `rows` ดังนั้น request ที่ถูกต้องคือ:

```json
{
  "rows": []
}
```

### 6. ตรวจสอบ authentication และ CSRF

JavaScript ใน Builder ใช้:

```js
credentials: 'same-origin'
X-CSRF-TOKEN: <ค่าจาก meta[name="csrf-token"]>
```

ดังนั้น browser ต้อง login อยู่ใน session เดียวกับหน้า Admin และ API ต้องยอมรับ authentication แบบเดียวกัน ในโปรเจกต์นี้:

- Web route ใช้ `auth:admin`
- API route ใช้ `auth:sanctum`
- `bootstrap/app.php` เปิด `statefulApi()` เพื่อให้ first-party session ใช้กับ Sanctum ได้
- `config/sanctum.php` ตรวจสอบ guard `admin` และ `SANCTUM_STATEFUL_DOMAINS`

ถ้าโปรเจกต์ปลายทางใช้ Bearer token อย่างเดียว ต้องแก้ JavaScript ให้ส่ง `Authorization: Bearer ...` หรือปรับ API middleware ให้รองรับ session ของ Admin แทน มิฉะนั้นจะพบ `401 Unauthenticated` หรือ `419 Page Expired`

## รูปแบบข้อมูล Layout JSON

Builder บันทึก JSON version 2 โดยมีโครงสร้างหลักดังนี้:

```json
{
  "version": 2,
  "rows": [
    {
      "id": "row_abc123",
      "region": "before_order",
      "columns": [
        {
          "id": "col_abc123",
          "width": 6,
          "blocks": [
            {
              "id": "block_abc123",
              "type": "heading",
              "settings": {
                "custom_id": "",
                "content_width": 100,
                "alignment": "left",
                "tag": "h2"
              }
            }
          ]
        },
        {
          "id": "col_def456",
          "width": 6,
          "blocks": []
        }
      ]
    }
  ]
}
```

กติกาสำคัญที่ API ตรวจสอบ:

- ในแต่ละ row ผลรวม `columns.*.width` ต้องเท่ากับ 12 และใช้ได้เฉพาะ 4, 6, 8, 12
- แต่ละ row มี 1–3 columns
- `row.id`, `column.id` และ block internal `id` ห้ามซ้ำ
- effective HTML ID คือ `settings.custom_id` ถ้ามี ไม่เช่นนั้นใช้ block `id`; ห้ามซ้ำโดยไม่สนตัวพิมพ์ใหญ่/เล็ก
- `custom_id` ต้องขึ้นต้นด้วยตัวอักษร และใช้ได้เฉพาะตัวอักษร ตัวเลข `_` และ `-`
- `content_width` ใช้ 33, 50, 75 หรือ 100
- `alignment` ใช้ `left`, `center` หรือ `right`
- `region` ใช้ `before_order` หรือ `after_order`
- `accordion` ซ้อน child ได้ แต่ห้ามซ้อน `accordion` ใน child อีกชั้น
- layout ที่จะ Publish ต้องมีอย่างน้อยหนึ่ง block

Component type ที่ controller รองรับในปัจจุบัน:

```text
Basic:
heading, rich_text, image, youtube, related_blogs, button,
text_link, custom_table, info_card, accordion, option_card_grid

Product:
product_header, product_gallery, product_details, template_button,
price_accordion, shipping_schedule, production_schedule

Layout:
divider, spacer
```

ข้อมูลเนื้อหาของแต่ละ Product ไม่ได้อยู่ใน layout JSON แต่เก็บแยกใน `product_pages.draft_content_json` และ `published_content_json` โดยอ้างอิง block `id`

## ลำดับการใช้งานจริง

```text
สร้าง Layout
    ↓
เปิด /admin/product-layouts/{id}/builder
    ↓
เพิ่ม row → เลือก column → เพิ่ม component → แก้ settings
    ↓
Save Draft  → draft_layout_json
    ↓
Publish     → published_layout_json
    ↓
กำหนด products.product_layout_id
    ↓
กรอก Product Content
    ↓
Publish Product Page → published_content_json
    ↓
Storefront render layout + content
```

การ Publish Layout กับการ Publish Product Page เป็นคนละขั้นตอนกัน หน้า Product ของ implementation นี้จะแสดงผลได้เมื่อมีทั้ง published layout และ published content

## ถ้าต้องการย้าย Storefront ด้วย

ต้องเพิ่ม route ประมาณนี้ไว้ท้ายกลุ่ม Product routes เพื่อไม่ให้ไปดัก route อื่นก่อน:

```php
use App\Http\Controllers\Storefront\ProductController;

Route::get(
    '/products/{productPath}',
    [ProductController::class, 'show']
)->where('productPath', '.+')->name('products.show');
```

`Storefront\ProductController` จะโหลด:

- Product ที่ `status = active`
- `layout.published_layout_json`
- `page.published_content_json`

จากนั้น `products.show` จะแบ่ง row เป็น `before_order` และ `after_order` แล้วส่งไปที่ `products.partials.layout-rows` และ `products.partials.block`

ส่วนที่ต้องตรวจสอบ/ปรับก่อนใช้กับเว็บอื่น:

- `layouts.product` และ `partials.legacy-head-products`
- CSS ของ `.product-layout-*` และ `.store-*`
- URL รูปภาพและไฟล์ใน `public/`
- logic ที่ตรวจ `$product->slug === 'rubberstrap'`
- order form และ route เฉพาะ Rubber Strap
- URL legacy ที่ hard-code อยู่ใน block renderer

ถ้าใช้ upload รูปหรือ template จาก `ProductPageController` ต้องมี public filesystem และรัน:

```bash
php artisan storage:link
```

## ข้อควรระวังเฉพาะ repository นี้

จากสถานะปัจจุบันของ repository:

1. migration `2026_09_02_044349_add_layout_columns_to_product_pages_table.php` เพิ่ม `draft_layout_json` และ `published_layout_json` ใน `product_pages` แต่ model/controller ใช้ `draft_content_json` และ `published_content_json`
2. migration ดังกล่าวยังเป็น Pending ขณะที่ฐานข้อมูลปัจจุบันมี `published_at` ใน `product_pages` อยู่แล้ว จึงไม่ควร copy แล้วรันตรง ๆ ในโปรเจกต์ใหม่
3. migration สำหรับสร้าง `product_layouts`, `products` และ `product_pages` แบบฐานเริ่มต้นไม่ได้อยู่ในโฟลเดอร์ `database/migrations` ของ repository นี้ แม้ตารางจะมีอยู่ในฐานข้อมูลปัจจุบัน
4. `price_accordion` และ `production_schedule` อยู่ในรายการที่ Builder/API ยอมรับ แต่ renderer ปัจจุบันยังเว้นไว้เป็น System Component และไม่สร้าง HTML รอบการ render ทั่วไป ต้อง implement เพิ่มเองหากต้องการให้แสดงผล

แนวทางที่ปลอดภัยคือสร้าง migration ใหม่ในโปรเจกต์ปลายทางให้ตรงกับ model/controller จริง โดยใช้ชื่อ column `draft_content_json` และ `published_content_json` สำหรับ Product Page

## คำสั่งตรวจสอบหลังย้าย

```bash
php artisan optimize:clear
php artisan route:list --path=product-layouts
php artisan migrate:status
php artisan view:cache
```

จากนั้นตรวจตามลำดับ:

1. Login Admin ได้
2. เปิด `/admin/product-layouts`
3. สร้าง layout ใหม่และเปิด Builder
4. เพิ่ม 1 row แบบ 6/6 แล้วกด Save Draft
5. ตรวจว่า `GET /api/v1/admin/product-layouts/{id}` คืน `draft_layout_json.rows`
6. กด Publish และตรวจ `status = published`
7. ถ้าย้าย Storefront ด้วย ให้กำหนด layout ให้ Product, publish Product Page และเปิด `/products/{slug}`

## ปัญหาที่พบบ่อย

| อาการ | จุดที่ควรตรวจ |
|---|---|
| `View [admin.layouts.app] not found` | ย้าย Admin layout หรือแก้ `@extends` |
| modal ไม่เปิด / `modal is not a function` | jQuery และ Bootstrap JS โหลดก่อน script ของ Builder |
| `419 Page Expired` | csrf meta, session domain และ `X-CSRF-TOKEN` |
| `401 Unauthenticated` | `auth:admin`, Sanctum guard และ stateful domain |
| Save ได้ `422` | width รวมไม่เท่ากับ 12, ID ซ้ำ หรือ type/settings ไม่ตรงกติกา |
| เปิด Builder แล้วไม่มี layout | ตรวจ `draft_layout_json` และ API response |
| Layout publish แล้วหน้า Product ว่าง/404 | ต้อง publish Product Page ด้วย และตรวจ renderer/asset |
| component บางชนิดไม่แสดง | ตรวจว่า `block.blade.php` รองรับ type นั้นหรือยัง |
