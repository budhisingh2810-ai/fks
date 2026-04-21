<?php
$file = '../settings.json';
$data = json_decode(file_get_contents($file), true);

// --- Robust Scraper Function ---
function fetchBuyhatke($url) {
    $options = [
        "http" => [
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $html = @file_get_contents($url, false, $context);
    
    if (!$html) return false;

    // Fetch Title
    preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $html, $titleMatch);
    $title = isset($titleMatch[1]) ? trim(strip_tags($titleMatch[1])) : "";

    // Fetch Price (Looks for the numeric value)
    preg_match('/"price":\s*"(\d+)"/', $html, $priceMatch);
    $price = isset($priceMatch[1]) ? $priceMatch[1] : "";

    // Fetch Image
    preg_match('/<img[^>]*id="p-image"[^>]*src="(.*?)"/', $html, $imageMatch);
    $image = isset($imageMatch[1]) ? $imageMatch[1] : "";

    return ['title' => $title, 'price' => $price, 'image' => $image];
}

// Delete Logic
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    array_splice($data['products'], $id, 1);
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: manage-products.php");
    exit();
}

// Add Product Logic
if (isset($_POST['add_product'])) {
    $new_p = [
        'title' => $_POST['p_title'],
        'brand' => $_POST['p_brand'],
        'price' => $_POST['p_price'],
        'mrp'   => $_POST['p_mrp'],
        'image' => $_POST['p_image']
    ];
    $data['products'][] = $new_p;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    $msg = "Product added successfully!";
}

// Fetch Logic
if (isset($_POST['fetch_link'])) {
    $scraped = fetchBuyhatke($_POST['bh_url']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f0f2f5; display: flex; }
        .sidebar { width: 260px; background: #2b3a67; color: white; position: fixed; height: 100vh; }
        .main-content { margin-left: 260px; width: 100%; padding: 40px; }
        .nav-link { color: #d1d8e0; padding: 15px 25px; }
        .nav-link.active { background: #3e4e88; color: white; border-left: 4px solid #48dbfb; }
        .product-img { width: 60px; height: 60px; object-fit: contain; background: white; border-radius: 5px; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2 class="p-4 text-center border-bottom">ADMIN</h2>
    <nav class="nav flex-column">
        <a class="nav-link" href="index.php"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
        <a class="nav-link active" href="manage-products.php"><i class="fas fa-box-open me-2"></i> Manage Product</a>
    </nav>
</div>
<div class="main-content">
    <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>
    <div class="card p-4 mb-4 border-0 shadow-sm">
        <h5>Add Product via Buyhatke Link</h5>
        <form method="POST" class="d-flex gap-2">
            <input type="url" name="bh_url" class="form-control" placeholder="Paste link here..." required>
            <button type="submit" name="fetch_link" class="btn btn-dark">Fetch</button>
        </form>
        <?php if(isset($scraped)): ?>
        <form method="POST" class="mt-4 p-3 border rounded bg-light">
            <div class="row align-items-center">
                <div class="col-md-2"><img src="<?php echo $scraped['image']; ?>" class="img-fluid rounded border"></div>
                <div class="col-md-10">
                    <input type="hidden" name="p_image" value="<?php echo $scraped['image']; ?>">
                    <input type="text" name="p_title" class="form-control mb-2" value="<?php echo $scraped['title']; ?>" placeholder="Product Title">
                    <div class="row g-2">
                        <div class="col-md-4"><input type="text" name="p_brand" class="form-control" placeholder="Brand (e.g. SMK)"></div>
                        <div class="col-md-4"><input type="number" name="p_price" class="form-control" value="<?php echo $scraped['price']; ?>" placeholder="Offer Price"></div>
                        <div class="col-md-4"><input type="number" name="p_mrp" class="form-control" value="<?php echo (int)$scraped['price']+1000; ?>" placeholder="MRP"></div>
                    </div>
                    <button type="submit" name="add_product" class="btn btn-success mt-3 w-100">Save Product to Site</button>
                </div>
            </div>
        </form>
        <?php endif; ?>
    </div>
    <div class="card p-4 border-0 shadow-sm">
        <h5>Active Products (<?php echo count($data['products']); ?>)</h5>
        <table class="table">
            <thead><tr><th>Image</th><th>Details</th><th>Price</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach($data['products'] as $id => $p): ?>
                <tr>
                    <td><img src="<?php echo $p['image']; ?>" class="product-img border"></td>
                    <td><strong><?php echo $p['brand']; ?></strong><br><small><?php echo substr($p['title'], 0, 50); ?>...</small></td>
                    <td>₹<?php echo $p['price']; ?></td>
                    <td><a href="?delete=<?php echo $id; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>