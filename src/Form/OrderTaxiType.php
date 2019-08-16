<?php

namespace App\Form;

use App\Entity\AirportEntity;
use App\Entity\OrderTaxiEntity;
use App\Entity\TerminalEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class OrderTaxiType  extends AbstractType
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('clientName', TextType::class, [
				'constraints' => [new NotBlank(), new Length(['min' => 2, 'max' => 100])],
			])
			->add('airport', EntityType::class, [
				'class' => AirportEntity::class,
				'choice_label' => false,
				'constraints' => new NotBlank(),
			])
			->add('phone', TextType::class, [
				'constraints' => [new NotBlank(), new Regex(['pattern' => '#^(07\d{8,12}|447\d{7,11})$#'])],
			])
			->add('airflightNumber', TextType::class, [
				'constraints' =>  [new NotBlank(), new Regex(['pattern' => '#^[a-z\d]{2}[a-z]?\d{1,4}[a-z]?$#i'])]
			])
		;

		$builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
			$orderData = $event->getData();
			$form = $event->getForm();
			if (empty($orderData['airport'])) {
				return;
			}
			$airportRef = $this->entityManager->getReference(AirportEntity::class, (int)$orderData['airport']);
			$hasTerminals = $this->entityManager->getRepository(TerminalEntity::class)->findOneBy(['airport' => $airportRef]);
			if ($hasTerminals) {
				$form->add('terminal', EntityType::class, [
					'class' => TerminalEntity::class,
					'choice_label' => false,
					'query_builder' => function (EntityRepository $er) use ($airportRef) {
						return $er->createQueryBuilder('terminal')
							->where('terminal.airport = :airport')
							->setParameter('airport', $airportRef);
					},
					'constraints' => new NotBlank(),
				]);
			}
		});
	}


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => OrderTaxiEntity::class,
			'allow_extra_fields' => true,
		]);
	}
}