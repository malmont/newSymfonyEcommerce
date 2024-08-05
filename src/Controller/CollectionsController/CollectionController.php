<?php

namespace App\Controller\CollectionsController;

use App\Entity\Collections;
use App\Entity\User; // Import de la classe User
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CollectionController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/api/createcollections', name: 'create_collection', methods: ['POST'])]
    public function createCollection(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Utilisez dd() pour arrêter l'exécution et afficher les données
        // dd($data);

        // Récupérer l'utilisateur connecté
        $currentUser = $this->security->getUser();
           
        if (!$currentUser) {
            return $this->json(['error' => 'Unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer l'utilisateur par ID
        if (!isset($data['userId']) || $data['userId'] !== $currentUser->getId()) {
            return $this->json(['error' => 'You can only create collections for yourself'], Response::HTTP_FORBIDDEN);
        }

        $user = $this->entityManager->getRepository(User::class)->find($data['userId']);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        // dd($user);
        $collection = new Collections();
        $collection->setBudgetCollection($data['budgetCollection']);
        $collection->setStartDateCollection(new \DateTime($data['startDateCollection']));
        $collection->setEndDateCollection(new \DateTime($data['endDateCollection']));
        $collection->setDel($data['del']);
        $collection->setNomCollection($data['nomCollection']);
        $collection->setPhotoCollection($data['photoCollection']);
        $collection->setUserCollections($user);

        $this->entityManager->persist($collection);
        $this->entityManager->flush();

        return $this->json($collection, Response::HTTP_CREATED, [], ['groups' => 'collection:read']);
    }
}
