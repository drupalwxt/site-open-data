Composer Project for Open Data
==============================

[![build status](http://github.com/open-data/site-open-data/badges/8.x/build.svg)](http://github.com/open-data/site-open-data/commits/8.x)

Drupal WxT codebase for Open Data Platform.

## Requirements

* [Composer][composer]
* [Node][node]

## Installation

Initialize a new project with this command:

```
$ composer create-project drupalwxt/wxt-project:8.x-dev PROJECT_NAME --no-interaction
```

## Maintenance

List of common commands are as follows:

| Task                                            | Composer                                               |
|-------------------------------------------------|--------------------------------------------------------|
| Latest version of a contributed project         | ```composer require drupal/PROJECT_NAME:8.*```         |
| Specific version of a contributed project       | ```composer require drupal/PROJECT_NAME:8.1.0-beta5``` |
| Updating all projects including Drupal Core     | ```composer update```                                  |
| Updating a single contributed project           | ```composer update drupal/PROJECT_NAME```              |
| Updating Drupal Core exclusively                | ```composer update drupal/core```                      |

## Docker Machine

Configure Docker on VirtualBox with support for proxy bypass. (Docker only)

The use of $HTTP_PROXY in this context implies the Host OS has the export.

```sh
  docker-machine create -d virtualbox \
  --engine-env HTTP_PROXY=$HTTP_PROXY \
  --engine-env HTTPS_PROXY=$HTTP_PROXY \
  --engine-env http_proxy=$HTTP_PROXY \
  --engine-env https_proxy=$HTTP_PROXY \
  --engine-storage-driver overlay \
  --virtualbox-cpu-count "4" \
  --virtualbox-memory "12288" \
  site-open-data
```

```sh
  docker-machine-nfs site-open-data
```

Create the following in: `/var/lib/boot2docker/bootlocal.sh`

```sh
  #!/bin/sh
  echo "export HTTP_PROXY=$HTTP_PROXY" >> /home/docker/.ashrc
  echo "export HTTPS_PROXY=$HTTP_PROXY" >> /home/docker/.ashrc
  echo "export http_proxy=$HTTP_PROXY" >> /home/docker/.ashrc
  echo "export https_proxy=$HTTP_PROXY" >> /home/docker/.ashrc
```

<!-- Links Referenced -->

[composer]:               https://getcomposer.org
[node]:                   https://nodejs.org
