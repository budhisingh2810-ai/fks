<?php
$file = '../settings.json';
$data = json_decode(file_get_contents($file), true);

if (isset($_POST['save_settings'])) {
    $data['upi_id'] = $_POST['upi'];
    $data['pixel_code'] = $_POST['pixel'];
    $data['custom_script'] = $_POST['script'];
    
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    $msg = "Settings Updated Successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Control Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-blue: #2b3a67; }
        body { background: #f0f2f5; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: var(--sidebar-blue); color: white; position: fixed; height: 100%; }
        .sidebar h2 { padding: 25px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .nav-link { color: #bdc3c7; padding: 15px 25px; border-left: 4px solid transparent; }
        .nav-link:hover, .nav-link.active { background: #3e4e88; color: white; border-left-color: #48dbfb; }
        .main-content { margin-left: 260px; width: 100%; padding: 40px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>ADMIN</h2>
    <nav class="nav flex-column">
        <a class="nav-link active" href="#"><i class="fas fa-cog me-2"></i> Site Settings</a>
        <a class="nav-link" href="../index.php" target="_blank"><i class="fas fa-external-link-alt me-2"></i> View Site</a>
    </nav>
</div>

<div class="main-content">
    <div class="container-fluid">
        <h4 class="mb-4 text-dark font-weight-bold">System Configuration</h4>

        <?php if(isset($msg)) echo "<div class='alert alert-success border-0 shadow-sm'>$msg</div>"; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card p-4">
                    <form method="POST">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary"><i class="fas fa-wallet me-2"></i>Active UPI ID</label>
                            <input type="text" name="upi" class="form-control form-control-lg" value="<?php echo htmlspecialchars($data['upi_id']); ?>" placeholder="example@paytm">
                            <div class="form-text">This ID will receive all payments instantly.</div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-danger"><i class="fas fa-code me-2"></i>Meta (Facebook) Pixel</label>
                            <textarea name="pixel" class="form-control" rows="5" placeholder="Paste your Facebook Pixel <script> here..."><?php echo htmlspecialchars($data['pixel_code']); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary"><i class="fas fa-terminal me-2"></i>Custom Header Scripts</label>
                            <textarea name="script" class="form-control" rows="3" placeholder="Additional CSS or JS..."><?php echo htmlspecialchars($data['custom_script']); ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="save_settings" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-save me-2"></i> Save All Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card p-4 bg-light">
                    <h6>Quick Tips:</h6>
                    <ul class="small text-muted ps-3">
                        <li>Changes to UPI take effect immediately on the payment page.</li>
                        <li>Ensure you paste the full Pixel code including the &lt;script&gt; tags.</li>
                        <li>Keep a backup of your current Pixel before overwriting.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>