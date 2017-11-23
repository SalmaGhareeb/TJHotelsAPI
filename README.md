# TajawalHotels

A REST API application to allow search in hotels inventory by any of the following:
- Hotel Name
- Destination [City]
- Price range [ex: $100:$200]
- Date range [ex: 10-10-2020:15-10-2020]

and allow sorting by:

- Hotel Name 
- Price

### Installing

- Run `composer install` to install the dependencies.
- Run `bin/console server:run`

## Brief
- `Hotel` an object contains (name,city,price,availability)
- `HotelDataMapper` for de-serializing the Json data to an object(ArrayCollection) of hotels.
- `HotelService` is a service which is responsible of filtering/matching the search query (name, price range, availabilities) 
and sorting by name/price,

### API Sandbox

![ScreenShot](/web/api-sandbox.png)

## Running the tests

- Run `./vendor/bin/phpunit tests/AppBundle/Controller/API/HotelControllerTest.php`

- Run `./vendor/bin/phpunit tests/AppBundle/Service//HotelServiceTest.php`

## Built With

* [PHP7.1](http://php.net)
* [Symfony3](http://www.symfony.com) 
* [jms/serializer](https://jmsyst.com/libs/serializer) - Library for (de-)serializing data of any complexity; supports XML, JSON
