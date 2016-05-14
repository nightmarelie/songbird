# Chapter 5: The Testing Framework Part 2

Since we are ready to build our application, we no longer need the route app/example. As good housekeeping, we are going to remove it and make sure that we have done that correctly.

## Objectives

> * Modifying the DefaultController.php

> * Making sure the / route is removed

> * Creating custom bash script to run acceptance test

## Pre-setup

Make sure you are in my_chapter5 branch.

```
-> git branch
## if not done
git checkout -b my_chapter5
```

## Modifying DefaultController.php

Previously, we could access the route "/" because the route exists in DefaultController.php. Removing index function of DefaultController will remove the route.

```
#  src/AppBundle/Controller/DefaultController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

}
```

Now, refresh http://songbird.dev/app_dev.php and you should see a 404 error.

```
No route found for "GET /"
```

This is correct because the url is no longer configured. How can you be sure? Let us check it out from the command line

```
-> app/console debug:router

[router] Current routes
 Name                     Method Scheme Host Path
 _wdt                     ANY    ANY    ANY  /_wdt/{token}
 _profiler_home           ANY    ANY    ANY  /_profiler/
 _profiler_search         ANY    ANY    ANY  /_profiler/search
 _profiler_search_bar     ANY    ANY    ANY  /_profiler/search_bar
 _profiler_purge          ANY    ANY    ANY  /_profiler/purge
 _profiler_info           ANY    ANY    ANY  /_profiler/info/{about}
 _profiler_phpinfo        ANY    ANY    ANY  /_profiler/phpinfo
 _profiler_search_results ANY    ANY    ANY  /_profiler/{token}/search/results
 _profiler                ANY    ANY    ANY  /_profiler/{token}
 _profiler_router         ANY    ANY    ANY  /_profiler/{token}/router
 _profiler_exception      ANY    ANY    ANY  /_profiler/{token}/exception
 _profiler_exception_css  ANY    ANY    ANY  /_profiler/{token}/exception.css
 _configurator_home       ANY    ANY    ANY  /_configurator/
 _configurator_step       ANY    ANY    ANY  /_configurator/step/{index}
 _configurator_final      ANY    ANY    ANY  /_configurator/final
 _twig_error_test         ANY    ANY    ANY  /_error/{code}.{_format}
```

Looks like there is no trace of the / path. This is all good but to do a proper job, we have to make sure that this logic is remembered in the future. We need to record this logic in a test.

## Making sure the / route is removed

To make sure that / route is correctly removed and not accidentally added again in the future, let us write a test for it.


```
# tests/acceptance/AppBundleCest.php
...
// replace InstallationTest by RemovalTest
public function RemovalTest(AcceptanceTester $I)
{
    $I->wantTo('Check if / is not active.');
    $I->amOnPage('/');
    $I->see('404 Not Found');
}
```

and run the test again,

```
-> app/console cache:clear --env=prod
# remember to start selenium server
-> bin/codecept run acceptance
...
Time: 1.66 seconds, Memory: 12.50Mb

OK (1 test, 1 assertion)
```

## Creating custom bash script to run acceptance test

We have to remember to clear the cache everytime we run the test so that we don't test on the cached version. Let us automate this by creating a script in ~/songbird/www/songbird/scripts called "runtest" and make it executable.

```
-> touch scripts/runtest
-> chmod u+x scripts/runtest
```

We have to also remember to start selenium server before we run the test. To make our live easy, let us create a script to automate starting selenium

```
-> touch scripts/start_selenium
-> chmod u+x start_selenium
```

in start_selenium,

```
# scripts/start_selenium

#!/bin/bash

# choose a firefox profile so we get more consistent result
java -jar scripts/selenium-server-standalone-2.53.0.jar -Dwebdriver.firefox.profile=default
```

and a new script called runtest

```
-> touch scripts/runtest
-> chmod u+x runtest
```

```
# scripts/runtest

#!/bin/bash

app/console cache:clear --no-warmup
bin/codecept run acceptance
```

Now test your automation by running

```
# open a new terminal
-> scripts/start_selenium

# back in your own terminal
-> scripts/runtest
...
OK (1 test, 1 assertion)
```

We are almost done. Remember to commit all your changes before moving on to the next chapter.

## Summary

In this chapter, we have removed the default / route and updated our test criteria. We have also created a few bash scripts to automate the task of running codecept test. We will add more to this scripts in the future.

## Exercises (Optional)

* Try running selenium in [docker](https://github.com/Codeception/SeleniumEnv). What are the pros and cons of doing that?

## Stuck? Checkout my code

```
-> git checkout -b chapter_5 origin/chapter_5
-> git clean -fd
```

## References

* [TDD](https://en.wikipedia.org/wiki/Test-driven_development)

* [BDD](https://en.wikipedia.org/wiki/Behavior-driven_development)

* [PhantomJS](http://phantomjs.org/download.html)

* [Codeception documentation](http://codeception.com/docs)

## Summary

Next Chapter: [Chapter 6: The User Management System Part 1](https://github.com/bernardpeh/songbird/tree/chapter_6)

Previous Chapter: [Chapter 4: The Testing Framework Part 1](https://github.com/bernardpeh/songbird/tree/chapter_4)

