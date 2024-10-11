# Document created by Arielle Lucca, based on a system developed as a test for a WordPress Developer position at WP Media

# SUMMARY
The purpose was to create a system developed in WordPress, with user management functionalities, with permissions and access levels.

- The system must contain three custom access roles and a default administrator level.
- The custom roles are: cool_kid, cooler_kid and coolest_kid - each with its own restrictions. 
- The cool_kid role is not allowed to view any information about any other user other than its own.
- The coolest_kid role has permission to view other users' names and countries. 
- The cooler_kid role has permission to view other users' names, countries, emails and roles.
- The administrator user is allowed to change the role of other users through a 3rd party integration, switching only between cool_kid, cooler_kid and coolest_kid.

# INSTALLATION
This repository covers the files needed for a theme that will be used for the system. You need to create a clean installation of WordPress, and a theme folder called cool-kids-network.
Checkout the master branch.

# APPROACH AND STEPS
- Initially, custom roles were created to be able to be assigned to users. As the purpose is just proof of concept, the default password for any user created is coolkid
- All user login, registration creation and role change functionality was developed with the front-end in mind, so it has a friendly interface.
- As much as possible and without the use of plugins, optimizations were made such as:
CSS minification, LCP image preload, font preload. 
(I really like using SCSS and Grunt, which makes CSS organized and processable.)
Fonts and some spacing were defined in 'rem', for accessibility purposes.
- Functionality files were separated into classes and applied namespaces. PHP's native spl_autoload_register was used as a class autoloader.
- The theme's basic files were also created, such as 404, archive, author and others. Although, the content of these pages was not developed, as they were not part of the purpose at this time.
- In terms of ajax and requests, I really like using REST API, so I did it that way. Even the functionality that allows the administrator user to change users' access levels has this integration.
- For important actions - like login, logout, login failed, user registration, role management - there is a log system that registers the ID of the user, date and time of each event. This logs are available in a menu page called Activity Logs. They are registered under the theme/logs/customkidslog.log.
There is a hook that is fired upon theme switching, which creates the log file. Depending on the host, there can be a permission error while creating the file. In this case, it can be created manually.

* every REST API request has nonces checking;
* every file is blocked for access outside of WordPress

# ADDITIONAL STEPS I WOULD DO IF THIS WAS A REAL PROJECT
- Secure the log file to be placed outside acessible folders;
- Refresh of user lists using ajax, without needing to refresh whole page;
- Implementation of tests (even though it is recommended in the assessment description, it would take a while to implement in this moment);
- Paginate Activity Logs (for a real system, this file would get a looot bigger), and creating log files per day;
- Send email to the user upon registration, using SMTP plugin;


# USAGE
The home page has a validation:
- If user is logged in, loads the user dashboard.
- If the user is not logged in, it shows the login box. Below, it shows the option to create registration. 
- Upon successful login, the user is redirected back to the home page containing the user panel.
If the user clicks on create registration, will be redirected to a page containing an email input and a register button. 
If registration is successful, a modal will open containing a link to the home page.
If the registration is not successful, a modal will open with a failure message and instructions to refresh the screen and try again.

## Once logged in:
- For the user cool_kid, the dashboard will only contain his own data.
- For the user cooler_kid, the dashboard will contain his own data, as well as cards containing the name and country of other users.
- For the user coolest_kid, the dashboard will contain his own data, as well as cards containing the name, country, email and role of other users.
- If the logged in user is the administrator, the dashboard will contain their own data, as well as complete cards from other users and two buttons to change the user's role.
When clicking on the new role button for any user, a request is sent to the REST API containing that user's email (in registration, it is not possible to include an existing email). The request will send this email along with the new role.
If it returns success, the screen will be reloaded. 
(because it's a proof of concept, I haven't worked with resending ajax requests to reload the list without reloading the page - but that's totally possible).


Thank you for reading this far! If any information is unclear or if you have any questions, please don't hesitate to ask me.
