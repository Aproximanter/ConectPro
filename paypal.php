<!DOCTYPE html>
<html lang="es"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integración de PayPal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }


   #paypal-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #paypal-button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
        }

        .paypal-button {
            background-color: #007bff; 
            color: #fff; 
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .paypal-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<?php include('navbar.php')?> 

<div id="paypal-container">
    <div id="paypal-button-container"></div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AZ7GhC2YboSaKchImw3DYAYpvu1yatQ-_hR5X4YN-pELuhpD6No5QB8aWbAuYMkCfMBJEuEeVsUxAmgZ&currency=MXN"></script>

<script>
    paypal.Buttons({
       
        locale: 'es_MX',
        style: {
            shape: 'pill', // Otras opciones: 'rect', 'label'
            color: 'gold', // Otras opciones: 'blue', 'silver', 'black'
            layout: 'vertical',  // Otras opciones: 'horizontal'
        },

        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '10.00' // Monto dinámico 
                    }
                }]
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Redirigir a una página de éxito o mostrar confirmación
                console.log('Transaction completed by ' + details.payer.name.given_name + '!'); 
                window.location.href = 'pagina_exito.php'; 
            });
        }

    }).render('#paypal-button-container');
</script>

</body>
</html>
