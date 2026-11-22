-- BIAM Laboratory School: safe demo faculty + leadership seed/migration
-- Import this file after selecting/creating the biam_school database in phpMyAdmin.
-- It does not delete tables, users, admins or existing school records.
CREATE DATABASE IF NOT EXISTS biam_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE biam_school;

CREATE TABLE IF NOT EXISTS settings (
  setting_key VARCHAR(100) PRIMARY KEY,
  setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS staff (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name_en VARCHAR(160) NOT NULL,
  name_bn VARCHAR(160) DEFAULT '',
  designation_en VARCHAR(160) DEFAULT '',
  designation_bn VARCHAR(160) DEFAULT '',
  bio_en TEXT,
  bio_bn TEXT,
  photo VARCHAR(255) DEFAULT '',
  category ENUM('leadership', 'teacher') DEFAULT 'teacher',
  is_published TINYINT(1) DEFAULT 1,
  sort_order INT DEFAULT 0
);

-- Demo contact values are deliberately marked as examples; replace them in Admin > School Settings.
INSERT
  IGNORE INTO settings(setting_key, setting_value)
VALUES
  ('school_name', 'BIAM Laboratory School'),
  (
    'address',
    'Kakrail, Dhaka-1000, Bangladesh (Demo Address)'
  ),
  ('phone', '+880 1715 442678 (Demo Number)'),
  ('email', 'demo@biamlaboratoryschool.example'),
  (
    'office_hours',
    'Sunday–Thursday, 8:00 AM–4:00 PM (Demo Hours)'
  );

UPDATE
  settings
SET
  setting_value = 'Kakrail, Dhaka-1000, Bangladesh (Demo Address)'
WHERE
  setting_key = 'address'
  AND (
    setting_value = ''
    OR setting_value LIKE 'Please update%'
  );

UPDATE
  settings
SET
  setting_value = '+880 1715 442678 (Demo Number)'
WHERE
  setting_key = 'phone'
  AND (
    setting_value = ''
    OR setting_value LIKE 'Please update%'
  );

UPDATE
  settings
SET
  setting_value = 'demo@biamlaboratoryschool.example'
WHERE
  setting_key = 'email'
  AND (
    setting_value = ''
    OR setting_value LIKE 'Please update%'
  );

UPDATE
  settings
SET
  setting_value = 'Sunday–Thursday, 8:00 AM–4:00 PM (Demo Hours)'
WHERE
  setting_key = 'office_hours'
  AND (
    setting_value = ''
    OR setting_value LIKE 'Please update%'
  );

-- Illustrative leadership. Names/photos are not verified BIAM personnel.
INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Dr. Farid Uddin Ahmed',
  'ড. ফরিদ উদ্দিন আহমেদ',
  'Principal / Head of Institution',
  'অধ্যক্ষ / প্রতিষ্ঠান প্রধান',
  'DEMO PROFILE — Illustrative leadership content for the website preview. Replace with the approved institutional profile before publishing.',
  'নমুনা প্রোফাইল — ওয়েবসাইট প্রদর্শনের জন্য তৈরি। প্রকাশের আগে অনুমোদিত প্রাতিষ্ঠানিক তথ্য যুক্ত করুন।',
  'assets/images/leadership/head-of-institution.jpg',
  'leadership',
  1,
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Dr. Farid Uddin Ahmed'
      AND category = 'leadership'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Md. Rezaul Karim',
  'মোঃ রেজাউল করিম',
  'Head Teacher',
  'প্রধান শিক্ষক',
  'DEMO PROFILE — Illustrative leadership content for the website preview. Replace with the approved institutional profile before publishing.',
  'নমুনা প্রোফাইল — ওয়েবসাইট প্রদর্শনের জন্য তৈরি। প্রকাশের আগে অনুমোদিত প্রাতিষ্ঠানিক তথ্য যুক্ত করুন।',
  'assets/images/leadership/head-teacher.jpg',
  'leadership',
  1,
  2
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Md. Rezaul Karim'
      AND category = 'leadership'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Shahana Akter',
  'শাহানা আক্তার',
  'Academic Coordinator',
  'একাডেমিক সমন্বয়কারী',
  'DEMO PROFILE — Illustrative leadership content for the website preview. Replace with the approved institutional profile before publishing.',
  'নমুনা প্রোফাইল — ওয়েবসাইট প্রদর্শনের জন্য তৈরি। প্রকাশের আগে অনুমোদিত প্রাতিষ্ঠানিক তথ্য যুক্ত করুন।',
  'assets/images/leadership/academic-coordinator.jpg',
  'leadership',
  1,
  3
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Shahana Akter'
      AND category = 'leadership'
  );

-- Illustrative faculty profiles. All records are editable in Admin > Leadership & Teachers.
INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Md. Mahbubur Rahman',
  'মোঃ মাহবুবুর রহমান',
  'Assistant Head Teacher · Mathematics',
  'সহকারী প্রধান শিক্ষক · গণিত',
  'DEMO PROFILE — Sample mathematics teacher profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — গণিত শিক্ষকের নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  '',
  'teacher',
  1,
  4
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Md. Mahbubur Rahman'
      AND category = 'teacher'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Nusrat Jahan',
  'নুসরাত জাহান',
  'Senior Assistant Teacher · English',
  'সিনিয়র সহকারী শিক্ষক · ইংরেজি',
  'DEMO PROFILE — Sample English teacher profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — ইংরেজি শিক্ষকের নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  '',
  'teacher',
  1,
  5
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Nusrat Jahan'
      AND category = 'teacher'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Farzana Akter',
  'ফারজানা আক্তার',
  'Assistant Teacher · Bangla',
  'সহকারী শিক্ষক · বাংলা',
  'DEMO PROFILE — Sample Bangla teacher profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — বাংলা শিক্ষকের নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  'assets/images/faculty/faculty-01.jpg',
  'teacher',
  1,
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Farzana Akter'
      AND category = 'teacher'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Md. Saiful Islam',
  'মোঃ সাইফুল ইসলাম',
  'Assistant Teacher · Science',
  'সহকারী শিক্ষক · বিজ্ঞান',
  'DEMO PROFILE — Sample science teacher profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — বিজ্ঞান শিক্ষকের নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  'assets/images/faculty/faculty-02.jpg',
  'teacher',
  1,
  2
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Md. Saiful Islam'
      AND category = 'teacher'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Tania Sultana',
  'তানিয়া সুলতানা',
  'Assistant Teacher · ICT',
  'সহকারী শিক্ষক · তথ্য ও যোগাযোগ প্রযুক্তি',
  'DEMO PROFILE — Sample ICT teacher profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — আইসিটি শিক্ষকের নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  'assets/images/faculty/faculty-03.jpg',
  'teacher',
  1,
  3
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Tania Sultana'
      AND category = 'teacher'
  );

INSERT INTO
  staff(
    name_en,
    name_bn,
    designation_en,
    designation_bn,
    bio_en,
    bio_bn,
    photo,
    category,
    is_published,
    sort_order
  )
SELECT
  'Md. Kamrul Hasan',
  'মোঃ কামরুল হাসান',
  'Physical Education Instructor · Sports',
  'শারীরিক শিক্ষা প্রশিক্ষক · খেলাধুলা',
  'DEMO PROFILE — Sample sports and physical education profile. Replace with verified staff details before publishing.',
  'নমুনা প্রোফাইল — খেলাধুলা ও শারীরিক শিক্ষার নমুনা পরিচিতি। প্রকাশের আগে যাচাইকৃত তথ্য যুক্ত করুন।',
  '',
  'teacher',
  1,
  6
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      staff
    WHERE
      name_en = 'Md. Kamrul Hasan'
      AND category = 'teacher'
  );

-- Keep the sample faculty profiles photo-matched and ordered consistently, including if this migration is rerun.
UPDATE
  staff
SET
  photo = 'assets/images/faculty/faculty-01.jpg',
  sort_order = 1
WHERE
  name_en = 'Farzana Akter'
  AND category = 'teacher'
  AND (
    photo = ''
    OR photo LIKE 'assets/images/faculty/%'
  )
  AND sort_order IN (0, 3, 1);

UPDATE
  staff
SET
  photo = 'assets/images/faculty/faculty-02.jpg',
  sort_order = 2
WHERE
  name_en = 'Md. Saiful Islam'
  AND category = 'teacher'
  AND (
    photo = ''
    OR photo LIKE 'assets/images/faculty/%'
  )
  AND sort_order IN (0, 4, 2);

UPDATE
  staff
SET
  photo = 'assets/images/faculty/faculty-03.jpg',
  sort_order = 3
WHERE
  name_en = 'Tania Sultana'
  AND category = 'teacher'
  AND (
    photo = ''
    OR photo LIKE 'assets/images/faculty/%'
  )
  AND sort_order IN (0, 5, 3);

UPDATE
  staff
SET
  photo = '',
  sort_order = 4
WHERE
  name_en = 'Md. Mahbubur Rahman'
  AND category = 'teacher'
  AND (
    photo LIKE 'assets/images/faculty/%'
    OR photo = ''
  )
  AND sort_order IN (0, 1, 4);

UPDATE
  staff
SET
  photo = '',
  sort_order = 5
WHERE
  name_en = 'Nusrat Jahan'
  AND category = 'teacher'
  AND (
    photo LIKE 'assets/images/faculty/%'
    OR photo = ''
  )
  AND sort_order IN (0, 2, 5);

UPDATE
  staff
SET
  photo = '',
  sort_order = 6
WHERE
  name_en = 'Md. Kamrul Hasan'
  AND category = 'teacher'
  AND (
    photo LIKE 'assets/images/faculty/%'
    OR photo = ''
  )
  AND sort_order IN (0, 6);