<form action="save_product.php" method="POST">
    <input type="text" name="name" placeholder="Nombre del producto" required>
    <textarea name="description" placeholder="Descripción"></textarea>
    <input type="number" name="quantity" placeholder="Cantidad" required>
    <input type="number" name="price" placeholder="Precio" step="0.01" required>
    <input type="hidden" name="user_id" value="1"> <!-- Ajustar según login -->
    <button type="submit">Guardar producto</button>
</form>
