<h1>Form Testimoni</h1>

<p>Order: {{ $order->order_code }}</p>

<form method="POST" action="/testimoni/{{ $order->order_code }}" enctype="multipart/form-data">
    @csrf

    <label>Rating:</label>
    <input type="number" name="rating" min="1" max="5" required>
    <br><br>

    <label>Komentar:</label><br>
    <textarea name="comment" required></textarea>
    <br><br>

    <label>Upload Foto (max 3):</label>
    <input type="file" name="images[]" multiple>
    <br><br>

    <button type="submit">Kirim Testimoni</button>
</form>