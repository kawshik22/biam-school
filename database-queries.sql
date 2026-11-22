-- BIAM Laboratory School: sample SQL operations
-- Run these queries after importing database.sql in phpMyAdmin.
-- DEMO-001 is a clearly labelled sample record. Replace it with verified data.
-- 1) Add a student record (Student Records are managed here, not in Admin CMS)
INSERT INTO
  students (
    student_id,
    full_name,
    class_name,
    guardian_name,
    guardian_mobile,
    email,
    enrollment_year,
    status
  )
VALUES
  (
    'DEMO-002',
    'Sample Student Two',
    'Class Six',
    'Sample Guardian',
    '01700000001',
    'demo2@example.test',
    '2026',
    'active'
  );

-- 2) View student records
SELECT
  student_id,
  full_name,
  class_name,
  guardian_name,
  status
FROM
  students
ORDER BY
  id DESC;

-- 3) Find one student by ID
SELECT
  *
FROM
  students
WHERE
  student_id = 'DEMO-002';

-- 4) Update a student's class or status
UPDATE
  students
SET
  class_name = 'Class Seven',
  status = 'active'
WHERE
  student_id = 'DEMO-002';

-- 5) Add an examination result for a student
INSERT INTO
  results (
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
  'DEMO-002',
  'Sample Student Two',
  'Class Six',
  'Annual Examination',
  '2026',
  '88',
  'A',
  'Sample result - replace before real use.'
WHERE
  EXISTS (
    SELECT
      1
    FROM
      students
    WHERE
      student_id = 'DEMO-002'
  );

-- 6) Check results (the public results page uses student_id + exam_name + academic_year)
SELECT
  *
FROM
  results
WHERE
  student_id = 'DEMO-002'
  AND exam_name = 'Annual Examination'
  AND academic_year = '2026';

-- 7) Delete the sample student and their sample results if needed
-- DELETE FROM results WHERE student_id = 'DEMO-002';
-- DELETE FROM students WHERE student_id = 'DEMO-002';