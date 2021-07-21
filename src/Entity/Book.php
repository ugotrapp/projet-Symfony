<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $publishing_year;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_pages;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $isbn_code;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Type::class, inversedBy="books")
     */
    private $types;

    /**
     * @ORM\OneToMany(targetEntity=Loan::class, mappedBy="book")
     */
    private $loans;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->loans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishingYear(): ?int
    {
        return $this->publishing_year;
    }

    public function setPublishingYear(?int $publishing_year): self
    {
        $this->publishing_year = $publishing_year;

        return $this;
    }

    public function getNumberOfPages(): ?int
    {
        return $this->number_of_pages;
    }

    public function setNumberOfPages(int $number_of_pages): self
    {
        $this->number_of_pages = $number_of_pages;

        return $this;
    }

    public function getIsbnCode(): ?string
    {
        return $this->isbn_code;
    }

    public function setIsbnCode(?string $isbn_code): self
    {
        $this->isbn_code = $isbn_code;

        return $this;
    }

    public function getAuthor(): ?author
    {
        return $this->author;
    }

    public function setAuthor(?author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        $this->types->removeElement($type);

        return $this;
    }

    /**
     * @return Collection|Loan[]
     */
    public function getLoans(): Collection
    {
        return $this->loans;
    }

    public function addLoan(Loan $loan): self
    {
        if (!$this->loans->contains($loan)) {
            $this->loans[] = $loan;
            $loan->setBook($this);
        }

        return $this;
    }

    public function removeLoan(Loan $loan): self
    {
        if ($this->loans->removeElement($loan)) {
            // set the owning side to null (unless already changed)
            if ($loan->getBook() === $this) {
                $loan->setBook(null);
            }
        }

        return $this;
    }
    public function isAvailable(): bool
    {
        foreach($this->getLoans() as $loan){
            if ($loan->getReturnDate() == null){
                return false;
            }
        }
        return true;
    }

    
}
