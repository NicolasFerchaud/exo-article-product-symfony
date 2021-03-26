<?php


namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous avez oublié de saisir un titre")
     */
    private $title;

    /* Pour pouvoir récupérer les articles depuis les catégories, je dois ajouter
     la relation inverse au ManyToOne déclaré dans l'entité Article.php, donc un OneToMany et je le relie
     avec l'entité Article.

     Je précise aussi, dans l'entité quelle propriété fait l'inverse du OneToMany (donc le ManyToOne),
     soit la propriété Category.*/
    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category")
     */
    private $articles;

    /*
    Le OneToMany veut dire que j'ai potentiellement plusieurs articles, donc
    il faut que la propriété qui stock les articles, soit un tableau ici unArrayCollection
    (class native de doctrine)
     */
    public function __construct()
    {
        $this->articles = new arrayCollection();
    }

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous avez oublié de saisir une description")
     * @Assert\Length(
     *    min = 2,
     *    max = 50,
     *    minMessage = "La description doit faire minilmum {{ limit }} characters de long",
     *    maxMessage = "La description de peut pas dépassée {{ limit }} characters"
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Vous avez oublié de saisir une date")
     * @Assert\Type(type="\DateTimeInterface", message="Veuillez saisir une date valide")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param mixed $published
     * @return Category
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /*enlever le ArrayCollection générer automatiquement dans @param et dans la function setArticles*/
    /**
     * @param ArrayCollection $articles
     * @return Category
     */
    public function setArticles($articles): Category
    {
        $this->articles = $articles;
        return $this;
    }



}