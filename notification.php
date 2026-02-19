<?php 
include 'includes/header.php';
include 'includes/navbar.php';
?>
    <!-- Social media section -->
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Important Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .notification-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .notification-container {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .notification {
            background-color: #fff;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #4CAF50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: slide-in 0.3s ease-out;
        }

        .notification p {
            margin: 0;
            font-size: 16px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #888;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: #000;
        }

        @keyframes slide-in {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

   
    <div class="our-team-head" data="fade-down"><span>Notifications</span></div>

    <div class="notification-page">
        <div class="notification-container" id="notificationContainer"></div>
    </div>

    

    <script>
      
        function addNotification(message) {
            const container = document.getElementById('notificationContainer');

           
            const notification = document.createElement('div');
            notification.className = 'notification';

           
            const messageText = document.createElement('p');
            messageText.textContent = message;
            notification.appendChild(messageText);

          
            const closeButton = document.createElement('button');
            closeButton.className = 'close-btn';
            closeButton.innerHTML = '&times;';
            closeButton.onclick = () => {
                notification.remove();
            };
            notification.appendChild(closeButton);

            
            container.appendChild(notification);

        
           
        }

        
        addNotification('New order received for your produce!');
        addNotification('Market price updated for tomatoes.');
        addNotification('Quality check completed for your shipment.');
        addNotification('Reminder: Submit your crop details for the next season.');
        addNotification('Training session on sustainable farming techniques scheduled tomorrow.');
        addNotification('Your payment for the last delivery has been processed successfully.');
        addNotification('New feature: Track your deliveries and payments on our platform!');
        addNotification('Important: Update your profile to include bank details for faster payments.');
        addNotification('Weather Alert: Heavy rainfall expected in your region. Take necessary precautions.');
        addNotification('Special Offer: Get subsidized seeds and fertilizers through our platform.');
    </script>
</body>
</html>

<?php 
    include 'includes/footer.php'; 

    ?>
     </section>

    