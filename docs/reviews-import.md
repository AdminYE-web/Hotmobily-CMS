# Review importer

ระบบใหม่ย้ายการทำงานจาก `original-web/get_data_review.php` มาเป็น Laravel service และ Artisan command โดยใช้ชื่อตารางที่เข้ากันได้คือ `reviews_hm` แต่บันทึกลงฐานข้อมูลของระบบใหม่ทั้งหมด

## สิ่งที่ทำงานเหมือนเดิม

- อ่านข้อมูลจากชีต `Form Responses 1` คอลัมน์ A ถึง H
- อ่านเฉพาะแถวที่มี `row_stamp` มากกว่าแถวล่าสุดในฐานข้อมูล
- แปลงคอลัมน์เป็น `comment`, `service`, `product`, `product_type`, `sale_name` และ `date_reviews`
- ดาวน์โหลดรูปจากลิงก์ Google Drive ไปที่ `public/reviews/upload`
- ถ้าไม่มีผู้รับผิดชอบ จะใช้ `その他・覚えていない`
- ใช้ `row_stamp` เป็นจุดเริ่มต้นของการ import รอบถัดไป เพื่อไม่ให้รันซ้ำแล้วสร้างรีวิวซ้ำ

## ตั้งค่าเครื่องใหม่

เพิ่มค่าต่อไปนี้ในไฟล์ `.env` ของโปรเจกต์ใหม่ โดยใช้ Spreadsheet ID และ API key ชุดเดิมที่มีสิทธิ์อ่าน Google Sheets/Drive:

```dotenv
REVIEWS_GOOGLE_API_KEY=ใส่_api_key_ที่นี่
# Optional token for /get_data_review.php; leave empty when using CLI only.
REVIEWS_IMPORT_TOKEN=
REVIEWS_GOOGLE_SPREADSHEET_ID=ใส่_spreadsheet_id_ที่นี่
REVIEWS_GOOGLE_SHEET_NAME="Form Responses 1"
REVIEWS_GOOGLE_FIRST_DATA_ROW=2
REVIEWS_GOOGLE_TIMEOUT=30
REVIEWS_UPLOAD_PATH="reviews/upload"
REVIEWS_FALLBACK_SALE_NAME="その他・覚えていない"
REVIEWS_DISPLAY_LIMIT=20
```

จากนั้นรัน:

```bash
php artisan migrate
php artisan reviews:import --dry-run
php artisan reviews:import
php artisan reviews:import --dry-run --limit=20
php artisan reviews:import --limit=20
```

Migration จะสร้างตาราง `reviews_hm` ในฐานข้อมูลของระบบใหม่ตามค่า `DB_*` ใน `.env` ไม่ต้องเชื่อมต่อฐานข้อมูลเก่า

`--dry-run` จะอ่านจำนวนแถวใหม่โดยไม่บันทึกข้อมูลหรือดาวน์โหลดรูป

`--limit=20` จำกัดจำนวนแถวจาก Google Sheet ในรอบนั้น เหมาะสำหรับทดสอบก่อนนำเข้าข้อมูลทั้งหมด

## จุดที่ใช้ข้อมูลรีวิว

- หน้าแรก: `/`
- หน้ารีวิว: `/reviews/`
- endpoint เดิมที่หน้าเก่าเรียก: `/get_review.php`
- URL เดิมสำหรับสั่ง import: `/get_data_review.php` (ถ้าตั้ง token ให้เรียก `/get_data_review.php?token=...`)

ไม่ต้องวาง `get_data_review.php` หรือ hardcode database password ไว้ในโปรเจกต์ใหม่แล้ว ให้เรียก command ผ่าน cron/scheduler ตามรอบที่ต้องการ เช่น:

```bash
php artisan reviews:import
```

Google Sheet และไฟล์ Drive ต้องเปิดสิทธิ์ให้ API key อ่านได้ เพราะฟังก์ชันเดิมใช้ developer key แบบ public เช่นเดียวกัน
