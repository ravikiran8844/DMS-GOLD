<!doctype html>
<html lang="en">
	
	<head>
		<script type="text/javascript">
			(function(c,l,a,r,i,t,y){
				c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
				t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
				y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
			})(window, document, "clarity", "script", "mopb0nhhuf");
		</script>
		<title>Emerald Silver</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
			}
			
			.container {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
			}
			
			.header {
            text-align: center;
            margin-bottom: 20px;
			}
			
			.header img {
            max-width: 150px;
			}
			
			.content {
            font-size: 16px;
            color: #333333;
			}
			
			.content p {
            margin-bottom: 15px;
			}
			
			.order-id {
            font-weight: bold;
            color: #007bff;
			}
			
			.highlight {
            color: #dc3545;
			}
			
			.footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888888;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<div class="header">
				<img src="https://www.emeraldsilver.in/retailer/assets/img/emerald-logo.png" alt="Emerald Jewel Industry">
			</div>
			<div class="content">
				<p>Thank you for placing your order with <strong>Emerald Jewel Industry!</strong></p>
				<p>Your order ID is: <span class="order-id">{{ $details[0]->order_no }}</span></p>
				<p>We have received your order and the order is under process...</p>
				<p>We will be checking with dealers near you and allocating the orders to the dealer from where it will be
				sent to you.</p>
				<p>Please expect a call from our dealer regarding order prices & fulfilment.</p>
				<p class="highlight">NOTE: Due to high demand, there are chances that one or more of the items that you have
				ordered cannot be fulfilled. You will receive a call in case such a cancellation occurs.</p>
			</div>
			<div class="footer">
				<p>Emerald Jewel Industry &copy; {{ date('Y') }}</p>
			</div>
		</div>
	</body>
	
</html>
