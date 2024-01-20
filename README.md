## About This Repository

This repository uses PHP Laravel version 10, Javascript Vue.js version 3 and Tailwind css frameworks to implement Role Permissions management in CMS. Vite is used to compile the frontend assets. Cookie based SPA authorization feature of Laravel Sanctum package is used to authorize the user inside the content management system. Vue router is used to handle the routing and Pinia is used as the frontend store management system. If a logged user has permission to do specific task, the link to visit the task and the page containing the task will be available to the logged user. Otherwise the page will be unavailable to the logged user with 401 unauthorized error even though try to access the route manually. Though some actions are visible on the frontend for better user experience, but it will handled on the backend and shows a error toast with relevant error message as well as permission requirements. This repo utilizes the SPA feature of Vue.js.

## Logging In

Following credentials can be used to log in the system

<table>
    <thead>
       <tr>
            <th>Sl</th>
            <th>Role</th>
            <th>Email Address</th>
            <th>Password</th>
       </tr> 
    </thead>
    <tbody>
        <tr>
            <td>01</td>
            <td>Super Admin</td>
            <td>sadmin@sadmin.com</td>
            <td>password</td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td>02</td>
            <td>Admin</td>
            <td>admin@admin.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>03</td>
            <td>Author</td>
            <td>author@author.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>04</td>
            <td>Editor</td>
            <td>editor@editor.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>05</td>
            <td>User</td>
            <td>user@user.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>06</td>
            <td>User</td>
            <td>user1@user.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>07</td>
            <td>User</td>
            <td>user2@user.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>08</td>
            <td>User</td>
            <td>user3@user.com</td>
            <td>password</td>
        </tr>
    </tbody>
        <tbody>
        <tr>
            <td>09</td>
            <td>User</td>
            <td>user4@user.com</td>
            <td>password</td>
        </tr>
    </tbody>
</table>
<br>

Initailly only Super Admin is granted all the permissions. All other role has no permissions. To add permissions to any other role, first log in as super admin, then go to the roles page. Assign necessary permissions to the role. Then come to the users page and update users roles. One user can have multiple roles. Overall user permissions will be the collection of all roles permissions combined. Super admin role is readonly(can not be edited or deleted). This role can not be applied to any other user. If a new permission is created, updated or deleted, it will be automatically applied to super admin.

## Installation

First download this repository. Navigate to root of the project and then

<pre>
    <code>composer install</code>
    <code>npm install</code>
</pre>

Copy the contents of .env.example to .env file. Fill up the database credentials(DB_DATABASE, DB_USERNAME, DB_PASSWORD) according to your database. At the root of your project run the following commands on terminal sequentially.

<pre>
    <code>php artisan key:generate</code>
    <code>php artisan migrate</code>
    <code>php artisan db:seed</code>
</pre>

This will store all the default data into the database. Then compile the assets and run development server by

<pre>
    <code>npm run dev</code>
</pre>

Finally initiate your server on a new terminal and enjoy !!!

<pre>
    <code>php artisan serve</code>
</pre>
