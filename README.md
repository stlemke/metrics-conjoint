# metrics-conjoint
Source files for the software used to collect data during the conjoint analysis experiments in the metrics-project. Detailed information on the experiments' background, conduction and results can be found in an article that was published in the Journal of the Association for Information Science and Technology: https://asistdl.onlinelibrary.wiley.com/doi/10.1002/asi.24445 

The software runs on PHP and a MySQL-database. It was tested using PHP 7.0.13, MySQL 5.0.12 and an Apache 2.4.23 webserver. 

To get it running, extract all files to your webservers htdocs-directory, create a new MySQL database using the sql-scheme included in db/conjoint.sql, and enter your database's credentials in db/connectdb.php. 

Some general settings can be changed in lines 8-14 of explanation.php. Under the current settings, the experiment consists of an introduction, a first survey part, 20 ranking tasks and then a second survey part. It also contains an additional "bonus experiment" that participants can enter after having finished the main experiment. To disable the bonus experiment, change the code on close.php accordingly. 

Inside the database, product attributes and their levels are saved in table "indicators", while products (combinations of attributes of certain levels) are saved in table "publications".

Needless to say that if you plan to use the software for your own experiment you will have to at least change the texts and contact information in the php files - for now we kept most information as it was shown in our experiments to facilitate reproduction of our research. By changing the images (/img) and database contents, the software could fairly easily be adapted to other domains than research metrics, as long as the goal is to conduct a ranking- or choice-based conjoint analysis that participants can enter via their web browser. 
