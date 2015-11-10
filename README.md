# interaktiv-test
This is the repo for Interaktiv's Recruitment Test


How To Install: 

	1. Clone this Repo to Your local folder.

	2. create your own .env base on .env.example provided in this repository. Place it on root of folder. Change your DB_HOST,DB_DATABASE, DB_USERNAME, and DB_PASSWORD base on your system. dont forget to create database in your local dbms.
	3. Open your terminal and go to your local folder path. use "composer install".
	4. after finished. run php artisan migrate.
	5. open browser, then go to address http://yourlocalip/your_path_to_local_folder/your_local_folder_name/public
	6. For the first time, click "Update Data From CSV and JSON" button.
	7. finish and enjoy!.


Note:
	
	1. If you get an error like "PHP Fatal error: Call to undefined method Illuminate\Foundation\Application::getCachedCompilePath()" then you must delete compiled.php file in /vendor and then run composer install / composer update again

	2. when you open the web and get an error 500 you must set user modify permission to laravel standard. or if you only want to see the web and not mind about security just change chmod to 777.
