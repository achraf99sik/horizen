# Changelog

All notable changes to this project will be documented in this file.

## [unreleased]

### 🚀 Features

- Adding rector to composer test script and fixing rector.php code style with pint
- Creating user model unit test and changing pest code coverage to 100%
- Add dates, DB and models configurations to AppServiceProvider for maintainability and consistency
- *(database)* Creating database migrations and the necessary models and factories
- Adjusting users table with the role column
- Adjusting commentFactory for testing
- Adjusting PlaylistVideoFactory
- Adjusting TagFactory
- Adjusting UserInfoFactory
- Adjusting VideoFactory
- Adjusting WatchHistoryFactory

### 🐛 Bug Fixes

- No_unused_imports in pint code linting
- *(docker)* Configure Xdebug and dependencies and resolve Xdebug double-loading issue
- *(docker)* Implementing new composer script and ignoring typos
- Puting tables in the write order and creating nationalities table
- Change back thumbnail from binary to longText
- Remove unnecessary rememberTocken from hidden column in the User Model
- Fixing test yml hashfiles bug
- Code style test is failing due to unmuching code styles
- Peck test is failing becouse of playlist, ignoring it in peck.json
- Rector test fail Add Closure Void Return Type Where No Return to fix it

### 💼 Other

- Create comments table schema
- Create categories table schema
- Create tags table schema
- Adjust user_infos table schema
- Adjust videos table schema
- Adjust playlists table schema
- Adjust playlist_videos table schema
- Adjust watch_histories table schema
- Adjust likes table schema

### 🚜 Refactor

- Changing all the code style to match pint rules to increase maintainability and consistency
- *(docker)* Change database name in docker compose
- Remove rememberTocken column from user table and UserFactory
- Refactoring commentFactory and adjusting LikeFactory with models factories
- Refactoring CommentFactory and adjusting PlaylistFactory

### 📚 Documentation

- Adding git cliff for auto changelog generating
- Update git-cliff ChangeLog

### 🧪 Testing

- Add scripts for unit tests, type checking, and linting

### ⚙️ Miscellaneous Tasks

- Initialize Laravel project
- Simplifying composer scripts
- Initializing rector to test and refactor code to match coding standard with set of formatting rules
- Adgusted composer test suit configration waiting for pest code coverage (fix)!!
- Applying rector rules
- Adjusting ci test workflow
- Setup database config, image and env
- Configure aspell in ci workflow
- Add on pull_request event triger for test workflow
- Setup docker configuration with all the required dependencies and images and nginx server config with custom php.ini
