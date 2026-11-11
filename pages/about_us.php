<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Search</title>
</head>
<body style="font-family: Arial, sans-serif; background: url('../assets/images/about us.png') no-repeat center center fixed; background-size: 1600px 770px; margin: 0; padding: 0; color: #1d1d1d; height: 100vh; position: relative;">

   
    <div style="position: absolute; bottom: 50px; left: 200px; display: flex; flex-direction: column; gap: 20px;">
        <div style="display: flex; gap: 60px;">
            <a href="about_us.php" style="font-size: 28px; color: #FCFC5C; text-decoration: underline; transition: 0.3s;">About Us</a>
            <a href="courses.php" style="font-size: 28px; color: #FCFC5C; text-decoration: underline; transition: 0.3s;">Courses</a>
        </div>
        <div style="display: flex; gap: 60px;">
            <a href="academic_calendar.php" style="font-size: 28px; color: #FCFC5C; text-decoration: underline; transition: 0.3s;">Academic Calendar</a>
            <a href="academic_policies.php" style="font-size: 28px; color: #FCFC5C; text-decoration: underline; transition: 0.3s;">Academic Policies</a>
            <a href="contact_information.php" style="font-size: 28px; color: #FCFC5C; text-decoration: underline; transition: 0.3s;">Contact Information</a>
        </div>
    </div>


    <div style="position: absolute; bottom: 30px; right: 40px; display: flex; gap: 15px;">
        <a href="map.php">
            <button style="padding: 12px 25px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; color: black; background-color: #FCFC5C; transition: 0.3s; box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);" 
                    onmouseover="this.style.boxShadow='0 0 20px rgba(255, 255, 255, 1)'; this.style.backgroundColor='#FFEE00';" 
                    onmouseout="this.style.boxShadow='0 0 10px rgba(255, 255, 255, 0.8)'; this.style.backgroundColor='#FCFC5C';">View Map</button>
        </a>
        <a href="rooms.php" style="text-decoration: none;">
            <button style="padding: 12px 25px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; color: black; background-color: #FBFB00; transition: 0.3s; box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);" 
                    onmouseover="this.style.boxShadow='0 0 20px rgba(255, 255, 255, 1)'; this.style.backgroundColor='#FFEE00';" 
                    onmouseout="this.style.boxShadow='0 0 10px rgba(255, 255, 255, 0.8)'; this.style.backgroundColor='#FBFB00';">Back</button>
        </a>
    </div>

</body>
</html>
