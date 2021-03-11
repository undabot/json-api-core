# json-api core

[![pipeline status](https://gitlab.com/undabot/json-api-core/badges/master/pipeline.svg)](https://gitlab.com/undabot/json-api-core/commits/master)
[![coverage report](https://gitlab.com/undabot/json-api-core/badges/master/coverage.svg)](https://gitlab.com/undabot/json-api-core/commits/master)

```
"repositories": [
    {
      "type": "vcs",
      "url": "git@gitlab.com:undabot/json-api-core.git"
    }
  ],
```

# Scripts
- PHPUnit tests: `composer test`
- PhpStan: `composer qc`
- PhpCsFixer: `composer lint`

# Development

There is a custom docker image that can be used for development.
This docker container should be used to run tests and check for any compatibility issues.

This repo is mounted inside of the container and any changes made to the files are automatically propagated into the container.
There isnt any syncing, the filesystem is pointed to the 2 locations at the same time.

A script called dev.sh can be used to manage the image. Here are the avaliable commands:

- ./dev.sh build

      used to build base dev docker image, and to install composer and dependencies at first run
- ./dev.sh run

      starts the dev container
- ./dev.sh stop

      stops the dev container
- ./dev.sh ssh

      attaches the container shell to the terminal so that you can execute commands inside of the container
- ./dev.sh test

      run php unit tests inside of the running container
- ./dev.sh qc

      executes qc tests

- ./dev.sh install
      executes composer install --optimize-autoloader
