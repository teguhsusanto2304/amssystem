<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'medical-record-list',
           'medical-record-create',
           'medical-record-edit',
           'medical-record-delete',
           'registration-list',
           'registration-create',
           'registration-edit',
           'registration-delete'
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}