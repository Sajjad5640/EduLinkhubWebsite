<?php
require '../config/database.php';



// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ' . ROOT_URL . 'login.php');
    exit;
}


// Get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Initialize variables
$oldImagePath = $user['profilePicture'] ? dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $user['profilePicture'] : '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sanitize input
    $name = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $qualification = trim(filter_var($_POST['qualification'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $institute = trim(filter_var($_POST['institute'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $address = trim(filter_var($_POST['address'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $phoneNumber = trim(filter_var($_POST['phoneNumber'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $image = $_FILES['profilePicture'] ?? null;

    // Store form data in session for repopulation if needed
    $_SESSION['settings-data'] = [
        'name' => $name,
        'email' => $email,
        'qualification' => $qualification,
        'institute' => $institute,
        'address' => $address,
        'phoneNumber' => $phoneNumber
    ];

    // Validate required fields
    if ($name === '') {
        $_SESSION['settings-error'] = 'Please enter your name.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['settings-error'] = 'Please enter a valid email address.';
    }

    $imageFileName = '';
    $uploadsDir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

    // Handle profile picture upload
    if (empty($_SESSION['settings-error']) && $image && !empty($image['name'])) {
        $allowedImg = ['png', 'jpg', 'jpeg', 'webp'];
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowedImg, true)) {
            $_SESSION['settings-error'] = 'Image must be PNG, JPG, JPEG, or WEBP.';
        } elseif (!is_uploaded_file($image['tmp_name'])) {
            $_SESSION['settings-error'] = 'Invalid image upload.';
        } elseif ($image['size'] > 2_000_000) {
            $_SESSION['settings-error'] = 'Image too large. Max size is 2MB.';
        } else {
            if (!is_dir($uploadsDir)) {
                @mkdir($uploadsDir, 0775, true);
            }
            
            $time = time();
            $safe = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', basename($image['name']));
            $imageFileName = $time . '_' . $safe;
            
            if (!move_uploaded_file($image['tmp_name'], $uploadsDir . $imageFileName)) {
                $_SESSION['settings-error'] = 'Failed to save profile picture.';
                $imageFileName = '';
            } else {
                // Delete old profile picture if new one was successfully uploaded
                if ($oldImagePath && file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
        }
    }

    if (!empty($_SESSION['settings-error'])) {
        if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
        header('location: ' . ROOT_URL . 'htmlclient/settings1.php');
        exit;
    }

    // Update user in database
    $sql = "UPDATE users SET 
            name = ?, 
            email = ?, 
            qualification = ?,
            institute = ?,
            address = ?,
            phoneNumber = ?,
            profilePicture = ?,
            updatedAt = NOW()
            WHERE id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
        $_SESSION['settings-error'] = 'Database error (prepare failed).';
        header('location: ' . ROOT_URL . 'htmlclient/settings1.php');
        exit;
    }

    // If no new image was uploaded, keep the existing one
    $finalImage = $imageFileName ?: $user['profilePicture'];
    
    mysqli_stmt_bind_param($stmt, 'sssssssi', 
        $name, 
        $email,
        $qualification,
        $institute,
        $address,
        $phoneNumber,
        $finalImage,
        $user_id
    );
    
    $ok = mysqli_stmt_execute($stmt);
    
    if (!$ok) {
        if ($imageFileName && is_file($uploadsDir . $imageFileName)) @unlink($uploadsDir . $imageFileName);
        $_SESSION['settings-error'] = 'Failed to update profile. (' . mysqli_error($conn) . ')';
        mysqli_stmt_close($stmt);
        header('location: ' . ROOT_URL . 'htmlclient/settings1.php');
        exit;
    }

    mysqli_stmt_close($stmt);
    unset($_SESSION['settings-data']);
    $_SESSION['settings-success'] = 'Profile updated successfully.';
    header('location: ' . ROOT_URL . 'htmlclient/settings1.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Account Settings - EdulinkHub</title>
    
</head>
<body>
<button class="floating-back" aria-label="Go back">
        <i class="fas fa-arrow-left"></i>
    </button>

<!-- Add this CSS to your style section -->
<style>
    /* Floating Back Button */
        .floating-back {
            position: fixed;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
            z-index: 1000;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            color: var(--primary);
        }

        .floating-back:hover {
            transform: translateX(-5px);
            color: var(--secondary);
        }
</style>

<!-- Add this improved JavaScript for better back button functionality -->
<script>
    // Back button functionality
        document.querySelector('.floating-back').addEventListener('click', function() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '../htmlclient/index1.php';
            }
        });
</script>
    <section class="settings-container">
    <h2>Update Profile</h2>
    
    <?php if (isset($_SESSION['settings-success'])): ?>
        <div class="message success">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['settings-success']; unset($_SESSION['settings-success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['settings-error'])): ?>
        <div class="message error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $_SESSION['settings-error']; unset($_SESSION['settings-error']); ?>
        </div>
    <?php endif; ?>
    
    <form class="settings-form" method="POST" enctype="multipart/form-data">
        <!-- Profile Picture Section - Now More Visible -->
        <div class="profile-section">
            <div class="profile-picture-container">
                <?php if (!empty($user['profilePicture'])): ?>
                    <img src="/uploads/<?php echo htmlspecialchars($user['profilePicture']); ?>" 
                         alt="Profile Picture" 
                         class="profile-image"
                         id="profileImage">
                <?php else: ?>
                    <img src="images/default-profile.png" 
                         alt="Default Profile Picture" 
                         class="profile-image"
                         id="profileImage">
                <?php endif; ?>
                
                <div class="upload-controls">
                    <label for="profilePicture" class="upload-btn">
                        <i class="fas fa-camera"></i> Change Photo
                    </label>
                    <input type="file" 
                           name="profilePicture" 
                           id="profilePicture" 
                           accept="image/png, image/jpeg, image/webp"
                           class="file-input">
                    <div class="file-info" id="filenameDisplay">
                        <?php if (!empty($user['profilePicture'])): ?>
                            Current: <?php echo htmlspecialchars($user['profilePicture']); ?>
                        <?php else: ?>
                            No image selected
                        <?php endif; ?>
                    </div>
                    <div class="file-requirements">
                        <small>PNG, JPG, JPEG, or WEBP (Max 2MB)</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="form-section">
            <h3 class="section-title">Personal Information</h3>
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['name'] ?? $user['name']); ?>" 
                       placeholder="Enter your full name"
                       required>
                <i class="fas fa-user form-icon"></i>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['email'] ?? $user['email']); ?>" 
                       placeholder="your.email@example.com"
                       required>
                <i class="fas fa-envelope form-icon"></i>
            </div>
            
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="tel" 
                       id="phoneNumber" 
                       name="phoneNumber" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['phoneNumber'] ?? $user['phoneNumber'] ?? ''); ?>" 
                       placeholder="+1 (123) 456-7890">
                <i class="fas fa-phone form-icon"></i>
            </div>
        </div>

        <!-- Professional Information Section -->
        <div class="form-section">
            <h3 class="section-title">Professional Information</h3>
            
            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" 
                       id="qualification" 
                       name="qualification" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['qualification'] ?? $user['qualification'] ?? ''); ?>" 
                       placeholder="e.g., BSc Computer Science">
                <i class="fas fa-graduation-cap form-icon"></i>
            </div>
            
            <div class="form-group">
                <label for="institute">Institute</label>
                <input type="text" 
                       id="institute" 
                       name="institute" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['institute'] ?? $user['institute'] ?? ''); ?>" 
                       placeholder="Your university or organization">
                <i class="fas fa-university form-icon"></i>
            </div>
        </div>

        <!-- Address Section -->
        <div class="form-section">
            <h3 class="section-title">Address</h3>
            
            <div class="form-group full-width">
                <label for="address">Full Address</label>
                <input type="text" 
                       id="address" 
                       name="address" 
                       value="<?php echo htmlspecialchars($_SESSION['settings-data']['address'] ?? $user['address'] ?? ''); ?>" 
                       placeholder="Street, City, Country">
                <i class="fas fa-map-marker-alt form-icon"></i>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-actions">
            <button type="submit" name="submit" class="save-btn">
                <i class="fas fa-save"></i><a href="profile1.php">Save</a> 
            </button>
        </div>
    </form>
</section>

<style>
/* Modern Design Styles */
:root {
    --primary: #4361ee;
    --primary-light: #4895ef;
    --secondary: #3f37c9;
    --dark: #1b263b;
    --light: #f8f9fa;
    --success: #4cc9f0;
    --error: #f72585;
    --border-radius: 12px;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
    --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    
}

.settings-container {
    max-width: 800px;
    margin: 2rem auto;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    padding: 1.5rem 2rem;
    margin: 0;
}

.section-title {
    font-size: 1.3rem;
    color: var(--dark);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #f0f0f0;
    grid-column: span 2;
}

/* Profile Picture Section */
.profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
    background: #f9fafc;
    border-radius: var(--border-radius);
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
}

.profile-picture-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.profile-image {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid white;
    box-shadow: var(--shadow-md);
    margin-bottom: 1.5rem;
    transition: var(--transition);
}

.upload-controls {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 400px;
}

.upload-btn {
    background: var(--primary);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-sm);
}

.upload-btn:hover {
    background: var(--secondary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.file-input {
    display: none;
}

.file-info {
    margin: 0.5rem 0;
    padding: 0.75rem 1rem;
    background: #f0f4f8;
    border-radius: var(--border-radius);
    width: 100%;
    text-align: center;
    font-size: 0.9rem;
    transition: var(--transition);
}

.file-requirements {
    color: #64748b;
    font-size: 0.8rem;
    margin-top: 0.5rem;
}

/* Form Sections */
.form-section {
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
}

.settings-form {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.95rem;
}

.form-group input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 2px solid #e2e8f0;
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: #f8fafc;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-light);
    background: white;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
}

.form-group input:hover {
    border-color: #cbd5e1;
}

.form-icon {
    position: absolute;
    left: 1rem;
    top: 2.5rem;
    color: #94a3b8;
}

.full-width {
    grid-column: span 2;
}

/* Messages */
.message {
    padding: 1rem;
    border-radius: var(--border-radius);
    margin: 1rem 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success {
    background-color: rgba(76, 201, 240, 0.1);
    color: var(--success);
    border-left: 4px solid var(--success);
}

.error {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--error);
    border-left: 4px solid var(--error);
}

/* Submit Button */
.form-actions {
    display: flex;
    justify-content: flex-end;
    padding: 0 2rem 2rem;
}

.save-btn {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.save-btn:active {
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    .settings-container {
        margin: 1rem;
    }
    
    .profile-section {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1.5rem;
    }
    
    .form-actions {
        padding: 0 1.5rem 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile picture upload preview
    const profilePicture = document.getElementById('profilePicture');
    const profileImage = document.getElementById('profileImage');
    const filenameDisplay = document.getElementById('filenameDisplay');
    
    if (profilePicture) {
        profilePicture.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file
                const validTypes = ['image/png', 'image/jpeg', 'image/webp'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    filenameDisplay.textContent = 'Invalid file type! Please select PNG, JPG, or WEBP.';
                    filenameDisplay.style.color = 'var(--error)';
                    this.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    filenameDisplay.textContent = 'File too large! Max size is 2MB.';
                    filenameDisplay.style.color = 'var(--error)';
                    this.value = '';
                    return;
                }
                
                // Update UI
                filenameDisplay.textContent = 'Selected: ' + file.name;
                filenameDisplay.style.color = 'var(--primary)';
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(event) {
                    profileImage.src = event.target.result;
                    profileImage.classList.add('image-updated');
                    setTimeout(() => profileImage.classList.remove('image-updated'), 500);
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Add animation to form inputs on focus
    document.querySelectorAll('.form-group input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentNode.querySelector('.form-icon').style.color = 'var(--primary)';
            this.parentNode.style.transform = 'translateY(-2px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentNode.querySelector('.form-icon').style.color = '#94a3b8';
            this.parentNode.style.transform = '';
        });
    });
});
</script>

    <script>
        // Display selected filename and preview image
        document.getElementById('profilePicture').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileName = file ? file.name : 'No image selected';
            document.getElementById('filenameDisplay').textContent = 'Selected: ' + fileName;
            
            // Preview the selected image
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('profileImage').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>