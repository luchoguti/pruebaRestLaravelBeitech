@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Ordenes</div>
                <div class="card-body">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <form v-on:submit="cargarOrdenes()" class="form-inline">
                            <div class="form-group mb-2">
                                <label for="fecha_init"><b>Fecha inicial filtro:</b> </label>
                                <input type="date"  v-model="fecha_init" value="" class="form-control input-sm" required placeholder="">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="fecha_end"><b>Fecha final filtro:</b> </label>
                                <input type="date" v-model="fecha_end" value="" class="form-control input-sm" required placeholder="">
                            </div>
                            <button class="btn btn-primary mb-2">
                                Cargar Ordenes
                            </button>
                        </form>
                    </div>
                    <div id="lista_ordenes" class="col-xs-12 col-sm-12 col-md-12">
                        <table id="mytable" class="table table-bordred table-striped" data-form="ListaForm">
							<thead>
								<th>Creation Date</th>
								<th>Order ID</th>
								<th>Total $</th>
								<th>Delivery Address</th>
								<th>Products</th>
							</thead>
							<tbody>
                                <tr v-for="orders in ordersList.data">
                                    <td>@{{ orders.creation_date }}</td>
                                    <td>@{{ orders.order_id }}</td>
                                    <td>@{{ orders.total }}</td>
                                    <td>@{{ orders.delivery_address }}</td>
                                    <td>
                                        <p v-for="ordersProducts in orders.orders_details">
                                            <span>@{{ ordersProducts.quantity }}</span>
                                            <span> x </span>
                                            <span v-if="ordersProducts.products.name !== 'null'">@{{ ordersProducts.products.name }}</span>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
