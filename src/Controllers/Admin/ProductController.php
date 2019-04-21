<?php declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Contracts\Validator\ValidatorException;
use App\Contracts\Validator\ValidatorInterface as Validator;
use App\Contracts\Services\ProductServiceInterface as ProductService;
use App\Contracts\View\EngineInterface as ViewEngine;
use App\Controllers\Controller;
use App\Models\Product;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class ProductController extends Controller{

    protected $service = null;
    protected $validator = null;

    public function __construct(ViewEngine $engine, Response $response, ProductService $service, Validator $validator)
    {
        parent::__construct($engine, $response);
        $this->service = $service;
        $this->validator = $validator;
    }

    public function index() : Response
    {
        $products = $this->service->all();
        return $this->view("admin.product.index", compact('products'));
    }

    public function create() : Response
    {
        $product = new Product;

        return $this->view("admin.product.create", compact('product'));
    }

    public function store(Request $request) : Response
    {
        try
        {
            $data = $this->validator->validate($request->getParsedBody(), [
                'name' => 'required',
                'price' => 'required|min_numeric,0',
            ]);

            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);

            $this->service->add($product);

            flash_message_success("Product successfully added!");
            return $this->redirect(__url("/admin/products"));
        }
        catch(ValidatorException $ex)
        {
            if(count($ex->getErrors())) {
                flash_message_error($ex->getErrors());
            }

            return $this->redirect(__url("/admin/products/create"), $request->getParsedBody(), $ex);
        }
    }

    public function edit(Request $request) : Response
    {
        $product = $this->service->find(+$request->getAttribute('id'));

        if($product == null)
        {
            return $this->notFound('Product Not Found');
        }

        return $this->view('admin.product.edit', compact('product'));
    }

    public function update(Request $request) : Response
    {

        try
        {
            $product = $this->service->find(+$request->getAttribute('id'));

            if($product == null)
            {
                return $this->notFound('Product Not Found');
            }

            $data = $this->validator->validate($request->getParsedBody(), [
                'name' => 'required',
                'price' => 'required|min_numeric, 0',
            ]);

            $product->setName($data['name']);
            $product->setPrice($data['price']);

            $this->service->update($product);

            flash_message_success("Product successfully updated!");
            return $this->redirect(__url("/admin/products"));
        }
        catch(ValidatorException $ex)
        {
            if(count($ex->getErrors())) {
                flash_message_error($ex->getErrors());
            }

            return $this->redirect(__url("/admin/products/create"), $request->getParsedBody(), $ex);
        }
    }
}