<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Commande;
use App\Entity\Billet;
use App\Form\CommandeType;
use App\Form\BilletType;
use App\Services\Tarif;
use App\Services\Mailer;


class HomeController extends Controller
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request, ObjectManager $manager, Tarif $tarif)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tarif->definePrice($commande);

            $manager->persist($commande);
            $manager->flush();
            return $this->render('form/recap.html.twig', [
                'title' => 'Billetterie',
                'commande' => $commande
            ]);
        }


        return $this->render('form/index.html.twig', [
            'title' => 'Billetterie',
            'commande' => $commande,
            'formCommande' => $form->createView()
        ]);
    }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('form/home.html.twig', [
            'title' => "Billetterie du Louvre",
        ]);
    }

    /**
     * @Route("/recap/{id}", name="recap")
     */
    public function recap($id)
    {
        $commande = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->find($id);

        if (!$commande) {
            throw $this->createNotFoundException(
                'Pas de commande trouvée pour id= ' . $id
            );
        }
        return $this->render('form/recap.html.twig', [
            'commande' => $commande,
            'title' => "Billetterie",
        ]);
    }

    /**
     * @Route("/infos", name="infos")
     */
    public function infos()
    {
        return $this->render('form/infos.html.twig');
    }

        /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('form/contact.html.twig');
    }

    /**
     * @Route("/success/{id}", name="success")
     */
    public function success(Commande $commande, Mailer $mailer)
    {
        $mailer->sendOrderSuccess($commande, $this->renderView('Mails/commande_ok.html.twig', [
            'Commande' => $commande,
        ]));
        return $this->render('form/success.html.twig', [
            'title' => 'Commande confirmée',
        ]);
    }


    /**
     * @Route("/limitCommande/{date}", name="limite_Commande")
     */
    public function limitCommande(Request $request, $date)
    {
        $newDate = new \DateTime($date);
        $commande = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findBy(
                ['DateCommande' => $newDate]
            );

        return new JsonResponse(['quantity' => sizeof($commande)]);

    }
}
