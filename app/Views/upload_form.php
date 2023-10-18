<!-- Include Dropzone.js and related styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/min/dropzone.min.css">
<script src="https://cdn.jsdelivr.net/npm/dropzone@5.9.2/dist/min/dropzone.min.js"></script>

<form action="<?= base_url('fileupload/upload'); ?>" class="dropzone" id="my-dropzone">
    <div class="fallback">
        <input name="file" type="file" multiple />
    </div>
</form>
