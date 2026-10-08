# แผนพัฒนา Product Content Visual Editor

เพิ่ม Visual Editor ให้ `resources/views/admin/products/content.blade.php` แสดงตัวอย่างหน้าสินค้า พร้อมปุ่ม Edit บนแต่ละส่วนและแถบ Page Sections ตามภาพอ้างอิง เมื่อกดปุ่ม ระบบจะเปิดส่วนแก้ไขที่ตรงกับบล็อกนั้น เลื่อนเข้าไปหา ไฮไลต์ และโฟกัสช่องแก้ไข โดยยังใช้ Save Draft และ Publish ของเดิม

สถานะ: เพิ่ม Visual Editor สำหรับ Product แล้ว มี Preview จากข้อมูลในฟอร์ม ปุ่ม Edit รายบล็อก Page Sections และ Back to Preview โดยใช้ Save Draft และ Publish เดิม ส่วน Header Banner และ Sidebar เปิดหน้าจัดการเดิมในแท็บใหม่ ส่วน Navigation ที่ยังไม่มีหน้าจัดการเฉพาะแสดงสถานะยังไม่รองรับ

## ประสบการณ์ใช้งาน

1. เข้า `/admin/products/{product}/content` แล้วเปิด Visual Editor Mode
2. เห็นตัวอย่างหน้าสินค้าจริงและแถบ Page Sections ทางขวา บนจอเล็กแถบนี้เปิดเป็น drawer
3. แต่ละส่วนที่แก้ไขได้มีกรอบสีและปุ่ม เช่น Edit Gallery, Edit Product Details และ Edit Price Card ปุ่มต้องมองเห็นได้โดยไม่ต้องใช้ hover
4. กด Edit บนตัวอย่าง หรือเลือกชื่อส่วนใน Page Sections แล้วไปยังบล็อกเดียวกันใน Content Editor เดิม
5. ระบบคลายบล็อกที่พับอยู่ เลื่อนให้หัวบล็อกอยู่ในพื้นที่มองเห็น ไฮไลต์ชั่วคราว และโฟกัสช่องแรกที่แก้ไขได้ โดยไม่เปลี่ยนค่าในฟอร์ม
6. หลังแก้ไขมีปุ่ม Back to Preview กลับไปยังส่วนเดิม พร้อมอัปเดตตัวอย่างจากข้อมูลใน editor
7. กด Save Draft เพื่อบันทึกร่าง และกด Publish เมื่อต้องการเผยแพร่ การกด Edit หรือเปิด Preview ไม่บันทึกและไม่เผยแพร่อัตโนมัติ

ปุ่ม ON/OFF ควบคุมกรอบ ปุ่ม Edit และ Page Sections ส่วนปุ่มปิดแถบเพียงซ่อนแถบ โดยสามารถเปิดกลับมาได้ ไม่ทิ้งข้อมูลที่กำลังแก้ไข

## โครงสร้างที่มีอยู่

| ส่วน | ไฟล์และพฤติกรรมปัจจุบัน |
| --- | --- |
| Content Editor | `resources/views/admin/products/content.blade.php` ใช้ `layout-canvas`, `layout`, `contents` และ `data-block-id` ในการสร้างฟอร์ม |
| การพับบล็อก | `collapsedContentBlockIds` และ `collapseAllContentBlocks()` ทำให้ต้องคลายบล็อกก่อนนำทาง |
| การเลื่อนไปบล็อก | มีโค้ดค้นหา `.content-block[data-block-id]` พร้อม `scrollIntoView()` และ `content-block-highlighted` ใช้ต่อยอดได้ |
| ตัวแสดงหน้าสินค้า | `resources/views/products/show.blade.php`, `resources/views/products/partials/layout-rows.blade.php` และ `resources/views/products/partials/block.blade.php` |
| ข้อมูลร่าง | `GET /api/v1/admin/products/{product}/page` ผ่าน `ProductPageController::edit()` |
| บันทึกร่าง | `PUT /api/v1/admin/products/{product}/page` |
| เผยแพร่ | `POST /api/v1/admin/products/{product}/page/publish` |
| Editor ที่ใช้ไฟล์ร่วมกัน | Product Data, Custom Page และ Guide ใช้ `content.blade.php` ร่วมกัน พร้อม API base และ suffix ต่างกัน |

เปิด Visual Editor สำหรับ Product, Product Data, Custom Page และ Guide แล้ว โดย Product Data ใช้ endpoint `/admin/product-data/{productDataPage}/content/preview` ส่วน Custom Page ใช้ `/admin/custom-pages/{customPage}/content/preview` และ Guide ใช้ `/admin/guides/{guidePage}/content/preview` แต่ละประเภทใช้ตัวกรองข้อมูลและตัวแสดงหน้าร้านของตัวเอง รวมข้อมูล Guide Main และ Guide Items สำหรับ Guide

## ปลายทางของแต่ละส่วน

ชื่อในภาพเป็นชื่อสำหรับผู้ใช้ ต้องจับคู่กับบล็อกจริงจาก layout ของสินค้านั้น ห้ามใช้ประเภทบล็อกเพียงอย่างเดียวเป็นตัวระบุ เพราะอาจมีหลายบล็อกประเภทเดียวกัน

| ชื่อใน Visual Editor | แหล่งข้อมูลหรือชนิดบล็อก | เมื่อกด Edit |
| --- | --- | --- |
| Product Header | `product_header` | เปิดฟอร์มของ block ID นั้น |
| Product Gallery | `product_gallery` | เปิดรายการรูปและส่วนอัปโหลดของ block ID นั้น |
| Product Details | `product_details` | เปิดฟอร์มรายละเอียดของ block ID นั้น |
| Price Card | ตรวจบล็อกจริง อาจเป็น `image`, `info_card`, `rich_text` หรือบล็อกอื่น | เปิดฟอร์มของบล็อกที่เรนเดอร์การ์ดนั้น ไม่สร้างชนิด `price_card` ขึ้นมาโดยอัตโนมัติ |
| Calendar | `shipping_schedule` หรือ `production_schedule` ตามข้อมูลจริง | เปิดฟอร์มตารางกำหนดการของบล็อกนั้น หากเป็นส่วนจาก shell ให้ระบุปลายทางแยก |
| Promo Banner | บล็อกภาพหรือเนื้อหาใน layout หรือ banner ที่ใช้ร่วมกัน | ถ้าเป็นบล็อกไปยัง block ID ถ้าเป็น banner กลางไปหน้าจัดการที่ตรงรายการ |
| FAQ Link | `faq`, `text_link` หรือ `button` ตาม layout | เปิดฟอร์มตั้งค่า FAQ หรือลิงก์ของบล็อกนั้น แยกจากการแก้คำถามคำตอบในหน้าจัดการ FAQ |
| Navigation | ส่วน navigation ของ shell หรือข้อมูลเมนู | ตรวจ partial และแหล่งข้อมูลก่อนกำหนด route หากยังไม่มีหน้าจัดการให้แสดงสถานะยังไม่รองรับ |
| Sidebar | sidebar ของ shell และข้อมูลเมนูที่เกี่ยวข้อง | พาไปหน้าจัดการเมนูชนิดที่ถูกต้อง พร้อมแจ้งว่าเป็นส่วนที่ใช้ร่วมกันหลายหน้า |

Page Sections สร้างจากลำดับที่เรนเดอร์จริง รวมส่วนหลังฟอร์มสั่งซื้อด้วย บล็อกซ้ำต้องมีชื่อแยก เช่น Image 1 และ Image 2 พร้อมรหัสบล็อกสำหรับแยกแยะ ไม่แสดงหัวข้อจากภาพอ้างอิงหากไม่มีส่วนนั้นในสินค้าจริง

## การผูก Preview กับ Editor

สร้างทะเบียนส่วนที่แก้ไขได้จาก layout โดยมีข้อมูลประมาณนี้:

```json
{
  "key": "block:actual-block-id",
  "blockId": "actual-block-id",
  "type": "product_gallery",
  "label": "Product Gallery",
  "targetKind": "content_block",
  "editorUrl": null,
  "shared": false
}
```

ค่าตัวอย่างนี้เป็นรูปแบบที่เสนอ ต้องใช้ ID จริงจาก layout ขณะทำงาน สำหรับส่วนกลางใช้ `targetKind: shared_editor` พร้อม URL ที่สร้างจาก route ฝั่งเซิร์ฟเวอร์ และไม่มี `blockId`

เพิ่ม `data-editor-section-key`, `data-editor-block-id` และ `data-editor-block-type` ให้ wrapper ของบล็อกใน preview เฉพาะโหมดที่ผ่านสิทธิ์แอดมิน เก็บ ID เป็นค่าดิบเดียวกับ editor และใช้ `CSS.escape()` เมื่อค้นหา DOM ห้ามใช้ slug หรือชื่อหัวข้อแทน ID

รวมการนำทางไว้ที่ `openContentBlock(blockId)`:

1. ตรวจว่า ID อยู่ใน layout ปัจจุบันและมีฟอร์มตรงกัน
2. สลับจาก Preview ไป Content Editor โดยรักษา DOM ของฟอร์มไว้
3. ลบ ID ออกจาก `collapsedContentBlockIds` และปรับ class รวมถึงสถานะปุ่มพับตามกลไกเดิม
4. เลื่อน ไฮไลต์ และโฟกัสช่องที่เหมาะสม ถ้ามีหลายช่องให้เริ่มจากช่องแรกที่มองเห็นและแก้ไขได้
5. จำส่วนล่าสุดเพื่อใช้กับ Back to Preview

ไม่เรียก `renderLayout()` ทั้งหน้าเพียงเพื่อเปิดบล็อก เพราะอาจทำให้ค่าที่ยังไม่บันทึก ไฟล์ที่เพิ่งเลือก และ rich text editor สูญหาย หากไม่พบปลายทางให้แจ้งว่าไม่มีบล็อกนี้ใน layout ปัจจุบัน และให้รีโหลด preview โดยไม่ทิ้งฟอร์ม

## การสร้างตัวอย่างหน้าสินค้า

ใช้ iframe ต้นทางเดียวกันในหน้าแอดมินเพื่อให้ CSS หน้าร้านและ editor ไม่กระทบกัน และใช้ Blade renderer เดิมเพื่อให้ภาพตัวอย่างใกล้เคียงหน้าจริง

เสนอเพิ่ม `POST /admin/products/{product}/content/preview` ภายใต้ `auth:admin` และ CSRF สำหรับเรนเดอร์ HTML จาก layout และข้อมูลร่าง โดยไม่เขียนฐานข้อมูล รับค่าเฉพาะรูปแบบ content ที่อนุญาตและตรวจ block ID กับ layout ของสินค้านั้นก่อนเรนเดอร์

ต้องแยกการประกอบข้อมูลสำหรับ preview ออกจากเงื่อนไขหน้าร้านที่ต้องมีข้อมูล published เพื่อให้สินค้าที่ยังไม่เผยแพร่ดูร่างได้ ตัวอย่างใช้ draft layout คู่กับ draft content ส่วนหน้าร้านยังใช้ published layout คู่กับ published content ไม่เปลี่ยนพฤติกรรมหน้าร้านเพื่อรองรับ preview

ใช้การเก็บค่าจากฟอร์มของเดิมที่ Save Draft ใช้อยู่ ทำ snapshot ในหน่วยความจำสำหรับ preview โดยไม่เรียก API บันทึก ตั้งต้นด้วยปุ่ม Refresh Preview และรีเฟรชเมื่อ Back to Preview ส่วนภาพที่ยังอัปโหลดไม่เสร็จให้แสดงสถานะรออัปโหลด

การสื่อสาร iframe ใช้ข้อความ `visual-editor:edit-section` และ `visual-editor:select-section` ตรวจทั้ง `event.origin`, `event.source`, รูปแบบข้อความ และ key ในทะเบียนส่วนก่อนดำเนินการ ใช้ origin ที่เจาะจงเมื่อส่งข้อความ และไม่รับ URL ปลายทางจาก iframe โดยตรง

ภายใน preview การกดพื้นที่เนื้อหาที่แก้ไขได้ควรเลือกส่วนนั้น ปุ่ม Edit ใช้ `preventDefault()` และ `stopPropagation()` เพื่อไม่ให้ลิงก์หรือ gallery เดิมทำงานแทน ปิดการส่งคำสั่งซื้อและการ submit ฟอร์มใน preview รวมถึงป้องกันการออกจาก iframe โดยไม่ได้ตั้งใจ

## ไฟล์ที่คาดว่าจะปรับ

| ไฟล์ | งานที่ต้องทำ |
| --- | --- |
| `resources/views/admin/products/content.blade.php` | เพิ่ม toggle, Preview, Page Sections, Back to Preview และเรียกตัวช่วยนำทาง |
| `resources/views/admin/products/partials/visual-editor.blade.php` ใหม่ | แยก markup ของ Visual Editor ออกจากฟอร์มขนาดใหญ่ |
| `public/admin/js/product-content-visual-editor.js` ใหม่ | ทะเบียนส่วน การนำทาง การส่งข้อความ และสถานะโหมด |
| `public/admin/css/product-content-visual-editor.css` ใหม่ | กรอบสี ปุ่ม Edit แถบข้าง responsive และ focus state |
| `app/Http/Controllers/Admin/ProductContentPreviewController.php` ใหม่ | ตรวจสิทธิ์ รับ snapshot และเรนเดอร์ preview โดยไม่บันทึก |
| `routes/web.php` | เพิ่ม route preview ภายในกลุ่มแอดมินที่ต้องล็อกอิน |
| `resources/views/products/partials/block.blade.php` | เพิ่ม metadata เฉพาะ preview |
| `resources/views/products/show.blade.php` และ `partials/layout-rows.blade.php` | ส่งโหมด preview ไปยัง renderer และควบคุมฟอร์มใน preview ตามความจำเป็น |
| `tests/Feature/Admin/ProductContentPreviewTest.php` ใหม่ | ตรวจสิทธิ์ การเรนเดอร์ร่าง และการไม่เปลี่ยนข้อมูล published |

ชื่อไฟล์ใหม่และ route preview ในตารางเป็นข้อเสนอ ยังไม่ใช่ส่วนที่มีอยู่แล้ว

## ลำดับพัฒนา

### ขั้นแรก การนำทางใน Content Editor

- แยก `openContentBlock()` จากกลไกค้นหาบล็อกและไฮไลต์เดิม
- เพิ่มการคลายบล็อก โฟกัส และจำส่วนล่าสุด
- ทดสอบกับ block ID จริง บล็อกประเภทซ้ำ และค่าที่ยังไม่บันทึก

### ขั้นที่สอง Preview จากข้อมูลร่าง

- เพิ่ม endpoint ที่ผ่านสิทธิ์และไม่บันทึกข้อมูล
- ใช้ renderer เดิมและเพิ่ม metadata ให้แต่ละบล็อก
- รองรับสินค้าที่ยังไม่ published และ layout ก่อนและหลังฟอร์มสั่งซื้อ

### ขั้นที่สาม ปุ่ม Edit และ Page Sections

- เพิ่ม toggle, กรอบสี, ปุ่ม Edit, รายการส่วน และ Back to Preview
- เชื่อมทั้งสองจุดเข้ากับตัวช่วยนำทางเดียวกัน
- ตรวจการเลือกส่วน การสื่อสาร iframe และการรักษาค่าในฟอร์ม

### ขั้นที่สี่ ส่วนกลางและการตรวจหน้าจอ

- ตรวจ source ของ Navigation, Sidebar และ banner กลาง แล้วผูก route ที่มีจริง
- ก่อนออกไปหน้าจัดการอื่นให้จัดการข้อมูลที่ยังไม่บันทึกด้วยตัวเลือกบันทึกร่างหรือยกเลิกการออกจากหน้า
- ตรวจ desktop, mobile, keyboard, gallery, rich text และ Save Draft กับ Publish

## เกณฑ์รับงาน

- กด Edit Gallery แล้วเปิดฟอร์ม Gallery ของบล็อกที่กด ไม่ใช่ Gallery ตัวแรกในหน้า
- กด Product Details หรือเลือกใน Page Sections แล้วไปยังบล็อกเดียวกัน พร้อมคลายบล็อกและโฟกัส
- ส่วนที่อยู่หลังฟอร์มสั่งซื้อและบล็อกประเภทซ้ำมีปลายทางถูกต้อง
- กลับ Preview แล้วเห็นค่าที่แก้ โดยไม่ต้อง Publish และไม่มีการบันทึกอัตโนมัติ
- สลับโหมดและนำทางแล้วค่าฟอร์ม รูปที่เลือก และเนื้อหา rich text ยังอยู่ครบ
- ปิดโหมดแล้วกรอบและปุ่ม Edit หาย แต่ข้อมูลที่กำลังแก้ไม่หาย
- ปุ่มเข้าถึงด้วยคีย์บอร์ดได้ มี focus ชัดเจน และชื่อส่วนอ่านได้โดยไม่อาศัยสีอย่างเดียว
- แถบข้างและปุ่มไม่บังเนื้อหาหรือทำให้หน้าจอเล็กเกิด horizontal overflow
- ผู้ที่ไม่ได้ล็อกอินแอดมินใช้ endpoint preview ไม่ได้ และหน้าสินค้าสาธารณะไม่มีเครื่องมือแก้ไข
- Preview ไม่ส่งคำสั่งซื้อ ไม่เปลี่ยน draft หรือ published ในฐานข้อมูล และไม่รับข้อความจาก iframe อื่น
- Save Draft และ Publish ทำงานตามเดิม รวมถึงโหมด Product Data, Custom Page และ Guide ที่ใช้ไฟล์ร่วมกัน
