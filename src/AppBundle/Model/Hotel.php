<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;

class Hotel
{
    /**
     * @var string
     * @Serializer\SerializedName("name")
     * @Serializer\Type(name="string")
     */
    protected $name;

    /**
     * @var float
     * @Serializer\SerializedName("price")
     * @Serializer\Type(name="float")
     */
    protected $price;

    /**
     * @var string
     * @Serializer\SerializedName("city")
     * @Serializer\Type(name="string")
     */
    protected $city;

    /**
     * @var array
     * @Serializer\SerializedName("availability")
     * @Serializer\Type(name="array")
     */
    protected $availability;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }


    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * @return array
     */
    public function getAvailability(): array
    {
        return $this->availability;
    }

    /**
     * @param array $availability
     */
    public function setAvailability(array $availability)
    {
        $this->availability = $availability;
    }

}