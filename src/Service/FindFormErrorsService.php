<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;

class FindFormErrorsService
{
	public function getErrors(FormInterface $form): array
	{
		if ($form->isValid()) {
			return [];
		}

		return ['form' => $this->getGlobalErrors($form), 'fields' => $this->getFieldErrors($form)];
	}

	private function getGlobalErrors(FormInterface $form): array
	{
		$errors = [];
		foreach ($form->getErrors() as $error) {
			$errors[$form->getName()][] = $error->getMessage();
		}

		return $errors;
	}

	private function getFieldErrors(FormInterface $form): array
	{
		$errors = [];
		foreach ($form as $child) {
			if ($child->isValid()) {
				continue;
			}
			foreach ($child->getErrors() as $error) {
				$errors[$child->getName()][] = $error->getMessage();
			}
		}

		return $errors;
	}
}