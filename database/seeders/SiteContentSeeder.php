<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\Highlight;
use App\Models\Office;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Redirect;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

/**
 * Content carried over from the original onyxial.com WordPress site,
 * tidied up (typos fixed, placeholder phone numbers and theme demo text removed).
 * Safe to run more than once — records are matched on their key or slug.
 */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->pages();
        $this->services();
        $this->projects();
        $this->team();
        $this->faqs();
        $this->highlights();
        $this->clients();
        $this->gallery();
        $this->offices();
        $this->redirects();
    }

    protected function settings(): void
    {
        Setting::put([
            // General
            'site_name' => 'Onyx Investment Advisory Limited',
            'founded_year' => '2022',
            'topbar_text' => 'Investment promotion and advisory across Nigeria',

            // Contact
            'contact_email' => 'info@onyxial.com',
            'contact_phone' => '+234 902 233 4405',
            'notify_email' => 'info@onyxial.com',
            'address_street' => '214 House B2, Block B, Phase II, Sani Zangon Daura Estate, Kado',
            'address_city' => 'Abuja',
            'address_region' => 'FCT',

            // Social
            'social_linkedin' => 'https://www.linkedin.com/company/onyx-investment-advisory-ltd',
            'social_x' => 'https://x.com/onyx_IAL_ng',
            'social_facebook' => 'https://facebook.com/profile.php?id=61559556457289',
            'social_instagram' => 'https://www.instagram.com/onyx_ial/',
            'twitter_handle' => '@onyx_IAL_ng',

            // Home page
            'hero_eyebrow' => 'Your key to investing in Nigeria',
            'hero_title' => "Invest with purpose.\nChange the world.",
            'hero_text' => 'Onyx Investment Advisory Limited promotes and facilitates investment, develops projects and supports private sector growth across Nigeria, investing in people one community at a time.',
            'home_about_eyebrow' => 'Who we are',
            'home_about_title' => 'Investing in people, one community at a time',
            'home_about_text' => '<p>At Onyx Investment Advisory Limited, we take a fresh look at what it means to invest responsibly. Our aim is simple: to change lives by investing in people, one community at a time.</p><p>Since we started in 2022, our work has focused on investment promotion and facilitation, international project development and private sector development, all aimed at driving economic growth and opening up investment opportunities, with a strong focus on Northern Nigeria.</p>',
            'home_about_points' => "Investment promotion and facilitation\nInternational project and private sector development\nPublic-private partnerships and strategic advisory",
            'home_about_image' => 'uploads/site/home-about.png',
            'ceo_quote' => 'Investment is not just about money. It is about time, energy and belief in a better future.',
            'ceo_name' => 'Aisha Yakubu Bako',
            'ceo_title' => 'MD/CEO, Onyx Investment Advisory Limited',
            'why_title' => 'Global experience, applied to local markets',
            'why_text' => 'Our team brings more than three decades of combined experience. It is led by our MD/CEO, Aisha Yakubu Bako, who has held key roles with the UK\'s Department for International Development (DFID), the International Finance Corporation (IFC) and leading Nigerian institutions. Everything we do serves one goal: results that grow your business while following best practice and serving the common good.',

            // About page
            'about_title' => 'Investing with purpose, for lasting change',
            'about_image' => 'uploads/site/about-team.jpg',
            'vision' => 'To create sustainable value and profitable growth while advancing inclusive development.',
            'mission' => 'To deliver high-impact, data-driven advisory and investment solutions that generate measurable results and long-term value.',

            // Contact page + CTA
            'contact_form_title' => 'Tell us about your project',
            'contact_form_text' => 'Whether you are an investor, a business or a government agency, we would like to hear from you. We usually reply within two working days.',
            'cta_eyebrow' => 'Work with us',
            'cta_heading' => 'Looking to invest in Nigeria, or bring investors to your state?',
            'cta_text' => 'Tell us what you are working on. We will help you find the right opportunities, partners and route to market.',
            'footer_about' => 'Investment promotion, facilitation and advisory for businesses, investors and governments working in Nigeria.',
            'footer_credit' => '',

            // SEO
            'seo_default_title' => 'Onyx Investment Advisory Limited | Investment Promotion & Advisory in Nigeria',
            'seo_default_description' => 'Onyx Investment Advisory Limited helps investors, businesses and governments find, structure and deliver investment in Nigeria, with a focus on the North.',
            'seo_default_image' => '',
            'seo_block_indexing' => '0',
            'google_analytics_id' => '',
            'google_site_verification' => '',
            'bing_site_verification' => '',
            'head_scripts' => '',
        ]);
    }

    protected function pages(): void
    {
        $pages = [
            'home' => [
                'title' => 'Home',
                'meta_title' => 'Onyx Investment Advisory Limited | Investment Promotion & Advisory in Nigeria',
                'meta_description' => 'Onyx Investment Advisory Limited helps investors, businesses and governments find, structure and deliver investment in Nigeria, with a focus on the North.',
                'meta_keywords' => 'investment advisory Nigeria, investment promotion, investment facilitation, Northern Nigeria, project development, PPP advisory',
            ],
            'about' => [
                'title' => 'About Us',
                'heading' => 'About Onyx Investment Advisory',
                'intro' => 'A Nigerian advisory firm that promotes and facilitates investment, develops projects and helps the private sector grow, so that communities benefit too.',
                'body' => '<p>At Onyx Investment Advisory Limited, we take a fresh look at what it means to invest responsibly. Since we started in 2022, we have been committed to investment promotion and facilitation, international project development and private sector development, all aimed at driving economic growth and opening up investment opportunities in Northern Nigeria.</p>'
                    .'<p>We are a strategic partner for businesses and investors who want to make the most of the Nigerian market. We believe in investing with purpose to pave the way for positive change, and that this only works when it improves the lives of the people who need it most.</p>'
                    .'<p>That is why we focus on sustainable growth in communities, driven by strategic investment and funding from partners and individuals who want to make a difference.</p>'
                    .'<p>Our services cover private sector development, market research, project management, and investment promotion and facilitation. Our experts bring experience from many fields: gender and public policy, market development, organisational leadership, project management, procurement, facility and financial management, strategic planning, women\'s empowerment and community social safeguards. All of it supports one aim: meaningful impact through purpose-driven investment, one project at a time.</p>',
                'meta_title' => 'About Us',
                'meta_description' => 'Founded in 2022, Onyx Investment Advisory Limited promotes investment, develops projects and supports private sector growth in Nigeria. Learn about our vision, mission and values.',
            ],
            'services' => [
                'title' => 'Our Services',
                'heading' => 'Our Services',
                'intro' => 'Research, programme design, investment promotion and training, shaped around the realities of doing business in Nigeria.',
                'meta_title' => 'Our Services',
                'meta_description' => 'Program development, investment promotion and facilitation, investment intelligence and training from Onyx Investment Advisory Limited.',
            ],
            'team' => [
                'title' => 'Our Team',
                'heading' => 'Meet our team',
                'intro' => 'Our people bring a wealth of knowledge and experience from development finance, investment, government and the private sector.',
                'meta_title' => 'Our Team',
                'meta_description' => 'Meet the team at Onyx Investment Advisory Limited, led by MD/CEO Aisha Yakubu Bako.',
            ],
            'projects' => [
                'title' => 'Our Projects',
                'heading' => 'Our Projects',
                'intro' => 'A selection of the work we are doing with state governments, regional bodies and development partners.',
                'meta_title' => 'Our Projects',
                'meta_description' => 'Projects by Onyx Investment Advisory Limited in hospitality, transport infrastructure and education across Nigeria.',
            ],
            'contacts' => [
                'title' => 'Contacts',
                'heading' => 'Get in touch',
                'intro' => 'Visit our Abuja office, write to us, or send a message using the form below.',
                'meta_title' => 'Contact Us',
                'meta_description' => 'Contact Onyx Investment Advisory Limited in Abuja, Nigeria, and London, UK. Call +234 902 233 4405 or email info@onyxial.com.',
            ],
            'faq' => [
                'title' => 'FAQ',
                'heading' => 'Frequently asked questions',
                'intro' => 'Answers to the questions clients ask us most often.',
                'meta_title' => 'Frequently Asked Questions',
                'meta_description' => 'Answers to common questions about Onyx Investment Advisory Limited: our services, fees, approach and how we work with clients.',
            ],
        ];

        foreach ($pages as $key => $data) {
            Page::updateOrCreate(['key' => $key], $data);
        }
    }

    protected function services(): void
    {
        $services = [
            [
                'title' => 'Program Development',
                'slug' => 'program-development',
                'icon' => 'compass',
                'image' => 'uploads/services/program-development.png',
                'excerpt' => 'Strategic guidance and careful planning, backed by research, to help you design programmes and enter new markets.',
                'body' => '<p>Good programmes start with a clear plan. Our specialists combine strategic guidance with careful, research-based planning to help communities and organisations reach their market goals.</p>'
                    .'<p>We help you set clear business objectives, shape your product or programme for the market, spot problems early and follow proven best practice. The aim is a viable, successful programme that works for the people it is meant to serve.</p>'
                    .'<p>We stay with you from the first idea through to implementation, so the plan on paper turns into real, positive change.</p>',
                'points' => [
                    'Project and programme design',
                    'Market entry planning',
                    'Defining business objectives',
                    'Risk and pitfall assessment',
                    'Green growth and women\'s economic empowerment',
                    'Support from concept to implementation',
                ],
            ],
            [
                'title' => 'Investment Promotion & Facilitation',
                'slug' => 'investment-promotion-facilitation',
                'icon' => 'handshake',
                'image' => 'uploads/services/investment-promotion-facilitation.png',
                'excerpt' => 'Promotion and facilitation support that lowers your costs, shortens start-up times and clears the usual obstacles to investing in Nigeria.',
                'body' => '<p>We act as a catalyst for investment success. Our promotion and facilitation services are built to cut your costs, shorten the time it takes to get started and remove many of the obstacles investors usually face in Nigeria.</p>'
                    .'<p>Our solutions are tailored to attract investment, simplify processes and create the right conditions for growth for our partners, whether you are a state government looking for investors or an investor looking for the right opportunity.</p>'
                    .'<p>Think of us as a trusted guide to investing in Nigeria: focused on returns, and on making a positive difference along the way.</p>',
                'points' => [
                    'Investment promotion, including investor events',
                    'Investment facilitation and after-care',
                    'Business environment reform',
                    'Public-private partnerships and concessions',
                    'Business linkages and value chain development',
                    'Deal origination and structuring',
                ],
            ],
            [
                'title' => 'Investment Intelligence',
                'slug' => 'investment-intelligence',
                'icon' => 'insight',
                'image' => 'uploads/services/investment-intelligence.png',
                'excerpt' => 'In-depth research, market analysis and risk assessment that give you clear, usable intelligence for investing in Nigeria.',
                'body' => '<p>Nigeria is a market full of opportunity, but it moves quickly. Making the right investment depends on having a partner who understands the country\'s social, economic and competitive landscape in depth.</p>'
                    .'<p>That is where we come in. Our specialists draw on decades of experience in the market, backed by data, to carry out in-depth research, market analysis and risk assessments.</p>'
                    .'<p>The result is practical intelligence you can act on, helping you make successful investments and strengthen your portfolio.</p>',
                'points' => [
                    'Market research and sector scans',
                    'Feasibility and risk assessment',
                    'Competitor and landscape analysis',
                    'Market systems development',
                    'Investment readiness reviews',
                    'Data-driven recommendations',
                ],
            ],
            [
                'title' => 'Training',
                'slug' => 'training',
                'icon' => 'graduation',
                'image' => 'uploads/services/training.png',
                'excerpt' => 'Training programmes designed around your organisation\'s needs, to build skills and improve performance.',
                'body' => '<p>Every organisation is different, so our training is too. We design each programme around the specific needs of your team and the goals you want to reach.</p>'
                    .'<p>Our training is flexible and can be adapted as you go, with a clear focus on improving performance and efficiency.</p>'
                    .'<p>We particularly enjoy working with purpose-driven organisations whose work has a positive effect on the environment and on society.</p>',
                'points' => [
                    'Tailored training needs assessments',
                    'Workshops and seminars',
                    'Investment promotion capacity building',
                    'Project and programme management skills',
                    'Business development services',
                    'Follow-up support after training',
                ],
            ],
        ];

        foreach ($services as $i => $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s + ['sort_order' => $i + 1, 'is_published' => true]);
        }
    }

    protected function projects(): void
    {
        $cats = [];
        foreach ([
            'hospitality' => 'Hospitality',
            'transport-infrastructure-management' => 'Transport Infrastructure & Management',
            'education-development-consultancy' => 'Education & Development Consultancy',
        ] as $slug => $name) {
            $cats[$slug] = ProjectCategory::updateOrCreate(['slug' => $slug], ['name' => $name, 'sort_order' => count($cats) + 1]);
        }

        $projects = [
            [
                'slug' => 'gombe-state-owned-hotels',
                'title' => 'Gombe State Owned Hotels',
                'category' => 'hospitality',
                'client' => 'Gombe Revenue Optimization Company Limited (GROCOL)',
                'location' => 'Gombe, Abuja and Kaduna',
                'start_date' => '2024-03-26',
                'status' => 'ongoing',
                'is_featured' => true,
                'image' => 'uploads/projects/gombe-state-owned-hotels.png',
                'summary' => 'Preparing four Gombe State-owned hotels and a conference centre for long-term private management, and bringing credible investors to the table.',
                'background' => '<p>Gombe Revenue Optimization Company Limited (GROCOL) is a Gombe State-owned company that manages the state\'s commercial assets. GROCOL appointed Onyx Investment Advisory Limited to prepare and engage credible investors to upgrade, operate and manage the following properties:</p>'
                    .'<ul>'
                    .'<li><strong>Gombe International Conference Centre, Gombe:</strong> a modern conference facility with halls, meeting rooms and space for future development.</li>'
                    .'<li><strong>Gombe Jewel Hotel, Abuja:</strong> 22 N\'djamena Crescent, off Aminu Kano Crescent, Wuse 2, with 57 rooms, a banquet hall, spa and restaurant.</li>'
                    .'<li><strong>Gombe Jewel Hotel, Kaduna:</strong> 7 Ex-Ministers Quarters, off Rabbah Road, with 44 chalets, a banquet hall, restaurants and ample parking.</li>'
                    .'<li><strong>Jewel Hotel Kaltungo, Gombe:</strong> VIP and executive rooms, an event hall and additional buildings.</li>'
                    .'<li><strong>Gombe International Hotel, Gombe:</strong> 95 rooms, a banquet hall, auditorium, shops, gym and swimming pool.</li>'
                    .'</ul>',
                'solution' => '<p>On behalf of GROCOL, we ran an open invitation to tender for the operation and management of the hotels. Successful bidders receive a 30-year concession. In return they are expected to upgrade the properties significantly, run them to a high standard and propose sound financial models that turn the hotels into steady sources of revenue. Gombe State has committed to protecting and supporting these investments.</p>'
                    .'<p>Interested companies were asked to submit, as part of pre-qualification:</p>'
                    .'<ul>'
                    .'<li>A company profile, evidence of registration and relevant certificates</li>'
                    .'<li>Tax clearance certificates for 2021, 2022 and 2023</li>'
                    .'<li>A technical bid with a business plan, hospitality track record, proposed team and revitalisation plan</li>'
                    .'<li>A financial bid with proof of funds and audited accounts</li>'
                    .'</ul>'
                    .'<p>Bids closed at 12 noon on 19 August 2024 at the Onyx Investment Advisory office in Abuja.</p>',
                'facts' => [
                    ['label' => 'Assets', 'value' => '4 hotels and 1 conference centre'],
                    ['label' => 'Concession', 'value' => '30 years'],
                ],
                'gallery' => [
                    ['uploads/projects/gombe/gombe-international-conference-centre.jpg', 'Gombe International Conference Centre'],
                    ['uploads/projects/gombe/gombe-1.jpg', null],
                    ['uploads/projects/gombe/gombe-2.png', null],
                    ['uploads/projects/gombe/gombe-4.jpg', null],
                    ['uploads/projects/gombe/gombe-5.jpg', null],
                    ['uploads/projects/gombe/gombe-6.jpg', null],
                    ['uploads/projects/gombe/gombe-7.jpg', null],
                    ['uploads/projects/gombe/gombe-8.jpg', null],
                ],
            ],
            [
                'slug' => 'innovative-transport-management-system-for-niger-state',
                'title' => 'Innovative Transport Management System for Niger State',
                'category' => 'transport-infrastructure-management',
                'client' => 'Niger State Ministry for Transportation',
                'location' => 'Niger State',
                'start_date' => '2024-05-15',
                'status' => 'ongoing',
                'is_featured' => true,
                'image' => 'uploads/projects/niger-state-transport.png',
                'summary' => 'Working with the Niger State Ministry for Transportation to design a modern transport management system that improves the state\'s infrastructure and connectivity.',
                'background' => '<p>The Niger State Ministry for Transportation selected Onyx Investment Advisory Limited to design and implement an advanced transport management system for the state. The goal is to overhaul transport infrastructure and improve connectivity and service for residents.</p>'
                    .'<p>The project has the backing of the state government and the Honourable Commissioner for Transportation, Hadiza Idris Kuta.</p>',
                'solution' => '<p>We designed the system to make transport operations across Niger State work better. It brings together infrastructure upgrades, route planning and real-time management tools.</p>'
                    .'<p>The system is expected to improve access to more than 80 buses, making journeys easier for commuters and day-to-day operations smoother for both the government and residents.</p>',
                'facts' => [
                    ['label' => 'Fleet', 'value' => '80+ buses'],
                ],
                'gallery' => [
                    ['uploads/projects/niger/niger-1.jpg', null],
                    ['uploads/projects/niger/niger-2.jpg', null],
                    ['uploads/projects/niger/niger-3.jpg', null],
                ],
            ],
            [
                'slug' => 'comprehensive-strategy-to-address-out-of-school-children-almajiri',
                'title' => 'Comprehensive Strategy to Address Out-of-School Children & Almajiri',
                'category' => 'education-development-consultancy',
                'client' => 'Northern States Governors\' Forum (NSGF)',
                'location' => 'Northern Nigeria',
                'start_date' => '2024-03-01',
                'status' => 'ongoing',
                'is_featured' => true,
                'image' => 'uploads/projects/out-of-school-children-almajiri.png',
                'summary' => 'A partnership between the Northern States Governors\' Forum and the Islamic Development Bank, with Onyx as consultant, to reduce the number of out-of-school children in Northern Nigeria.',
                'background' => '<p>The Northern States Governors\' Forum (NSGF) appointed Onyx Investment Advisory Limited to develop a strategy to tackle the high number of out-of-school children in Northern Nigeria, with a particular focus on the Almajiri system.</p>'
                    .'<p>The work is part of a wider partnership with the Islamic Development Bank (IsDB) under its SMART Education project. It aims to bring formal education together with Islamic teaching and to modernise the Almajiri system.</p>',
                'solution' => '<p>Working with the NSGF and the IsDB, we are developing an inclusive strategy to bring more children into school. The plan focuses on wider access to education through better infrastructure, stronger teacher capacity and curriculum reform.</p>'
                    .'<p>It also covers agriculture and livelihoods, and is designed to reach more than 500,000 people, half of them young people and 40% women.</p>',
                'facts' => [
                    ['label' => 'Partner', 'value' => 'Islamic Development Bank (IsDB)'],
                    ['label' => 'Target reach', 'value' => '500,000+ people'],
                    ['label' => 'Youth / women', 'value' => '50% / 40%'],
                ],
                'gallery' => [
                    ['uploads/projects/almajiri/almajiri-1.jpg', null],
                    ['uploads/projects/almajiri/almajiri-2.jpg', null],
                ],
            ],
        ];

        foreach ($projects as $i => $p) {
            $gallery = $p['gallery'];
            $category = $cats[$p['category']];
            unset($p['gallery'], $p['category']);

            $project = Project::updateOrCreate(['slug' => $p['slug']], $p + [
                'project_category_id' => $category->id,
                'sort_order' => $i + 1,
                'is_published' => true,
            ]);

            if ($project->images()->count() === 0) {
                foreach ($gallery as $j => [$path, $caption]) {
                    $project->images()->create(['path' => $path, 'caption' => $caption, 'sort_order' => $j + 1]);
                }
            }
        }
    }

    protected function team(): void
    {
        $team = [
            [
                'slug' => 'aisha-yakubu-bako',
                'name' => 'Aisha Yakubu Bako',
                'position' => 'MD/CEO',
                'photo' => 'uploads/team/aisha-yakubu-bako.png',
                'email' => 'aisha.yakubu@onyxial.com',
                'linkedin' => 'https://www.linkedin.com/in/ashax/',
                'twitter' => 'https://x.com/ashlaxx',
                'summary' => 'A specialist in gender, public policy and market development with about 20 years of experience in project management, gender mainstreaming and private sector development.',
                'bio' => '<p>Aisha Yakubu Bako is the Managing Director and CEO of Onyx Investment Advisory Limited. She is from Kano State and specialises in gender, public policy and market development, with about 20 years of combined experience in project management, gender mainstreaming and private sector development.</p>'
                    .'<p>She has worked on several programmes funded by the UK government (DFID, now FCDO), including ENABLE, GEMS, Propcom-Maikarfi and LINKS, where she currently serves as Investment Lead. She has also worked as a business development consultant for the International Finance Corporation (IFC) in Northern Nigeria.</p>'
                    .'<p>Earlier in her career she coordinated an education access initiative during reforms at the Federal Ministry of Education, advised on women in business, led a marketing team at Oceanic Bank and was Project Manager for Gender, Democracy and Rights at the Heinrich Böll Stiftung.</p>'
                    .'<p>Her investment promotion work includes helping to set up the Kaduna State Investment Promotion Agency (KADIPA) and supporting Kaduna State\'s application for World Bank financing.</p>'
                    .'<p>She is a member of the Chartered Institute of Banking, has received an Ambassador for Peace award and is a former Director of Memberships at the World Association of NGOs (WANGO).</p>',
                'credentials' => [
                    'Master\'s in Financial Economics',
                    'B.Sc. Agricultural Engineering, Ahmadu Bello University',
                    'Diploma in Business Dynamics, Maastricht School of Management',
                    'Studied at the Nigerian Defence Academy',
                    'Member, Chartered Institute of Banking',
                ],
            ],
            [
                'slug' => 'austin-onele',
                'name' => 'Austin Onele',
                'position' => 'Head of Investment Promotion and Facilitation',
                'photo' => 'uploads/team/austin-onele.jpg',
                'email' => 'a.onele@onyxial.com',
                'linkedin' => 'https://www.linkedin.com/in/austinonele',
                'summary' => 'A transaction adviser who originates, structures and facilitates investment deals in infrastructure, energy and agriculture across Nigeria and West Africa.',
                'bio' => '<p>Austin Onele leads deal origination and facilitation at Onyx, with a focus on the energy transition, infrastructure concessions, agricultural value chains and private credit. His work connects bankable projects with development finance institutions and institutional investors.</p>'
                    .'<p>He has helped deliver more than $100 million in cumulative project value. This includes an $85 million capital raise for the Onitsha River Port concession, a 20,000-tonne sovereign grain storage transaction between the Nigeria Sovereign Investment Authority and an agricultural consortium, and advisory support to Nigeria\'s Gas Flare Commercialisation Programme under USAID Power Africa, which brought together more than 100 investors, developers and technology providers.</p>'
                    .'<p>Austin began his career in oil and gas at TotalEnergies, working on gas pricing strategy and the Egina FPSO project. His project finance work since then covers CNG and LNG, utility-scale solar, mini-grids, agricultural logistics and real estate.</p>'
                    .'<p>He works closely with the IsDB Group (ICD, ITFC and ICIEC), the World Bank, AfDB, JICA, UNDP, REA, NIRSAL, NIPC, NSIA and the Bank of Industry, and has supported mandates in Nigeria, Ghana and Liberia.</p>',
                'credentials' => [
                    'Financial Modelling & Valuation Analyst (FMVA®), Corporate Finance Institute',
                    'Advanced Financial Modelling (AFM), Corporate Finance Institute',
                    'Executive education, Harvard Business School Online',
                    'Executive education, Bocconi University',
                ],
            ],
            [
                'slug' => 'takwi-titus-leonard',
                'name' => 'Takwi Titus Leonard',
                'position' => 'Head of Human Resource, People and Admin',
                'photo' => 'uploads/team/takwi-titus-leonard.jpg',
                'email' => 't.leonard@onyxial.com',
                'linkedin' => 'https://www.linkedin.com/in/takwi-leonard',
                'summary' => 'An HR manager and consultant with experience in talent acquisition, employee retention and HR operations.',
                'bio' => '<p>Takwi Titus Leonard leads human resources, people and administration at Onyx. She has more than three years of experience in talent acquisition, employee retention and HR operations.</p>'
                    .'<p>She has managed the full recruitment cycle, from sourcing and screening candidates to onboarding, always with an eye on how well people fit the organisation\'s needs and culture.</p>'
                    .'<p>Proactive and detail-oriented, she is committed to building a positive workplace that supports staff growth, engagement and career progression.</p>',
                'credentials' => [
                    'Master\'s degree in Human Resource Management',
                    'CIPM, CIHRM and AIHRM certifications',
                ],
            ],
        ];

        foreach ($team as $i => $m) {
            TeamMember::updateOrCreate(['slug' => $m['slug']], $m + ['sort_order' => $i + 1, 'is_published' => true, 'show_on_home' => true]);
        }
    }

    protected function faqs(): void
    {
        $faqs = [
            ['What services do you offer?',
                '<p>We offer investment advisory and facilitation services. Our work falls into three broad areas:</p>'
                .'<p><strong>International development</strong></p><ul><li>Project development</li><li>Green growth</li><li>Women\'s economic empowerment</li></ul>'
                .'<p><strong>Business and private sector development</strong></p><ul><li>Market research</li><li>Private sector development</li><li>Business environment reform</li><li>Business linkages and value chain development</li><li>Business development services</li><li>Market systems development</li></ul>'
                .'<p><strong>Investment promotion and facilitation</strong></p><ul><li>Investment promotion, including investment promotion events</li><li>Investment facilitation</li></ul>'
                .'<p>We also offer training and investment intelligence. See <a href="/our-services">our services</a> for details.</p>'],
            ['What is your investment philosophy?',
                '<p>We start with a thorough scan of the sector, then look closely at your investment goals, how much risk you are comfortable with, your time frame and what you expect to achieve. Our advice is built around those answers, not a one-size-fits-all model.</p>'],
            ['How much do you charge?',
                '<p>Our fees are set to suit the scope of each engagement. We are open to discussing how fees are structured and, depending on the size of the work, different or staged payment terms may be possible. Contact us for a proposal.</p>'],
            ['Can I trust Onyx Investment Advisory Limited?',
                '<p>We hold ourselves to high standards of transparency, integrity and professionalism. Our clients get independent, research-backed advice tailored to their goals and their appetite for risk. We also keep client information confidential, which adds a further layer of trust to the relationship.</p>'],
            ['Do you put my interests first?',
                '<p>Yes. We have a duty to put your interests as a client ahead of our own. Your peace of mind and your investment goals are our priority throughout every engagement.</p>'],
            ['How do you measure the success of an investment?',
                '<p>We agree clear measures with each client at the start. Depending on the project, these may include financial returns, jobs created, capital raised, people reached or wider economic and social impact. We back our recommendations with our own market research and track progress during the monitoring stage of our process.</p>'],
            ['What makes you different from other firms?',
                '<p>Personal service, openness and a joined-up approach to planning. Our team combines international experience with organisations such as DFID and the IFC with deep knowledge of Nigerian markets, especially in the North. We focus on our clients\' long-term success and design solutions that fit their specific needs.</p>'],
            ['Do you offer training for clients?',
                '<p>Yes. We run training programmes, seminars and workshops, and we can design training around the specific needs you identify for your team. See <a href="/services/training">Training</a> for more.</p>'],
            ['Are you registered with the relevant authorities?',
                '<p>Yes. We are registered with the relevant regulatory authorities and follow the rules and standards they set, to make sure our clients receive a high level of service and protection. We are happy to share our registration details on request.</p>'],
            ['What types of investments do you recommend?',
                '<p>It depends on you. Our recommendations are tailored to each client\'s situation, goals, interests and risk tolerance. Much of our work involves sectors such as infrastructure, energy, agriculture, hospitality, transport and education.</p>'],
        ];

        foreach ($faqs as $i => [$q, $a]) {
            Faq::updateOrCreate(['sort_order' => $i + 1], ['question' => $q, 'answer' => $a, 'is_published' => true]);
        }
    }

    protected function highlights(): void
    {
        $groups = [
            'stats' => [
                ['title' => 'Years of leadership experience', 'subtitle' => '#+', 'value' => '20', 'body' => 'Our MD/CEO\'s career across DFID, IFC and Nigerian institutions'],
                ['title' => 'In project value facilitated', 'subtitle' => '$#M+', 'value' => '100', 'body' => 'Deals our investment team has helped originate and close'],
                ['title' => 'People targeted', 'subtitle' => '#k+', 'value' => '500', 'body' => 'Planned reach of our out-of-school children strategy'],
                ['title' => 'Years of combined team experience', 'subtitle' => '#+', 'value' => '30', 'body' => 'Across investment, finance, policy and development'],
            ],
            'why_us' => [
                ['icon' => 'award', 'title' => 'Experience', 'body' => 'A versatile team with more than three decades of combined experience, led by a CEO who has held senior roles at DFID, the IFC and key Nigerian institutions.'],
                ['icon' => 'layers', 'title' => 'Expertise', 'body' => 'Investment promotion, international finance, public-private partnerships and strategic advisory, applying global best practice to local markets.'],
                ['icon' => 'puzzle', 'title' => 'Tailored solutions', 'body' => 'Every business is different. We use our specialists\' experience to build solutions around your specific challenges, so your goals are met precisely and efficiently.'],
                ['icon' => 'shield', 'title' => 'Proven track record', 'body' => 'Projects delivered with DFID, the IFC and government agencies. Our leadership has led work in international project development, investment facilitation and market reform.'],
                ['icon' => 'star', 'title' => 'Commitment to excellence', 'body' => 'Led by a CEO with over 20 years in finance, investment and development, our team is committed to exceeding expectations and delivering world-class results.'],
            ],
            'values' => [
                ['title' => 'Impact-driven value creation', 'subtitle' => 'We measure success by the value and impact we create.', 'body' => 'We focus on outcomes, not activity. Every engagement must deliver measurable financial performance and meaningful development impact. We pursue solutions that create lasting value for our partners and contribute to wider economic progress.'],
                ['title' => 'Strategic rigour', 'subtitle' => 'We bring disciplined thinking and data-driven insight to every decision.', 'body' => 'Our work rests on evidence, structured analysis and deep market intelligence. We challenge assumptions, test ideas and make sure our recommendations are robust, defensible and aligned with long-term goals.'],
                ['title' => 'Excellence in execution', 'subtitle' => 'We turn strategy into measurable results.', 'body' => 'We go beyond advice to make sure strategies are practical, workable and focused on results. Through strong governance, accountability and quality assurance, we deliver solutions that perform in the real world.'],
            ],
            'process' => [
                ['icon' => 'users', 'title' => 'Initial consultation', 'body' => 'We listen first: your goals, your constraints and what success looks like for you.'],
                ['icon' => 'lightbulb', 'title' => 'Customised strategy', 'body' => 'We research the market and build a strategy designed around your specific situation.'],
                ['icon' => 'rocket', 'title' => 'Implementation & execution', 'body' => 'We put the plan into action alongside you, working with partners and stakeholders.'],
                ['icon' => 'trending', 'title' => 'Monitoring & optimisation', 'body' => 'We track results against agreed measures and adjust the approach to keep improving.'],
            ],
        ];

        foreach ($groups as $group => $items) {
            foreach ($items as $i => $item) {
                Highlight::updateOrCreate(['group' => $group, 'sort_order' => $i + 1], $item + ['is_published' => true]);
            }
        }
    }

    protected function clients(): void
    {
        $clients = [
            ['name' => 'Kano State Government', 'logo' => 'uploads/clients/kano.png', 'is_published' => true],
            ['name' => 'Bauchi State Government', 'logo' => 'uploads/clients/bauchi.png', 'is_published' => true],
            ['name' => 'Niger State Government', 'logo' => 'uploads/clients/niger.png', 'is_published' => true],
            ['name' => 'Northern States Governors\' Forum', 'logo' => null, 'is_published' => true],
            ['name' => 'Islamic Development Bank', 'logo' => null, 'is_published' => true],
            ['name' => 'Gombe Revenue Optimization Company (GROCOL)', 'logo' => null, 'is_published' => true],
            ['name' => 'Niger State Ministry for Transportation', 'logo' => null, 'is_published' => true],
            // Logos from the old site whose organisation names were not shown there.
            // Confirm each name in the admin dashboard, then publish it.
            ['name' => 'Client logo "gg" (confirm name)', 'logo' => 'uploads/clients/gg.png', 'is_published' => false],
            ['name' => 'Client logo "npicc" (confirm name)', 'logo' => 'uploads/clients/npicc.png', 'is_published' => false],
            ['name' => 'Client logo "master" (confirm name)', 'logo' => 'uploads/clients/master.png', 'is_published' => false],
            ['name' => 'Client logo "blue" (confirm name)', 'logo' => 'uploads/clients/blue.png', 'is_published' => false],
            ['name' => 'Client logo "client-1" (confirm name)', 'logo' => 'uploads/clients/client-1.png', 'is_published' => false],
        ];

        foreach ($clients as $i => $c) {
            Client::updateOrCreate(['sort_order' => $i + 1], $c);
        }
    }

    protected function gallery(): void
    {
        $captions = [
            1 => 'Onyx team at a stakeholder engagement',
            9 => 'Onyx Investment Advisory in the field',
        ];
        $files = [
            'uploads/gallery/gallery-1.png', 'uploads/gallery/gallery-2.png', 'uploads/gallery/gallery-3.png',
            'uploads/gallery/gallery-4.png', 'uploads/gallery/gallery-5.png', 'uploads/gallery/gallery-6.png',
            'uploads/gallery/gallery-7.png', 'uploads/gallery/gallery-8.png', 'uploads/gallery/gallery-9.jpg',
        ];
        foreach ($files as $i => $path) {
            GalleryImage::updateOrCreate(['path' => $path], ['caption' => $captions[$i + 1] ?? null, 'sort_order' => $i + 1, 'is_published' => true]);
        }
    }

    protected function offices(): void
    {
        Office::updateOrCreate(['name' => 'Abuja Office'], [
            'address' => '214 House B2, Block B, Phase II, Sani Zangon Daura Estate, Kado, FCT Abuja, Nigeria',
            'phone' => '+234 902 233 4405',
            'email' => 'info@onyxial.com',
            'map_query' => 'Sani Zangon Daura Estate, Kado, Abuja, Nigeria',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Office::updateOrCreate(['name' => 'London Office'], [
            'address' => '71–75 Shelton Street, Covent Garden, London WC2H 9JQ, United Kingdom',
            'phone' => null,
            'email' => 'info@onyxial.com',
            'map_query' => null,
            'sort_order' => 2,
            'is_published' => true,
        ]);
    }

    protected function redirects(): void
    {
        $map = [
            // Old WordPress team URLs that used the wrong names
            '/team/temitope-ajayi-adegbulu-acim-acia-shrm-pchrm' => '/team/takwi-titus-leonard',
            '/team/oloruntoba-oluwagbenga-oluwaseyi' => '/team/austin-onele',
            // Theme demo leftovers and common guesses
            '/portfolio-metro-mouse-info' => '/our-projects',
            '/portfolio' => '/our-projects',
            '/projects' => '/our-projects',
            '/services' => '/our-services',
            '/team' => '/our-team',
            '/about' => '/about-us',
            '/contact' => '/contacts',
            '/contact-us' => '/contacts',
            '/faqs' => '/faq',
            '/home' => '/',
        ];
        foreach ($map as $from => $to) {
            Redirect::updateOrCreate(['from_path' => $from], ['to_path' => $to, 'status_code' => 301]);
        }
    }
}
