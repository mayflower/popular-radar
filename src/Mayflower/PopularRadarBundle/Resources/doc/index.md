Popular Radar
=============

This bundle is the application bundle of the Mayflower Popular Radar.

1) Table of contents
--------------------

- About
- Installation
- How to write a custom radar strategy


2) About
--------

This application is a MVP only. You can send two buzzwords and select the APIs where to compare them using some 
defined criteria. The result will be displayed after that.

The current APIs in use:
- GitHub Forks
- Stackoverflow questions


3) Installation
--------------

The installation is pretty simple. There's no database required and the APIs doesn't need to be configured.

Installation script

    git clone -b master git@github.com:Mayflower/popular-radar /path/to/webroot
    composer install


4) How to write a custom radar strategy
---------------------------------------

In order to provide many APIs without changing the whole code, the strategy pattern is used:

You just have too implement your custom api strategy:


``` php
namespace Mayflower\PopularRadarBundle\Model\APIVoter;

use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Comparison\Strategy\StrategyInterface;
use Mayflower\PopularRadarBundle\Model\ResultMapping\Buzzword;

class ExampleStrategy extends AbstractVoter implements StrategyInterface
{
    public function supports(BuzzwordFormData $data)
    {
        return in_array($this->getDisplayAlias(), $data->getStrategies());
    }
    
    public function apply(BuzzwordFormData $data)
    {
        // fetch data from foreign api
        
        return array(
            new Buzzword(/* args */),
            new Buzzword(/* args */)
        );
    }
    
    public function getDisplayAlias()
    {
        return 'Example';
    }
}
```

If you have a custom voter, you can use the *Mayflower\PopularRadarBundle\Model\APIVoter\AbstractGitHubVoter* which 
provides a *findRepository()* method in order to search for git repositories hosted on github.

Now you just need to register the strategy

``` yaml
# config/voters.yml
services:
    mayflower.popular_radar.voter.example:
        class: Mayflower\PopularRadarBundle\Model\APIVoter\ExampleStrategy
        tags:
            - { name: radar.voter }
```
