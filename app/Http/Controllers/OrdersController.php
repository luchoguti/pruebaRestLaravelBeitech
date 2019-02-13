<?php

namespace App\Http\Controllers;

use App\Orders;
use App\OrderDetails;
use App\CustomerProducts;

use Illuminate\Http\Request;
use App\Http\Resources\OrdersResource as OrdersResource;
use App\Http\Resources\OrderDetailsResource;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * example url:
     * 
     * 127.0.0.1:8000/api/orders/?fecha_init=2019-02-13&fecha_end=2019-02-13
     * 
     */
    public function index()
    {
        if(request()->filled('fecha_init') && request()->filled('fecha_end')){
            return OrdersResource::collection(Orders::whereBetween('creation_date', [request()->fecha_init, request()->fecha_end])->with(['OrderDetail'])->get());  
        }else{
            $dataRespose['status'] = 404;
            $dataRespose['message'] = "the parameters fecha_init and fecha_end must exist and can not be null, check please!";
            return response()->json($dataRespose, 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * 
     * example json aplication store:
     * 
     * 
     * {
     *   "customer_id":1,
     *   "delivery_address":"direccion prueba",
     *   "orders": [
     *       {
     *       "product_id":16,
     *       "product_description":"pppp",
     *       "price":"45700.88",
     *       "quantity":7
     *       },
     *       {
     *       "product_id":10,
     *       "product_description":"jjjj",
     *       "price":"11900",
     *       "quantity":9
     *       },
     *       {
     *       "product_id":15,
     *       "product_description":"bbbbb",
     *       "price":"56800.01",
     *       "quantity":11
     *       }
     *   ]
     *   }
     */
    public function store(Request $request)
    {
        $avaibleSqlProducts = CustomerProducts::where('customer_id',$request->customer_id)->get()->toArray();
        $limitProducts=count($request->orders);
        $arrayProductsInvalid = array();
        $dataRespose = array();
        $totalOrderDatails=0;
        if($limitProducts <= 5){
            foreach ($request->orders as $order) {
                $avaibleProducts=$this->searchProducsAvaible($avaibleSqlProducts,$order['product_id']);
                if(!$avaibleProducts){
                    $arrayProductsInvalid[]=$order;
                }
                $totalOrderDatails+=$order['price'];
            }

            if(count($arrayProductsInvalid)>0){
                $dataRespose['status'] = 404;
                $dataRespose['message'] = "some products are not allowed for the user ".$request->customer_id.", check please!";
                $dataRespose['listProductsNotAllowed'] = $arrayProductsInvalid;
                return response()->json($dataRespose, 404);
            }else{
                $insertOrders=Orders::create([
                    "customer_id"=>$request->customer_id, 
                    "creation_date"=>date("Y-m-d"), 
                    "delivery_address"=>$request->delivery_address,
                    "total"=>$totalOrderDatails
                ]);
                foreach ($request->orders as $order) {
                    OrderDetails::create([
                        "order_id"=>$insertOrders->order_id, 
                        "product_description"=> $order['product_description'], 
                        "price"=> $order['price'],
                        "quantity" => $order['quantity'],
                        "product_id"=> $order['product_id']
                    ]);
                }
                $dataRespose['status'] = 201;
                $dataRespose['message'] = "products created successfully!";
                return response()->json($dataRespose, 201);
            }
        }else{
            $dataRespose['status'] = 404;
            $dataRespose['message'] = "Products limit exceeded, check please!";
            return response()->json($dataRespose, 404);
        }
    }

    public function searchProducsAvaible($array,$valueProduct){
        foreach ($array as $dataCustomerProducts) {
            if($dataCustomerProducts['product_id'] == $valueProduct){
                return true;
                break;
            }
        }
        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function show(Orders $orders)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
    
    public function orderDetails(OrderDetails $orders){
        return new OrderDetailsResource($orders->OrderDetails);
    }
}
