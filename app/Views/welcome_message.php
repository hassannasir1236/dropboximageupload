<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js"></script>
</head>
<body>
<form action="/" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="Upload Image">
</form>
<img src="<?= site_url('fetch-image') ?>" alt="Fetched Image">
<img src="https://www.dropbox.com/scl/fi/ep9qvszqvijghpbdib7sw/359787138_3592562827641778_1454368951635431297_n.jpg?rlkey=b15z26zjjzpokk8bd3tah64gx&dl=0" alt="Image" />
<h1>Multiple Image Gallery</h1>

<?php foreach ($images as $image): ?>
            <img width="100" height="100" src="<?= $image ?>" alt="Image" />
        <?php  endforeach; ?>
</body>
</html>