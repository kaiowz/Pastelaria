<style>
p{
    font-size: 14px;
}

span{
    color: #FF1232;
}
</style>

<html>
    <body class="container">
        <div>
        <p>Olá {{ $name }}. <strong>Obrigado por realizar esse pedido <span>irado</span> com a gente!</strong></p>
        </div>
        <p></p>
        <p>Aqui está os detalhes do seu pedido realizado em {{date("d/m/Y h:i", $order->create_at)}}</p>
        @foreach ($order->suborder as $suborder)
        <p>Sabor: {{$suborder->pastry->name}} por R$ <strong>{{str_replace(".", ",", $suborder->pastry->price)}}</strong></p>
        @endforeach
        <p></p>
        <p>Tamo juntão! <br>
        Pastelaria Daora</p>
    </body>
</html>
