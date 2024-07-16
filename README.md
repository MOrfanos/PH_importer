The project is Dockerized and written in Laravel and MySQL using Javascript and jQuery for the front end.

Follow these steps to launch the project:

1. composer install
2. ./vendor/bin/sail up -d
3. ./vendor/bin/sail artisan migrate #creates the DB
4. ./vendor/bin/sail artisan import-pornstars #imports pornstars from the json
5. Begin by visiting http://localhost/

You may find a postman collection included in the project with the 2 API endpoints [index, show].

I've also provided a unit test on the "download image" functionality which can run as follows `vendor/bin/phpunit tests/Unit/HandlesImagesTest.php`.

A few words on the project:

- Hitting the command for the import I compare the headers of the server 'etag' and 'last-modified' to check if the json has changed. If it has not I'm not importing.
- I introduce a JsonMetadata table to keep track of all the times the import has tried to run and save the above headers for comparison.
- Assuming there are changes I delete any cached images and start storing pornstars. On every pornstar item I keep a "hash" to check if there are any changes on the json from the last time the import run.

- The import is scheduled on Kernel to run daily (no specific time was given though).
- I've added throttling on the API endpoints.
- No throttling on the WEB endpoints.

- There are 2 pages accessible from the browser. The landing page (index page) which has some basic info on the pornstar and a LOAD MORE button and a Profile page which includes all the other data including the images.
- Images are stored in storage the first time a profile is hit.
- Cached images will get deleted when the import reruns (and there are changes on the json file).
