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
<div style="display:flex;">
<?php $i=0; foreach ($images as $image): ?>
        <div class="image-item" style ="flex-direction: column;width: 100px; display: flex">
        <img width="100" height="100" src="<?= $image ?>" alt="Image" />
            <button class="delete-button" style="color: white;background-color: #d32a2aad;margin: 5px 1px;" data-image-path="<?= $path[$i] ?>">X</button>
        </div>
        <?php $i++; endforeach; ?>
       
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
        // Handle delete button click using jQuery
        $(document).ready(function() {
        $('.delete-button').click(function () {
            console.log("button click");
            const imagePath = $(this).data('image-path');
            console.log(imagePath);
            deleteImage(imagePath);
        });

        function deleteImage(imagePath) {
            $.ajax({
                url: '/delete-image',
                method: 'POST',
                data: { imagePath: imagePath },
                success: function (response) {
                    if (response.success) {
                        // Handle success, e.g., remove the deleted image from the gallery
                        $('.delete-button').click(function() {
        // Find the closest parent <div> with the class "item" and hide it
                            $(this).closest('.image-item').fadeOut();
                        });
                        console.log(response);
                    } else {
                        // Handle error, e.g., display an error message
                        console.log(response);
                    }
                },
                error: function (response) {
                    // Handle AJAX error
                    console.log("error");
                },
            });
        }
    });
    </script>
</body>
</html>