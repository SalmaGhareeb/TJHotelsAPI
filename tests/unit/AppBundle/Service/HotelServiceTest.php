<?php

namespace Tests\AppBundle\Service;


use AppBundle\Model\Hotel;
use AppBundle\Service\HotelService;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class HotelServiceTest extends WebTestCase
{
    /**
     * @var HotelService
     */
    private $hotelService;

    protected function setUp()
    {
        $hotels = $this->getMockHotelDataForTesting();

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($hotels);

    }

    /**
     * @return ArrayCollection
     */
    private function getMockHotelDataForTesting(): ArrayCollection
    {
        $hotels = new ArrayCollection();

        $hotel1 = new Hotel();
        $hotel1->setCity('cairo');
        $hotel1->setName('Concorde Moreen beach');
        $hotel1->setPrice(120.2);
        $hotel1->setAvailability(
            [
                [
                    "from" => "10-10-2020",
                    "to"   => "15-10-2020",
                ],
                [
                    "from" => "25-10-2020",
                    "to"   => "15-11-2020",
                ],
            ]
        );
        $hotels->add($hotel1);

        $hotel2 = new Hotel();
        $hotel2->setCity('dubai');
        $hotel2->setName('Holiday In Hotel');
        $hotel2->setPrice(140.9);
        $hotel2->setAvailability(
            [
                [
                    "from" => "10-10-2020",
                    "to"   => "12-10-2020",
                ],
                [
                    "from" => "25-10-2020",
                    "to"   => "10-11-2020",
                ],
            ]
        );
        $hotels->add($hotel2);


        $hotel3 = new Hotel();
        $hotel3->setCity('tanzania');
        $hotel3->setName('Hilton Hotel');
        $hotel3->setPrice(90);
        $hotel3->setAvailability(
            [
                [
                    "from" => "01-10-2020",
                    "to"   => "12-10-2020",
                ],
                [
                    "from" => "05-10-2020",
                    "to"   => "10-11-2020",
                ],
            ]
        );
        $hotels->add($hotel3);

        $hotel3 = new Hotel();
        $hotel3->setCity('cape town');
        $hotel3->setName('Marriott Hotel');
        $hotel3->setPrice(80);
        $hotel3->setAvailability(
            [
                [
                    "from" => "04-10-2020",
                    "to"   => "17-10-2020",
                ],
                [
                    "from" => "16-10-2020",
                    "to"   => "11-11-2020",
                ],
            ]
        );
        $hotels->add($hotel3);

        return $hotels;
    }


    public function testSearchByValidCity()
    {
        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            ['city' => 'cairo'],
            false
        );


        $this->assertEquals(1, $hotels->count());
        $hotel = $hotels->first();
        $this->assertEquals('cairo', $hotel->getCity());
    }

    public function testSearchByInValidCity()
    {

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            ['city' => 'xcairo'],
            false
        );

        $this->assertEquals(0, $hotels->count());
    }

    public function testSearchByValidName()
    {

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            ['name' => 'Hilton Hotel'],
            false
        );

        $this->assertEquals(1, $hotels->count());
        $hotel = $hotels->first();
        $this->assertEquals('Hilton Hotel', $hotel->getName());
    }

    public function testSearchByInValidName()
    {

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            ['name' => 'abcd'],
            false
        );

        $this->assertEquals(0, $hotels->count());
    }

    public function testSearchByValidPriceRange()
    {

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            [
                'minPrice' => 70,
                'maxPrice' => 100,
                'orderBy'  => 'price',
            ],
            false
        );
        /** @var Hotel $minHotel */
        $minHotel = $hotels->first();
        $this->assertGreaterThanOrEqual(70, $minHotel->getPrice());
        /** @var Hotel $maxHotel */
        $maxHotel = $hotels->last();
        $this->assertLessThanOrEqual(100, $maxHotel->getPrice());
    }


    public function testSearchByInValidPriceRange()
    {
        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            [
                'minPrice' => 5,
                'maxPrice' => 10,
                'orderBy'  => 'price',
            ],
            false
        );

        $this->assertEquals(0, $hotels->count());
    }


    public function testDefaultOrderByNameASC()
    {
        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            ['orderBy' => 'name'],
            false
        );

        $firstHotel = $hotels->first();
        $this->assertEquals('Concorde Moreen beach', $firstHotel->getName());
        $lastHotel = $hotels->last();
        $this->assertEquals('Marriott Hotel', $lastHotel->getName());
    }


    public function testSearchByDateRange()
    {

        $this->hotelService = $this->createMock(HotelService::class);
        $this->hotelService->expects($this->once())->method('setHotels')->with($this->getMockHotelDataForTesting());
        $hotels = $this->hotelService->getSearchResults(
            [
                'availableFrom' => '04-10-2020',
                'availableTo'   => '30-10-2020',
            ],
            false
        );

        $this->assertEquals(2, $hotels->count());
    }

}