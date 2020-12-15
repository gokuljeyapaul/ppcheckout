<html>


<head>
<script src="https://www.paypal.com/sdk/js?client-id=Abj3PA3TgqUIG5CGf4ONmLPhd-b9fcwH543OcbPdwcJ8aZ2YOD69RRWhddmIgR4_-vmnkXN8-o-5CHQ6"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>


<div id="base-container">
    <div class="text-center">
        <img id="google-pay-gift-card"
            src="https://www.pngkey.com/png/full/0-5222_google-play-gift-cards-google-play-gift-card.png"
            alt="Google Play Gift Card"
            width="300"
            height="400">
            </img>
    </div>
        

    <div class="text-center">
        <label for="customRange3" class="form-label">Denomination</label>
        <input type="range" name="amountRange" class="form-range" min="5" max="15" step="5" id="customRange3" onchange="updateTextInput(this.value);">
    </div>

    <div class="text-center">
        <label for="amount" class="form-label">Value</label>
        <input type="text" id="amount" name="amount" value="10"  readonly>
    </div>


    <div class="text-center" id="paypal-button-container" style="display:block; margin:0 auto; width:300px;"></div>

</div>
<footer>

<script>
paypal.Buttons({
    createOrder: function() {
        return fetch('/order.php', {
            method: 'post',
            headers: {
                'content-type': 'application/json',
                'accept': 'application/json'
            },
            body: JSON.stringify({
                amount: document.getElementById("amount").value,
                sku: "custom-valued-gift-card"
            })
        }).then(function(res) {
            console.log(res);
            return res.json();
        }).then(function(data) {
            console.log(JSON.stringify(data));
            return data.id; 
        });
    },
    onApprove: function(data) {
        console.log(data);
        return fetch('/order-details.php', {
            method: 'post',
            headers: {
                'content-type': 'application/json',
                'accept': 'application/json'
            },
            body: JSON.stringify({
                order_id: data.orderID,
                payer_id: data.payerID
            })
        }).then(function(res) {
            console.log(res);
            return res.text();
        }).then(function(details) {
            console.log(details);
            $("#base-container").empty();
            $("#base-container").html(details);
        });
    }
}).render('#paypal-button-container');

function updateTextInput(val) {
    document.getElementById('amount').value=val; 
}
</script>
</footer>

<html>