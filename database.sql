CREATE DATABASE IF NOT EXISTS biam_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE biam_school;

CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS settings (
  setting_key VARCHAR(100) PRIMARY KEY,
  setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(255) NOT NULL,
  title_bn VARCHAR(255) NOT NULL DEFAULT '',
  body_en TEXT,
  body_bn TEXT,
  publish_date DATE NOT NULL,
  is_published TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

CREATE TABLE IF NOT EXISTS page_content (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_key VARCHAR(100) NOT NULL UNIQUE,
  title_en VARCHAR(255),
  title_bn VARCHAR(255),
  body_en LONGTEXT,
  body_bn LONGTEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_name VARCHAR(160) NOT NULL,
  class_name VARCHAR(80) NOT NULL,
  guardian_name VARCHAR(160) NOT NULL,
  mobile VARCHAR(30) NOT NULL,
  email VARCHAR(160),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(160) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(80) NOT NULL,
  student_name VARCHAR(160) NOT NULL,
  class_name VARCHAR(80),
  exam_name VARCHAR(160) NOT NULL,
  academic_year VARCHAR(10) NOT NULL,
  marks VARCHAR(30),
  grade VARCHAR(20),
  remarks TEXT
);

INSERT
  IGNORE INTO settings(setting_key, setting_value)
VALUES
  ('school_name', 'BIAM LABORATORY SCHOOL'),
('address', 'Please update official address'),
('phone', 'Please update official phone number'),
('email', 'Please update official email address'),
('office_hours', 'Please update office hours');

INSERT INTO
  notices(
    title_en,
    title_bn,
    body_en,
    body_bn,
    publish_date,
    is_published
  )
SELECT
  'Welcome to BIAM Laboratory School',
  'বিয়াম ল্যাবরেটরি স্কুলে স্বাগতম',
  'Welcome to the official school website.',
  'বিদ্যালয়ের অফিসিয়াল ওয়েবসাইটে স্বাগতম।',
  CURDATE(),
  1
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      notices
  );

-- CMS expansion (safe to import over an existing BIAM database)
CREATE TABLE IF NOT EXISTS achievements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(220) NOT NULL,
  title_bn VARCHAR(220) NOT NULL DEFAULT '',
  description_en TEXT,
  description_bn TEXT,
  achievement_date DATE NULL,
  image_path VARCHAR(255) DEFAULT '',
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_en VARCHAR(220) NOT NULL,
  title_bn VARCHAR(220) NOT NULL DEFAULT '',
  image_path VARCHAR(255) NOT NULL,
  category VARCHAR(100) DEFAULT 'Campus',
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS site_sections (
  id INT AUTO_INCREMENT PRIMARY KEY,
  section_key VARCHAR(100) NOT NULL UNIQUE,
  title_en VARCHAR(255) NOT NULL,
  title_bn VARCHAR(255) NOT NULL DEFAULT '',
  body_en TEXT,
  body_bn TEXT,
  image_path VARCHAR(255) DEFAULT '',
  button_text_en VARCHAR(100) DEFAULT '',
  button_text_bn VARCHAR(100) DEFAULT '',
  button_url VARCHAR(255) DEFAULT '',
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(160) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  mobile VARCHAR(30) DEFAULT '',
  account_type ENUM('student', 'teacher') NOT NULL,
  reference_id VARCHAR(80) DEFAULT '',
  password_hash VARCHAR(255) NOT NULL,
  status ENUM('pending', 'approved', 'rejected', 'suspended') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  approved_at DATETIME NULL
);

INSERT
  IGNORE INTO site_sections(
    section_key,
    title_en,
    title_bn,
    body_en,
    body_bn,
    image_path,
    button_text_en,
    button_text_bn,
    button_url,
    is_published,
    sort_order
  )
VALUES
  (
    'hero',
    'Shaping Young Minds. Building a Better Future.',
    'তরুণ মন গড়ি, উজ্জ্বল ভবিষ্যৎ নির্মাণ করি',
    'A welcoming learning community where knowledge, discipline and creativity prepare students for tomorrow.',
    'জ্ঞান, শৃঙ্খলা ও সৃজনশীলতার মাধ্যমে শিক্ষার্থীদের আগামী দিনের জন্য প্রস্তুত করার একটি শিক্ষাবান্ধব পরিবেশ।',
    'assets/images/campus/classroom.jpg',
    'Explore Our School',
    'আমাদের বিদ্যালয় দেখুন',
    'index.php#about',
    1,
    1
  ),
  (
    'about',
    'A place to learn, grow and achieve',
    'শেখা, বেড়ে ওঠা ও সাফল্যের ঠিকানা',
    'BIAM Laboratory School is committed to nurturing curious minds through quality education, supportive teaching and a positive school environment.',
    'মানসম্মত শিক্ষা, সহায়ক পাঠদান ও ইতিবাচক পরিবেশের মাধ্যমে শিক্ষার্থীদের বিকাশে বিয়াম ল্যাবরেটরি স্কুল প্রতিশ্রুতিবদ্ধ।',
    'assets/images/campus/teacher-classroom.jpg',
    'Learn More',
    'আরও জানুন',
    'academics.php',
    1,
    2
  );

INSERT
  IGNORE INTO page_content(page_key, title_en, title_bn, body_en, body_bn)
VALUES
  (
    'academics',
    'Academic Information',
    'একাডেমিক তথ্য',
    'Building knowledge, skills and confidence for the future.',
    'ভবিষ্যতের জন্য জ্ঞান, দক্ষতা ও আত্মবিশ্বাস গড়ে তোলা।'
  ),
  (
    'administration',
    'School Administration',
    'বিদ্যালয় প্রশাসন',
    'Dedicated administration supporting the school community.',
    'বিদ্যালয় পরিবারকে সহায়তা প্রদানকারী নিবেদিত প্রশাসন।'
  ),
  (
    'teachers',
    'Meet Our Teachers',
    'আমাদের শিক্ষকমণ্ডলী',
    'Committed educators supporting students in their learning journey.',
    'শিক্ষার্থীদের শেখার যাত্রায় সহায়তাকারী নিবেদিত শিক্ষকমণ্ডলী।'
  ),
  (
    'students',
    'Student Information',
    'শিক্ষার্থী তথ্য',
    'Access academic resources and student services.',
    'একাডেমিক তথ্য ও শিক্ষার্থী সেবা দেখুন।'
  ),
  (
    'admission',
    'Start Your Journey With Us',
    'আমাদের সঙ্গে আপনার যাত্রা শুরু করুন',
    'Apply for admission to BIAM Laboratory School.',
    'বিয়াম ল্যাবরেটরি স্কুলে ভর্তির জন্য আবেদন করুন।'
  ),
  (
    'contact',
    'Contact BIAM Laboratory School',
    'বিয়াম ল্যাবরেটরি স্কুলে যোগাযোগ',
    'We are here to assist students, parents and visitors.',
    'শিক্ষার্থী, অভিভাবক ও দর্শনার্থীদের সহায়তায় আমরা প্রস্তুত।'
  );

INSERT INTO
  achievements(
    title_en,
    title_bn,
    description_en,
    description_bn,
    achievement_date,
    image_path,
    is_published
  )
SELECT
  'Student Achievement Showcase (Demo)',
  'শিক্ষার্থী অর্জন প্রদর্শনী (ডেমো)',
  'A sample CMS item to demonstrate how school achievements can be highlighted. Replace this with verified school achievements.',
  'বিদ্যালয়ের অর্জন প্রদর্শনের জন্য নমুনা কনটেন্ট। প্রকাশের আগে প্রকৃত তথ্য দিয়ে পরিবর্তন করুন।',
  CURDATE(),
  'assets/images/campus/classroom.jpg',
  1
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      achievements
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Classroom learning (Demo)',
  'শ্রেণিকক্ষে শিক্ষা (ডেমো)',
  'assets/images/campus/classroom.jpg',
  'Campus',
  1
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Teacher support (Demo)',
  'শিক্ষকের সহায়তা (ডেমো)',
  'assets/images/campus/teacher-classroom.jpg',
  'Learning',
  1
WHERE
  (
    SELECT
      COUNT(*)
    FROM
      gallery
  ) < 2;

INSERT INTO
  results(
    student_id,
    student_name,
    class_name,
    exam_name,
    academic_year,
    marks,
    grade,
    remarks
  )
SELECT
  'DEMO-001',
  'Demo Student',
  'Class Five',
  'Annual Examination',
  '2026',
  '85',
  'A',
  'Sample record for testing only. Replace or delete before launch.'
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      results
    WHERE
      student_id = 'DEMO-001'
      AND exam_name = 'Annual Examination'
      AND academic_year = '2026'
  );

INSERT
  IGNORE INTO site_sections(
    section_key,
    title_en,
    title_bn,
    body_en,
    body_bn,
    image_path,
    button_text_en,
    button_text_bn,
    button_url,
    is_published,
    sort_order
  )
VALUES
  (
    'highlights',
    'A strong foundation for every learner',
    'প্রতিটি শিক্ষার্থীর জন্য মজবুত ভিত্তি',
    'Why BIAM',
    'কেন বিয়াম',
    '',
    '',
    '',
    '',
    1,
    3
  ),
  (
    'campus',
    'Learning beyond the classroom',
    'শ্রেণিকক্ষের বাইরেও শেখা',
    'Campus life and learning experiences',
    'ক্যাম্পাস জীবন ও শেখার অভিজ্ঞতা',
    '',
    '',
    '',
    'gallery.php',
    1,
    4
  ),
  (
    'achievements',
    'Achievements & recognition',
    'অর্জন ও স্বীকৃতি',
    'Celebrating student and school achievements',
    'শিক্ষার্থী ও বিদ্যালয়ের অর্জন উদযাপন',
    '',
    '',
    '',
    '',
    1,
    5
  );

INSERT
  IGNORE INTO site_sections(
    section_key,
    title_en,
    title_bn,
    body_en,
    body_bn,
    image_path,
    button_text_en,
    button_text_bn,
    button_url,
    is_published,
    sort_order
  )
VALUES
  (
    'highlight-1',
    'Supportive Learning',
    'সহায়ক শিক্ষার পরিবেশ',
    'Encouraging curiosity, confidence and a love of learning.',
    'কৌতূহল, আত্মবিশ্বাস ও শেখার আগ্রহ তৈরি করা।',
    '',
    '',
    '',
    '',
    1,
    10
  ),
  (
    'highlight-2',
    'Holistic Development',
    'সার্বিক বিকাশ',
    'Balancing classroom learning with creativity and activities.',
    'শ্রেণিকক্ষের শিক্ষার সঙ্গে সৃজনশীলতা ও কার্যক্রমের সমন্বয়।',
    '',
    '',
    '',
    '',
    1,
    11
  ),
  (
    'highlight-3',
    'Values & Discipline',
    'মূল্যবোধ ও শৃঙ্খলা',
    'Building responsibility, respect and positive habits.',
    'দায়িত্ববোধ, শ্রদ্ধা ও ইতিবাচক অভ্যাস গড়ে তোলা।',
    '',
    '',
    '',
    '',
    1,
    12
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'School community (Demo)',
  'বিদ্যালয় পরিবার (ডেমো)',
  'assets/images/campus/principal-office.jpg',
  'Campus',
  1
WHERE
  (
    SELECT
      COUNT(*)
    FROM
      gallery
  ) < 3;

-- Student master records are intentionally maintained through SQL/phpMyAdmin, not Admin CRUD.
CREATE TABLE IF NOT EXISTS students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id VARCHAR(80) NOT NULL UNIQUE,
  full_name VARCHAR(160) NOT NULL,
  class_name VARCHAR(80) NOT NULL,
  guardian_name VARCHAR(160) DEFAULT '',
  guardian_mobile VARCHAR(30) DEFAULT '',
  email VARCHAR(190) DEFAULT '',
  enrollment_year VARCHAR(10) DEFAULT '',
  status ENUM('active', 'inactive', 'graduated') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT
  IGNORE INTO students(
    student_id,
    full_name,
    class_name,
    guardian_name,
    guardian_mobile,
    enrollment_year,
    status
  )
VALUES
(
    'DEMO-001',
    'Demo Student',
    'Class Five',
    'Demo Guardian',
    '01700000000',
    '2026',
    'active'
  );

-- BIAM visual refresh: hero slides, principal message and supplied demo photo library.
-- Existing administrator content is kept; only default campus paths are redirected to the new image set.
UPDATE
  site_sections
SET
  image_path = 'assets/images/school/04-modern-classroom.jpg'
WHERE
  section_key = 'hero'
  AND (
    image_path = ''
    OR image_path = 'assets/images/campus/classroom.jpg'
    OR image_path = 'assets/images/school/01-homepage-banner.jpg'
  );

UPDATE
  site_sections
SET
  image_path = 'assets/images/school/01-homepage-banner.jpg'
WHERE
  section_key = 'hero-2'
  AND (
    image_path = ''
    OR image_path = 'assets/images/school/04-modern-classroom.jpg'
  );

UPDATE
  site_sections
SET
  image_path = 'assets/images/school/04-modern-classroom.jpg'
WHERE
  section_key = 'about'
  AND (
    image_path = ''
    OR image_path = 'assets/images/campus/teacher-classroom.jpg'
  );

INSERT
  IGNORE INTO site_sections(
    section_key,
    title_en,
    title_bn,
    body_en,
    body_bn,
    image_path,
    button_text_en,
    button_text_bn,
    button_url,
    is_published,
    sort_order
  )
VALUES
  (
    'hero-2',
    'A school community that grows together',
    'একসঙ্গে বেড়ে ওঠার বিদ্যালয় পরিবার',
    'Learning, friendship and shared experiences shape a memorable school journey.',
    'শিক্ষা, বন্ধুত্ব ও সম্মিলিত অভিজ্ঞতা গড়ে তোলে স্মরণীয় বিদ্যালয় জীবন।',
    'assets/images/school/01-homepage-banner.jpg',
    'Explore school life',
    'বিদ্যালয় জীবন দেখুন',
    'gallery.php',
    1,
    2
  ),
  (
    'hero-3',
    'Learning through discovery',
    'আবিষ্কারের মাধ্যমে শিক্ষা',
    'Build knowledge and practical skills through exploration and active learning.',
    'অন্বেষণ ও সক্রিয় শিক্ষার মাধ্যমে জ্ঞান ও ব্যবহারিক দক্ষতা গড়ে তুলুন।',
    'assets/images/school/05-science-laboratory.jpg',
    'See our facilities',
    'সুযোগ-সুবিধা দেখুন',
    'gallery.php',
    1,
    3
  ),
  (
    'hero-4',
    'Every learner has a place to shine',
    'প্রতিটি শিক্ষার্থীর বিকশিত হওয়ার সুযোগ আছে',
    'A supportive school community encourages participation, creativity and confidence.',
    'সহায়ক বিদ্যালয় পরিবার অংশগ্রহণ, সৃজনশীলতা ও আত্মবিশ্বাসে উৎসাহ দেয়।',
    'assets/images/school/11-teachers-and-students.jpg',
    'Explore student life',
    'শিক্ষার্থী জীবন দেখুন',
    'gallery.php',
    1,
    4
  ),
  (
    'principal-message',
    'A message from our school leadership',
    'বিদ্যালয় নেতৃত্বের পক্ষ থেকে বার্তা',
    'We believe every learner deserves encouragement, opportunity and a safe place to discover their strengths. Together, we work to make learning purposeful and inspiring.',
    'আমরা বিশ্বাস করি, প্রত্যেক শিক্ষার্থীর উৎসাহ, সুযোগ এবং নিজের সক্ষমতা আবিষ্কারের নিরাপদ পরিবেশ প্রাপ্য। অর্থবহ ও অনুপ্রেরণামূলক শিক্ষা নিশ্চিত করতে আমরা একসঙ্গে কাজ করি।',
    'assets/images/school/16-principals-message.jpg',
    '',
    '',
    '',
    '',
    1,
    20
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Library learning',
  'পাঠাগারে পাঠচর্চা',
  'assets/images/school/03-school-library.jpg',
  'Facilities',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/03-school-library.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Modern classroom',
  'আধুনিক শ্রেণিকক্ষ',
  'assets/images/school/04-modern-classroom.jpg',
  'Facilities',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/04-modern-classroom.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Science laboratory',
  'বিজ্ঞানাগার',
  'assets/images/school/05-science-laboratory.jpg',
  'Facilities',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/05-science-laboratory.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Computer laboratory',
  'কম্পিউটার ল্যাব',
  'assets/images/school/06-computer-laboratory.jpg',
  'Facilities',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/06-computer-laboratory.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Indoor activities',
  'ইনডোর কার্যক্রম',
  'assets/images/school/07-indoor-playground.jpg',
  'Student Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/07-indoor-playground.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Sports and playground',
  'খেলাধুলা ও মাঠ',
  'assets/images/school/08-school-sports-field.jpg',
  'Student Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/08-school-sports-field.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Student achievements',
  'শিক্ষার্থীদের অর্জন',
  'assets/images/school/09-student-achievements.jpg',
  'Achievements',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/09-student-achievements.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Prizes and awards',
  'পুরস্কার ও সম্মাননা',
  'assets/images/school/10-prizes-and-awards.jpg',
  'Achievements',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/10-prizes-and-awards.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Teachers and students',
  'শিক্ষক ও শিক্ষার্থী',
  'assets/images/school/11-teachers-and-students.jpg',
  'School Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/11-teachers-and-students.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Cultural activities',
  'সাংস্কৃতিক কার্যক্রম',
  'assets/images/school/12-cultural-activities.jpg',
  'Events',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/12-cultural-activities.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'School events',
  'বিদ্যালয়ের অনুষ্ঠান',
  'assets/images/school/13-school-events.jpg',
  'Events',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/13-school-events.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'School announcements',
  'বিদ্যালয়ের ঘোষণা',
  'assets/images/school/14-announcements.jpg',
  'School Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/14-announcements.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Admission information',
  'ভর্তি সংক্রান্ত তথ্য',
  'assets/images/school/15-admissions.jpg',
  'School Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/15-admissions.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Principal message',
  'প্রধান শিক্ষকের বার্তা',
  'assets/images/school/16-principals-message.jpg',
  'Leadership',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/16-principals-message.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'Student activities',
  'শিক্ষার্থীদের কার্যক্রম',
  'assets/images/school/17-student-activities.jpg',
  'Student Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/17-student-activities.jpg'
  );

INSERT INTO
  gallery(
    title_en,
    title_bn,
    image_path,
    category,
    is_published
  )
SELECT
  'School life gallery',
  'বিদ্যালয় জীবনের ছবি',
  'assets/images/school/18-school-life-gallery.jpg',
  'School Life',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      gallery
    WHERE
      image_path = 'assets/images/school/18-school-life-gallery.jpg'
  );

INSERT INTO
  achievements(
    title_en,
    title_bn,
    description_en,
    description_bn,
    achievement_date,
    image_path,
    is_published
  )
SELECT
  'Learning and participation (Demo)',
  'শিক্ষা ও অংশগ্রহণ (ডেমো)',
  'Illustrative sample content. Replace with a verified BIAM school achievement before publication.',
  'উদাহরণস্বরূপ নমুনা কনটেন্ট। প্রকাশের আগে বিয়াম বিদ্যালয়ের যাচাইকৃত অর্জনের তথ্য যুক্ত করুন।',
  CURDATE(),
  'assets/images/school/09-student-achievements.jpg',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      achievements
    WHERE
      title_en = 'Learning and participation (Demo)'
  );

INSERT INTO
  achievements(
    title_en,
    title_bn,
    description_en,
    description_bn,
    achievement_date,
    image_path,
    is_published
  )
SELECT
  'Awards and recognition (Demo)',
  'পুরস্কার ও স্বীকৃতি (ডেমো)',
  'A sample achievement card demonstrating the image-led CMS layout. Replace with an official award or event.',
  'ইমেজভিত্তিক সিএমএস লেআউট দেখানোর জন্য নমুনা অর্জন। প্রকৃত পুরস্কার বা অনুষ্ঠানের তথ্য দিয়ে পরিবর্তন করুন।',
  CURDATE(),
  'assets/images/school/10-prizes-and-awards.jpg',
  1
FROM
  DUAL
WHERE
  NOT EXISTS (
    SELECT
      1
    FROM
      achievements
    WHERE
      title_en = 'Awards and recognition (Demo)'
  );

-- Helpful indexes for frequently used public feeds and admin lists.
DELIMITER $ $ DROP PROCEDURE IF EXISTS biam_add_missing_indexes $ $ CREATE PROCEDURE biam_add_missing_indexes() BEGIN IF NOT EXISTS (
  SELECT
    1
  FROM
    information_schema.statistics
  WHERE
    table_schema = DATABASE()
    AND table_name = 'notices'
    AND index_name = 'idx_notices_public_feed'
) THEN
ALTER TABLE
  notices
ADD
  INDEX idx_notices_public_feed (is_published, publish_date, id);

END IF;

IF NOT EXISTS (
  SELECT
    1
  FROM
    information_schema.statistics
  WHERE
    table_schema = DATABASE()
    AND table_name = 'staff'
    AND index_name = 'idx_staff_public_category'
) THEN
ALTER TABLE
  staff
ADD
  INDEX idx_staff_public_category (is_published, category, sort_order, id);

END IF;

IF NOT EXISTS (
  SELECT
    1
  FROM
    information_schema.statistics
  WHERE
    table_schema = DATABASE()
    AND table_name = 'gallery'
    AND index_name = 'idx_gallery_public'
) THEN
ALTER TABLE
  gallery
ADD
  INDEX idx_gallery_public (is_published, id);

END IF;

IF NOT EXISTS (
  SELECT
    1
  FROM
    information_schema.statistics
  WHERE
    table_schema = DATABASE()
    AND table_name = 'users'
    AND index_name = 'idx_users_status_created'
) THEN
ALTER TABLE
  users
ADD
  INDEX idx_users_status_created (status, created_at);

END IF;

END $ $ CALL biam_add_missing_indexes() $ $ DROP PROCEDURE biam_add_missing_indexes $ $ DELIMITER;

-- BIAM Laboratory School: safe demo faculty + leadership seed/migration
-- Import this file after selecting/creating the biam_school database in phpMyAdmin.
-- It does not delete tables, users, admins or existing school records.
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