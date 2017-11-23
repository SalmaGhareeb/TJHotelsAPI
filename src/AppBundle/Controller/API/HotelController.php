<?php

namespace AppBundle\Controller\API;

use AppBundle\Form\HotelFormType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HotelController
 * @package AppBundle\Controller\API
 * @Rest\Route("/api")
 */
class HotelController extends FOSRestController
{
    /**
     * @param Request $request
     * @Rest\View()
     * @Rest\Get("/hotels")
     *
     *
     * @ApiDoc(
     *   resource = false,
     *   section = "Hotel",
     *   description = "Search",
     *   statusCodes={
     *       200="Returned when successful",
     *       500="Returned when something went wrong",
     *       400 = "Bad Request"
     *   },
     * )
     *
     * @Rest\QueryParam(name="name", requirements="[a-z]+", description="Hotel Name.")
     * @Rest\QueryParam(name="city", requirements="[a-z]+", description="Hotel City\Location.")
     *
     * @Rest\QueryParam(name="minPrice", requirements="\d+", default=null, description="Minimum Prices")
     * @Rest\QueryParam(name="maxPrice", requirements="\d+", default=null, description="Maximum Prices")
     *
     * @Rest\QueryParam(name="orderBy", requirements="name|price", nullable=true, description="Sort
     * search results by name or price.")
     *
     * @Rest\QueryParam(name="availableFrom", nullable=true, description="Date format(d-m-Y)")
     * @Rest\QueryParam(name="availableTo", nullable=true, description="Date format(d-m-Y)")
     *
     * @Rest\QueryParam(name="orderDirection", requirements="asc|desc", nullable=true, default="asc",
     *     description="Ascending (A to Z, 0 to 9), Descending (Z to A, 9 to 0)")
     *
     * @return View
     */
    public function searchAction(Request $request)
    {
        $hotelsFormHelper = $this->get('hotels_form_hepler');
        $hotels           = $this->get('hotels_data_mapper')->getHotels();
        $hotelsService    = $this->get('hotels_service');
        $hotelsService->setHotels($hotels);
        $form = $this->createForm(HotelFormType::class);
        $form->submit($request->query->all());

        if ($form->isValid()) {
            $params  = $form->getData();
            $results = $hotelsService->getSearchResults($params);

            return View::create()->setData(['hotels' => $results])->setStatusCode(Response::HTTP_OK);
        }

        $errors = $hotelsFormHelper->getFormErrors($form);

        return View::create()->setData(['errors' => $errors])->setStatusCode(Response::HTTP_BAD_REQUEST);
    }


}