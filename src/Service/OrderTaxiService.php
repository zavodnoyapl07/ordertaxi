<?php

namespace App\Service;

use App\Entity\OrderTaxiEntity;
use Doctrine\ORM\EntityManagerInterface;

class OrderTaxiService
{
	private $entityManager;

	private $mailer;

	public function __construct(EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
	{
		$this->entityManager = $entityManager;
		$this->mailer = $mailer;
	}

	public function order(OrderTaxiEntity $order)
	{
		$this->entityManager->persist($order);
		$this->entityManager->flush();

		$this->sendMessage($order);
	}

	private function sendMessage(OrderTaxiEntity $order)
	{
		$message = (new \Swift_Message('Hello Email'))
			->setFrom('order@taxi.uk')
			->setTo('test@test.com')
			->setBody($this->getMessageTemplate($order))
		;
		$this->mailer->send($message);
	}

	private function getMessageTemplate(OrderTaxiEntity $order): string
	{
		$message = "
			Client: {$order->getClientName()}\n
			Phone Number: {$order->getPhone()}\n
			AirFlight Number: {$order->getAirflightNumber()}\n
			Airport: {$order->getAirport()->getName()}\n
		";
		if (null !== $order->getTerminal()) {
			$message .= "Terminal: {$order->getTerminal()->getName()}";
		}

		return trim($message);
	}
}