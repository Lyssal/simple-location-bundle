# The Lyssal simple location bundle

The simple location bundle permits create dynamic typed locations.

## Installation

```shell
composer require lyssal/simple-location-bundle
```

## Usage

### Create your Location entity

```php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lyssal\SimpleLocationBundle\Entity\Location as LyssalLocation;

/**
 * @ORM\Entity()
 */
class Location extends LyssalLocation
{
    // If you want to add properties
}
```


### Exemples of use

```php
$continent = (new LocationType())->setName('Continent');
$country = (new LocationType())->setName('Country')->addParent($continent);
$city = (new LocationType())->setName('City')->addParent($country);

$europa = (new Location())->setName('Europe')->setType($continent);
$america = (new Location())->setName('America')->setType($continent);
$asia = (new Location())->setName('Asia')->setType($continent);

$france = (new Location())->setName('France')->setType($country)->addParent($europa);
$italy = (new Location())->setName('Italy')->setType($country)->addParent($europa);
$sovietUnion = (new Location())->setName('Soviet Union')->setType($country)->addParent($europa)->addParent($asia);

$paris = (new Location())->setName('Paris')->setType($city)->addParent($france);

$countrySet = (new LocationType())->setName('Country set')->addChild($country);

$northAmerica = (new Location())->setName('North America')->setType($countrySet)->addParent($america);
$usa = (new Location())->setName('United States of America')->setType($country)->addParent($america)->addParent($northAmerica);

$europeanUnion = (new Location())->setName('European Union')->setType($countrySet)->addParent($europa)->addChild($france)->addChild($italy);

$germany = (new Location())->setName('Germany')->setType($country)->addParent($europa)->addParent($europeanUnion);
$westGermany = (new Location())->setName('Federal Republic of Germany')->setType($country)->addParent($germany)->addParent($europa)->addParent($europeanUnion);
$eastGermany = (new Location())->setName('German Democratic Republic')->setType($country)->addParent($sovietUnion)->addParent($germany)->addParent($europa);
```
