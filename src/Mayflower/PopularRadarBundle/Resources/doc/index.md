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

At first you have to update the form stuff

``` php
// src/Mayflower/PopularRadarBundle/Form/BuzzwordSearchType.php
public function buildForm(FormBuilder $builder, array $options)
{
    // ...
    ->add('use_custom_api', 'checkbox', array('required' => false, 'label' => 'Use custom api'))
}

// src/Mayflower/PopularRadarBundle/Form/DataBuzzwordFormData.php
// ...
private $useCustomApi = false;
// ...
public function setUseCustomApi($useCustomApi)
{
    $this->useCustomApi = (bool) $useCustomApi;
    return $this;
}

public function isUseCustomApi()
{
    return $this->useCustomApi;
}
```

Now you can implement the comparison strategy. This must contain the following methods:
- setHttpClient:void (sets the guzzle client in order to communicate with apis)
- supports:bool (checks if the user has enabled the comparison of this strategy)
- apply:array (executes the comparison)

The apply() method must return two Buzzword instances. This instance requires three paramters:
- $name: name of the buzzword
- $countLength: the comparison must return an integer (like *facebook likes*)
- $resultTypeName: display name of the comparison (like *Facebook Like(s)*)

The strategy class may look like this:

``` php
<?php

namespace Mayflower\PopularRadarBundle\Service\Strategy;

use Guzzle\Http\Client;
use Mayflower\PopularRadarBundle\Form\Data\BuzzwordFormData;
use Mayflower\PopularRadarBundle\Model\Buzzword;

class CustomAPIStrategy implements StrategyInterface
{
    private $client;
    
    public function setHttpClient(Client $client)
    {
        $this->client = $client;
    }
    
    public function supports(BuzzwordFormData $data)
    {
        // check if the user has selected the option in order to compare using this strategy
    }
    
    public function apply(BuzzwordFormData $data)
    {
        // compare buzzwords
    
        return array(
            new Buzzword($name, $countLength, $resultTypeName),
            new Buzzword($name, $countLength, $resultTypeName)
        );
    }
}
```

Now you need to add this strategy to the comparator service, which is pretty simple:

``` xml
<!-- src/Mayflower/PopularRadarBundle/Resources/config/services.xml -->
<?xml version="1.0" ?>
<!--- ... -->
<service id="mayflower.radar.api_strategy" class="%mayflower.radar.api_strategy.class%">
    <call method="addStrategy">
        <argument type="service">
            <service class="Mayflower\PopularRadarBundle\Service\Strategy\CustomAPIStrategy" />
        </argument>
    </call>
    
    <!-- ... -->
</service>
```
