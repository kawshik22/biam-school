<?php require_once 'config.php';
$c = page_content('academics', ['title_en' => 'Academic Information', 'title_bn' => 'একাডেমিক তথ্য', 'body_en' => 'Building knowledge, skills and confidence for the future.', 'body_bn' => 'ভবিষ্যতের জন্য জ্ঞান, দক্ষতা ও আত্মবিশ্বাস গড়ে তোলা।']);
include 'includes/header.php'; ?><main class="container inner-page">
    <section class="page-banner"><span data-en="ACADEMIC PROGRAMME" data-bn="একাডেমিক কার্যক্রম">ACADEMIC PROGRAMME</span>
        <h1 data-en="<?= e($c['title_en']) ?>" data-bn="<?= e($c['title_bn'] ?: $c['title_en']) ?>"><?= e($c['title_en']) ?></h1>
        <p data-en="<?= e($c['body_en']) ?>" data-bn="<?= e($c['body_bn'] ?: $c['body_en']) ?>"><?= e($c['body_en']) ?></p>
    </section>
    <section class="student-service-grid">
        <article class="service-panel">
            <h2 data-en="Primary Section" data-bn="প্রাথমিক শাখা">Primary Section</h2>
            <p data-en="Foundational learning, literacy, numeracy and creative activities." data-bn="প্রাথমিক শিক্ষা, ভাষা, গণিত ও সৃজনশীল কার্যক্রম।">Foundational learning, literacy, numeracy and creative activities.</p>
        </article>
        <article class="service-panel">
            <h2 data-en="Secondary Section" data-bn="মাধ্যমিক শাখা">Secondary Section</h2>
            <p data-en="Subject-based learning, academic development and examination preparation." data-bn="বিষয়ভিত্তিক শিক্ষা, একাডেমিক উন্নয়ন ও পরীক্ষার প্রস্তুতি।">Subject-based learning, academic development and examination preparation.</p>
        </article>
        <article class="service-panel">
            <h2 data-en="Curriculum" data-bn="পাঠ্যক্রম">Curriculum</h2>
            <p data-en="Information about subjects, syllabus and academic learning activities." data-bn="বিষয়, পাঠ্যসূচি ও একাডেমিক কার্যক্রমের তথ্য।">Information about subjects, syllabus and academic learning activities.</p>
        </article>
        <article class="service-panel">
            <h2 data-en="Academic Calendar" data-bn="একাডেমিক ক্যালেন্ডার">Academic Calendar</h2>
            <p data-en="School terms, examinations, holidays and important academic dates." data-bn="শিক্ষাবর্ষ, পরীক্ষা, ছুটি ও গুরুত্বপূর্ণ একাডেমিক তারিখ।">School terms, examinations, holidays and important academic dates.</p>
        </article>
    </section>
</main><?php include 'includes/footer.php'; ?>