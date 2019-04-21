<?php declare(strict_types=1);

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use App\Contracts\Models\ModelInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order implements ModelInterface
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
     * @ORM\Column(type="decimal", precision=15, scale=4, options={"default" : 0})
     */
    protected $sub_total;
    /**
     * @ORM\Column(type="decimal", precision=15, scale=4, options={"default" : 0})
     */
    protected $shipping_fee;
    /**
     * @ORM\Column(type="decimal", precision=15, scale=4, options={"default" : 0})
     */
    protected $total_paid;
    /**
     * @ORM\Column(type="decimal", precision=15, scale=4, options={"default" : 0})
     */
    protected $previous_balance;
    /**
     * @ORM\Column(type="string")
     */
    protected $shipping_type;
    /**
     * @ORM\Column(type="string", options={"default": "PENDING"})
     */
    protected $status;
    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $created_at;
    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $updated_at;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $user_id;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSubTotal()
    {
        return $this->sub_total;
    }

    /**
     * @param mixed $sub_total
     */
    public function setSubTotal($sub_total): void
    {
        $this->sub_total = $sub_total;
    }

    /**
     * @return mixed
     */
    public function getShippingFee()
    {
        return $this->shipping_fee;
    }

    /**
     * @param mixed $shipping_fee
     */
    public function setShippingFee($shipping_fee): void
    {
        $this->shipping_fee = $shipping_fee;
    }

    /**
     * @return mixed
     */
    public function getTotalPaid()
    {
        return $this->total_paid;
    }

    /**
     * @param mixed $total_paid
     */
    public function setTotalPaid($total_paid): void
    {
        $this->total_paid = $total_paid;
    }

    /**
     * @return mixed
     */
    public function getPreviousBalance()
    {
        return $this->previous_balance;
    }

    /**
     * @param mixed $previous_balance
     */
    public function setPreviousBalance($previous_balance): void
    {
        $this->previous_balance = $previous_balance;
    }

    /**
     * @return mixed
     */
    public function getShippingType()
    {
        return $this->shipping_type;
    }

    /**
     * @param mixed $shipping_type
     */
    public function setShippingType($shipping_type): void
    {
        $this->shipping_type = $shipping_type;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(): void
    {
        $this->updated_at = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

}