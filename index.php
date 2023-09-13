<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@4.6/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link href="node_modules/cropperjs/dist/cropper.css" rel="stylesheet">

  <style>
    .label {
      cursor: pointer;
    }

    .progress {
      display: none;
      margin-bottom: 1rem;
    }

    .alert {
      display: none;
    }

    .img-container img {
      max-width: 100%;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Upload cropped image to server</h1>
    <form action="recebe.php" method="post" enctype="multipart/form-data" id="formIMG">
      <label class="label" data-toggle="tooltip" title="Change your avatar">
        <img class="img-fluid" style="max-width: 150px;" id="avatar" src="https://www.geradoresuteis.com.br/img/sem-imagem.png" alt="avatar">
        <input type="hidden" value="" name="img64" id="img64">
        <input type="file" class="" id="input" name="image" accept="image/*">
      </label>
      <button class="btn btn-success" type="submit">Enviar</button>
    </form>



    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Recortar a imagem - Tente sempre selecionar a maior área possível</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="image" src="">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="crop">Recortar</button>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://unpkg.com/jquery@3/dist/jquery.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap@4/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="node_modules/cropperjs/dist/cropper.js"></script>


  <script>
    window.addEventListener('DOMContentLoaded', function() {
      var avatar = document.getElementById('avatar');
      var image = document.getElementById('image');
      var input = document.getElementById('input');
      var $progress = $('.progress');
      var $progressBar = $('.progress-bar');
      var $alert = $('.alert');
      var $modal = $('#modal');
      var cropper;

      $('[data-toggle="tooltip"]').tooltip();

      input.addEventListener('change', function(e) {
        var files = e.target.files;
        var done = function(url) {
          input.value = '';
          image.src = url;
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
      });

      $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 0,
        });
      }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
      });

      document.getElementById('crop').addEventListener('click', function() {
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
          canvas = cropper.getCroppedCanvas();
          initialAvatarURL = avatar.src;
          avatar.src = canvas.toDataURL();
          $("#img64").val(avatar.src);

          canvas.toBlob(function(blob) {});
        }
      });
    });
  </script>

</body>

</html>