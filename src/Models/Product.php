<?php declare(strict_types=1);

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use App\Contracts\Models\ModelInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product implements ModelInterface
{
    public function __construct(array $properties = [])
    {
        foreach($properties as $key => $value) {
            $this->{$key} = $value;
        }
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="decimal", precision=15, scale=4, options={"default" : 0})
     */
    protected $price;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="ProductRating", mappedBy="product")
     */
    private $ratings;

    protected $review_count;
    protected $average_rate;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getReviewCount()
    {
        return $this->review_count;
    }

    public function getAverageRate()
    {
        if($this->average_rate == 0) return 5;

        return $this->average_rate;
    }
}