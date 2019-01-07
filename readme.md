#  <a href="http://142.93.119.73/">Laravel Focused website</a>

This website was my first time using laravel. It focused heavily on a wiki - esque video game based site where the user could create a wiki for a video game and then add tips to the page. After a user added a game or tip, a moderator would have to accept it before it was pushed to the public. The website uses Laravels Gates and Policies to determine if a user has access to do things such as add, edit, or push data.

Laravel Gates and Policies used to determine user rights. each role in UserRoles table in database determines what each Role has access to. For example Administrator has access to the following UserRoles: pushUpdate, showEdit, showView, pushDelete. The pushUpdate the user to make any post visible. showEdit allows the user to see any invisible edits. showView allows the user to see to see any invisible posts and pushDelete allows the user to delete anything they have access to.

Skills Used
- Laravel
  - Laravel Gates and Policies
- Node.js
- PHP
