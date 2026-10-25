<?php

/*
|--------------------------------------------------------------------------
| Images from the old WordPress site (onyxial.com/wp-content/uploads)
|--------------------------------------------------------------------------
| local path (inside /public)  =>  original URL
|
| `php artisan onyx:import-images` downloads any of these that are missing.
| Run it while the old site is still reachable (before the domain moves).
*/

$wp = 'https://onyxial.com/wp-content/uploads/';

return [
    // Team
    'uploads/team/aisha-yakubu-bako.png' => $wp.'2020/04/Aisha.png',
    'uploads/team/takwi-titus-leonard.jpg' => $wp.'2020/04/Takwi_Leonard.jpg',
    'uploads/team/austin-onele.jpg' => $wp.'2020/04/MR-AUSTINE-1.jpg',

    // Services
    'uploads/services/program-development.png' => $wp.'2021/04/um-1.png',
    'uploads/services/investment-promotion-facilitation.png' => $wp.'2021/04/Artboard-1-1.png',
    'uploads/services/investment-intelligence.png' => $wp.'2021/04/inves-1.png',
    'uploads/services/training.png' => $wp.'2021/04/train-1.png',

    // Projects — featured images
    'uploads/projects/gombe-state-owned-hotels.png' => $wp.'2020/05/sde.png',
    'uploads/projects/niger-state-transport.png' => $wp.'2020/05/nt.png',
    'uploads/projects/out-of-school-children-almajiri.png' => $wp.'2020/05/mng-1.png',

    // Projects — galleries
    'uploads/projects/gombe/gombe-1.jpg' => $wp.'2020/05/267810338_111230741411403_5442586301455461017_n.jpg',
    'uploads/projects/gombe/gombe-2.png' => $wp.'2020/05/bae7225c.png',
    'uploads/projects/gombe/gombe-international-conference-centre.jpg' => $wp.'2020/05/The-abandoned-Gombe-International-Conference-Centre-1024x555.jpg',
    'uploads/projects/gombe/gombe-4.jpg' => $wp.'2020/05/onyx7-1-725x1024.jpeg',
    'uploads/projects/gombe/gombe-5.jpg' => $wp.'2020/05/2019-03-19.jpg',
    'uploads/projects/gombe/gombe-6.jpg' => $wp.'2020/05/IMG_20171104_095912-1024x768.jpg',
    'uploads/projects/gombe/gombe-7.jpg' => $wp.'2020/05/2017-05-05-1024x576.jpg',
    'uploads/projects/gombe/gombe-8.jpg' => $wp.'2020/05/471330627_574831781842265_7346291821798708278_n-1024x768.jpg',
    'uploads/projects/niger/niger-1.jpg' => $wp.'2025/01/469877538_122150936252318548_3909664889616516488_n-803x1024.jpg',
    'uploads/projects/niger/niger-2.jpg' => $wp.'2025/01/469665714_122150935952318548_3049171754845282316_n-1024x1003.jpg',
    'uploads/projects/niger/niger-3.jpg' => $wp.'2025/01/469871402_122150936030318548_7862129395229998841_n-1024x977.jpg',
    'uploads/projects/almajiri/almajiri-1.jpg' => $wp.'2020/05/onyx1-1024x683.jpg',
    'uploads/projects/almajiri/almajiri-2.jpg' => $wp.'2020/05/onyx3-1024x737.jpg',

    // Client logos
    'uploads/clients/kano.png' => $wp.'2025/01/kano.png',
    'uploads/clients/bauchi.png' => $wp.'2025/01/bauchoi.png',
    'uploads/clients/niger.png' => $wp.'2025/01/niger-1.png',
    'uploads/clients/gg.png' => $wp.'2025/01/gg.png',
    'uploads/clients/npicc.png' => $wp.'2025/01/npicc.png',
    'uploads/clients/master.png' => $wp.'2025/01/master.png',
    'uploads/clients/blue.png' => $wp.'2025/01/blue.png',
    'uploads/clients/client-1.png' => $wp.'2025/01/client-1-copyright.png',

    // Site images
    'uploads/site/about-team.jpg' => $wp.'2025/05/Onyx_RUfa.jpg',
    'uploads/site/home-about.png' => $wp.'2025/01/abttt.png',

    // About page gallery
    'uploads/gallery/gallery-1.png' => $wp.'2025/01/ima-2.png',
    'uploads/gallery/gallery-2.png' => $wp.'2025/01/mmn.png',
    'uploads/gallery/gallery-3.png' => $wp.'2025/01/mg-5.png',
    'uploads/gallery/gallery-4.png' => $wp.'2025/01/imm.png',
    'uploads/gallery/gallery-5.png' => $wp.'2025/01/mg.png',
    'uploads/gallery/gallery-6.png' => $wp.'2025/01/mg-8.png',
    'uploads/gallery/gallery-7.png' => $wp.'2025/01/mg-7.png',
    'uploads/gallery/gallery-8.png' => $wp.'2025/01/img-2.png',
    'uploads/gallery/gallery-9.jpg' => $wp.'2020/08/WhatsApp-Image-2025-01-24-at-11.31.42-AM.jpeg',
];
