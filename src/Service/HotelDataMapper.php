<?php

namespace App\Service;


use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\SerializerBuilder;

class HotelDataMapper
{

    /**
     * @var ArrayCollection
     * @Serializer\SerializedName("hotels")
     * @Serializer\Type(name="ArrayCollection<App\Model\Hotel>")
     */
    public $hotels;


    public function __construct($hotelsAPI)
    {
        $client       = new \GuzzleHttp\Client();
        $res          = $client->request('GET', $hotelsAPI);
        $serializer   = SerializerBuilder::create()->build();
        $this->hotels = $serializer->deserialize($res->getBody(), 'App\Service\HotelDataMapper', 'json')->hotels;
    }

    /**
     * @return ArrayCollection
     */
    public function getHotels(): ArrayCollection
    {
        return $this->hotels;
    }
}