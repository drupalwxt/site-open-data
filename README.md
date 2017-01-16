Composer Project for Open Data
==============================

[![Build Status][ci-badge]][ci]

Drupal WxT codebase for `Open Data`.

## Requirements

* [Composer][composer]
* [Node][node]

## Maintenance

List of common commands are as follows:

| Task                                            | Composer                                               |
|-------------------------------------------------|--------------------------------------------------------|
| Latest version of a contributed project         | ```composer require drupal/PROJECT_NAME:8.*```         |
| Specific version of a contributed project       | ```composer require drupal/PROJECT_NAME:8.1.0-beta5``` |
| Updating all projects including Drupal Core     | ```composer update```                                  |
| Updating a single contributed project           | ```composer update drupal/PROJECT_NAME```              |
| Updating Drupal Core exclusively                | ```composer update drupal/core```                      |


[ci]:                   http://github.com/open-data/site-open-data/commits/8.x
[ci-badge]:             http://github.com/open-data/site-open-data/badges/8.x/build.svg
[composer]:             https://getcomposer.org
[node]:                 https://nodejs.org
