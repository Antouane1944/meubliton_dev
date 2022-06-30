<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $vendeur;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $ville;

    #[ORM\Column(type: 'json', nullable: true)]
    private $images_ = [];

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'annonces')]
    private $tag1;

    public function __construct()
    {
        $this->tag1 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getImages_(): ?array
    {
        return $this->images_;
    }

    public function setImages_(?array $images_): self
    {
        $this->images_ = $images_;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTag1(): Collection
    {
        return $this->tag1;
    }

    public function addTag1(Tag $tag1): self
    {
        if (!$this->tag1->contains($tag1)) {
            $this->tag1[] = $tag1;
        }

        return $this;
    }

    public function removeTag1(Tag $tag1): self
    {
        $this->tag1->removeElement($tag1);

        return $this;
    }
}
