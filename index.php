<html>


<head>
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
<script src="https://www.paypal.com/sdk/js?client-id=Abj3PA3TgqUIG5CGf4ONmLPhd-b9fcwH543OcbPdwcJ8aZ2YOD69RRWhddmIgR4_-vmnkXN8-o-5CHQ6"></script>
</head>

<img id="google-pay-gift-card"
        src="https://www.pngkey.com/png/full/0-5222_google-play-gift-cards-google-play-gift-card.png"
        alt="Google Play Gift Card"
        width="300"
        height="400">
</img>
<br/>
<!-- form action="/order.php" method="POST">
  <label for="amount">Amount (USD)</label>
  <input type="text" id="amount" name="amount">
  <input type="submit" name="submit" value = "submit"/>
</form-->

<label for="amount">Amount (USD)</label>
<input type="text" id="amount" name="amount">
<br/>
<br/>
<div id="paypal-button-container" style="width:300px;"></div>

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
            return res.json();
        }).then(function(details) {
            console.log(JSON.stringify(details));
            alert(JSON.stringify(details, null, 2));
            document.getElementById("amount").value="";
        });
    }
}).render('#paypal-button-container');
</script>
</footer>

<html>