<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin1',
                'path'        => 'admin1',
                'text'        => 'jsghaldkfjghaksljdg',
                'page_id'     => 0,
                'status'      => 0,
            ],
            [
                'name'        => 'Admin2',
                'path'        => 'admin2',
                'text'        => 'jsghaldkfjghaksljdg',
                'page_id'     => 0,
                'status'      => 1,
            ],
            [
                'name'        => 'Admin3',
                'path'        => 'admin3',
                'text'        => 'jsghaldkfjghaksljdg',
                'page_id'     => 2,
                'status'      => 4,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = DB::table('pages')->insert([
                'name'          => $RoleItem['name'],
                'path'          => $RoleItem['path'],
                'text'   => $RoleItem['text'],
                'page_id'         => $RoleItem['page_id'],
                'status'         => $RoleItem['status'],
            ]);
        }
    }
}
