# multiauth

php artisan make:migration add_role_to_users_table--table=users

  $table->string('role')->default('user');
  make change in modal laso

While multi factor authentication enum is used enum is olny for valid user authentication
$user->role = UserRole::Admin; // Safe
Instead of repeating strings 'admin','user' time and again like:
if($user->role=='admin')
{

}
use
if($user->role==UserRole::Admin)
{

}
It reducres typos and make more maintanable.


In modal
 protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class
        ];
    }
Casting in Laravel is a powerful feature that allows you to automatically convert attributes on your Eloquent models to common data types (like integers, booleans, dates, arrays, objects) or even custom types like enums when you retrieve or set them.
It automatically binds with the enum data type

   if(auth()->user()->role === UserRole::Admin){
            return redirect()->route('admin.dashboard')->with("success","log in sucessfull");
        }
If the user is logged in, you get the User model instance. Then $user->role will return an enum instance, not just a string
=== UserRole::Admin
his compares the user’s role with the enum value UserRole::Admin.
This is a strict comparison, meaning both:
The value must be 'admin'
The type must match the enum type 
 
