<?php

namespace Database\Seeders\VersionSeeders;

use Database\Seeders\DefaultSettingSeeder;
use Database\Seeders\RolePermissionsSeeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Seeder;
use App\Models\{Menu, MenuItem};

class V222Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
 
        $menus = [
            [
                'name'          => 'Footer menu 6',
                'location'      => 'footer',
                'menu_items'    => [
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'About Us',
                        'route'     => url('about-us'),
                        'type'      => 'page',
                        'sort'      => '1',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Terms and Condition',
                        'route'     => url('terms-condition'),
                        'type'      => 'page',
                        'sort'      => '3',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Privacy Policy',
                        'route'     => url('privacy-policy'),
                        'type'      => 'page',
                        'sort'      => '4',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Contact Us',
                        'route'     => url('#'),
                        'type'      => 'page',
                        'sort'      => '5',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'FAQs',
                        'route'     => url('faq'),
                        'type'      => 'page',
                        'sort'      => '6',
                        'class'     => '',
                    ],
                    [
                        'menu_id'   => '',
                        'parent_id' => null,
                        'label'     => 'Blogs',
                        'route'     => url('blogs'),
                        'type'      => 'page',
                        'sort'      => '7',
                        'class'     => '',
                    ],
                ]
            ],
        ];

        foreach ($menus as $key => $menu) {
            $check = Menu::where('name', $menu['name'])->exists();
            if (!$check) {
                $menue = Menu::create([
                    'name'      => $menu['name'],
                    'location'  => $menu['location'],
                ]);

                foreach ($menu['menu_items'] as $items) {
                    MenuItem::create([
                        'menu_id'   => $menue->id,
                        'parent_id' => $items['parent_id'],
                        'label'     => $items['label'],
                        'route'     => $items['route'],
                        'type'      => $items['type'],
                        'sort'      => $items['sort'],
                        'class'     => '',
                    ]);
                }
            }
        }
        Artisan::call('optimize:clear');
    }
}
