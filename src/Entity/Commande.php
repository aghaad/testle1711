<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbBillet;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $PrixTotal;

    /**
     * The internal primary key.
     * @var UuidInterface
     *
     * @ORM\Column(type="uuid", unique=true)
     */
    private $NumeroCommande;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $formule;

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Billet",mappedBy="billetCommande", cascade={"persist","remove"})
    */
    private $billets;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $DateCommande;

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getformule() && date('G') >= 14 && $this->getDateCommande()->diff(new \DateTime())->d==0) {
            dump($this->getDateCommande()->diff(new \DateTime())->d==0);
            $context->buildViolation('Vous ne pouvez pas réserver un billet journée après 14h pour le jour même.')
                ->atPath('DateCommande')
                ->addViolation();
        }
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbBillet(): ?int
    {
        return $this->NbBillet;
    }

    public function setNbBillet(int $NbBillet): self
    {
        $this->NbBillet = $NbBillet;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->PrixTotal;
    }

    public function setPrixTotal(int $PrixTotal): self
    {
        $this->PrixTotal = $PrixTotal;

        return $this;
    }

    public function getNumeroCommande(): UuidInterface
    {
        return $this->NumeroCommande;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(\DateTimeInterface $DateCommande): self
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getBillets()
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setBilletCommande($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getBilletCommande() === $this) {
                $billet->setBilletCommande(null);
            }
        }

        return $this;
    }

    /**
     * Set formule
     *
     * @param string $formule
     *
     * @return Commande
     */
    public function setFormule($formule)
    {
        $this->formule = $formule;

        return $this;
    }

    /**
     * Get formule
     *
     * @return boolean
     */
    public function getformule()
    {
        return $this->formule;
    }


    public function __construct() {



        $this->billets = new ArrayCollection();
        $this->NumeroCommande=Uuid::uuid4();
    }

//    /**
//     * @return ArrayCollection
//     */
//    public function addBillet(Billet $billet)
//    {
//        $this->billets[]=$billet;
//        return $this;
//    }
//
//    /**
//     * @param ArrayCollection $billets
//     */
//    public function removeBillet(Billet $billet)
//    {
//        $this->billets->removeElement($billet);
//    }
}
