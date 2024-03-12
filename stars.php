<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reseña con Estrellas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .stars {
      display: inline-block;
      font-size: 30px;
      color: #ffd700;
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Deja tu reseña</h2>

  <div class="mb-3">
    <label for="stars">Selecciona las estrellas:</label>
    <div class="stars" id="stars-container">
      <span class="star" data-value="1">&#9733;</span>
      <span class="star" data-value="2">&#9733;</span>
      <span class="star" data-value="3">&#9733;</span>
      <span class="star" data-value="4">&#9733;</span>
      <span class="star" data-value="5">&#9733;</span>
    </div>
  </div>

  <div class="mb-3">
    <label for="comment">Deja tu comentario:</label>
    <textarea class="form-control" id="comment" rows="4"></textarea>
  </div>

  <button class="btn btn-primary" onclick="submitReview()">Enviar reseña</button>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  let selectedStars = 0;

  // Función para manejar la selección de estrellas
  function selectStar(value) {
    selectedStars = value;
    updateStars();
  }

  // Función para actualizar el estilo de las estrellas seleccionadas
  function updateStars() {
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
      if (index < selectedStars) {
        star.classList.add('text-warning');
      } else {
        star.classList.remove('text-warning');
      }
    });
  }

  // Función para enviar la reseña (puedes personalizar según tus necesidades)
  function submitReview() {
    const comment = document.getElementById('comment').value;
    alert(`Reseña enviada:\nEstrellas: ${selectedStars}\nComentario: ${comment}`);
  }

  // Añadir evento de clic a las estrellas
  const starsContainer = document.getElementById('stars-container');
  starsContainer.addEventListener('click', (event) => {
    if (event.target.classList.contains('star')) {
      selectStar(parseInt(event.target.getAttribute('data-value')));
    }
  });
</script>

</body>
</html>
