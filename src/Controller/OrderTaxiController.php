<?php

namespace App\Controller;

use App\Entity\AirportEntity;
use App\Entity\OrderTaxiEntity;
use App\Form\OrderTaxiType;
use App\Service\FindFormErrorsService;
use App\Service\OrderTaxiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class OrderTaxiController extends AbstractController
{
	public function indexAction()
	{
		return $this->render('base.html.twig', []);
	}


	public function getAirportsAction(SerializerInterface $serializer)
	{
		$airports = $this->getDoctrine()
			->getRepository(AirportEntity::class)
			->findAll()
		;
		$json = $serializer->serialize(
			$airports,
			'json',
			['ignored_attributes' => ['airport']]
		);

		return JsonResponse::fromJsonString($json);
	}

	public function sendFormAction(Request $request, FindFormErrorsService $formErrorsService, OrderTaxiService $orderTaxiService)
	{
		$data = $this->get('serializer')->decode($request->getContent(), 'json');
		$form = $this->createForm(OrderTaxiType::class, new OrderTaxiEntity());
		$form->submit($data);

		if (!$form->isValid()) {
			return new JsonResponse([
				'success' => false,
				'errors' => $formErrorsService->getErrors($form)
			]);
		}

		$order = $form->getData();

		try {
			$orderTaxiService->order($order);
		} catch (\Exception $e) {
			return new JsonResponse([
				'success' => false,
				'errors' =>[$e->getMessage()]
			]);
		}

		return new JsonResponse([
			'success' => true,
			'data' =>['id' => $order->getId()]
		]);
	}
}