BIAM LABORATORY SCHOOL — REDESIGNED CMS WEBSITE
================================================

LOCAL REQUIREMENTS
- XAMPP with Apache, PHP 8.1+ and MySQL/MariaDB
- PHP extensions: PDO, PDO_MYSQL, fileinfo, mbstring

SAFE UPGRADE FOR AN EXISTING BIAM INSTALLATION
1. Back up C:\xampp\htdocs\biam-school and export the biam_school database from phpMyAdmin.
2. Extract this package so index.php is directly inside C:\xampp\htdocs\biam-school\. Do not create a nested biam-school\biam-school folder.
3. Keep your existing database. Do not drop or recreate it.
4. In phpMyAdmin, click the existing biam_school database, choose Import, and import database-update.sql from this package. This inserts demo leadership/faculty profiles and example contact settings only when matching records are absent; it does not delete admins or existing records.
5. Start Apache and MySQL in XAMPP.
6. Check config.php. Standard XAMPP defaults are DB_USER=root and DB_PASS=''.
7. Public website: http://localhost/biam-school/
8. Public login: http://localhost/biam-school/portal/login.php
9. Admin login: http://localhost/biam-school/admin/login.php
10. After confirming that your existing Admin account still works, delete install.php from the project for security.

CLEAN INSTALL
- If this is a brand-new installation, create/import database.sql in phpMyAdmin instead of using only database-update.sql.
- Use install.php only when the admins table is empty. It will not reset an existing administrator. Delete install.php after the first administrator is created.

FACULTY / LEADERSHIP
- The demo directory contains six sample teacher records and three sample leadership records.
- These names, designations and generated portraits are illustrative examples, not verified BIAM staff.
- Edit or replace them in Admin > Leadership & Teachers before publishing. The public Faculty page supports search by name/designation.

LOGIN BEHAVIOUR AND PASSWORD SECURITY
- The public Login icon always opens the public sign-in page, even when an admin session is already active. It no longer silently redirects an active admin to the dashboard.
- The same sign-in form accepts an administrator username or an approved student/teacher email. A successful account switch clears the other role's session.
- New student/teacher registrations remain pending until an administrator approves them. Pending requests appear in Admin > User Approvals. Email notifications are not configured in this local build.
- Passwords are stored using PHP password_hash(PASSWORD_DEFAULT), verified using password_verify(), and rehashed after successful login when required. Passwords are never stored in reversible/plaintext form.

CMS FEATURES
- Edit homepage hero slides, introduction and leadership message.
- Manage notices, staff, achievements, gallery photographs, page content and school settings.
- Notice records are searchable and paginated; the header ticker only queries the six newest published notices.
- Student master records are deliberately not exposed as Admin Dashboard CRUD. Maintain student master records through SQL/phpMyAdmin as requested by the supervisor.
- Public results lookup uses the results table.

DEMO CONTACT VALUES
- The database-update.sql file can set example contact values if the corresponding settings are blank or still say “Please update”.
- The example address, phone, email and office hours are not verified BIAM contact details. Replace them in Admin > School Settings before publication.

BEFORE PUBLIC DEPLOYMENT
- Replace all sample staff profiles, photos, achievements, notices, contact information and other demo content with approved BIAM information.
- Do not use the XAMPP root account with a blank password on a public server. Create a least-privilege database user with a strong password.
- Use HTTPS, secure session settings, private database backups and regular backups.
- Keep database SQL and setup files private; delete install.php after initial setup.
- Review student data privacy and account approval policies with the school.
