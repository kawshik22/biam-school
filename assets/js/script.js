document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('languageToggle');
  const mobileToggle = document.querySelector('.mobile-menu-toggle');
  const nav = document.getElementById('primaryNav');
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Responsive navigation: keep the native details dropdowns keyboard-accessible.
  if (mobileToggle && nav) {
    mobileToggle.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }

  const dictionary = {
    'Dashboard':'ড্যাশবোর্ড','Manage website content':'ওয়েবসাইটের কনটেন্ট পরিচালনা','Manage the public website, school updates and account requests.':'পাবলিক ওয়েবসাইট, স্কুল আপডেট ও অ্যাকাউন্টের আবেদন পরিচালনা করুন।','Content management system':'কনটেন্ট ম্যানেজমেন্ট সিস্টেম','Homepage & Hero':'হোমপেজ ও হিরো','Homepage Sections':'হোমপেজের সেকশন','Notices & News':'নোটিশ ও খবর','News & Notices':'খবর ও নোটিশ','Awards & Achievements':'পুরস্কার ও অর্জন','Photo Gallery':'ফটো গ্যালারি','Leadership & Teachers':'নেতৃত্ব ও শিক্ষকবৃন্দ','Page Content':'পেজের কনটেন্ট','School Settings':'বিদ্যালয়ের সেটিংস','User Approvals':'ব্যবহারকারীর অনুমোদন','Admission Enquiries':'ভর্তি সংক্রান্ত অনুসন্ধান','Contact Messages':'যোগাযোগের বার্তা','Preview Website ↗':'ওয়েবসাইট প্রিভিউ ↗','Manage':'পরিচালনা','Manage the website content':'ওয়েবসাইটের কনটেন্ট পরিচালনা','Content management':'কনটেন্ট ব্যবস্থাপনা','Add new record':'নতুন রেকর্ড যোগ করুন','Edit record':'রেকর্ড সম্পাদনা করুন','Title (English)':'শিরোনাম (ইংরেজি)','Title (Bangla)':'শিরোনাম (বাংলা)','Description (English)':'বিবরণ (ইংরেজি)','Description (Bangla)':'বিবরণ (বাংলা)','Publish date':'প্রকাশের তারিখ','Published':'প্রকাশিত','Unpublished':'অপ্রকাশিত','Save':'সংরক্ষণ করুন','Save Section':'সেকশন সংরক্ষণ করুন','Delete':'মুছে ফেলুন','Search records':'রেকর্ড খুঁজুন','Search title or name':'শিরোনাম বা নাম খুঁজুন','Account type':'অ্যাকাউন্টের ধরন','Contact':'যোগাযোগ','Actions':'কার্যক্রম','Edit':'সম্পাদনা','Delete this record?':'এই রেকর্ডটি মুছে ফেলবেন?','Sign In':'লগইন করুন','Sign in to CMS →':'সিএমএস-এ লগইন করুন →','Home':'হোম','About Us':'আমাদের সম্পর্কে','School Overview':'বিদ্যালয় পরিচিতি','Administration':'প্রশাসন','Our Teachers':'শিক্ষকমণ্ডলী','Academics':'একাডেমিক','Admission':'ভর্তি','Students':'শিক্ষার্থী','Student Information':'শিক্ষার্থী তথ্য','Examination Results':'পরীক্ষার ফলাফল','Student Portal':'শিক্ষার্থী পোর্টাল','Facilities & Gallery':'সুযোগ-সুবিধা ও গ্যালারি','News & Notices':'খবর ও নোটিশ','Contact':'যোগাযোগ','Notices':'নোটিশ','Results':'ফলাফল','Email address':'ইমেইল ঠিকানা','Password':'পাসওয়ার্ড','Full name':'পূর্ণ নাম','Mobile number':'মোবাইল নম্বর','Account type':'অ্যাকাউন্টের ধরন','Choose account type':'অ্যাকাউন্টের ধরন নির্বাচন করুন','Student / Teacher ID (if available)':'শিক্ষার্থী / শিক্ষক আইডি (যদি থাকে)','Edit the hero and introduction content. The image can be uploaded or set using an existing relative path.':'হিরো ও পরিচিতির কনটেন্ট সম্পাদনা করুন। ছবি আপলোড অথবা বিদ্যমান রিলেটিভ পাথ ব্যবহার করা যাবে।','Welcome,':'স্বাগতম,','Log Out':'লগআউট','View Website':'ওয়েবসাইট দেখুন','CONTENT MANAGEMENT':'কনটেন্ট ব্যবস্থাপনা','CONTENT MANAGEMENT SYSTEM':'কনটেন্ট ম্যানেজমেন্ট সিস্টেম','VISUAL CONTENT':'ভিজ্যুয়াল কনটেন্ট','Recently published photographs':'সাম্প্রতিক প্রকাশিত ছবি','Preview the images currently available on the public school website.':'পাবলিক ওয়েবসাইটে বর্তমানে প্রকাশিত ছবিগুলো দেখুন।','Manage gallery':'গ্যালারি পরিচালনা','Homepage & hero slides':'হোমপেজ ও হিরো স্লাইড','User account approvals':'ব্যবহারকারী অ্যাকাউন্ট অনুমোদন','Student master records are maintained in MySQL/phpMyAdmin, not from this dashboard.':'শিক্ষার্থীদের মূল রেকর্ড এই ড্যাশবোর্ডে নয়, MySQL/phpMyAdmin থেকে পরিচালনা করা হয়।','Student records are intentionally not exposed as a dashboard CRUD module. As requested by the supervisor, maintain student master data using SQL queries in phpMyAdmin. Public result lookup uses the results table.':'সুপারভাইজারের নির্দেশ অনুযায়ী শিক্ষার্থীদের মূল রেকর্ড ড্যাশবোর্ডে CRUD হিসেবে রাখা হয়নি। phpMyAdmin-এ SQL query ব্যবহার করে রেকর্ড পরিচালনা করুন। পাবলিক ফলাফল অনুসন্ধানে results টেবিল ব্যবহৃত হয়।','Password (minimum 10 characters)':'পাসওয়ার্ড (কমপক্ষে ১০ অক্ষর)','Create an account':'অ্যাকাউন্ট তৈরি করুন','Your account will be reviewed by the school administrator before access is activated.':'অ্যাকাউন্ট সক্রিয় হওয়ার আগে বিদ্যালয়ের প্রশাসক আপনার আবেদন পর্যালোচনা করবেন।','Sign in with your approved student or teacher account.':'অনুমোদিত শিক্ষার্থী বা শিক্ষক অ্যাকাউন্ট দিয়ে লগইন করুন।','Your account is awaiting administrator approval.':'আপনার অ্যাকাউন্ট প্রশাসকের অনুমোদনের অপেক্ষায় রয়েছে।','This account is not active. Please contact the school office.':'এই অ্যাকাউন্টটি সক্রিয় নয়। বিদ্যালয় অফিসে যোগাযোগ করুন।','Invalid email or password.':'ইমেইল অথবা পাসওয়ার্ড সঠিক নয়.','Submit registration':'নিবন্ধন জমা দিন','Go to login':'লগইন পেজে যান','Already registered?':'ইতোমধ্যে নিবন্ধিত?','Sign in':'লগইন','Sign out':'লগআউট','Welcome':'স্বাগতম','Your account is approved and active.':'আপনার অ্যাকাউন্ট অনুমোদিত ও সক্রিয়।','Reference ID':'রেফারেন্স আইডি','Not provided':'দেওয়া হয়নি','Portal services can be added here as the school\'s requirements are finalised.':'বিদ্যালয়ের প্রয়োজন অনুযায়ী এখানে পোর্টাল সেবা যুক্ত করা হবে.','Apply for Admission':'ভর্তির আবেদন','Login':'লগইন','Create Account':'অ্যাকাউন্ট তৈরি','User Portal':'ইউজার পোর্টাল','LATEST UPDATES':'সর্বশেষ আপডেট','All notices →':'সব নোটিশ →','School name':'বিদ্যালয়ের নাম','Address':'ঠিকানা','Phone':'ফোন','Office hours':'অফিস সময়সূচি','Username or email':'ইউজারনেম অথবা ইমেইল','Enter username or email':'ইউজারনেম অথবা ইমেইল লিখুন','Incorrect username/email or password.':'ইউজারনেম/ইমেইল অথবা পাসওয়ার্ড সঠিক নয়।','Too many sign-in attempts. Please wait 15 minutes and try again.':'অনেকবার লগইন চেষ্টা করা হয়েছে। অনুগ্রহ করে ১৫ মিনিট অপেক্ষা করে আবার চেষ্টা করুন।','Use your administrator username or your approved student/teacher email address.':'অ্যাডমিন ইউজারনেম অথবা অনুমোদিত শিক্ষার্থী/শিক্ষকের ইমেইল ঠিকানা ব্যবহার করুন।','New student or teacher?':'নতুন শিক্ষার্থী বা শিক্ষক?','Class':'শ্রেণি','Year':'বছর','Marks':'নম্বর','Grade':'গ্রেড','Select Class':'শ্রেণি নির্বাচন করুন','No published notices at this time.':'এ মুহূর্তে কোনো প্রকাশিত নোটিশ নেই।','Please complete all fields with valid information.':'সঠিক তথ্য দিয়ে সব ঘর পূরণ করুন।','Unable to send your message right now. Please try later.':'এই মুহূর্তে বার্তা পাঠানো যাচ্ছে না। পরে আবার চেষ্টা করুন।','Contact the school office for the official address.':'অফিসিয়াল ঠিকানার জন্য বিদ্যালয় অফিসে যোগাযোগ করুন।','Official phone information will be published here.':'অফিসিয়াল ফোন নম্বর এখানে প্রকাশ করা হবে।','Official email information will be published here.':'অফিসিয়াল ইমেইল ঠিকানা এখানে প্রকাশ করা হবে।','Please contact the school office for visiting hours.':'বিদ্যালয়ে আসার সময় জানতে অফিসে যোগাযোগ করুন।','View Academic Information →':'একাডেমিক তথ্য দেখুন →','Check Results →':'ফলাফল দেখুন →','Login →':'লগইন →','Contact School →':'বিদ্যালয়ে যোগাযোগ করুন →','Gallery photographs will be published here by the school administrator.':'বিদ্যালয় প্রশাসক এখানে গ্যালারির ছবি প্রকাশ করবেন।','Please check your details. Password must be at least 10 characters.':'আপনার তথ্য যাচাই করুন। পাসওয়ার্ড কমপক্ষে ১০ অক্ষরের হতে হবে।','This email may already be registered. Please try logging in.':'এই ইমেইল দিয়ে আগে নিবন্ধন করা হয়ে থাকতে পারে। অনুগ্রহ করে লগইন করুন।','Unable to submit right now. Please contact the school office.':'এই মুহূর্তে আবেদন জমা দেওয়া যাচ্ছে না। বিদ্যালয় অফিসে যোগাযোগ করুন।','No teacher profiles are published yet.':'এখনও কোনো শিক্ষক প্রোফাইল প্রকাশ করা হয়নি।','Teacher profiles will be added by the administrator.':'প্রশাসক শিক্ষক প্রোফাইল যুক্ত করবেন।','View Academic Information →':'একাডেমিক তথ্য দেখুন →','Contact School →':'বিদ্যালয়ে যোগাযোগ করুন →','Section':'সেকশন','Action':'কার্যক্রম','Yes':'হ্যাঁ','No':'না','Current image path':'বর্তমান ছবির পাথ','Upload replacement image':'নতুন ছবি আপলোড করুন','Upload image (JPG, PNG or WEBP, max 5 MB)':'ছবি আপলোড করুন (JPG, PNG অথবা WEBP, সর্বোচ্চ ৫ MB)','Profile category':'প্রোফাইলের ধরন','Name (English)':'নাম (ইংরেজি)','Name (Bangla)':'নাম (বাংলা)','Designation (English)':'পদবি (ইংরেজি)','Designation (Bangla)':'পদবি (বাংলা)','Biography (English)':'জীবনী (ইংরেজি)','Biography (Bangla)':'জীবনী (বাংলা)','Notice body (English)':'নোটিশের বিবরণ (ইংরেজি)','Notice body (Bangla)':'নোটিশের বিবরণ (বাংলা)','Achievement title (English)':'অর্জনের শিরোনাম (ইংরেজি)','Achievement title (Bangla)':'অর্জনের শিরোনাম (বাংলা)','Image title (English)':'ছবির শিরোনাম (ইংরেজি)','Image title (Bangla)':'ছবির শিরোনাম (বাংলা)','Current photo path':'বর্তমান ছবির পাথ','Category':'বিভাগ','Date / Category':'তারিখ / বিভাগ','Title / Name':'শিরোনাম / নাম','Published':'প্রকাশিত','Draft':'খসড়া','Approve':'অনুমোদন','Reject':'প্রত্যাখ্যান','Suspend':'স্থগিত','Set Pending':'অপেক্ষমাণ করুন','Registered':'নিবন্ধিত','Pending':'অপেক্ষমাণ','Approved':'অনুমোদিত','Rejected':'প্রত্যাখ্যাত','Suspended':'স্থগিত','Add a new record':'নতুন রেকর্ড যোগ করুন','Save Settings':'সেটিংস সংরক্ষণ করুন','Save page content':'পেজের কনটেন্ট সংরক্ষণ করুন','Notice board':'নোটিশ বোর্ড','Homepage & hero slides':'হোমপেজ ও হিরো স্লাইড','News & notices':'খবর ও নোটিশ','Leadership & teacher profiles':'নেতৃত্ব ও শিক্ষকদের প্রোফাইল','Published gallery images':'প্রকাশিত গ্যালারির ছবি','Registered accounts':'নিবন্ধিত অ্যাকাউন্ট','Recent notices':'সাম্প্রতিক নোটিশ','Pending registrations':'অনুমোদনের অপেক্ষায় থাকা নিবন্ধন','Preview Website ↗':'ওয়েবসাইট প্রিভিউ ↗',
    'LEARN · DISCOVER · ACHIEVE':'শিখি · আবিষ্কার করি · এগিয়ে যাই','A COMMUNITY OF LEARNING':'শেখার এক সম্মিলিত পরিবার','Every day is an opportunity to grow.':'প্রতিটি দিনই এগিয়ে যাওয়ার নতুন সুযোগ।','Discover our school':'আমাদের বিদ্যালয় সম্পর্কে জানুন','Admission information':'ভর্তি সংক্রান্ত তথ্য','Explore learning':'শেখার পরিবেশ দেখুন','See our facilities':'সুযোগ-সুবিধা দেখুন','Learning with purpose':'উদ্দেশ্যপূর্ণ শিক্ষা','WELCOME TO OUR SCHOOL':'আমাদের বিদ্যালয়ে স্বাগতম','A place to learn, grow and achieve':'শেখা, বেড়ে ওঠা ও সাফল্যের ঠিকানা','Discover our school →':'আমাদের বিদ্যালয় সম্পর্কে জানুন →','THE LEARNING EXPERIENCE':'শিক্ষার অভিজ্ঞতা','An environment where potential can flourish':'যে পরিবেশে বিকশিত হয় সম্ভাবনা','Learning is more than lessons. It is curiosity, participation, friendship and discovering what you can do.':'শিক্ষা শুধু পাঠ্যবই নয়। শিক্ষা হলো কৌতূহল, অংশগ্রহণ, বন্ধুত্ব এবং নিজের সক্ষমতা আবিষ্কার।','CAMPUS & FACILITIES':'ক্যাম্পাস ও সুযোগ-সুবিধা','Spaces that inspire learning':'শেখার অনুপ্রেরণায় সাজানো পরিসর','Take a look at the spaces and activities that support everyday learning.':'দৈনন্দিন শিক্ষাকে সহায়তা করে এমন স্থান ও কার্যক্রমগুলো দেখে নিন।','View all facilities →':'সব ছবি দেখুন →','School Library':'বিদ্যালয় পাঠাগার','Classrooms':'শ্রেণিকক্ষ','Science Laboratory':'বিজ্ঞানাগার','Computer Laboratory':'কম্পিউটার ল্যাব','Sports & Playground':'খেলাধুলা ও মাঠ','READ · EXPLORE · DISCOVER':'পড়ি · অন্বেষণ করি · আবিষ্কার করি','ACTIVE LEARNING':'সক্রিয় শিক্ষা','LEARN BY DISCOVERY':'আবিষ্কারের মাধ্যমে শিক্ষা','DIGITAL SKILLS':'ডিজিটাল দক্ষতা','PLAY · TEAMWORK · GROW':'খেলি · দলবদ্ধ হই · বেড়ে উঠি',
    'SCHOOL UPDATES':'বিদ্যালয়ের আপডেট','Latest news & notices':'সর্বশেষ খবর ও নোটিশ','Stay connected with school announcements, academic updates and important information.':'বিদ্যালয়ের ঘোষণা, একাডেমিক আপডেট ও গুরুত্বপূর্ণ তথ্যের সঙ্গে যুক্ত থাকুন।','Browse all notices →':'সব নোটিশ দেখুন →','New school notices will appear here.':'বিদ্যালয়ের নতুন নোটিশ এখানে প্রকাশিত হবে।','MILESTONES & MOMENTS':'অর্জন ও স্মরণীয় মুহূর্ত','Celebrating achievements':'অর্জনকে উদযাপন','Stories of effort, participation and progress from our school community.':'বিদ্যালয় পরিবারের প্রচেষ্টা, অংশগ্রহণ ও অগ্রগতির গল্প।','A NOTE TO OUR COMMUNITY':'আমাদের বিদ্যালয় পরিবারের প্রতি','A message from our school leadership':'বিদ্যালয় নেতৃত্বের পক্ষ থেকে বার্তা','Meet the leadership team →':'নেতৃত্বের সঙ্গে পরিচিত হোন →','OUR PEOPLE':'আমাদের মানুষ','Guiding and supporting every learner':'প্রতিটি শিক্ষার্থীর পাশে আমাদের শিক্ষকবৃন্দ','Meet all teachers →':'সব শিক্ষকের পরিচিতি →','SCHOOL LIFE':'বিদ্যালয় জীবন','More than a classroom':'শ্রেণিকক্ষের বাইরেও অনেক কিছু','Shared experiences, activities and moments make every school day memorable.':'অভিজ্ঞতা, কার্যক্রম ও আনন্দঘন মুহূর্ত প্রতিটি স্কুলের দিনকে স্মরণীয় করে তোলে।','Explore the gallery →':'গ্যালারি দেখুন →','Teachers & Students':'শিক্ষক ও শিক্ষার্থী','Cultural Activities':'সাংস্কৃতিক কার্যক্রম','School Events':'বিদ্যালয়ের অনুষ্ঠান','Student Activities':'শিক্ষার্থীদের কার্যক্রম','STUDENT & TEACHER SERVICES':'শিক্ষার্থী ও শিক্ষক সেবা','Your school services, in one place':'বিদ্যালয়ের প্রয়োজনীয় সেবা এক জায়গায়','Sign in with an approved account to access the services available to you.':'অনুমোদিত অ্যাকাউন্ট দিয়ে লগইন করে আপনার জন্য নির্ধারিত সেবা ব্যবহার করুন।','Open user portal →':'ইউজার পোর্টাল খুলুন →','Explore':'এক নজরে','Student Services':'শিক্ষার্থী সেবা','Photo Gallery':'ফটো গ্যালারি','Contact the school →':'বিদ্যালয়ে যোগাযোগ করুন →','All Rights Reserved.':'সর্বস্বত্ব সংরক্ষিত।','Designed & Developed by':'পরিকল্পনা ও নির্মাণ',
    'School Notices & Announcements':'বিদ্যালয়ের নোটিশ ও ঘোষণা','School Photo Gallery':'বিদ্যালয়ের ফটো গ্যালারি','Stay informed about important school updates.':'বিদ্যালয়ের গুরুত্বপূর্ণ আপডেট সম্পর্কে অবগত থাকুন।','A glimpse of learning, activities and school life.':'শিক্ষা, কার্যক্রম ও বিদ্যালয় জীবনের কিছু মুহূর্ত।','School Address':'বিদ্যালয়ের ঠিকানা','Phone Number':'ফোন নম্বর','Office Hours':'অফিস সময়সূচি','Send Us a Message':'আমাদের বার্তা পাঠান','Your Name':'আপনার নাম','Email Address':'ইমেইল ঠিকানা','Subject':'বিষয়','Message':'বার্তা','Send Message →':'বার্তা পাঠান →','Start Your Journey With Us':'আমাদের সঙ্গে আপনার যাত্রা শুরু করুন','Online Admission Information':'অনলাইন ভর্তি সংক্রান্ত তথ্য','Admission Enquiry Form':'ভর্তি অনুসন্ধান ফরম','Student Name':'শিক্ষার্থীর নাম','Class Applying For':'যে শ্রেণিতে ভর্তি হতে ইচ্ছুক','Parent/Guardian Name':'অভিভাবকের নাম','Mobile Number':'মোবাইল নম্বর','Submit Enquiry →':'অনুসন্ধান জমা দিন →','Check student examination results.':'শিক্ষার্থীদের পরীক্ষার ফলাফল দেখুন।','Student Result Search':'শিক্ষার্থীর ফলাফল অনুসন্ধান','Student ID':'শিক্ষার্থী আইডি','Examination':'পরীক্ষা','Academic Year':'শিক্ষাবর্ষ','Check Result':'ফলাফল দেখুন','Primary Section':'প্রাথমিক শাখা','Secondary Section':'মাধ্যমিক শাখা','Curriculum':'পাঠ্যক্রম','Academic Calendar':'একাডেমিক ক্যালেন্ডার','Admission Requirements':'ভর্তির প্রয়োজনীয় কাগজপত্র','Application Process':'আবেদন প্রক্রিয়া','Contact Information':'যোগাযোগের তথ্য','Knowledge • Discipline • Excellence':'জ্ঞান • শৃঙ্খলা • উৎকর্ষ','Annual Examination':'বার্ষিক পরীক্ষা','Half Yearly Examination':'অর্ধবার্ষিক পরীক্ষা','Model Test':'মডেল টেস্ট','Select Examination':'পরীক্ষা নির্বাচন করুন','Select Year':'বছর নির্বাচন করুন','Select Class':'শ্রেণি নির্বাচন করুন','Play Group':'প্লে গ্রুপ','Nursery':'নার্সারি','Class One':'প্রথম শ্রেণি','Class Two':'দ্বিতীয় শ্রেণি','Class Three':'তৃতীয় শ্রেণি','Class Four':'চতুর্থ শ্রেণি','Class Five':'পঞ্চম শ্রেণি','Class Six':'ষষ্ঠ শ্রেণি','Class Seven':'সপ্তম শ্রেণি','Class Eight':'অষ্টম শ্রেণি','Class Nine':'নবম শ্রেণি','Class Ten':'দশম শ্রেণি'
  };
  const reverse = Object.fromEntries(Object.entries(dictionary).map(([en,bn]) => [bn,en]));
  const placeholders = {'Enter your name':'আপনার নাম লিখুন','Enter your email':'আপনার ইমেইল লিখুন','Enter subject':'বিষয় লিখুন','Write your message':'আপনার বার্তা লিখুন','Enter student name':'শিক্ষার্থীর নাম লিখুন','Enter guardian name':'অভিভাবকের নাম লিখুন','Enter Student ID':'শিক্ষার্থী আইডি লিখুন','Enter username or email':'ইউজারনেম অথবা ইমেইল লিখুন','Enter your full name':'আপনার পূর্ণ নাম লিখুন','Enter mobile number':'মোবাইল নম্বর লিখুন'};
  let language = localStorage.getItem('biam-language') || 'en';

  function applyLanguage(next) {
    document.querySelectorAll('[data-en][data-bn]').forEach(el => {
      const translated = el.dataset[next];
      if (translated !== undefined && !el.children.length) {
        el.textContent = translated;
      } else if (translated !== undefined) {
        const textNode = [...el.childNodes].find(node => node.nodeType === Node.TEXT_NODE && node.textContent.trim());
        if (textNode) textNode.textContent = ` ${translated} `;
      }
    });
    const map = next === 'bn' ? dictionary : reverse;
    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    let node;
    while ((node = walker.nextNode())) {
      const parent = node.parentElement;
      if (!parent || parent.closest('script,style,textarea,input,select,option,[data-en][data-bn]')) continue;
      const original = node.nodeValue.trim();
      if (map[original]) node.nodeValue = node.nodeValue.replace(original, map[original]);
    }
    document.querySelectorAll('input[placeholder],textarea[placeholder]').forEach(el => {
      if (!el.dataset.enPlaceholder) el.dataset.enPlaceholder = el.placeholder;
      const englishPlaceholder = el.dataset.enPlaceholder;
      const banglaPlaceholder = el.dataset.bnPlaceholder || placeholders[englishPlaceholder] || englishPlaceholder;
      el.placeholder = next === 'bn' ? banglaPlaceholder : englishPlaceholder;
    });
    document.querySelectorAll('option').forEach(el => {
      if (el.matches('[data-en][data-bn]')) return;
      if (!el.dataset.enText) el.dataset.enText = el.textContent;
      el.textContent = next === 'bn' ? (dictionary[el.dataset.enText] || el.dataset.enText) : el.dataset.enText;
    });
    document.querySelectorAll('[data-en-title][data-bn-title]').forEach(el => el.title = el.dataset[next + 'Title']);
    if (toggle) toggle.textContent = next === 'en' ? 'বাংলা' : 'English';
    document.documentElement.lang = next;
    localStorage.setItem('biam-language', next);
    document.cookie = `biam-language=${next};path=/;SameSite=Lax`;
    language = next;
  }
  if (toggle) toggle.addEventListener('click', () => applyLanguage(language === 'en' ? 'bn' : 'en'));
  if (language === 'bn') applyLanguage('bn');

  // Hero carousel: restrained auto-advance, manual controls and pause on hover/focus.
  const slides = [...document.querySelectorAll('.hero-slide')];
  const dots = [...document.querySelectorAll('[data-hero-dot]')];
  const hero = document.querySelector('.visual-hero');
  if (slides.length > 1 && hero) {
    let current = 0;
    let timer = null;
    const show = index => {
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => { slide.classList.toggle('is-current', i === current); slide.setAttribute('aria-hidden', i === current ? 'false' : 'true'); });
      dots.forEach((dot, i) => dot.classList.toggle('is-active', i === current));
    };
    const stop = () => { if (timer) window.clearInterval(timer); timer = null; };
    const start = () => { if (!reducedMotion) { stop(); timer = window.setInterval(() => show(current + 1), 7000); } };
    document.querySelector('[data-hero-prev]')?.addEventListener('click', () => { show(current - 1); start(); });
    document.querySelector('[data-hero-next]')?.addEventListener('click', () => { show(current + 1); start(); });
    dots.forEach(dot => dot.addEventListener('click', () => { show(Number(dot.dataset.heroDot)); start(); }));
    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);
    hero.addEventListener('focusin', stop);
    hero.addEventListener('focusout', start);
    start();
  }

  // Reveal sections as they enter the viewport; reduced-motion users see them immediately.
  const revealItems = document.querySelectorAll('.reveal');
  if (reducedMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach(item => item.classList.add('is-visible'));
  } else {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, {threshold: 0.12, rootMargin: '0px 0px -35px 0px'});
    revealItems.forEach(item => observer.observe(item));
  }
});
