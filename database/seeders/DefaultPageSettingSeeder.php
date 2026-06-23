<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Larabuild\Pagebuilder\Models\Page;
use App\Services\PageBuilderService;
use Modules\Courses\Models\Course;
class DefaultPageSettingSeeder extends Seeder
{
    private $pageBuilderService;
    public function __construct()
    {
        $this->pageBuilderService = new PageBuilderService();
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run($version = null)
    {
        if ($version == '1.1') {

            try {
                $page = Page::where('slug', 'home-two')->first();
                if (!$page) {
                    $page = Page::create([
                        'name' => 'Home Page 2',
                        'slug' => 'home-two',
                        'title' => 'Home Page 2 | Lernen',
                        'description' => 'Home Page 2 | Lernen',
                        'settings' => null,
                        'status' => 'published',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $page->settings = $this->getHomePage2Settings($page);
                    $page->save();
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }
            return;
        }

        if ($version == '1.3') {
            try {
                DB::beginTransaction();

                $page = Page::where('slug', 'home-three')->first();
                if (!$page) {
                    $page = Page::create([
                        'name' => 'Home Page 3',
                        'slug' => 'home-three',
                        'title' => 'Home Page 3 | Lernen',
                        'description' => 'Home Page 3 | Lernen',
                        'settings' => null,
                        'status' => 'published',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $page->settings = $this->getHomePage3Settings($page);
                    $page->save();
                }

                $page = Page::where('slug', 'home-four')->first();
                if (!$page) {
                    $page = Page::create([
                        'name' => 'Home Page 4',
                        'slug' => 'home-four',
                        'title' => 'Home Page 4 | Lernen',
                        'description' => 'Home Page 4 | Lernen',
                        'settings' => null,
                        'status' => 'published',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $page->settings = $this->getHomePage4Settings($page);
                    $page->save();
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th->getMessage());
            }

            return;
        }

        if ($version == '1.5') {
            try {

                $page = Page::where('slug', 'home-five')->first();
                if (!$page) {
                    $page = Page::create([
                        'name' => 'Home Page 5',
                        'slug' => 'home-five',
                        'title' => 'Home Page 5 | Lernen',
                        'description' => 'Home Page 5 | Lernen',
                        'settings' => null,
                        'status' => 'published',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    $page->settings = $this->getHomePage5Settings($page);
                    $page->save();
                }
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            return;
        }

        if ($version == '1.7') {
            $page = Page::where('slug', 'home-six')->first();

            if (!$page) {
                $page = Page::create([
                    'name' => 'Home Page 6',
                    'slug' => 'home-six',
                    'title' => 'Home Page 6 | Lernen',
                    'description' => 'Home Page 6 | Lernen',
                    'settings' => null,
                    'status' => 'published',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            try {
                $page->settings = $this->getHomePage6Settings($page);

                $page->save();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            return;
        }

        if ($version == '1.9') {
            $page = Page::where('slug', 'home-seven')->first();

            if (!$page) {
                $page = Page::create([
                    'name' => 'Home Page 7',
                    'slug' => 'home-seven',
                    'title' => 'Home Page 7 | Lernen',
                    'description' => 'Home Page 7 | Lernen',
                    'settings' => null,
                    'status' => 'published',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            try {
                $page->settings = $this->getHomePage7Settings($page);

                $page->save();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            return;
        }

        if ($version == '1.11') {
            $page = Page::where('slug', 'home-eight')->first();

            if (!$page) {
                $page = Page::create([
                    'name' => 'Home Page 8',
                    'slug' => 'home-eight',
                    'title' => 'Home Page 8 | Lernen',
                    'description' => 'Home Page 8 | Lernen',
                    'settings' => null,
                    'status' => 'published',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            try {
                $page->settings = $this->getHomePage8Settings($page);

                $page->save();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            return;
        }

        if ($version == '2.1.5') {
            $page = Page::where('slug', 'home-nine')->first();

            if (!$page) {
                $page = Page::create([
                    'name' => 'Home Page 9',
                    'slug' => 'home-nine',
                    'title' => 'Home Page 9 | Lernen',
                    'description' => 'Home Page 9 | Lernen',
                    'settings' => null,
                    'status' => 'published',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            try {
                $page->settings = $this->getHomePage9Settings($page);

                $page->save();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            return;
        }

        Page::truncate();
        $pageData = [];
        $pages = [
            [
                'name' => 'Home Page',
                'slug' => '/',
                'title' => 'Home | Lernen',
                'description' => 'Home | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 2',
                'slug' => 'home-two',
                'title' => 'Home Page 2 | Lernen',
                'description' => 'Home Page 2 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 3',
                'slug' => 'home-three',
                'title' => 'Home Page 3 | Lernen',
                'description' => 'Home Page 3 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 4',
                'slug' => 'home-four',
                'title' => 'Home Page 4 | Lernen',
                'description' => 'Home Page 4 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 5',
                'slug' => 'home-five',
                'title' => 'Home Page 5 | Lernen',
                'description' => 'Home Page 5 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 6',
                'slug' => 'home-six',
                'title' => 'Home Page 6 | Lernen',
                'description' => 'Home Page 6 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 7',
                'slug' => 'home-seven',
                'title' => 'Home Page 7 | Lernen',
                'description' => 'Home Page 7 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 8',
                'slug' => 'home-eight',
                'title' => 'Home Page 8 | Lernen',
                'description' => 'Home Page 8 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Home Page 9',
                'slug' => 'home-nine',
                'title' => 'Home Page 9 | Lernen',
                'description' => 'Home Page 9 | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Faq',
                'slug' => 'faq',
                'title' => 'Faqs | Lernen',
                'description' => 'Faqs | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'How it works',
                'slug' => 'how-it-works',
                'title' => 'How it works | Lernen',
                'description' => 'How it works | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'About Us',
                'slug' => 'about-us',
                'title' => 'About Us | Lernen',
                'description' => 'About Us | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Terms & condition',
                'slug' => 'terms-condition',
                'title' => 'Terms & condition | Lernen',
                'description' => 'Terms & condition | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy | Lernen',
                'description' => 'Privacy Policy | Lernen',
                'settings' => null,
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];


        Page::insert($pages);

        $sitePages = Page::get();

        if (!empty($sitePages)) {
            foreach ($sitePages as $page) {
                $pageName = preg_replace("/[^A-zÀ-ú0-9]+/", "", str_replace(' ', '', $page->name));
                $page->settings  = $this->{'get' . $pageName . 'Settings'}($page);
                $page->save();
            }
        }
        // clearCache();
    }

    private function getHomePageSettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => ''], 'data' => [['banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['steps']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['marketplace']]],
        ];
        if (\Nwidart\Modules\Facades\Module::has('Courses') && \Nwidart\Modules\Facades\Module::isEnabled('Courses') && Course::exists()) {
            $sections[] = ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['courses']]];
        }
        $sections = array_merge($sections, [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['user-guide']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-tutors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
        ]);
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage2Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v2']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['easy-steps']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['revolutionize']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['track']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
        ];
        if (\Nwidart\Modules\Facades\Module::has('Courses') && \Nwidart\Modules\Facades\Module::isEnabled('Courses') && Course::exists()) {
            $sections[] = ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['courses']]];
        }
        $sections = array_merge($sections, [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['tuition']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['experienced-tutors']]],
        ]);

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage3Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v3']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['easy-steps']]],
        ];
        if (\Nwidart\Modules\Facades\Module::has('Courses') && \Nwidart\Modules\Facades\Module::isEnabled('Courses') && Course::exists()) {
            $sections[] = ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['courses']]];
        }
        $sections = array_merge($sections, [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['unique-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['experienced-tutors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['faqs-without-btn']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
        ]);

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage4Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v4']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['easy-steps']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['unique-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['why-choose-us']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['experienced-tutors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],

        ];

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage5Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v5']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['categories']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['categories']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-mentors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-mentors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['limitless-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['unique-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
        ];
        $sectionPosition = 0; 
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                foreach ($colSection as $section) {
                    $sectionId = $section == 'categories' ? $section . "_" . $sectionPosition : $this->uniqueId();
                    $categoryId = $section == 'categories' ? $section . "_" . $sectionPosition : $this->uniqueId();
                    $tutorId = $section == 'featured-mentors' ? $section . "_" . $sectionPosition : $this->uniqueId();
                
                    if ($section == 'categories') {
                        $page->section_id = $categoryId;
                    } elseif ($section == 'featured-mentors') {
                        $page->section_id = $tutorId;
                    }

                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                    unset($page->section_id);
                    $sectionPosition++;
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage6Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v6']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['categories']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['marketplace-stands-out']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['guide-steps']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['faqs-without-btn']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
        ];
        $sectionPosition = 0;
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                foreach ($colSection as $section) {
                    $sectionId = $section == 'categories' ? $section . "_" . $sectionPosition : $this->uniqueId();
                    $categoryId = $section == 'categories' ? $section . "_" . $sectionPosition : $this->uniqueId();
                    $tutorId = $section == 'featured-mentors' ? $section . "_" . $sectionPosition : $this->uniqueId();

                    if ($section == 'categories') {
                        $page->section_id = $categoryId;
                    } elseif ($section == 'featured-mentors') {
                        $page->section_id = $tutorId;
                    }

                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                    unset($page->section_id);
                    $sectionPosition++;
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage7Settings($page) 
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v7']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['easy-steps']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['categories']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['marketplace-stands-out']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-mentors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['tuition']]],
        ];
        $sectionPosition = 0;
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                foreach ($colSection as $section) {
                    $sectionId = $section == 'categories' ? $section."_".$sectionPosition : $this->uniqueId();
                    $categoryId = $section == 'categories' ? $section."_".$sectionPosition : $this->uniqueId();
                    $tutorId = $section == 'featured-mentors' ? $section."_".$sectionPosition : $this->uniqueId();

                    if ($section == 'categories') {
                        $page->section_id = $categoryId;
                    } elseif ($section == 'featured-mentors') {
                        $page->section_id = $tutorId;
                    }

                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                    unset($page->section_id);
                    $sectionPosition ++;
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;

            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage8Settings($page) 
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v8']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['mission']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['marketplace-stands-out']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['categories']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-mentors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['tuition']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
        ];
        $sectionPosition = 0;
        foreach ($sections as $gridData) {
            $gridPosition = 0;  
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                foreach ($colSection as $section) {
                    $sectionId = $section == 'categories' ? $section."_".$sectionPosition : $this->uniqueId();
                    $categoryId = $section == 'categories' ? $section."_".$sectionPosition : $this->uniqueId();
                    $tutorId = $section == 'featured-mentors' ? $section."_".$sectionPosition : $this->uniqueId();

                    if ($section == 'categories') {
                        $page->section_id = $categoryId;
                    } elseif ($section == 'featured-mentors') {
                        $page->section_id = $tutorId;
                    }

                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                    unset($page->section_id);
                    $sectionPosition ++;
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;

            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    public function getHomePage9Settings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['banner-v9']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['easy-steps']]],
        ];
        if (\Nwidart\Modules\Facades\Module::has('Courses') && \Nwidart\Modules\Facades\Module::isEnabled('Courses') && Course::exists()) {
            $sections[] = ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['courses']]];
        }
        $sections = array_merge($sections, [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['unique-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['featured-mentors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['limitless-features']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['get-app']]],
        ]);
        
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
       
        return $pageData;
    }

    private function getFaqSettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => '', 'classes' => ''], 'data' => [['content-banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['faqs']]],
        ];

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    private function getHowItWorksSettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => '', 'classes' => ''], 'data' => [['content-banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['how-it-works']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['vision']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
            ['grid' => '12x1', 'styles' => ['content_width' => '', 'classes' => 'am-joincommunity'], 'data' => [['content-banner']]],
        ];
        $sectionPosition = 0;
        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                foreach ($colSection as $section) {
                    $sectionId = $section == 'content-banner' ? $section . "_" . $sectionPosition : $this->uniqueId();
                    $page->section_id = $sectionId;
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                    unset($page->section_id);
                    $sectionPosition++;
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    private function getAboutUsSettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => ''], 'data' => [['content-banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['mission']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['vision']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['experienced-tutors']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['achievements']]],
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['clients-feedback']]],
        ];

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }

    private function getTermsConditionSettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['content-banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => ''], 'data' => [['paragraph']]],
        ];

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }

        return $pageData;
    }

    private function getPrivacyPolicySettings($page)
    {
        $pageData = [];
        $sections = [
            ['grid' => '12x1', 'styles' => ['content_width' => 'full_width'], 'data' => [['content-banner']]],
            ['grid' => '12x1', 'styles' => ['content_width' => ''], 'data' => [['paragraph']]],
        ];

        foreach ($sections as $gridData) {
            $gridPosition = 0;
            $gridId       = $this->uniqueId();
            $data         = [];
            foreach ($gridData['data'] as $col => $colSection) {
                $sectionPosition = 0;
                foreach ($colSection as $section) {
                    $sectionId = $this->uniqueId();
                    $data[$col][] = ['id' => $sectionId, 'section_id' => $section, 'position' => $sectionPosition];
                    $parseFunction = (string)"get" . Str::ucfirst(Str::camel($section)) . "Data";
                    $pageData['section_data'][$sectionId]['settings'] = $this->$parseFunction($page);
                }
                $data;
                $pageData['section_data'][$gridId]['styles'] = array_merge($this->defaultStyles(), $gridData['styles']);
                $gridPosition++;
            }
            $pageData['grids'][] = ['grid' => $gridData['grid'], 'position' => $gridPosition, 'grid_id' => $gridId, 'data' => $data];
        }
        return $pageData;
    }
    
    private function getBannerData($page)
    {
        return $this->pageBuilderService->getBannerData($page->id);
    }

    private function getBannerV2Data($page)
    {
        return $this->pageBuilderService->getBannerV2Data($page->id);
    }

    private function getBannerV3Data($page)
    {
        return $this->pageBuilderService->getBannerV3Data($page->id);
    }

    private function getBannerV4Data($page)
    {
        return $this->pageBuilderService->getBannerV4Data($page->id);
    }
  
    private function getBannerV5Data($page)
    {
        return $this->pageBuilderService->getBannerV5Data($page->id);
    }

    private function getBannerV6Data($page)
    {
        return $this->pageBuilderService->getBannerV6Data($page->id);
    }

    private function getBannerV7Data($page) 
    {
        return $this->pageBuilderService->getBannerV7Data($page->id);
    }

    private function getBannerV8Data($page) 
    {
        return $this->pageBuilderService->getBannerV8Data($page->id);
    }

    private function getBannerV9Data($page)
    {
        return $this->pageBuilderService->getBannerV9Data($page->id);
    }

    private function getCoursesData($page)
    {
       return $this->pageBuilderService->getCoursesData($page->id, $page->section_id ?? null);
    }

    private function getCategoriesData($page)
    {
       return $this->pageBuilderService->getCategoriesData($page->id, $page->section_id ?? null);
    }

    private function getEasyStepsData($page)
    {
        return $this->pageBuilderService->getEasyStepsData($page->id);
    }

    private function getGuideStepsData($page)
    {
        return $this->pageBuilderService->getGuideStepsData($page->id);
    }

    private function getWhyChooseUsData($page)
    {
        return $this->pageBuilderService->getWhyChooseUsData($page->id);
    }

    private function getRevolutionizeData($page)
    {
        return $this->pageBuilderService->getRevolutionizeData($page->id);
    }

    private function getTrackData($page)
    {
        return $this->pageBuilderService->getTrackData($page->id);
    }

    private function getTuitionData($page)
    {
        return $this->pageBuilderService->getTuitionData($page->id);   
    }

    private function getGetAppData($page)
    {
        return $this->pageBuilderService->getGetAppData($page->id);
    }

    private function getMarketplaceData($page)
    {
        return $this->pageBuilderService->getMarketplaceData($page->id);
    }

    private function getStepsData($page)
    {
        return $this->pageBuilderService->getStepsData($page->id);
    }
   
    private function getUserGuideData($page)
    {
        return $this->pageBuilderService->getUserGuideData($page->id);
    }

    private function getFeaturedTutorsData($page)
    {
        return $this->pageBuilderService->getFeaturedTutorsData($page->id);
    }

    private function getFaqsData($page)
    {
        return $this->pageBuilderService->getFaqsData($page->id);
    }

    private function getFaqsWithoutBtnData($page)
    {
        return $this->pageBuilderService->getFaqsWithoutBtnData($page->id);
    }

    private function getHowItWorksData($page)
    {
        return $this->pageBuilderService->getHowItWorksData($page->id);
    }

    private function getParagraphData($page)
    {
        return $this->pageBuilderService->getParagraphData($page->id);
    }

    private function getContentBannerData($page)
    {
        return $this->pageBuilderService->getContentBannerData($page->id);
    }

    private function getMissionData($page)
    {
        return $this->pageBuilderService->getMissionData($page->id);
    }

    private function getVisionData($page)
    {
        return $this->pageBuilderService->getVisionData($page->id);
    }

    private function getExperiencedTutorsData($page)
    {
        return $this->pageBuilderService->getExperiencedTutorsData($page->id);
    }

    private function getFeaturedMentorsData($page)
    {
        return $this->pageBuilderService->getFeaturedMentorsData($page->id, $page->section_id ?? null);
    }

    private function getAchievementsData($page)
    {
        return $this->pageBuilderService->getAchievementsData($page->id);
    }

    private function getClientsFeedbackData($page)
    {
        return $this->pageBuilderService->getClientsFeedbackData($page->id);
    }

    private function getUniqueFeaturesData($page)
    {
        return $this->pageBuilderService->getUniqueFeaturesData($page->id);
    }

    private function getMarketplaceStandsOutData($page)
    {
        return $this->pageBuilderService->getMarketplaceStandsOutData($page->id);
    }

    private function getSpacerData($page)
    {
        return $this->pageBuilderService->getSpacerData($page->id);
    }

    private function getCategoriesV1($page){

        return [
            'section_title_variation'   => ['value' => 'am-section_title_three', 'is_array' => 0],
            'categories_verient'        => ['value' => 'verient-one', 'is_array' => 0],
            'pre_heading'               => ['value' => 'Categories', 'is_array' => 0],
            'heading'                   => ['value' => 'Explore Mentorship Categories', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Discover categories designed to help you excel in your professional and personal growth.', 'is_array' => 0],
            'all_category_heading'      => ['value' => 'Discover All Categories', 'is_array' => 0],
            'all_category_paragraph'    => ['value' => 'Build responsive websites with expert guidance.', 'is_array' => 0],
            'view_category_btn_url'     => ['value' => 'find-tutors', 'is_array' => 0],
            'view_category_btn_txt'     => ['value' => 'View Categories', 'is_array' => 0],
            'categories_repeater'       => ['value' => [
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img01.png')],
                    'category_heading'     => 'Web Development',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=1'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img02.png')],
                    'category_heading'     => 'Software Design',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=4'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img03.png')],
                    'category_heading'     => 'Content Writing',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img04.png')],
                    'category_heading'     => 'Social Studies',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=8'),
                    'explore_more_btn_txt' => 'Explore more'
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img05.png')],
                    'category_heading'     => 'Physical Education',
                    'category_paragraph'   => 'Build responsive websites with expert guidance.',
                    'explore_more_btn_url' => url('find-tutors?subject_id=11'),
                    'explore_more_btn_txt' => 'Explore more'
                ]
            ], 'is_array' => '1']
        ];
    }

    private function getCategoriesV2($page)
    {
        $variation = '';
        if ($page->slug == 'home-six') {
            $variation = 'am-verient-three';
        } elseif ($page->slug == 'home-five' && $page->section_id == 'categories_2') {
            $variation = 'verient-two';
        }

        return [
            'section_title_variation'   => ['value' => 'am-section_title_three', 'is_array' => 0],
            'categories_verient'        => ['value' => $variation, 'is_array' => 0],
            'pre_heading'               => ['value' => 'Categories', 'is_array' => 0],
            'heading'                   => ['value' => 'Explore Mentorship Categories', 'is_array' => 0],
            'paragraph'                 => ['value' => 'Discover categories designed to help you excel in your professional and personal growth.', 'is_array' => 0],
            'view_category_btn_url'     => ['value' => 'find-tutors', 'is_array' => 0],
            'view_category_btn_txt'     => ['value' => 'View Categories', 'is_array' => 0],
            'categories_repeater'       => ['value' => [
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img06.png')],
                    'category_heading'     => 'Web Development',
                    'explore_more_btn_url' => url('find-tutors?subject_id=1'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img02.png')],
                    'category_heading'     => 'Software Design',
                    'explore_more_btn_url' => url('find-tutors?subject_id=4'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img05.png')],
                    'category_heading'     => 'Physical Education',
                    'explore_more_btn_url' => url('find-tutors?subject_id=11'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img04.png')],
                    'category_heading'     => 'Social Studies',
                    'explore_more_btn_url' => url('find-tutors?subject_id=8'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img03.png')],
                    'category_heading'     => 'Content Writing',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img07.png')],
                    'category_heading'     => 'Finance',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img08.png')],
                    'category_heading'     => 'Science',
                    'explore_more_btn_url' => url('find-tutors?subject_id=10'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img09.png')],
                    'category_heading'     => 'English',
                    'explore_more_btn_url' => url('find-tutors?subject_id=6'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img10.png')],
                    'category_heading'     => 'Communication',
                    'explore_more_btn_url' => url('find-tutors'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img11.png')],
                    'category_heading'     => 'Blogging',
                    'explore_more_btn_url' => url('blogs'),
                ],
                $this->uniqueId() => [
                    'category_image'       => [uploadObMedia('demo-content/home-v5/category-img12.png')],
                    'category_heading'     => 'Graphic Design',
                    'explore_more_btn_url' => url('find-tutors'),
                ]
            ], 'is_array' => '1']
        ];
    }

    private function getLimitlessFeaturesData($page)
    {
        return $this->pageBuilderService->getLimitlessFeaturesData($page->id);
    }

    public function uniqueId()
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, 10);
    }

    public function defaultStyles()
    {
        return [
            'content_width'     => '',
            'width-height-type' => 'px',
            'width'             => '',
            'height'            => '',
            'min-width'         => '',
            'max-width'         => '',
            'min-height'        => '',
            'max-height'        => '',
            'margin-type'       => 'px',
            'margin-top'        => '',
            'margin-right'      => '',
            'margin-bottom'     => '',
            'margin-left'       => '',
            'padding-type'      => 'px',
            'padding-top'       => '',
            'padding-right'     => '',
            'padding-bottom'    => '',
            'padding-left'      => '',
            'z-index'           => '',
            'classes'           => '',
            'background-size'   => '',
            'background-position' => '',
        ];
    }
}
