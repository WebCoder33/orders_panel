<?php

namespace App\Controller;

use App\Entity\Person\Person;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Person\PersonRepository;


class CustomApiController extends AbstractController
{

	/**
	 * @Route("/person/{id}", name="customApi_get-person")
	 */
	public function getPerson($id, PersonRepository $personRepository, SerializerInterface $serializer)
	{
		$person = $personRepository->find($id);

		return new JsonResponse($serializer->serialize($person, 'json'));
	}


	/**
	 * @Route("/setPerson", name="customApi_post-person")
	 */
	public function postPerson(Request $request, SerializerInterface $serializer)
	{

		$person = new Person();

		$form = $this->createForm(PersonType::class, $person);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$person = $form->getData();
			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($person);
			$entityManager->flush();

			var_dump($form->getErrors());

			return new JsonResponse($serializer->serialize($person, 'json'));
		}

		throw new BadRequestHttpException('400 Bad Request');
	}


}
