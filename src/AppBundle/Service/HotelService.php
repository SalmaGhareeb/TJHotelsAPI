<?php

namespace AppBundle\Service;


use AppBundle\Model\Hotel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class HotelService
 * @package AppBundle\Service
 */
class HotelService
{
    public static $SORT_BY = ['name', 'price'];

    /**
     * @var ArrayCollection
     */
    public $hotels;

    /**
     * @var Criteria
     */
    private $criteria;

    /**
     * HotelService constructor.
     */
    public function __construct()
    {
        $this->criteria = Criteria::create();
    }

    /**
     * @param array $searchParams
     * @param bool $rawData
     *
     * @return array|\Doctrine\Common\Collections\Collection|static
     */
    public function getSearchResults(array $searchParams, $rawData = true)
    {
        if (isset($searchParams['availableFrom']) && isset($searchParams['availableTo'])) {
            $this->searchHotelsByAvailability($searchParams['availableFrom'], $searchParams['availableTo']);
        }

        if (isset($searchParams['name'])) {
            $this->searchHotelsByName($searchParams['name']);
        }

        if (isset($searchParams['city'])) {
            $this->searchHotelsByCity(strtolower($searchParams['city']));
        }

        if (isset($searchParams['minPrice']) && isset($searchParams['maxPrice'])) {
            $this->searchHotelsByPriceRange($searchParams['minPrice'], $searchParams['maxPrice']);
        }

        if (isset($searchParams['orderBy']) && in_array($searchParams['orderBy'], self::$SORT_BY)) {
            $orderDirection = isset($searchParams['orderDirection']) ? $searchParams['orderDirection'] : Criteria::ASC;
            $this->criteria->orderBy(array($searchParams['orderBy'] => $orderDirection));
        }

        $hotels = $this->hotels->matching($this->criteria);

        return $rawData ? array_values($hotels->toArray()) : $hotels;
    }

    /**
     * @return ArrayCollection
     */
    public function getHotels(): ArrayCollection
    {
        return $this->hotels;
    }

    /**
     * @param ArrayCollection $hotels
     */
    public function setHotels(ArrayCollection $hotels)
    {
        $this->hotels = $hotels;
    }

    /**
     * @param $city
     */
    private function searchHotelsByCity(string $city)
    {
        $this->criteria->andWhere(Criteria::expr()->eq('city', $city));
    }

    /**
     * @param string $name
     */
    private function searchHotelsByName(string $name)
    {
        $this->criteria
            ->andWhere(Criteria::expr()->eq('name', $name));
    }

    /**
     * @param $start
     * @param $end
     */
    private function searchHotelsByPriceRange(float $start, float $end)
    {
        $this->criteria
            ->andWhere(Criteria::expr()->gte('price', $start))
            ->andWhere(Criteria::expr()->lte('price', $end));
    }

    /**
     * @param $from
     * @param $to
     */
    private function searchHotelsByAvailability($from, $to)
    {
        $availableHotels = $this->hotels->filter(
            function (Hotel $hotel) use ($from, $to) {
                $availabilities = $hotel->getAvailability();
                $from           = strtotime($from);
                $to             = strtotime($to);

                foreach ($availabilities as $availability) {
                    $availableFrom = strtotime($availability['from']);
                    $availableTo   = strtotime($availability['to']);
                    if ($from >= $availableFrom
                        && $to >= $availableTo
                        && $from <= $availableTo
                        && $to >= $availableFrom
                    ) {
                        return $hotel;
                    }
                }

                return null;
            }
        );

        $this->hotels = $availableHotels;
    }
}