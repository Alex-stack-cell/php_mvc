# php_mvc - Version 0.1
Home made php mvc framework 

<h2>Introduction</h2>
This is a home made php mvc framework based on the Udemy object oriented programming course from Traversy Media.
This framework is broken down into 2 parts containing each an htaccess file responsible for url, and redirection :
  * Public : This folder contains the entry point of the whole app; index.php. It also has files for CSS and JavaScript;
  * App : This folder contains all the features required for running the app. The base controller is covered by the Controller class under the libraries folder.
  
<h2>Customisation</h2>
For personnal customisation, some modifications are required :
  * Under the public folder, modify the name of your project at line 4 - RewriteBase /mvc/public;
  * For database configugration, go to config.php file under app/config. Update the constant as per your local environement.
  
