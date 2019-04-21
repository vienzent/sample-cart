<?php declare(strict_types=1);

namespace App\Services;

use App\Contracts\Repositories\OrderLineRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\ShopServiceInterface;
use App\Exceptions\CartItemNotFoundException;
use App\Exceptions\NoCurrentUserException;
use App\Exceptions\NoItemsOnCartException;
use App\Exceptions\UserInsufficientBalanceException;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\User;
use DateTime;

class ShopService implements ShopServiceInterface // SESSION VERSION
{
    private $key = "__CART";

    protected $userRepository = null;
    protected $orderRepository = null;
    protected $orderLineRepository = null;
    protected $productRepository = null;

    const SHIPPING = [
        'PICK_UP' => 0,
        'UPS' => 5,
    ];

    public function __construct(
        UserRepositoryInterface $userRepository,
        OrderRepositoryInterface $orderRepository,
        OrderLineRepositoryInterface $orderLineRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->orderLineRepository = $orderLineRepository;
        $this->productRepository = $productRepository;
    }

    public function addItem(CartItem $cartItem): void
    {
        if(!isset($_SESSION[$this->key]) || !is_array($_SESSION[$this->key])) {
            $_SESSION[$this->key] = [
                'items' => []
            ];
        }

        $_SESSION[$this->key]['items'] = [$cartItem->getId() => $cartItem];
    }

    public function updateItem(CartItem $cartItem) : void
    {
        if(!array_key_exists($cartItem->getId(), $_SESSION[$this->key]['items'])) {
            throw new CartItemNotFoundException($cartItem->getId());
        }

        $_SESSION[$this->key]['items'][$cartItem->getId()] = $cartItem;
    }

    public function findItem(int $id) : CartItem
    {
        $items = $this->getItems();

        if(!array_key_exists($id, $items))
        {
            throw new CartItemNotFoundException($id);
        }

        return $items[$id];
    }

    public function getItems() : array
    {
        if(!isset($_SESSION[$this->key]) || !is_array($_SESSION[$this->key])) {
            return [];
        }

        return $_SESSION[$this->key]['items'];
    }

    public function deleteItem(int $id): void
    {
        $cartItem = $this->findItem($id);

        unset($_SESSION[$this->key]['items'][$cartItem->getId()]);
    }

    public function subTotal(): float
    {
        $items = $this->getItems();
        $sub_total = 0;
        foreach ($items as $item)
        {
            $sub_total += $item->getTotal();
        }

        return $sub_total;
    }

    public function checkout(string $shipping_type): void
    {
        // TODO: add database transaction handling
        $items = $this->getItems();

        if(count($items) == 0)
        {
            throw new NoItemsOnCartException();
        }

        $sub_total = $this->subTotal();
        $shipping_fee = self::SHIPPING[$shipping_type];
        $total = $sub_total + $shipping_fee;

        $user = $this->getCurrentUser();

        if($user->getBalance() - $total < 0)
        {
            throw new UserInsufficientBalanceException();
        }

        $order = new Order([
            'sub_total' => $sub_total,
            'shipping_fee' => $shipping_fee,
            'total_paid' => $total,
            'previous_balance' => $user->getBalance(),
            'shipping_type' => $shipping_type,
            'status' => 'PENDING',
            'user_id' => $user->getId(),
            'user' => $user,
            'created_at' => new DateTime('now'),
            'updated_at' => new DateTime('now'),
        ]);

//        var_dump($order);
//        die();

        $this->orderRepository->insert($order);

        $user->setBalance($user->getBalance() - $total);

        $this->userRepository->update($user);

        foreach ($items as $item)
        {

            $product = $this->productRepository->find($item->getProductId());
            $item = new OrderLine([
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'qty' => $item->getQty(),
                'product_id' => $item->getProductId(),
                'product' => $product,
                'order_id' => $order->getId(),
                'order' => $order
            ]);

            $this->orderLineRepository->insert($item);
        }

        $_SESSION[$this->key]['items'] = [];
    }

    private function getCurrentUser() : User
    {
        If(!isset($_SESSION['user_id']))
        {
            throw new NoCurrentUserException();
        }

        $user = $this->userRepository->find(+$_SESSION['user_id']);

        if($user == null)
        {
            throw new NoCurrentUserException();
        }

        return $user;
    }
}