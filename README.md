# MusicApp
[![Coverage Status](https://coveralls.io/repos/github/Basemera/MusicApp/badge.svg)](https://coveralls.io/github/Basemera/MusicApp)
[![Build Status](https://travis-ci.org/Basemera/MusicApp.svg?branch=master)](https://travis-ci.org/Basemera/MusicApp)

Find it here live [`basemera-music`](https://basemera-music.herokuapp.com/api/)

## Requirements

[`PHP 7.2`](http://php.net/manual/en/install.php) - This version of Laravel uses PHP 7.2

[`Composer`](https://getcomposer.org/) - Composer is required for the libraries and dependencies

## Clone 
```git clone https://github.com/Basemera/MusicApp.git```

## Installation

Install all the required libraries from Composer while in the MusicApp folder
```
composer install
```
For the app to connect to you local database, you need to create a `.env` file on the root of your project.

To do that, copy the `.env.example` and rename it to `.env`, and then fill in the
necessary configurations as shown below
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=<database name>
DB_USERNAME=<database username>
DB_PASSWORD=<database password>

```

Generate an Artisan Key
```
php artisan key:generate
```
Generate Jwt key 
```
php artisan jwt:secret
```

Run migrations to create tables.
```
php artisan migrate
```

#Endpoints

| Method | Endpoint                                              | Description                  | Access          |
|--------|-------------------------------------------------------|------------------------------|-----------------|
| POST   | /api/auth/register                                    | Creates a user               | all users       |
| POST   | /api/user/login                                       | Login a user                 | all users       |
| POST   | /api/user/add_album/{user_id}                         | create an album id           | logged in users |
| GET    | /api//user/{user_id}/album                            | get a user's albums          | premium user    |
| PUT    | /api/user/album/user/{user_id}/edit/{album_id}        | edit album                   | premium user    |
| DELETE | /api/user/album/user/{user_id}/delete/{album_id}      | delete album                 | premium user    |
| POST   | /api/user/{user_id}/album/{album_id}/track            | create track                 | premium user    |
| GET    | /api/user/{user_id}/album/{album_id}/track/{track_id} | get track                    | logged in users |
| PATCH  | /api/user/{user_id}/album/{album_id}/track/{track_id} | updates track                | premium user    |
| DELETE | /api/user/{user_id}/album/{album_id}/track/{track_id} | delete track                 | premium user    |
| POST   | /api/user/{user_id}/playlist                          | create playlist              | premium user    |
| PATCH  | /api/user/{user_id}/playlist/{playlist_id}            | add or remove track from playlist| premium user|
| POST   | /api/user/{user_id}/track/{track_id}/comment          | comment on track             | logged in users |
| GET    | /api//user/comment/{comment_id}                       | get single comment           | logged in users |
| GET    | /api/user/comment/track/{track_id}                    | get all comments on a track  | logged in users |
| DELETE | /api/user/comment/{comment_id}                        | delete comment               | logged in users |
| PATCH  | /api/user/comment/{comment_id}                        | update comment               | logged in users |
