<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="../css/tailwind.css" rel="stylesheet">
    <script>
        function validateForm(event) {
            event.preventDefault();  // Prevent form submission
            let error_message = '';
            
            // Get form values
            const fullname = document.getElementById('fullname').value;
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;

            // Validation checks
            if (password !== confirm_password) {
                error_message = 'Passwords do not match.';
            } else if (fullname === '' || username === '' || email === '' || password === '') {
                error_message = 'All fields are required.';
            } else if (password.length < 8) {
                error_message = 'Password should be at least 8 characters.';
            }

            // Display error message
            const errorMessageElement = document.getElementById('error_message');
            if (error_message) {
                errorMessageElement.textContent = error_message;
                errorMessageElement.style.display = 'block';
            } else {
                errorMessageElement.style.display = 'none';
                // If no errors, submit the form (you can use AJAX here for smoother experience)
                document.getElementById('signupForm').submit();
            }
        }
    </script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
  <!-- Left Pane -->
  <div class="hidden lg:flex items-center justify-center flex-1 bg-white text-black">
    <div class="max-w-md text-center">
      <img src="https://media.istockphoto.com/id/1472849554/id/foto/kue-ulang-tahun-dengan-tetesan-ganache-biru-dan-taburan-warna-warni-diisolasi-dengan-latar.jpg?s=1024x1024&w=is&k=20&c=VRg0zZEjni5qgB-ZxQQyDqR6b-r3pI9xZQCz8C-ciG0=" alt="Login Image">
      <h1 class="font-bold text-3xl -translate-y-5">ResepCakeKU</h1>
    </div>
  </div>

  <!-- Right Pane -->
  <div class="w-full bg-gray-100 lg:w-1/2 flex items-center justify-center">
    <div class="max-w-md w-full p-6">
      <h1 class="text-3xl font-semibold mb-6 text-black text-center">Sign Up</h1>
      <p class="text-sm font-semibold mb-6 text-gray-500 text-center">Join to Our Community with all-time access and free</p>

      <!-- Error message display -->
      

      <!-- Sign-up form -->
      <form id="signupForm" action="/../src/controller/SignupController.php" method="POST" class="space-y-4" onsubmit="validateForm(event)">
        <div>
          <label for="fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
          <input type="text" id="fullname" name="fullname_222263" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300" required>
        </div>
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" id="username" name="username_222263" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300" required>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email_222263" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300" required>
        </div>
        <div class="flex gap-2">
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password_222263" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300" required>
          </div>
          <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="mt-1 p-2 w-full border rounded-md focus:border-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-colors duration-300" required>
          </div>
        </div>
        <div style="color: red;" id="error_message"  class="mb-4  text-center" style="display: none;"></div>
        <div>
          <button type="submit" name="signup" class="w-full bg-black text-white p-2 rounded-md hover:bg-gray-800  focus:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-300">Sign Up</button>
        </div>
      </form>
      <div class="mt-4 text-sm text-gray-600 text-center">
        <p>Already have an account? <a href="/login" class="text-black hover:underline">Login here</a></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
