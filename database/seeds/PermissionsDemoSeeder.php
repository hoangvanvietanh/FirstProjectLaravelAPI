<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
/**
* Create the initial roles and permissions.
*
* @return void
*/
public function run()
{
// Reset cached roles and permissions
app()[PermissionRegistrar::class]->forgetCachedPermissions();

// create permissions
Permission::create(['name' => 'edit post']);
Permission::create(['name' => 'add post']);
Permission::create(['name' => 'view post']);

// create roles and assign existing permissions
$role3 = Role::create(['name' => 'guest']);
$role3->givePermissionTo('view post');

$role2 = Role::create(['name' => 'user']);
$role2->givePermissionTo('add post');
$role2->givePermissionTo('edit post');

$role1 = Role::create(['name' => 'admin']);
// gets all permissions via Gate::before rule; see AuthServiceProvider

// create demo users
$user = Factory(App\User::class)->create([
'name' => 'admin',
'email' => 'admin@gmail.com',
'password' => '123456',
    'gender'=>'Female'
]);
$user->assignRole($role1);

$user = Factory(App\User::class)->create([
    'name' => 'user',
'email' => 'user@gmail.com',
    'password' => '123456',
    'gender'=>'Male'
]);
$user->assignRole($role2);

$user = Factory(App\User::class)->create([
    'name' => 'guest',
'email' => 'guest@gmail.com',
    'password' => '123456',
    'gender'=>'Male'
]);
$user->assignRole($role3);
}
}

