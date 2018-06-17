# Get involved

If you want to contribute code (features or bugfixes), you have to create a pull request.


# Pull Requests

When creating a pull requests you should mention:

 * *Why* you are changing it
 * *What* you are changing
 * If this will *break* something

Pull request should be English (title, description and code comments, if applicable).

When coding and committing, please:

 * Write your commit messages in English
 * Have them short and descriptive
 * Don't fix things which are related to other issues / pull requests
 * Provide a test
 * Follow the coding standards


# Coding standards
All contributions should follow the [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) and [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) coding
standards.


# Start hacking

To start contributing, just fork the repository and clone your fork to your local machine:

    git clone git@github.com:[YOUR USERNAME]/symfony4.git

After having done this, configure the upstream remote:

    cd symfony4
    git remote add upstream git://github.com/football-betting/symfony4.git
    git config branch.master.remote upstream

To keep your master up to date:

    git checkout master
    git pull --rebase
    php composer.phar self-update
    php composer.phar install
    php bin/console doctrine:migrations:migrate

Checkout a new topic-branch and you're ready to start hacking and contributing to Shopware:

    git checkout -b feature/your-cool-feature

If you're done hacking, filling bugs or building fancy new features, push your changes to your forked repo:

    git push origin feature/your-cool-feature


... and send us a pull request with your changes. We'll verify the pull request and merge it with the main branch.

# Running Tests

## Database
For most tests a configured database connection is required.
    
    DB_USER: docker
    DB_PASS: docker
    
You can change DB-Config in: 
    
    phpunit.xml.dist -> <env name="DATABASE_URL_TEST" value="mysql://docker:docker@127.0.0.1:3306/symfony_football_test" />
    .env -> DATABASE_URL_TEST=mysql://docker:docker@127.0.0.1:3306/symfony_football_test

## Running the tests
The tests are located in the `tests/` directory
You can run the entire test suite with the following command:

    php bin/console doctrine:database:create --env=test --no-interaction
    php bin/console doctrine:migrations:migrate --env=test --no-interaction
    php bin/phpunit --coverage-clover=clover.xml

If you want to test a single component, add its path after the phpunit command, e.g.:

    php bin/phpunit tests/pathToFolder
