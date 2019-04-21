<?php declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\ShopServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Validator\ValidatorInterface;
use App\Contracts\Validator\ValidatorException;
use App\Contracts\View\EngineInterface as ViewEngine;
use App\Exceptions\CartItemNotFoundException;
use App\Exceptions\NoItemsOnCartException;
use App\Exceptions\UserInsufficientBalanceException;
use App\Models\CartItem;
use App\Models\ProductRating;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;


class ShopController extends Controller
{
    protected $productService = null;
    protected $shopService = null;
    protected $validator = null;
    protected $userService = null;

    public function __construct(
        ViewEngine $engine,
        Response $response,
        ProductServiceInterface $productService,
        ValidatorInterface $validator,
        ShopServiceInterface $shopService,
        UserServiceInterface $userService)
    {
        $this->productService = $productService;
        $this->validator = $validator;
        $this->shopService = $shopService;
        $this->userService = $userService;
        parent::__construct($engine, $response);
    }

    public function index() : Response
    {
        $products = $this->productService->getProductsWithRatings();
        return $this->view("shop.index", compact('products'));
    }

    public function cart() : Response
    {
        $items = $this->shopService->getItems();
        $sub_total = $this->shopService->subTotal();
        $current_balance = $this->userService->current()->getBalance();
        return $this->view("shop.cart", compact('items', 'sub_total', 'current_balance'));
    }

    public function addItem(Request $request) : Response
    {
        try
        {
            $product = $this->productService->find(+$request->getAttribute('product_id'));

            if($product == null)
            {
                return $this->notFound('Product Not Found');
            }

            $data = $this->validator->validate($request->getParsedBody(), [
                'qty' => 'required|integer|min_numeric, 1',
            ]);

            $cartItem = new CartItem([
                'id' => time(),
                'cart_id' => session_id(), // TODO: get cart id
                'product_id' => $product->getId(),
                'qty' => $data['qty'],
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ]);

            $this->shopService->addItem($cartItem);

            flash_message_success("Product was successfully added to the cart");
            return $this->redirect('/shop');
        }
        catch(ValidatorException $ex)
        {
            if(count($ex->getErrors())) {
                flash_message_error($ex->getErrors());
            }

            return $this->redirect(__url("/shop"), $request->getParsedBody());
        }
    }

    public function updateItemQty(Request $request) : Response
    {
        try
        {
            $data = $this->validator->validate($request->getParsedBody(), [
                'qty' => 'required|integer|min_numeric, 1',
            ]);

            $cartItem = $this->shopService->findItem(+$request->getAttribute('id'));

            $cartItem->setQty($data['qty']);

            $this->shopService->updateItem($cartItem);

            flash_message_success("Item was successfully updated.");

            return $this->redirect('/cart');
        }
        catch(CartItemNotFoundException $ex)
        {
            flash_message_error("Cart item not found or the item was already deleted");
            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
        catch(ValidatorException $ex)
        {
            if(count($ex->getErrors())) {
                flash_message_error($ex->getErrors());
            }

            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
    }

    public function deleteItem(Request $request) : Response
    {
        try
        {
            $this->shopService->deleteItem(+$request->getAttribute('id'));

            flash_message_success("Item was successfully remove from cart.");

            return $this->redirect('/cart');
        }
        catch(CartItemNotFoundException $ex)
        {
            flash_message_error("Cart item not found or the item was already deleted");
            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
    }

    public function checkout(Request $request) : Response
    {
        try
        {
            $data = $this->validator->validate($request->getParsedBody(), [
                'shipping' => 'required|contains_list,PICK_UP;UPS',
            ]);

            $items = $this->shopService->getItems();

            if(count($items) == 0)
            {
                flash_message_error("Not items found in the cart");
                return $this->redirect(__url("/cart"), $request->getParsedBody());
            }

            $this->shopService->checkout($data['shipping']);

            flash_message_success("Order successfully.");
            return $this->redirect('/orders');
        }
        catch(ValidatorException $ex)
        {
            if(count($ex->getErrors())) {
                flash_message_error($ex->getErrors());
            }

            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
        catch(UserInsufficientBalanceException $ex)
        {
            flash_message_error("Insufficient Balance");
            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
        catch(NoItemsOnCartException $ex)
        {
            flash_message_error("Cart is empty");
            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
        catch(\Exception $ex)
        {
            flash_message_error("Something went wrong");
            return $this->redirect(__url("/cart"), $request->getParsedBody());
        }
    }

    public function rate(Request $request) : Response
    {
        try
        {
            $data = $this->validator->validate($request->getParsedBody(), [
                'rate' => 'required|integer|min_numeric,1',
            ]);

            $product_id = +$request->getAttribute('id');

            $product = $this->productService->find($product_id);

            if($product == null)
            {
                return new JsonResponse(["message" => "Product not found"], 404);
            }

            $user = $this->userService->current();

            $productRating = new ProductRating([
                'product' => $product,
                'user' => $user,
                'rate' => $data['rate']
            ]);

            $this->productService->addRating($productRating);

            $product = $this->productService->getProductWithRating($product_id);

            return new JsonResponse(['count' => $product->getReviewCount(), 'average' => $product->getAverageRate(),]);
        }
        catch(ValidatorException $ex)
        {
            return new JsonResponse($ex->getErrors(), 500);
        }
    }
}