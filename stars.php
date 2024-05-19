<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reseña y calificación</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h2>Deja tu reseña y calificación</h2>
    <form action="cargar_comentarios.php" method="POST">
      <div class="form-group">
        <label for="calificacion">Calificación:</label><br>
        <div class="rating">
          <input type="radio" name="star" id="star5" value="5"><label for="star5"></label>
          <input type="radio" name="star" id="star4" value="4"><label for="star4"></label>
          <input type="radio" name="star" id="star3" value="3"><label for="star3"></label>
          <input type="radio" name="star" id="star2" value="2"><label for="star2"></label>
          <input type="radio" name="star" id="star1" value="1"><label for="star1"></label>
        </div>
      </div>
      <div class="form-group">
        <label for="comentario">Comentario:</label>
        <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reseña y calificación</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h2>Deja tu reseña y calificación</h2>
    <form action="cargar_comentarios.php" method="POST">
      <div class="form-group">
        <label for="calificacion">Calificación:</label><br>
        <div class="rating">
          <input type="radio" name="star" id="star5" value="5"><label for="star5"></label>
          <input type="radio" name="star" id="star4" value="4"><label for="star4"></label>
          <input type="radio" name="star" id="star3" value="3"><label for="star3"></label>
          <input type="radio" name="star" id="star2" value="2"><label for="star2"></label>
          <input type="radio" name="star" id="star1" value="1"><label for="star1"></label>
        </div>
      </div>
      <div class="form-group">
        <label for="comentario">Comentario:</label>
        <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
