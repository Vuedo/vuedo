# Vuedo ![logo](http://i.imgur.com/iBEAx7O.png?2)
[![Build Status](https://travis-ci.org/Vuedo/vuedo.svg?branch=master)](https://travis-ci.org/Vuedo/vuedo) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE) [![Join the chat at https://gitter.im/vuedo/Lobby](https://badges.gitter.im/vuedo/Lobby.svg)](https://gitter.im/vuedo/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## What is Vuedo?

Vuedo is an open source project built with Laravel and Vue.js. It is a live example of how everything works together.

## Website using Vuedo in production : [https://vuejsfeed.com/](https://vuejsfeed.com/)

Vue.js Feed is a place where News, Tutorials, Plugins, Showcases and more things regarding Vue are handpicked and shared with the community.

![Dashboard Overview](http://i.imgur.com/4AdbjsF.gif)

## Basic Features:

* Manage posts and media
* Categorize posts
* User Roles
* Content moderation
* Markdown Editor
* Amazon S3 integration
* and more...

## Installation

Download this repo.

Rename `.env.example` to `.env` and fill the options.

Run the following commands:

```
composer install
npm install
php artisan key:generate
php artisan migrate
php artisan db:seed
gulp
php artisan serve
```

If you are making changes to JavaScript or Styles make sure you run `gulp watch`.

## Technical Description

You can find the technical description and a list with the libraries used in development [here](https://github.com/Vuedo/vuedo/wiki/Technical-Description).

## Documentation

Coming soon...

## Issues

For technical questions and bugs feel free to open one issue.

## Contribution

Soon a roadmap for contribution will be added so everyone will be welcome to join.

## Stay In Touch

For latest releases and announcements, follow [@vuedo](https://twitter.com/vuedo) on Twitter.

## License

Vuedo is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
