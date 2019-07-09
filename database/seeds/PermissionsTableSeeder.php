<?php

//namespace Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'name'        => 'Добавлять статьи',
                'slug'        => 'articles.create',
                'description' => 'Юзеры могут добавлять статьи',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Изменять статьи',
                'slug'        => 'articles.edit',
                'description' => 'Юзеры могут изменять статьи',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Удалять статьи',
                'slug'        => 'articles.delete',
                'description' => 'Юзеры могут удалять статьи',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Менять приоритет статей',
                'slug'        => 'articles.priority',
                'description' => 'Юзеры могут менять приоритет статей',
                'model'       => 'Permission',
            ],

            [
                'name'        => 'Добавлять разделы',
                'slug'        => 'sections.create',
                'description' => 'Юзеры могут добавлять разделы',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Изменять разделы',
                'slug'        => 'sections.edit',
                'description' => 'Юзеры могут изменять разделы',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Удалять разделы',
                'slug'        => 'sections.delete',
                'description' => 'Юзеры могут удалять разделы',
                'model'       => 'Permission',
            ],
            [
                'name'        => 'Менять приоритет разделов',
                'slug'        => 'sections.priority',
                'description' => 'Юзеры могут менять приоритет разделов',
                'model'       => 'Permission',
            ],

        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
