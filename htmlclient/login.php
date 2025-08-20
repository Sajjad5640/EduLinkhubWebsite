
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Replace your current Font Awesome script with this -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../CSS/login_client.css" />
  <title>Sign in & Sign up Form</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }


    body {
      min-height: 100vh;
      overflow: hidden;
      background-color: #f5f5f5;

    }

    .container {
      position: relative;
      width: 100%;
      min-height: 100vh;
      overflow-x: hidden;
      /* keep horizontal safe */
      overflow-y: visible;
    }

    /* .forms-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 50px;
        left: 0;
      }

      .signin-signup {
        position: absolute;
        top: 50%;
        transform: translate(-50%, -50%);
        left: 75%;
        width: 50%;
        transition: 1s 0.7s ease-in-out;
        display: grid;
        grid-template-columns: 1fr;
        z-index: 5;
      } */

    form {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0rem 5rem;
      transition: all 0.2s 0.7s;
      overflow: hidden;
      grid-column: 1 / 2;
      grid-row: 1 / 2;
    }

    form.sign-up-form {
      opacity: 0;
      z-index: 1;
    }

    form.sign-in-form {
      z-index: 2;
    }

    .title {
      font-size: 2.2rem;
      color: #444;
      margin-bottom: 10px;
    }

    .input-field {
      max-width: 380px;
      width: 100%;
      background-color: #f0f0f0;
      margin: 10px 0;
      height: 55px;
      border-radius: 55px;
      display: grid;
      grid-template-columns: 15% 85%;
      padding: 0 0.4rem;
      position: relative;
    }

    .input-field i {
      text-align: center;
      line-height: 55px;
      color: #acacac;
      transition: 0.5s;
      font-size: 1.1rem;
    }

    .input-field input,
    .input-field select {
      background: none;
      border-radius: 50px;
      outline: none;
      border: none;
      line-height: 1;
      font-weight: 600;
      font-size: 1.1rem;
      color: #000000ff;
    }

    .input-field input::placeholder {
      color: #aaa;
      font-weight: 500;
    }

    .input-field select {
      width: 100%;
      color: #000000ff;
      font-weight: 600;
      background: transparent;
      cursor: pointer;
    }

    .input-field select option {
      background: #f0f0f0;
      color: #333;
    }

    .btn {
      width: 150px;
      background-color: #5995fd;
      border: none;
      outline: none;
      height: 49px;
      border-radius: 49px;
      color: #fff;
      text-transform: uppercase;
      font-weight: 600;
      margin: 10px 0;
      cursor: pointer;
      transition: 0.5s;
    }

    .btn:hover {
      background-color: #4d84e2;
    }

    .social-text {
      padding: 0.7rem 0;
      font-size: 1rem;
    }

    .social-media {
      display: flex;
      justify-content: center;
    }

    .social-icon {
      height: 46px;
      width: 46px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 0.45rem;
      color: #333;
      border-radius: 50%;
      border: 1px solid #333;
      text-decoration: none;
      font-size: 1.1rem;
      transition: 0.3s;
    }

    .social-icon:hover {
      color: #4481eb;
      border-color: #4481eb;
    }

    .panels-container {
      position: absolute;
      height: 100%;
      width: 100%;
      top: 0;
      left: 0;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
    }

    .container:before {
      content: "";
      position: absolute;
      height: 2000px;
      width: 2000px;
      top: -10%;
      right: 48%;
      transform: translateY(-50%);
      background-image: linear-gradient(-45deg, #4481eb 0%, #04befe 100%);
      transition: 1.8s ease-in-out;
      border-radius: 50%;
      z-index: 6;
    }

    .image {
      width: 100%;
      transition: transform 1.1s ease-in-out;
      transition-delay: 0.4s;
    }

    .panel {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: space-around;
      text-align: center;
      z-index: 6;
    }

    .left-panel {
      pointer-events: all;
      padding: 3rem 17% 2rem 12%;
    }

    .right-panel {
      pointer-events: none;
      padding: 3rem 12% 2rem 17%;
    }

    .panel .content {
      color: #fff;
      transition: transform 0.9s ease-in-out;
      transition-delay: 0.6s;
    }

    .panel h3 {
      font-weight: 600;
      line-height: 1;
      font-size: 1.5rem;
    }

    .panel p {
      font-size: 0.95rem;
      padding: 0.7rem 0;
    }

    .btn.transparent {
      margin: 0;
      background: none;
      border: 2px solid #fff;
      width: 130px;
      height: 41px;
      font-weight: 600;
      font-size: 0.8rem;
    }

    .right-panel .image,
    .right-panel .content {
      transform: translateX(800px);
    }

    /* ANIMATION */

    .container.sign-up-mode:before {
      transform: translate(100%, -50%);
      right: 52%;
    }

    .container.sign-up-mode .left-panel .image,
    .container.sign-up-mode .left-panel .content {
      transform: translateX(-800px);
    }

    .container.sign-up-mode .signin-signup {
      left: 25%;
    }

    .container.sign-up-mode form.sign-up-form {
      opacity: 1;
      z-index: 2;
    }

    .container.sign-up-mode form.sign-in-form {
      opacity: 0;
      z-index: 1;
    }

    .container.sign-up-mode .right-panel .image,
    .container.sign-up-mode .right-panel .content {
      transform: translateX(0%);
    }

    .container.sign-up-mode .left-panel {
      pointer-events: none;
    }

    .container.sign-up-mode .right-panel {
      pointer-events: all;
    }

    /* Validation Styles */
    .error-message {
      color: #e74c3c;
      font-size: 0.8rem;
      margin-top: -5px;
      margin-bottom: 10px;
      display: none;
      text-align: left;
      width: 100%;
      max-width: 380px;
      padding-left: 15px;
    }

    .input-error {
      border: 2px solid #e74c3c !important;
      background-color: #fff0f0 !important;
    }

    .input-error i {
      color: #e74c3c !important;
    }

    .input-success {
      border: 2px solid #2ecc71 !important;
      background-color: #f0fff4 !important;
    }

    .input-success i {
      color: #2ecc71 !important;
    }

    .password-requirements {
      margin-top: 5px;
      padding: 10px;
      background: #f9f9f9;
      border-radius: 10px;
      font-size: 0.8rem;
      display: none;
      max-width: 380px;
      width: 100%;
    }

    .password-requirements ul {
      list-style: none;
      padding-left: 5px;
      text-align: left;
    }

    .password-requirements li {
      margin-bottom: 5px;
      display: flex;
      align-items: center;
    }

    .password-requirements li i {
      margin-right: 5px;
      font-size: 0.7rem;
    }

    .requirement-met {
      color: #27ae60;
    }

    .requirement-not-met {
      color: #e74c3c;
    }
    .success-message {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CAF50;
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    animation: fadeInOut 3s ease-in-out;
}

.error-message {
    position: fixed;
    top: -50px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #f44336;
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    z-index: 1000;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    max-width: 80%;
}

.error-message ul {
    margin: 5px 0 0 0;
    padding-left: 20px;
}

@keyframes fadeInOut {
    0% { opacity: 0; top: 0; }
    10% { opacity: 1; top: 20px; }
    90% { opacity: 1; top: 20px; }
    100% { opacity: 0; top: 0; }
}

    @media (max-width: 870px) {
      .container {
        min-height: 800px;
        height: 100vh;
      }

      .signin-signup {
        width: 100%;
        top: 95%;
        transform: translate(-50%, -100%);
        transition: 1s 0.8s ease-in-out;
      }

      .signin-signup,
      .container.sign-up-mode .signin-signup {
        left: 50%;
      }

      .panels-container {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 2fr 1fr;
      }

      .panel {
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
        padding: 2.5rem 8%;
        grid-column: 1 / 2;
      }

      .right-panel {
        grid-row: 3 / 4;
      }

      .left-panel {
        grid-row: 1 / 2;
      }

      .image {
        width: 200px;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.6s;
      }

      .panel .content {
        padding-right: 15%;
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.8s;
      }

      .panel h3 {
        font-size: 1.2rem;
      }

      .panel p {
        font-size: 0.7rem;
        padding: 0.5rem 0;
      }

      .btn.transparent {
        width: 110px;
        height: 35px;
        font-size: 0.7rem;
      }

      .container:before {
        width: 1500px;
        height: 1500px;
        transform: translateX(-50%);
        left: 30%;
        bottom: 68%;
        right: initial;
        top: initial;
        transition: 2s ease-in-out;
      }

      .container.sign-up-mode:before {
        transform: translate(-50%, 100%);
        bottom: 32%;
        right: initial;
      }

      .container.sign-up-mode .left-panel .image,
      .container.sign-up-mode .left-panel .content {
        transform: translateY(-300px);
      }

      .container.sign-up-mode .right-panel .image,
      .container.sign-up-mode .right-panel .content {
        transform: translateY(0px);
      }

      .right-panel .image,
      .right-panel .content {
        transform: translateY(300px);
      }

      .container.sign-up-mode .signin-signup {
        top: 5%;
        transform: translate(-50%, 0);
      }
    }

    @media (max-width: 570px) {
      form {
        padding: 0 1.5rem;
      }

      .image {
        display: none;
      }

      .panel .content {
        padding: 0.5rem 1rem;
      }

      .container {
        padding: 1.5rem;
      }

      .container:before {
        bottom: 72%;
        left: 50%;
      }

      .container.sign-up-mode:before {
        bottom: 28%;
        left: 50%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="signin_client.php" method="POST" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="login-username" name="email"  placeholder="Email" />
          </div>
          <div class="error-message" id="login-username-error">Email is required</div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="login-password" name="password" placeholder="Password" />
          </div>
          <div class="error-message" id="login-password-error">Password is required</div>

          <input type="submit" value="Login" class="btn solid" id="login-btn" />
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
        <form action="signup_client.php" method="POST" class="sign-up-form">
          <h2 class="title">Create Account</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="full-name" name="full_name" placeholder="Full Name" />
          </div>
          <div class="error-message" id="full-name-error">Full name is required</div>

          <div class="input-field">
            <i class="fas fa-user-tag"></i>
            <select class="gender-select" id="gender" name="gender">
              <option value="" disabled selected>Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="error-message" id="gender-error">Please select your gender</div>

          <div class="input-field">
            <i class="fas fa-graduation-cap"></i>
            <select class="qualification-select" name="qualification" id="qualification">
              <option value="" disabled selected>Education Qualification</option>
              <option value="high-school">High School</option>
              <option value="bachelor">Bachelor's Degree</option>
              <option value="master">Master's Degree</option>
              <option value="phd">PhD</option>
              <option value="other">Other</option>
            </select>
          </div>
          <div class="error-message" id="qualification-error">Please select your education qualification</div>

          <div class="input-field">
            <i class="fas fa-school"></i>
            <input type="text"  name="institute" id="institute" placeholder="Educational Institute" />
          </div>
          <div class="error-message" id="institute-error">Institute name is required</div>

          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email Address" />
          </div>
          <div class="error-message" id="email-error">Please enter a valid email address</div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" />
          </div>
          <div class="password-requirements" id="password-requirements">
            <ul>
              <li id="req-length"><i class="fas"></i> At least 8 characters</li>
              <li id="req-uppercase"><i class="fas"></i> At least one uppercase letter</li>
              <li id="req-number"><i class="fas"></i> At least one number</li>
              <li id="req-special"><i class="fas"></i> At least one special character</li>
            </ul>
          </div>
          <div class="error-message" id="password-error">Password must meet all requirements</div>

          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="confirm_password" id="confirm-password" placeholder="Confirm Password" />
          </div>
          <div class="error-message" id="confirm-password-error">Passwords do not match</div>

          <input type="submit" class="btn" value="Sign up" id="signup-btn" />
          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>New here ?</h3>
          <p>
            Join our community today! Create an account to access exclusive features and content.
          </p>
          <button class="btn transparent" id="sign-up-btn">
            Sign up
          </button>
        </div>
        <img src="../images/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>One of us ?</h3>
          <p>
            Welcome back! Sign in to continue your journey with us.
          </p>
          <button class="btn transparent" id="sign-in-btn">
            Sign in
          </button>
        </div>
        <img src="../images//register.svg" class="image" alt="" />
      </div>
    </div>
  </div>
  <?php 
// Display success message
if (isset($_GET['signup']) && $_GET['signup'] === 'success'): ?>
<div class="success-message">
    Registration successful! You can now sign in.
</div>
<?php endif; ?>

<?php 
// Display error messages
if (isset($_GET['signup']) && $_GET['signup'] === 'error' && isset($_GET['errors'])): 
    $errors = explode("|", $_GET['errors']);
?>
<div class="error-message">
    <h4>Registration failed:</h4>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
  const sign_in_btn = document.querySelector("#sign-in-btn");
  const sign_up_btn = document.querySelector("#sign-up-btn");
  const container = document.querySelector(".container");

  sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
  });

  sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
  });

  // Auto-trigger sign in mode if redirected after signup
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('signup') === 'success') {
    container.classList.remove("sign-up-mode"); // Ensure it's in sign-in mode
    // Optional: Show success message
    alert("Registration successful! Please log in.");
  }


      

      const loginForm = document.querySelector('.sign-in-form');
  const loginUsername = document.getElementById('login-username');
  const loginPassword = document.getElementById('login-password');
  const loginUsernameError = document.getElementById('login-username-error');
  const loginPasswordError = document.getElementById('login-password-error');

  loginForm.addEventListener('submit', function (e) {
    let isValid = true;

    // Validate email
    if (!loginUsername.value.trim()) {
      loginUsername.parentElement.classList.add('input-error');
      loginUsernameError.style.display = 'block';
      isValid = false;
    } else {
      loginUsername.parentElement.classList.remove('input-error');
      loginUsernameError.style.display = 'none';
    }

    // Validate password
    if (!loginPassword.value.trim()) {
      loginPassword.parentElement.classList.add('input-error');
      loginPasswordError.style.display = 'block';
      isValid = false;
    } else {
      loginPassword.parentElement.classList.remove('input-error');
      loginPasswordError.style.display = 'none';
    }

    // If valid, allow form to submit to PHP
    if (!isValid) {
      e.preventDefault(); // Stop form submission
    }
  });

      // Sign Up Form Validation
      const signupForm = document.querySelector('.sign-up-form');
      const fullName = document.getElementById('full-name');
      const gender = document.getElementById('gender');
      const qualification = document.getElementById('qualification');
      const institute = document.getElementById('institute');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirm-password');
      const passwordRequirements = document.getElementById('password-requirements');

      // Show password requirements when password field is focused
      password.addEventListener('focus', function () {
        passwordRequirements.style.display = 'block';
      });

      // Hide password requirements when password field loses focus (if valid)
      password.addEventListener('blur', function () {
        if (checkPasswordRequirements(password.value)) {
          passwordRequirements.style.display = 'none';
        }
      });

      // Real-time password validation
      password.addEventListener('input', function () {
        checkPasswordRequirements(password.value);
      });

      // Check password requirements
      function checkPasswordRequirements(pwd) {
        const hasLength = pwd.length >= 8;
        const hasUppercase = /[A-Z]/.test(pwd);
        const hasNumber = /[0-9]/.test(pwd);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(pwd);

        updateRequirement('req-length', hasLength);
        updateRequirement('req-uppercase', hasUppercase);
        updateRequirement('req-number', hasNumber);
        updateRequirement('req-special', hasSpecial);

        return hasLength && hasUppercase && hasNumber && hasSpecial;
      }

      function updateRequirement(elementId, isValid) {
        const element = document.getElementById(elementId);
        const icon = element.querySelector('i');

        if (isValid) {
          icon.className = 'fas fa-check-circle requirement-met';
          element.classList.add('requirement-met');
          element.classList.remove('requirement-not-met');
        } else {
          icon.className = 'fas fa-times-circle requirement-not-met';
          element.classList.add('requirement-not-met');
          element.classList.remove('requirement-met');
        }
      }

      signupForm.addEventListener('submit', function (e) {
        e.preventDefault();
        let isValid = true;

        // Validate full name
        if (!fullName.value.trim()) {
          fullName.parentElement.classList.add('input-error');
          document.getElementById('full-name-error').style.display = 'block';
          isValid = false;
        } else {
          fullName.parentElement.classList.remove('input-error');
          document.getElementById('full-name-error').style.display = 'none';
        }

        // Validate gender
        if (!gender.value) {
          gender.parentElement.classList.add('input-error');
          document.getElementById('gender-error').style.display = 'block';
          isValid = false;
        } else {
          gender.parentElement.classList.remove('input-error');
          document.getElementById('gender-error').style.display = 'none';
        }

        // Validate qualification
        if (!qualification.value) {
          qualification.parentElement.classList.add('input-error');
          document.getElementById('qualification-error').style.display = 'block';
          isValid = false;
        } else {
          qualification.parentElement.classList.remove('input-error');
          document.getElementById('qualification-error').style.display = 'none';
        }

        // Validate institute
        if (!institute.value.trim()) {
          institute.parentElement.classList.add('input-error');
          document.getElementById('institute-error').style.display = 'block';
          isValid = false;
        } else {
          institute.parentElement.classList.remove('input-error');
          document.getElementById('institute-error').style.display = 'none';
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailRegex.test(email.value)) {
          email.parentElement.classList.add('input-error');
          document.getElementById('email-error').style.display = 'block';
          isValid = false;
        } else {
          email.parentElement.classList.remove('input-error');
          document.getElementById('email-error').style.display = 'none';
        }

        // Validate password
        if (!checkPasswordRequirements(password.value)) {
          password.parentElement.classList.add('input-error');
          document.getElementById('password-error').style.display = 'block';
          passwordRequirements.style.display = 'block';
          isValid = false;
        } else {
          password.parentElement.classList.remove('input-error');
          document.getElementById('password-error').style.display = 'none';
        }

        // Validate confirm password
        if (password.value !== confirmPassword.value || !confirmPassword.value) {
          confirmPassword.parentElement.classList.add('input-error');
          document.getElementById('confirm-password-error').style.display = 'block';
          isValid = false;
        } else {
          confirmPassword.parentElement.classList.remove('input-error');
          document.getElementById('confirm-password-error').style.display = 'none';
        }

        if (isValid) {
    signupForm.submit(); // Actually submit the form
} else {
    e.preventDefault(); // Prevent form submission if not valid
}
      });

      // Input validation on blur
      const inputs = document.querySelectorAll('input, select');
      inputs.forEach(input => {
        input.addEventListener('blur', function () {
          if (this.id === 'login-username' && !this.value.trim()) {
            this.parentElement.classList.add('input-error');
            loginUsernameError.style.display = 'block';
          } else if (this.id === 'login-password' && !this.value.trim()) {
            this.parentElement.classList.add('input-error');
            loginPasswordError.style.display = 'block';
          } else if (this.id === 'full-name' && !this.value.trim()) {
            this.parentElement.classList.add('input-error');
            document.getElementById('full-name-error').style.display = 'block';
          } else if (this.id === 'gender' && !this.value) {
            this.parentElement.classList.add('input-error');
            document.getElementById('gender-error').style.display = 'block';
          } else if (this.id === 'qualification' && !this.value) {
            this.parentElement.classList.add('input-error');
            document.getElementById('qualification-error').style.display = 'block';
          } else if (this.id === 'institute' && !this.value.trim()) {
            this.parentElement.classList.add('input-error');
            document.getElementById('institute-error').style.display = 'block';
          } else if (this.id === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.value.trim() || !emailRegex.test(this.value)) {
              this.parentElement.classList.add('input-error');
              document.getElementById('email-error').style.display = 'block';
            } else {
              this.parentElement.classList.remove('input-error');
              document.getElementById('email-error').style.display = 'none';
            }
          } else if (this.id === 'password') {
            if (!checkPasswordRequirements(this.value)) {
              this.parentElement.classList.add('input-error');
              document.getElementById('password-error').style.display = 'block';
              passwordRequirements.style.display = 'block';
            } else {
              this.parentElement.classList.remove('input-error');
              document.getElementById('password-error').style.display = 'none';
            }
          } else if (this.id === 'confirm-password') {
            const password = document.getElementById('password').value;
            if (this.value !== password || !this.value) {
              this.parentElement.classList.add('input-error');
              document.getElementById('confirm-password-error').style.display = 'block';
            } else {
              this.parentElement.classList.remove('input-error');
              document.getElementById('confirm-password-error').style.display = 'none';
            }
          }
        });

        

        // Remove error on input
        input.addEventListener('input', function () {
          if (this.parentElement.classList.contains('input-error')) {
            this.parentElement.classList.remove('input-error');
            const errorElement = document.getElementById(`${this.id}-error`);
            if (errorElement) errorElement.style.display = 'none';
          }
        });
      });
    });
  </script>
  
</body>
</html>