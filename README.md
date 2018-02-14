Drupal Composer Project for open.canada.ca
==========================================

Codebase for fresh install of Drupal 8.x for open.canada.ca.

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

[composer]:                 https://getcomposer.org
[node]:                     https://nodejs.org
